<?php

namespace App\Http\Controllers;

use App\Models\AnnualReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AnnualReportPdfController extends Controller
{
    public function download($id)
    {
        $report = AnnualReport::with('lessee')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.annual-report', compact('report'))
            ->setPaper([0, 0, 576, 936], 'portrait');
            
        return $pdf->stream("Annual_Report_{$report->fla_no}.pdf");
    }
}