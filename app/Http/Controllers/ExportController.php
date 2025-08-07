<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Foreigner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function index()
    {
        return view('exports.index');
    }

    public function exportForeigners(Request $request)
    {
        $format = $request->get('format', 'csv');
        $filters = $request->only(['status', 'nationality', 'residence_permit_type', 'city']);
        
        $query = Foreigner::query();
        
        // Apply filters
        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $query->where($field, $value);
            }
        }
        
        $foreigners = $query->get();
        
        switch ($format) {
            case 'csv':
                return $this->exportToCsv($foreigners);
            case 'json':
                return $this->exportToJson($foreigners);
            case 'excel':
                return $this->exportToExcel($foreigners);
            default:
                return redirect()->back()->with('error', 'Unsupported export format');
        }
    }

    private function exportToCsv($foreigners)
    {
        $filename = 'foreigners_export_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($foreigners) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID', 'First Name', 'Last Name', 'Nationality', 'Passport Number',
                'Residence Permit Type', 'Status', 'Entry Date', 'Residence Permit Expiry Date', 
                'Current Address', 'Latitude', 'Longitude',
                'City', 'State/Province', 'Phone', 'Email', 'Sponsor Contact Name', 'Sponsor Contact Number'
            ]);
            
            // Data rows
            foreach ($foreigners as $foreigner) {
                fputcsv($file, [
                    $foreigner->id ?? '',
                    $foreigner->first_name ?? '',
                    $foreigner->last_name ?? '',
                    $foreigner->nationality ?? '',
                    $foreigner->passport_number ?? '',
                    $foreigner->residence_permit_type ?? '',
                    $foreigner->status ?? '',
                    $foreigner->entry_date?->format('Y-m-d') ?? '',
                    $foreigner->residence_permit_expiry_date?->format('Y-m-d') ?? '',
                    $foreigner->current_address ?? '',
                    $foreigner->latitude ?? '',
                    $foreigner->longitude ?? '',
                    $foreigner->city ?? '',
                    $foreigner->state_province ?? '',
                    $foreigner->phone_number ?? '',
                    $foreigner->email ?? '',
                    $foreigner->sponsor_contact_name ?? '',
                    $foreigner->sponsor_contact_number ?? '',
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToJson($foreigners)
    {
        $filename = 'foreigners_export_' . now()->format('Y-m-d_H-i-s') . '.json';
        
        $data = [
            'export_info' => [
                'generated_at' => now()->toISOString(),
                'total_records' => $foreigners->count(),
                'source' => 'ImmiTrace Immigration Office Cirebon'
            ],
            'data' => $foreigners->toArray()
        ];
        
        return response()->json($data)
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    private function exportToExcel($foreigners)
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
            'A1' => 'ID',
            'B1' => 'First Name',
            'C1' => 'Last Name', 
            'D1' => 'Nationality',
            'E1' => 'Passport Number',
            'F1' => 'Residence Permit Type',
            'G1' => 'Status',
            'H1' => 'Entry Date',
            'I1' => 'Residence Permit Expiry',
            'J1' => 'Current Address',
            'K1' => 'Latitude',
            'L1' => 'Longitude',
            'M1' => 'City',
            'N1' => 'State/Province',
            'O1' => 'Phone',
            'P1' => 'Email',
            'Q1' => 'Sponsor Contact Name',
            'R1' => 'Sponsor Contact Number'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style the header row
        $sheet->getStyle('A1:R1')->getFont()->setBold(true);
        $sheet->getStyle('A1:R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:R1')->getFill()->getStartColor()->setRGB('E3F2FD');

        // Add data
        $row = 2;
        foreach ($foreigners as $foreigner) {
            $sheet->setCellValue('A' . $row, $foreigner->id ?? '');
            $sheet->setCellValue('B' . $row, $foreigner->first_name ?? '');
            $sheet->setCellValue('C' . $row, $foreigner->last_name ?? '');
            $sheet->setCellValue('D' . $row, $foreigner->nationality ?? '');
            $sheet->setCellValue('E' . $row, $foreigner->passport_number ?? '');
            $sheet->setCellValue('F' . $row, $foreigner->residence_permit_type ?? '');
            $sheet->setCellValue('G' . $row, $foreigner->status ?? '');
            $sheet->setCellValue('H' . $row, $foreigner->entry_date?->format('Y-m-d') ?? '');
            $sheet->setCellValue('I' . $row, $foreigner->residence_permit_expiry_date?->format('Y-m-d') ?? '');
            $sheet->setCellValue('J' . $row, $foreigner->current_address ?? '');
            $sheet->setCellValue('K' . $row, $foreigner->latitude ?? '');
            $sheet->setCellValue('L' . $row, $foreigner->longitude ?? '');
            $sheet->setCellValue('M' . $row, $foreigner->city ?? '');
            $sheet->setCellValue('N' . $row, $foreigner->state_province ?? '');
            $sheet->setCellValue('O' . $row, $foreigner->phone_number ?? '');
            $sheet->setCellValue('P' . $row, $foreigner->email ?? '');
            $sheet->setCellValue('Q' . $row, $foreigner->sponsor_contact_name ?? '');
            $sheet->setCellValue('R' . $row, $foreigner->sponsor_contact_number ?? '');
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'O') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Create Excel file
        $filename = 'foreigners_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        
        // Create a temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'excel_export');
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function exportStatistics(Request $request)
    {
        $stats = [
            'summary' => [
                'total_foreigners' => Foreigner::count(),
                'active_foreigners' => Foreigner::where('status', 'active')->count(),
                'expired_residence_permits' => Foreigner::where('residence_permit_expiry_date', '<', now())->count(),
                'generated_at' => now()->toISOString()
            ],
            'by_nationality' => Foreigner::selectRaw('nationality, COUNT(*) as count')
                ->groupBy('nationality')
                ->orderByDesc('count')
                ->get(),
            'by_city' => Foreigner::selectRaw('city, COUNT(*) as count')
                ->groupBy('city')
                ->orderByDesc('count')
                ->get(),
            'by_residence_permit_type' => Foreigner::selectRaw('residence_permit_type, COUNT(*) as count')
                ->groupBy('residence_permit_type')
                ->orderByDesc('count')
                ->get()
        ];

        $filename = 'immigration_statistics_' . now()->format('Y-m-d_H-i-s') . '.json';
        
        return response()->json($stats)
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }
}
