<?php

namespace App\Http\Controllers;

use App\Models\Foreigner;
use App\Models\Region;
use App\Http\Requests\StoreForeignerRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ForeignerController extends Controller
{
    public function index(Request $request)
    {
        // Check if user can view foreigner list
        $currentUser = \App\Http\Controllers\AuthController::user();
        if (!$currentUser || !is_object($currentUser) || !$currentUser->canViewForeignerList()) {
            abort(403, 'You do not have permission to view the foreigner management list.');
        }

        $query = Foreigner::query();

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('passport_number', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $searchTerm . '%']);
            });
        }

        // Filter by nationality if provided
        if ($request->filled('nationality')) {
            $query->where('nationality', $request->nationality);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by region (search in city, state_province, and country fields)
        if ($request->filled('region')) {
            $query->where(function($q) use ($request) {
                $q->where('city', 'like', '%' . $request->region . '%')
                  ->orWhere('state_province', 'like', '%' . $request->region . '%')
                  ->orWhere('country', 'like', '%' . $request->region . '%');
            });
        }

        // Handle export requests first (before pagination)
        if ($request->filled('export')) {
            $exportData = $query->select([
                'id', 'first_name', 'last_name', 'nationality', 'passport_number',
                'residence_permit_type', 'status', 'entry_date', 'residence_permit_expiry_date', 
                'current_address', 'latitude', 'longitude', 'city', 'state_province', 
                'phone_number', 'email', 'sponsor_contact_name', 'sponsor_contact_number'
            ])->orderBy('created_at', 'desc')->get();

            if ($request->export === 'csv') {
                return $this->exportToCsv($exportData);
            } elseif ($request->export === 'excel') {
                return $this->exportToExcel($exportData);
            } elseif ($request->export === 'json') {
                return $this->exportToJson($exportData);
            }
        }

        $foreigners = $query->select([
            'id', 'first_name', 'last_name', 'nationality', 'passport_number',
            'residence_permit_type', 'status', 'city', 'state_province', 'residence_permit_expiry_date', 'photo', 'email'
        ])->orderBy('created_at', 'desc')->paginate(20);

        $nationalities = Foreigner::distinct()->pluck('nationality')->sort();
        $regions = Region::pluck('name', 'id');

        return view('foreigners.index', compact('foreigners', 'nationalities', 'regions'));
    }

    public function create()
    {
        // Check if user can add foreigners
        $currentUser = \App\Http\Controllers\AuthController::user();
        if (!$currentUser || !is_object($currentUser) || !$currentUser->canAddForeigners()) {
            abort(403, 'You do not have permission to add new foreigners.');
        }

        $regions = Region::orderBy('name')->get();
        return view('foreigners.create', compact('regions'));
    }

    public function store(StoreForeignerRequest $request)
    {
        // Check if user can add foreigners
        $currentUser = \App\Http\Controllers\AuthController::user();
        if (!$currentUser || !is_object($currentUser) || !$currentUser->canAddForeigners()) {
            abort(403, 'You do not have permission to add new foreigners.');
        }

        try {
            $validated = $request->validated();

            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('foreigners', 'public');
                $validated['photo'] = $photoPath;
            }

            // Create foreigner record
            $foreigner = Foreigner::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'nationality' => $validated['nationality'],
                'passport_number' => $validated['passport_number'],
                'photo' => $photoPath,
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'residence_permit_type' => $validated['residence_permit_type'],
                'status' => $validated['status'],  // Excel Status field -> status
                'residence_permit_status' => $validated['residence_permit_status'] ?? 'Active',
                'residence_permit_expiry_date' => $validated['residence_permit_type'] === 'ITAP' ? null : ($validated['residence_permit_expiry_date'] ?? null),
                'entry_date' => $validated['entry_date'] ?? now(),
                'current_address' => $validated['current_address'],  // Excel Current Address
                'city' => $validated['city'],  // Excel City/Regency
                'state_province' => $validated['state_province'],  // Excel Subdistrict
                'village' => $validated['village'],  // Excel Village/Kelurahan
                'country' => $validated['country'] ?? 'Indonesia',  // Excel Country
                'postal_code' => $validated['postal_code'],  // Excel Postal Code
                'email' => $validated['email'] ?? null,  // Excel Email
                'sponsor_contact_name' => $validated['sponsor_contact_name'] ?? null,
                'sponsor_contact_number' => $validated['sponsor_contact_number'] ?? null,
                'latitude' => $validated['latitude'] ?? null,  // Generated coordinates
                'longitude' => $validated['longitude'] ?? null,  // Generated coordinates
            ]);

            Log::info('New foreigner registered', [
                'id' => $foreigner->id,
                'passport' => $foreigner->passport_number,
                'nationality' => $foreigner->nationality,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('foreigners.index')
                ->with('success', 'Foreign national registered successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to register foreigner', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'data' => $request->except(['photo'])
            ]);

            return back()->withInput()
                ->with('error', 'Failed to register foreign national. Please try again.');
        }
    }

    public function show(Foreigner $foreigner)
    {
        // Check if user can view foreigner details (same as list permission)
        $currentUser = \App\Http\Controllers\AuthController::user();
        if (!$currentUser || !is_object($currentUser) || !$currentUser->canViewForeignerList()) {
            abort(403, 'You do not have permission to view foreigner details.');
        }

        return view('foreigners.show', compact('foreigner'));
    }

    public function edit(Foreigner $foreigner)
    {
        // Check if user can edit foreigners
        $currentUser = \App\Http\Controllers\AuthController::user();
        if (!$currentUser || !is_object($currentUser) || !$currentUser->canEditForeigners()) {
            abort(403, 'You do not have permission to edit foreigners.');
        }

        return view('foreigners.edit', compact('foreigner'));
    }

    public function update(Request $request, Foreigner $foreigner)
    {
        // Check if user can edit foreigners
        $currentUser = \App\Http\Controllers\AuthController::user();
        if (!$currentUser || !is_object($currentUser) || !$currentUser->canEditForeigners()) {
            abort(403, 'You do not have permission to edit foreigners.');
        }

        // Base validation rules
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'nationality' => 'required|string|max:255',
            'passport_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('foreigners')->ignore($foreigner->id)
            ],
            'residence_permit_type' => 'required|in:ITK,ITAS,ITAP,other',
            'residence_permit_status' => 'nullable|string|max:255',
            'residence_permit_issue_date' => 'nullable|date|before_or_equal:today',
            'status' => 'required|in:active,expired,departed',
            'city' => 'required|string|max:255',
            'state_province' => 'required|string|max:255',
            'village' => 'nullable|string|max:255',
            'current_address' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:255',
            'sponsor_contact_name' => 'nullable|string|max:255',
            'sponsor_contact_number' => 'nullable|string|max:255',
            'entry_date' => 'nullable|date',
            'occupation' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];

        // Conditional validation for residence permit expiry date
        // ITAP (permanent permit) doesn't require expiry date
        if ($request->input('residence_permit_type') !== 'ITAP') {
            $rules['residence_permit_expiry_date'] = 'required|date|after:today';
        } else {
            $rules['residence_permit_expiry_date'] = 'nullable|date|after:today';
        }

        $validated = $request->validate($rules);

        $photoPath = $foreigner->photo;
        if ($request->hasFile('photo')) {
            if ($foreigner->photo) {
                \Storage::disk('public')->delete($foreigner->photo);
            }
            $photoPath = $request->file('photo')->store('foreigners', 'public');
        }

        $foreigner->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'nationality' => $validated['nationality'],
            'passport_number' => $validated['passport_number'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'residence_permit_type' => $validated['residence_permit_type'],
            'status' => $validated['status'],  // Excel Status field -> status
            'residence_permit_status' => $validated['residence_permit_status'] ?? 'Active',
            'residence_permit_expiry_date' => $validated['residence_permit_type'] === 'ITAP' ? null : ($validated['residence_permit_expiry_date'] ?? null),
            'entry_date' => $validated['entry_date'],
            'current_address' => $validated['current_address'],  // Excel Current Address
            'city' => $validated['city'],  // Excel City/Regency
            'state_province' => $validated['state_province'],  // Excel Subdistrict
            'village' => $validated['village'],  // Excel Village/Kelurahan
            'country' => $validated['country'],  // Excel Country
            'postal_code' => $validated['postal_code'],  // Excel Postal Code
            'email' => $validated['email'],  // Excel Email
            'sponsor_contact_name' => $validated['sponsor_contact_name'],
            'sponsor_contact_number' => $validated['sponsor_contact_number'],
            'latitude' => $validated['latitude'] ?? $foreigner->latitude,  // Keep existing if not updated
            'longitude' => $validated['longitude'] ?? $foreigner->longitude,  // Keep existing if not updated
        ]);

        return redirect()->route('foreigners.show', $foreigner)
            ->with('success', 'Data WNA berhasil diperbarui!');
    }

    public function destroy(Foreigner $foreigner)
    {
        // Check if user can delete foreigners
        $currentUser = \App\Http\Controllers\AuthController::user();
        if (!$currentUser || !is_object($currentUser) || !$currentUser->canDeleteForeigners()) {
            abort(403, 'You do not have permission to delete foreigners.');
        }

        if ($foreigner->photo) {
            \Storage::disk('public')->delete($foreigner->photo);
        }

        $foreigner->delete();

        return redirect()->route('foreigners.index')
            ->with('success', 'Data WNA berhasil dihapus!');
    }

    private function exportToCsv($data)
    {
        $filename = 'foreigners_' . date('Y-m-d_H-i-s') . '.csv';
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'First Name', 'Last Name', 'Nationality', 'Passport Number',
                'Residence Permit Type', 'Status', 'City', 'State/Province', 'Residence Permit Expiry', 'Email'
            ]);

            // CSV data
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->first_name ?? '',
                    $row->last_name ?? '',
                    $row->nationality ?? '',
                    $row->passport_number ?? '',
                    $row->residence_permit_type ?? '',
                    $row->status ?? '',
                    $row->city ?? '',
                    $row->state_province ?? '',
                    $row->residence_permit_expiry_date ?? '',
                    $row->email ?? '',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }

    private function exportToExcel($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Foreign Nationals Mapping System')
            ->setTitle('Foreign Nationals Export')
            ->setSubject('Foreign Nationals Data')
            ->setDescription('Export of foreign nationals data from the mapping system');

        // Set headers
        $headers = [
            'A1' => 'First Name',
            'B1' => 'Last Name', 
            'C1' => 'Nationality',
            'D1' => 'Passport Number',
            'E1' => 'Residence Permit Type',
            'F1' => 'Status',
            'G1' => 'City',
            'H1' => 'State/Province',
            'I1' => 'Residence Permit Expiry',
            'J1' => 'Email'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style the header row
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->getStyle('A1:J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:J1')->getFill()->getStartColor()->setRGB('E3F2FD');

        // Add data
        $row = 2;
        foreach ($data as $foreigner) {
            $sheet->setCellValue('A' . $row, $foreigner->first_name ?? '');
            $sheet->setCellValue('B' . $row, $foreigner->last_name ?? '');
            $sheet->setCellValue('C' . $row, $foreigner->nationality ?? '');
            $sheet->setCellValue('D' . $row, $foreigner->passport_number ?? '');
            $sheet->setCellValue('E' . $row, $foreigner->residence_permit_type ?? '');
            $sheet->setCellValue('F' . $row, $foreigner->status ?? '');
            $sheet->setCellValue('G' . $row, $foreigner->city ?? '');
            $sheet->setCellValue('H' . $row, $foreigner->state_province ?? '');
            $sheet->setCellValue('I' . $row, $foreigner->residence_permit_expiry_date ?? '');
            $sheet->setCellValue('J' . $row, $foreigner->email ?? '');
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Create Excel file
        $filename = 'foreigners_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        
        // Create a temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'excel_export');
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    private function exportToJson($data)
    {
        $filename = 'foreigners_' . date('Y-m-d_H-i-s') . '.json';
        
        $jsonData = [
            'export_date' => date('Y-m-d H:i:s'),
            'total_records' => $data->count(),
            'data' => $data->map(function($row) {
                return [
                    'first_name' => $row->first_name ?? '',
                    'last_name' => $row->last_name ?? '',
                    'nationality' => $row->nationality ?? '',
                    'passport_number' => $row->passport_number ?? '',
                    'residence_permit_type' => $row->residence_permit_type ?? '',
                    'status' => $row->status ?? '',
                    'city' => $row->city ?? '',
                    'state_province' => $row->state_province ?? '',
                    'residence_permit_expiry_date' => $row->residence_permit_expiry_date ?? '',
                    'email' => $row->email ?? '',
                ];
            })
        ];

        return response()->json($jsonData)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Type', 'application/json');
    }
}
