<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Foreigner;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function index()
    {
        // Check if user can import foreigners
        $currentUser = \App\Http\Controllers\AuthController::user();
        if (!$currentUser || !is_object($currentUser) || !$currentUser->canImportForeigners()) {
            abort(403, 'You do not have permission to import foreigners.');
        }

        return view('imports.index');
    }

    public function importForeigners(Request $request)
    {
        // Check if user can import foreigners
        $currentUser = \App\Http\Controllers\AuthController::user();
        if (!$currentUser || !is_object($currentUser) || !$currentUser->canImportForeigners()) {
            abort(403, 'You do not have permission to import foreigners.');
        }

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ]);

        try {
            $file = $request->file('excel_file');
            
            // Load the spreadsheet
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Remove header row
            $header = array_shift($rows);
            
            // Validate header format
            $expectedHeaders = [
                'First Name', 'Last Name', 'Date of Birth', 'Gender', 'Nationality', 'Passport Number',
                'Residence Permit Type', 'Status', 'City/Regency', 'Subdistrict', 'Village/Kelurahan', 
                'Current Address', 'Latitude', 'Longitude', 'Postal Code', 'Country', 
                'Residence Permit Expiry', 'Email', 'Sponsor Contact Name', 'Sponsor Contact Number'
            ];
            
            if (!$this->validateHeaders($header, $expectedHeaders)) {
                return back()->with('error', 'Excel file format is incorrect. Please use the correct template.');
            }

            $imported = 0;
            $errors = [];
            $skipped = 0;

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 because we removed header and Excel starts at 1
                
                // Skip empty rows
                if (empty(array_filter($row))) {
                    $skipped++;
                    continue;
                }

                // Prepare data
                $data = [
                    'first_name' => $row[0] ?? '',
                    'last_name' => $row[1] ?? '',
                    'date_of_birth' => $this->parseDate($row[2] ?? null),
                    'gender' => strtolower($row[3] ?? 'other'),
                    'nationality' => $row[4] ?? '',
                    'passport_number' => $row[5] ?? '',
                    'residence_permit_type' => $row[6] ?? '',
                    'status' => $row[7] ?? 'active',
                    'city' => $row[8] ?? '', // City/Regency
                    'state_province' => $row[9] ?? '', // Subdistrict
                    'village' => $row[10] ?? '', // Village/Kelurahan
                    'current_address' => $row[11] ?? '',
                    'latitude' => is_numeric($row[12] ?? null) ? floatval($row[12]) : null,
                    'longitude' => is_numeric($row[13] ?? null) ? floatval($row[13]) : null,
                    'postal_code' => $row[14] ?? '',
                    'country' => $row[15] ?? 'Indonesia',
                    'residence_permit_expiry_date' => $this->parseDate($row[16] ?? null),
                    'email' => $row[17] ?? null,
                    'sponsor_contact_name' => $row[18] ?? null,
                    'sponsor_contact_number' => $row[19] ?? null,
                    'residence_permit_status' => 'Active',
                    'entry_date' => now(),
                ];

                // Validate data with conditional rules for ITAP
                $validationRules = [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'date_of_birth' => 'required|date|before:today',
                    'gender' => 'required|in:male,female,other',
                    'nationality' => 'required|string|max:255',
                    'passport_number' => 'required|string|max:255',
                    'residence_permit_type' => 'required|in:ITK,ITAS,ITAP,other',
                    'status' => 'required|in:active,expired,departed',
                    'city' => 'required|string|max:255',
                    'state_province' => 'required|string|max:255',
                    'village' => 'nullable|string|max:255',
                    'current_address' => 'required|string|max:255',
                    'latitude' => 'nullable|numeric|between:-90,90',
                    'longitude' => 'nullable|numeric|between:-180,180',
                    'postal_code' => 'required|string|max:20',
                    'country' => 'required|string|max:255',
                    'email' => 'nullable|email|max:255',
                    'sponsor_contact_name' => 'nullable|string|max:255',
                    'sponsor_contact_number' => 'nullable|string|max:20',
                ];

                // Conditional validation for residence permit expiry date
                // ITAP (permanent permit) doesn't require expiry date
                if ($data['residence_permit_type'] !== 'ITAP') {
                    $validationRules['residence_permit_expiry_date'] = 'required|date|after:today';
                } else {
                    $validationRules['residence_permit_expiry_date'] = 'nullable|date|after:today';
                }

                $validator = Validator::make($data, $validationRules);

                if ($validator->fails()) {
                    $errors[] = "Row {$rowNumber}: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                // Check for duplicate passport number manually to avoid transaction issues
                $existingForeigner = Foreigner::where('passport_number', $data['passport_number'])->first();
                if ($existingForeigner) {
                    $errors[] = "Row {$rowNumber}: Passport number {$data['passport_number']} already exists";
                    continue;
                }

                // Create foreigner record with individual transaction
                try {
                    DB::beginTransaction();
                    Foreigner::create($data);
                    DB::commit();
                    $imported++;
                } catch (\Exception $e) {
                    DB::rollBack();
                    $errors[] = "Row {$rowNumber}: " . $e->getMessage();
                }
            }

            $message = "Import completed! Imported: {$imported} records";
            if ($skipped > 0) {
                $message .= ", Skipped: {$skipped} empty rows";
            }
            if (!empty($errors)) {
                $message .= ", Errors: " . count($errors) . " rows failed";
            }

            return back()->with([
                'success' => $message,
                'import_errors' => $errors
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Foreign Nationals Mapping System')
            ->setTitle('Foreign Nationals Import Template')
            ->setDescription('Template for importing foreign nationals data');

        // Set headers
        $headers = [
            'A1' => 'First Name',
            'B1' => 'Last Name',
            'C1' => 'Date of Birth',
            'D1' => 'Gender',
            'E1' => 'Nationality',
            'F1' => 'Passport Number',
            'G1' => 'Residence Permit Type',
            'H1' => 'Status',
            'I1' => 'City/Regency',
            'J1' => 'Subdistrict',
            'K1' => 'Village/Kelurahan',
            'L1' => 'Current Address',
            'M1' => 'Latitude',
            'N1' => 'Longitude',
            'O1' => 'Postal Code',
            'P1' => 'Country',
            'Q1' => 'Residence Permit Expiry',
            'R1' => 'Email',
            'S1' => 'Sponsor Contact Name',
            'T1' => 'Sponsor Contact Number'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style the header row
        $sheet->getStyle('A1:T1')->getFont()->setBold(true);
        $sheet->getStyle('A1:T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:T1')->getFill()->getStartColor()->setRGB('E3F2FD');

        // Add sample data with proper nationality names for flag display and coordinates
        $sampleData = [
            ['John', 'Doe', '1990-05-15', 'male', 'American', 'P123456789', 'ITK', 'active', 'Kota Cirebon', 'Harjamukti', 'Kecapi', 'Jl. Sudirman No. 123', '-6.7063', '108.5678', '45121', 'Indonesia', '2025-12-31', 'john.doe@email.com', 'PT Sponsor Company', '+628123456789'],
            ['Jane', 'Smith', '1985-03-22', 'female', 'British', 'P987654321', 'ITAS', 'active', 'Kabupaten Cirebon', 'Waled', 'Astapada', 'Jl. Ahmad Yani No. 456', '-6.9080', '108.7126', '45122', 'Indonesia', '2025-11-30', 'jane.smith@email.com', 'Individual Sponsor', '+628987654321'],
        ];

        $row = 2;
        foreach ($sampleData as $data) {
            $col = 'A';
            foreach ($data as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'T') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Create Excel file
        $filename = 'foreigners_import_template.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        // Create a temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'excel_template');
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    private function validateHeaders($actualHeaders, $expectedHeaders)
    {
        // Remove extra spaces and compare
        $cleanActual = array_map('trim', $actualHeaders);
        $cleanExpected = array_map('trim', $expectedHeaders);
        
        for ($i = 0; $i < count($cleanExpected); $i++) {
            if (!isset($cleanActual[$i]) || $cleanActual[$i] !== $cleanExpected[$i]) {
                return false;
            }
        }
        
        return true;
    }

    private function parseDate($dateValue)
    {
        if (empty($dateValue)) {
            return null;
        }

        // If it's an Excel date serial number
        if (is_numeric($dateValue)) {
            try {
                $dateObject = Date::excelToDateTimeObject($dateValue);
                return $dateObject->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // If it's a string date, try multiple formats
        try {
            // Try common date formats
            $formats = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'd-m-Y', 'm-d-Y'];
            
            foreach ($formats as $format) {
                $date = \DateTime::createFromFormat($format, $dateValue);
                if ($date !== false) {
                    return $date->format('Y-m-d');
                }
            }
            
            // Fallback to strtotime
            $timestamp = strtotime($dateValue);
            if ($timestamp !== false) {
                return date('Y-m-d', $timestamp);
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
