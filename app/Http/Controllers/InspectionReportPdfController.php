<?php

namespace App\Http\Controllers;

use App\Models\InspectionReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InspectionReportPdfController extends Controller
{
    public function download($id)
    {
        $report = InspectionReport::with('lessee')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.inspection-report', compact('report'))
            ->setPaper([0, 0, 576, 936], 'portrait');
        return $pdf->stream("Inspection_Report_{$report->fla_no}.pdf");
    }
}