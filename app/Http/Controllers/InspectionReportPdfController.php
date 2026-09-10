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
            ->setPaper([0, 0, 576, 936], 'portrait'); // 8in x 13in (Legal/Foolscap size in points: 8 * 72 = 576pt, 13 * 72 = 936pt)

        // Stream inline to open in a new tab instead of forcing a download
        return $pdf->stream("Inspection_Report_{$report->fla_no}.pdf");
    }
}