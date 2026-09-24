<?php

namespace App\Http\Controllers;

use App\Models\InspectionReport;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Http\Request;

class InspectionReportPdfController extends Controller
{
    public function download($id)
    {
        $report = InspectionReport::with('lessee')->findOrFail($id);

        return Pdf::view('pdf.inspection-report', compact('report'))
            ->paperSize(203.2, 330.2, 'mm') 
            ->margins(10, 15, 10, 15)       
            ->name("Inspection_Report_{$report->fla_no}.pdf")
            ->inline();                    
    }
}