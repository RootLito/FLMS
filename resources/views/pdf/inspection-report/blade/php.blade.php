<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>REPORT OF INSPECTION AND VERIFICATION OF IMPROVEMENTS</title>
    <style>
        @page {
            size: 8in 13in;
            margin: 0.5in;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .underline { text-decoration: underline; }

        .header {
            margin-bottom: 15px;
        }
        .header h3 {
            margin: 0;
            font-size: 13px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table-bordered, .table-bordered th, .table-bordered td {
            border: 1px solid #000;
            padding: 4px;
        }

        .dotted-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            padding-left: 5px;
            padding-right: 5px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <div class="header text-center font-bold">
        <h3>REPORT OF INSPECTION AND VERIFICATION OF IMPROVEMENTS</h3>
    </div>

    <table style="width: 100%;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%; text-align: right;">
                Date: <span class="underline">{{ $report->date_inspection ? \Carbon\Carbon::parse($report->date_inspection)->format('F d, Y') : '___________________' }}</span>
            </td>
        </tr>
    </table>

    <p>
        <strong>The Director</strong><br>
        Bureau of Fisheries and Aquatic Resources<br>
        3/F Main Building, Fisheries Building Complex<br>
        Visayas Avenue, Diliman, Quezon City
    </p>

    <p>Sir:</p>

    <p style="text-align: justify; text-indent: 30px;">
        I have the honor to inform you that an ocular inspection and verification of improvements was conducted by the undersigned in the fishpond area covered by FLA/ASC/Fp. A. No. <span class="font-bold underline">{{ $report->fla_no }}</span> located in Bgry. <span class="font-bold underline">{{ $report->barangay ?? '________' }}</span>, Municipality of <span class="font-bold underline">{{ $report->municipality ?? '________' }}</span>, Province of <span class="font-bold underline">{{ $report->province ?? '________' }}</span>, and I hereby certify that the following are the kind and extent of improvements found existing in the area and production thereof[cite: 1, 2].
    </p>

    <table>
        <tr>
            <td style="width: 60%;"><strong>Name of Lessee/Applicant:</strong> <span class="underline">{{ $report->lessee->full_name ?? '' }}</span></td>
            <td style="width: 40%;"><strong>FLA/ASC/Fp. A. No.</strong> <span class="underline">{{ $report->fla_no }}</span></td>
        </tr>
        <tr>
            <td><strong>Address:</strong> <span class="underline">{{ $report->lessee->address ?? '' }}</span></td>
            <td><strong>Date Issued:</strong> <span class="underline">{{ $report->date_issued ? \Carbon\Carbon::parse($report->date_issued)->format('m/d/Y') : '' }}</span></td>
        </tr>
        <tr>
            <td><strong>No. of hectares granted:</strong> <span class="underline">{{ $report->no_hec_granted }}</span></td>
            <td><strong>Date of Expiration:</strong> <span class="underline">{{ $report->date_expire ? \Carbon\Carbon::parse($report->date_expire)->format('m/d/Y') : '' }}</span></td>
        </tr>
        <tr>
            <td><strong>No. of hectares developed:</strong> <span class="underline">{{ $report->no_hec_developed }}</span></td>
            <td><strong>No. of hectares undeveloped:</strong> <span class="underline">{{ $report->no_hect_undeveloped }}</span></td>
        </tr>
    </table>

    <div class="section-title">A. Kind and Extent of Improvements[cite: 1, 2]</div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Kind and Extent of Improvements[cite: 1, 2]</th>
                <th>Date Introduced[cite: 1, 2]</th>
                <th>Value/Cost (Php)[cite: 1, 2]</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>1. Clearings:</strong><br>
                    Area Cleared: {{ $report->improvements['area_cleared'] ?? '____' }} has.<br>
                    Main dike: {{ $report->improvements['main_dike'] ?? '____' }} lineal meters<br>
                    Secondary dikes: {{ $report->improvements['secondary_dike'] ?? '____' }} lineal meters[cite: 1, 2]
                </td>
                <td>{{ $report->improvements['clearings_date'] ?? '' }}</td>
                <td>{{ $report->improvements['clearings_cost'] ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>2. Excavation:</strong> {{ $report->improvements['excavation_cubic'] ?? '____' }} cubic meters[cite: 1, 2]</td>
                <td>{{ $report->improvements['excavation_date'] ?? '' }}</td>
                <td>{{ $report->improvements['excavation_cost'] ?? '' }}</td>
            </tr>
            <tr>
                <td>
                    <strong>3. Gates:</strong><br>
                    Concrete: {{ $report->improvements['gates_concrete'] ?? '____' }} (number)<br>
                    Wooden: {{ $report->improvements['gates_wooden'] ?? '____' }} (number)[cite: 1, 2]
                </td>
                <td>{{ $report->improvements['gates_date'] ?? '' }}</td>
                <td>{{ $report->improvements['gates_cost'] ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>4. House, etc.:</strong> {{ $report->improvements['house_desc'] ?? '' }}[cite: 1, 2]</td>
                <td>{{ $report->improvements['house_date'] ?? '' }}</td>
                <td>{{ $report->improvements['house_cost'] ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>5. Equipment, etc.:</strong> {{ $report->improvements['equipment_desc'] ?? '' }}[cite: 1, 2]</td>
                <td>{{ $report->improvements['equipment_date'] ?? '' }}</td>
                <td>{{ $report->improvements['equipment_cost'] ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>6. Assessed Value</strong><br>
                    Actual Appraisal: {{ $report->financial_values['actual_appraisal'] ?? '________________' }}<br>
                    Under Tax Declaration: {{ $report->financial_values['tax_declaration'] ?? '________________' }}[cite: 1, 2]
                </td>
                <td>
                    <strong>TOTAL VALUE:</strong><br>
                    {{ $report->financial_values['total_value'] ?? '' }}[cite: 1, 2]
                </td>
            </tr>
        </tbody>
    </table>

    <p style="margin: 2px 0;"><strong>7. No. of Permanent Personnel/Workers Employed:</strong> {{ $report->improvements['perm_workers'] ?? '____' }}[cite: 1, 2]</p>
    <p style="margin: 2px 0;"><strong>8. No. of Non-Permanent Personnel/Workers Employed:</strong> {{ $report->improvements['non_perm_workers'] ?? '____' }}[cite: 1, 2]</p>
    <p style="margin: 2px 0;"><strong>9. No. of Personnel/Workers Registered in (FishR):</strong> {{ $report->improvements['fishr_workers'] ?? '____' }}[cite: 1, 2]</p>

    <div class="section-title">B. Operation and Production[cite: 1, 2]</div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th>SPECIES STOCKED[cite: 1, 2]</th>
                <th>SOURCE[cite: 1, 2]</th>
                <th>QUANTITY[cite: 1, 2]</th>
                <th>VALUE/COST (Php)[cite: 1, 2]</th>
            </tr>
        </thead>
        <tbody>
            @forelse($report->stocking_records ?? [] as $stock)
            <tr>
                <td>{{ $stock['species'] ?? '' }}</td>
                <td>{{ $stock['source'] ?? '' }}</td>
                <td>{{ $stock['quantity'] ?? '' }}</td>
                <td>{{ $stock['cost'] ?? '' }}</td>
            </tr>
            @empty
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table style="width: 100%;">
        <tr>
            <td><strong>Date of Stocking:</strong> {{ $report->stocking['date'] ?? '________________' }}[cite: 1, 2]</td>
            <td><strong>No. of Kilos harvested:</strong> {{ $report->harvesting['kilos'] ?? '________________' }}[cite: 1, 2]</td>
        </tr>
        <tr>
            <td><strong>Date of Harvest:</strong> {{ $report->harvesting['date'] ?? '________________' }}[cite: 1, 2]</td>
            <td><strong>Gross Sales:</strong> {{ $report->harvesting['sales'] ?? '________________' }}[cite: 1, 2]</td>
        </tr>
        <tr>
            <td><strong>Markets:</strong> Domestic: {{ $report->marketing['domestic'] ?? '__________' }}[cite: 1, 2]</td>
            <td><strong>No. of Kilos:</strong> {{ $report->marketing['domestic_kilos'] ?? '__________' }}[cite: 1, 2]</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Export: {{ $report->marketing['export'] ?? '__________' }}[cite: 1, 2]</td>
            <td><strong>No. of Kilos:</strong> {{ $report->marketing['export_kilos'] ?? '__________' }}[cite: 1, 2]</td>
        </tr>
    </table>

    <div class="section-title">C. Verification of Presence of Facilities that minimize Environmental pollution[cite: 1, 2]</div>
    <p style="margin: 2px 0;">
        ( {{ isset($report->pond_types['nursery']) ? 'X' : ' ' }} ) Nursery: {{ $report->pond_types['nursery_has'] ?? '______' }} (Has.)[cite: 1, 2]<br>
        ( {{ isset($report->pond_types['transition']) ? 'X' : ' ' }} ) Transition: {{ $report->pond_types['transition_has'] ?? '______' }} (Has.)[cite: 1, 2]<br>
        ( {{ isset($report->pond_types['rearing']) ? 'X' : ' ' }} ) Rearing: {{ $report->pond_types['rearing_has'] ?? '______' }} (Has.)[cite: 1, 2]<br>
        ( {{ isset($report->pond_types['canal']) ? 'X' : ' ' }} ) Canal: {{ $report->pond_types['canal_has'] ?? '______' }} (Has.)[cite: 1, 2]<br>
        ( {{ isset($report->pond_types['others']) ? 'X' : ' ' }} ) Others: {{ $report->pond_types['others_has'] ?? '______' }} (Has.)[cite: 1, 2]
    </p>

    <div class="section-title">D. Case status of the area[cite: 1, 2]</div>
    <p style="margin: 2px 0;">1. With pending administrative case: {{ $report->with_pending_admin_case ? '( X ) Yes (   ) No' : '(   ) Yes ( X ) No' }}[cite: 1, 2]</p>
    <p style="margin: 2px 0;">2. With pending judicial case: {{ $report->with_pending_judicial_case ? '( X ) Yes (   ) No' : '(   ) Yes ( X ) No' }}[cite: 1, 2]</p>

    <div class="section-title">E. Remarks and Recommendation/s:[cite: 1, 2]</div>
    <div style="border: 1px solid #000; padding: 5px; min-height: 50px;">
        {{ $report->remarks ?? 'N/A' }}
    </div>

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center;">
                Very truly yours,<br><br><br>
                ________________________________________________<br>
                <strong>Inspecting Officer</strong>[cite: 1, 2]
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    {{-- Page 2: Certification & Sketch --}}
    <div class="text-center font-bold" style="margin-top: 20px;">
        <h3>C E R T I F I C A T I O N</h3>[cite: 1, 2]
    </div>

    <p style="text-align: justify; text-indent: 30px;">
        I, ________________________________________, under my official oath, do hereby certify that I have personally conducted a thorough, actual inspection and verification of the fishpond area treated in the foregoing report and all statements of facts are true and correct.[cite: 1, 2]
    </p>

    <p style="text-align: justify; text-indent: 30px;">
        I am fully aware that any false or misleading statements I have stated in the said report will subject me to appropriate disciplinary action which may be summary dismissal from the service.[cite: 1, 2]
    </p>

    <p style="text-align: justify; text-indent: 30px;">
        IN WITNESS WHEREOF, I have hereunto set my signature this _______ day of _________________ at ____________________________________________.[cite: 1, 2]
    </p>

    <table style="width: 100%; margin-top: 30px;">
        <tr>
            <td style="width: 50%;">
                Noted by:<br><br><br>
                _____________________________________________ <br>
                <strong>Designation</strong>[cite: 1, 2]
            </td>
            <td style="width: 50%; text-align: center;">
                <br><br>
                ________________________________________________<br>
                <strong>(Signature over Printed Name)</strong><br><br>
                <strong>Notary Public</strong>[cite: 1, 2]
            </td>
        </tr>
    </table>

    <div style="margin-top: 40px;" class="text-center font-bold">
        <p>SKETCH OF THE AREA SHOWING IMPROVEMENTS WITH RECENT PHOTOS SHOWING THE ACTUAL STATUS OF THE AREA</p>[cite: 1, 2]
    </div>

</body>
</html>