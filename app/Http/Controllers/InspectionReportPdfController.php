<?php

// namespace App\Http\Controllers;

// use App\Models\InspectionReport;
// use Barryvdh\DomPDF\Facade\Pdf;
// use Illuminate\Http\Request;

// class InspectionReportPdfController extends Controller
// {
//     public function download($id)
//     {
//         $report = InspectionReport::with('lessee')->findOrFail($id);

//         $pdf = Pdf::loadView('pdf.inspection-report', compact('report'))
//             ->setPaper([0, 0, 576, 936], 'portrait');
//         return $pdf->stream("Inspection_Report_{$report->fla_no}.pdf");
//     }
// }

namespace App\Http\Controllers;

use App\Models\InspectionReport;
use FPDF;

class InspectionReportPdfController extends Controller
{
    public function download($id)
    {
        $report = InspectionReport::with('lessee')->findOrFail($id);

        $improvements = $report->improvements ?? [];
        $stockingRecords = $report->stocking_records ?? [];

        $pdf = new FPDF('P', 'mm', 'legal');

        // MARGINS: Top = 1.5 in (38.1 mm), Bottom = 1.0 in (25.4 mm), Left/Right = 0.75 in (19.05 mm)
        $pdf->SetMargins(19.05, 38.1, 19.05);
        $pdf->SetAutoPageBreak(true, 25.4);

        // Built-in standard serif font (No extra files required)
        $fontMain = 'Times';

        $pageWidth = 177.8; // 215.9mm - (19.05mm * 2)

        // ================= PAGE 1 =================
        $pdf->AddPage();

        // Title: Times 13pt
        $pdf->SetFont($fontMain, 'B', 13);
        $pdf->Cell($pageWidth, 6, 'REPORT OF INSPECTION AND VERIFICATION OF', 0, 1, 'C');
        $pdf->Cell($pageWidth, 6, 'IMPROVEMENTS', 0, 1, 'C');
        $pdf->Ln(6);

        // All other text: Times 12pt
        $pdf->SetFont($fontMain, '', 12);

        // Date right-aligned
        $dateInspection = $report->date_inspection ? $report->date_inspection->format('F d, Y') : '___________________';
        $pdf->Cell(97.8, 5, '', 0, 0);
        $pdf->Cell(80, 5, $dateInspection, 'B', 1, 'C');
        $pdf->Cell(97.8, 5, '', 0, 0);
        $pdf->Cell(80, 5, 'Date', 0, 1, 'C');
        $pdf->Ln(3);

        // Recipient details
        $pdf->SetFont($fontMain, 'B', 12);
        $pdf->Cell($pageWidth, 5, 'The Director', 0, 1);
        $pdf->SetFont($fontMain, '', 12);
        $pdf->Cell($pageWidth, 5, 'Bureau of Fisheries and Aquatic Resources', 0, 1);
        $pdf->Cell($pageWidth, 5, '3/F Main Building, Fisheries Building Complex', 0, 1);
        $pdf->Cell($pageWidth, 5, 'Visayas Avenue, Diliman, Quezon City', 0, 1);
        $pdf->Ln(4);

        // Salutation & Preamble
        $pdf->Cell($pageWidth, 5, 'Sir:', 0, 1);
        $pdf->Ln(2);

        $preamble = sprintf(
            "I have the honor to inform you that an ocular inspection and verification of improvements was conducted by the undersigned in the fishpond area covered by FLA/ASC/Fp. A. No. %s located in Bgry. %s, Municipality of %s, Province of %s, and I hereby certify that the following are the kind and extent of improvements found existing in the area and production thereof.",
            $report->fla_no ?? '_________________',
            $report->barangay ?? '_________________',
            $report->municipality ?? '_________________',
            $report->province ?? '_________________'
        );
        $pdf->MultiCell($pageWidth, 5, $preamble, 0, 'J');
        $pdf->Ln(3);

        // Lessee details
        $lesseeName = $report->lessee ? $report->lessee->name : '';
        $lesseeAddress = $report->lessee ? $report->lessee->address : '';
        $dateIssued = $report->date_issued ? $report->date_issued->format('M d, Y') : '';
        $dateExpire = $report->date_expire ? $report->date_expire->format('M d, Y') : '';

        $pdf->Cell(97.8, 5, 'Name of Lessee/Applicant: ' . $lesseeName, 0, 0);
        $pdf->Cell(80, 5, 'FLA/ASC/Fp. A. No.: ' . ($report->fla_no ?? ''), 0, 1);

        $pdf->Cell(97.8, 5, 'Address: ' . $lesseeAddress, 0, 0);
        $pdf->Cell(80, 5, 'Date Issued: ' . $dateIssued, 0, 1);

        $pdf->Cell(97.8, 5, 'No. of hectares granted: ' . ($report->no_hec_granted ?? ''), 0, 0);
        $pdf->Cell(80, 5, 'Date of Expiration: ' . $dateExpire, 0, 1);

        $pdf->Cell(97.8, 5, 'No. of hectares developed: ' . ($report->no_hec_developed ?? ''), 0, 0);
        $pdf->Cell(80, 5, 'No. of hectares undeveloped: ' . ($report->no_hect_undeveloped ?? ''), 0, 1);
        $pdf->Ln(4);

        // SECTION A: Kind and Extent of Improvements
        $startX = $pdf->GetX();

        // Fixed Column X Positions
        $col1X = $startX;        // Left column
        $col2X = $startX + 90;   // Date Introduced column
        $col3X = $startX + 138;  // Value/Cost column

        // --- HEADER ROW ---
        $pdf->SetFont($fontMain, 'B', 12);
        $pdf->Cell(90, 5, 'A. Kind and Extent of Improvements', 0, 0);
        $pdf->SetX($col2X);
        $pdf->Cell(42, 5, 'Date Introduced', 0, 0, 'C');
        $pdf->SetX($col3X);
        $pdf->Cell(42.8, 5, 'Value/Cost (Php)', 0, 1, 'R');

        $pdf->SetFont($fontMain, '', 12);

        // Reusable Helper Function for standard rows
        $printRow = function ($label, $date, $cost, $indent = 8) use ($pdf, $col1X, $col2X, $col3X) {
            $dateStr = !empty($date) ? $date : '_________________';
            $costStr = (is_numeric($cost) && (float) $cost > 0) ? number_format((float) $cost, 2) : '_________________';

            $pdf->SetX($col1X + $indent);
            $pdf->Cell(86 - $indent, 5, $label, 0, 0);

            $pdf->SetX($col2X);
            $pdf->Cell(42, 5, $dateStr, 0, 0, 'C');

            $pdf->SetX($col3X);
            $pdf->Cell(42.8, 5, $costStr, 0, 1, 'R');
        };

        // --- ITEM 1: Clearings ---
        $pdf->SetX($col1X + 4);
        $pdf->Cell(86, 5, '1. Clearings:', 0, 1); // Header row: no middle/right lines

        $printRow('Area Cleared: ' . ($improvements['area_cleared'] ?? '_______') . ' has.', $improvements['cleared_date'] ?? '', $improvements['cleared_cost'] ?? '', 8);
        $printRow('Main dike: ' . ($improvements['main_dike_lm'] ?? '_______') . ' lineal meters', $improvements['main_dike_date'] ?? '', $improvements['main_dike_cost'] ?? '', 8);
        $printRow('Secondary dikes: ' . ($improvements['secondary_dike_lm'] ?? '_______') . ' lineal meters', $improvements['secondary_dike_date'] ?? '', $improvements['secondary_dike_cost'] ?? '', 8);

        // --- ITEM 2: Excavation ---
        $printRow('2. Excavation: ' . ($improvements['excavation_cubic'] ?? '_______') . ' cubic meters', $improvements['excavation_date'] ?? '', $improvements['excavation_cost'] ?? '', 4);

        // --- ITEM 3: Gates ---
        $pdf->SetX($col1X + 4);
        $pdf->Cell(86, 5, '3. Gates:', 0, 1); // Header row: no middle/right lines

        $printRow('Concrete: ' . ($improvements['concrete_gates'] ?? '_______') . ' (number)', $improvements['concrete_gates_date'] ?? '', $improvements['concrete_gates_cost'] ?? '', 8);
        $printRow('Wooden: ' . ($improvements['wooden_gates'] ?? '_______') . ' (number)', $improvements['wooden_gates_date'] ?? '', $improvements['wooden_gates_cost'] ?? '', 8);

        // --- ITEM 4 & 5 (with trailing underline to fill left column) ---
        $houseDesc = !empty($improvements['house_desc']) ? $improvements['house_desc'] : '_________________';
        $printRow('4. House, etc. ' . $houseDesc, $improvements['house_date'] ?? '', $improvements['house_cost'] ?? '', 4);

        $equipDesc = !empty($improvements['equipment_desc']) ? $improvements['equipment_desc'] : '_________________';
        $printRow('5. Equipment, etc. ' . $equipDesc, $improvements['equipment_date'] ?? '', $improvements['equipment_cost'] ?? '', 4);

        // --- ITEM 6 & TOTAL VALUE ---
        $pdf->SetX($col1X + 4);
        $pdf->Cell(86, 5, '6. Assessed Value', 0, 0);

        $pdf->SetFont($fontMain, 'B', 12);
        $pdf->SetX($col2X);
        $pdf->Cell(42, 5, 'TOTAL VALUE:', 0, 0, 'R');

        $totalVal = $improvements['total_value'] ?? '';
        $totalStr = (is_numeric($totalVal) && (float) $totalVal > 0) ? number_format((float) $totalVal, 2) : '_________________';
        $pdf->SetX($col3X);
        $pdf->Cell(42.8, 5, $totalStr, 0, 1, 'R');

        $pdf->SetFont($fontMain, '', 12);

        // Sub-items under Assessed Value
        $actualApp = (isset($improvements['actual_appraisal']) && is_numeric($improvements['actual_appraisal'])) ? number_format((float) $improvements['actual_appraisal'], 2) : '_________________';
        $pdf->SetX($col1X + 8);
        $pdf->Cell(130, 5, 'Actual Appraisal - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -', 0, 0);
        $pdf->SetX($col3X);
        $pdf->Cell(42.8, 5, $actualApp, 0, 1, 'R');

        $taxDec = (isset($improvements['tax_declaration']) && is_numeric($improvements['tax_declaration'])) ? number_format((float) $improvements['tax_declaration'], 2) : '_________________';
        $pdf->SetX($col1X + 8);
        $pdf->Cell(130, 5, 'Under Tax Declaration - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -', 0, 0);
        $pdf->SetX($col3X);
        $pdf->Cell(42.8, 5, $taxDec, 0, 1, 'R');

        // --- ITEMS 7, 8, 9 ---
        $permVal = !empty($improvements['perm_workers']) ? $improvements['perm_workers'] : '_________________';
        $pdf->SetX($col1X + 4);
        $pdf->Cell(174.8, 5, '7. No. of Permanent Personnel/Workers Employed: ' . $permVal . ' (Attach proof of SSS', 0, 1);
        $pdf->SetX($col1X + 8);
        $pdf->Cell(166.8, 5, 'Contribution/Remittances)', 0, 1);

        $nonPermVal = !empty($improvements['non_perm_workers']) ? $improvements['non_perm_workers'] : '_________________';
        $pdf->SetX($col1X + 4);
        $pdf->Cell(174.8, 5, '8. No. of Non-Permanent Personnel/Workers Employed: ' . $nonPermVal, 0, 1);

        $fishrVal = !empty($improvements['fishr_workers']) ? $improvements['fishr_workers'] : '_________________';
        $pdf->SetX($col1X + 4);
        $pdf->Cell(174.8, 5, '9. No. of Personnel/Workers Registered in (FishR): ' . $fishrVal, 0, 1);

        $pdf->Ln(4);

        // SECTION B: Operation and Production
        $pdf->SetFont($fontMain, 'B', 12);
        $pdf->Cell($pageWidth, 5, 'B. Operation and Production', 0, 1);

        $pdf->Cell(50, 5, 'SPECIES STOCKED', 1, 0, 'C');
        $pdf->Cell(45, 5, 'SOURCE', 1, 0, 'C');
        $pdf->Cell(40, 5, 'QUANTITY', 1, 0, 'C');
        $pdf->Cell(42.8, 5, 'VALUE/COST (Php)', 1, 1, 'C');

        $pdf->SetFont($fontMain, '', 12);
        for ($i = 0; $i < 3; $i++) {
            $stock = $stockingRecords[$i] ?? [];
            $pdf->Cell(50, 5, $stock['species'] ?? '', 1, 0);
            $pdf->Cell(45, 5, $stock['source'] ?? '', 1, 0);
            $pdf->Cell(40, 5, $stock['quantity'] ?? '', 1, 0, 'C');
            $pdf->Cell(42.8, 5, isset($stock['cost']) ? number_format((float) $stock['cost'], 2) : '', 1, 1, 'R');
        }

        $pdf->Ln(3);
        $pdf->Cell(90, 5, 'Date of Stocking: ' . ($report->date_stocking ?? '__________________'), 0, 0);
        $pdf->Cell(87.8, 5, 'No. of Kilos harvested: ' . ($report->kilos_harvested ?? '__________________'), 0, 1);

        $pdf->Cell(90, 5, 'Date of Harvest: ' . ($report->date_harvest ?? '__________________'), 0, 0);
        $pdf->Cell(87.8, 5, 'Gross Sales: ' . ($report->gross_sales ?? '__________________'), 0, 1);


        // ================= PAGE 2 =================
        $pdf->AddPage();

        // Legal Note
        $pdf->SetFont($fontMain, 'I', 10);
        $noteText = "Note: Section 23(e) - Within one (1) year and six (6) months from the approval of the FLA/ASC, the area leased shall be developed and producing in commercial scale; provided, however, that within five (5) years from the approval of the FLA/ASC, the holder must have fully developed the area.";
        $pdf->MultiCell($pageWidth, 4.5, $noteText, 0, 'J');
        $pdf->Ln(4);

        // SECTION C
        $pdf->SetFont($fontMain, 'B', 12);
        $pdf->Cell($pageWidth, 5, 'C. Verification of Presence of Facilities that minimize Environmental pollution', 0, 1);
        $pdf->SetFont($fontMain, '', 12);
        $pdf->Cell($pageWidth, 5, '   (   ) Nursery: __________________(Has.)', 0, 1);
        $pdf->Cell($pageWidth, 5, '   (   ) Transition: __________________(Has.)', 0, 1);
        $pdf->Cell($pageWidth, 5, '   (   ) Rearing: __________________(Has.)', 0, 1);
        $pdf->Cell($pageWidth, 5, '   (   ) Canal: __________________(Has.)', 0, 1);
        $pdf->Cell($pageWidth, 5, '   (   ) Others:_________________(Has.)', 0, 1);
        $pdf->Ln(4);

        // SECTION D
        $pdf->SetFont($fontMain, 'B', 12);
        $pdf->Cell($pageWidth, 5, 'D. Case status of the area', 0, 1);
        $pdf->SetFont($fontMain, '', 12);
        $pdf->Cell($pageWidth, 5, '   1. With pending administrative case ____ (  )Yes or (  )No', 0, 1);
        $pdf->Cell($pageWidth, 5, '   2. With pending judicial case ___________ (  )Yes or (  )No', 0, 1);
        $pdf->Ln(4);

        // SECTION E: Remarks
        $pdf->SetFont($fontMain, 'B', 12);
        $pdf->Cell($pageWidth, 5, 'E. Remarks and Recommendation/s:', 0, 1);
        $pdf->SetFont($fontMain, '', 12);
        $pdf->MultiCell($pageWidth, 5, $report->remarks_recommendation ?? 'None', 0, 'L');
        $pdf->Ln(10);

        // Inspecting Officer
        $pdf->Cell(97.8, 5, '', 0, 0);
        $pdf->Cell(80, 5, 'Very truly yours,', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->Cell(97.8, 5, '', 0, 0);
        $pdf->Cell(80, 5, $report->inspecting_officer ?? '_________________', 'B', 1, 'C');
        $pdf->Cell(97.8, 5, '', 0, 0);
        $pdf->Cell(80, 5, 'Inspecting Officer', 0, 1, 'C');
        $pdf->Ln(8);

        // CERTIFICATION Block
        $pdf->SetFont($fontMain, 'B', 12);
        $pdf->Cell($pageWidth, 6, 'C E R T I F I C A T I O N', 0, 1, 'C');
        $pdf->SetFont($fontMain, '', 12);
        $pdf->Ln(3);

        $certText = sprintf(
            "I, %s, under my official oath, do hereby certify that I have personally conducted a thorough, actual inspection and verification of the fishpond area treated in the foregoing report and all statements of facts are true and correct.\n\nI am fully aware that any false or misleading statements I have stated in the said report will subject me to appropriate disciplinary action which may be summary dismissal from the service.",
            $report->inspecting_officer ?? '___________________'
        );
        $pdf->MultiCell($pageWidth, 5, $certText, 0, 'J');
        $pdf->Ln(5);

        $pdf->Cell($pageWidth, 5, 'IN WITNESS WHEREOF, I have hereunto set my signature this ______ day of _______________ at __________________.', 0, 1);
        $pdf->Ln(10);

        $pdf->Cell(97.8, 5, '', 0, 0);
        $pdf->Cell(80, 5, '(Signature over Printed Name)', 'T', 1, 'C');
        $pdf->Ln(5);

        $pdf->Cell(90, 5, 'Noted by:', 0, 0);
        $pdf->Cell(87.8, 5, '', 0, 1);
        $pdf->Ln(8);
        $pdf->Cell(90, 5, '__________________', 0, 0);
        $pdf->Cell(87.8, 5, 'Notary Public', 0, 1, 'R');
        $pdf0 = $pdf->Cell(90, 5, 'Designation', 0, 1);


        // ================= PAGE 3 =================
        $pdf->AddPage();
        $pdf->SetFont($fontMain, 'B', 12);
        $pdf->Cell($pageWidth, 6, 'SKETCH OF THE AREA SHOWING IMPROVEMENTS WITH RECENT PHOTOS SHOWING THE', 0, 1, 'C');
        $pdf->Cell($pageWidth, 6, 'ACTUAL STATUS OF THE AREA', 0, 1, 'C');

        return response($pdf->Output('S', "Inspection_Report_{$report->fla_no}.pdf"), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "inline; filename=\"Inspection_Report_{$report->fla_no}.pdf\"");
    }
}