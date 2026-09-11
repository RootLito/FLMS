<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <title>REPORT OF INSPECTION AND VERIFICATION OF IMPROVEMENTS</title>
    <style>
        @page {
            size: 8.5in 13in;
            margin-top: 1.5in;
            margin-bottom: 1.0in;
            margin-left: 0.75in;
            margin-right: 0.75in;
            font-family: 'Cambria';
            line-height: 1.25;
        }
    </style>
</head>

<body>

    {{-- PAGE 1 --}}
    <div class="header text-center font-bold">
        <h3 class="text-center">REPORT OF INSPECTION AND VERIFICATION OF IMPROVEMENTS</h3>
    </div>

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center;">
                ____________________________________<br>
                Date
            </td>
        </tr>
    </table>

    <p style="margin-bottom: 8px;">
        <strong>The Director</strong><br>
        Bureau of Fisheries and Aquatic Resources<br>
        3/F Main Building, Fisheries Building Complex<br>
        Visayas Avenue, Diliman, Quezon City
    </p>

    <p style="margin-bottom: 8px;">Sir:</p>

    <p style="text-align: justify; text-indent: 30px; margin-bottom: 10px;">
        I have the honor to inform you that an ocular inspection and verification of improvements was conducted by the
        undersigned in the fishpond area covered by FLA/ASC/Fp. A. No. <span
            class="underline">{{ $report->fla_no ?? '________________' }}</span> located in Bgry. <span
            class="underline">{{ $report->barangay ?? '___________________' }}</span>, Municipality of <span
            class="underline">{{ $report->municipality ?? '_______________________' }}</span>, Province of <span
            class="underline">{{ $report->province ?? '__________________________' }}</span>, and I hereby certify that
        the following are the kind and extent of improvements found existing in the area and production thereof.
    </p>

    <table style="width: 100%; margin-bottom: 8px;">
        <tr>
            <td style="width: 55%;"><strong>Name of Lessee/Applicant:</strong> <span
                    class="underline">{{ $report->lessee->full_name ?? '___________________________________' }}</span>
            </td>
            <td style="width: 45%;"><strong>FLA/ASC/Fp. A. No.</strong> <span
                    class="underline">{{ $report->fla_no ?? '_________________' }}</span></td>
        </tr>
        <tr>
            <td><strong>Address:</strong> <span class="underline">{{ $report->barangay }}, {{ $report->municipality }},
                    {{ $report->province }}</span></td>
            <td><strong>Date Issued:</strong> <span
                    class="underline">{{ $report->date_issued ? \Carbon\Carbon::parse($report->date_issued)->format('m/d/Y') : '__________________________' }}</span>
            </td>
        </tr>
        <tr>
            <td><strong>No. of hectares granted:</strong> <span
                    class="underline">{{ $report->no_hec_granted ?? '_______________________________________' }}</span>
            </td>
            <td><strong>Date of Expiration:</strong> <span
                    class="underline">{{ $report->date_expire ? \Carbon\Carbon::parse($report->date_expire)->format('m/d/Y') : '__________________' }}</span>
            </td>
        </tr>
        <tr>
            <td><strong>No. of hectares developed:</strong> <span
                    class="underline">{{ $report->no_hec_developed ?? '____________________________________' }}</span>
            </td>
            <td><strong>No. of hectares undeveloped:</strong> <span
                    class="underline">{{ $report->no_hect_undeveloped ?? '_______' }}</span></td>
        </tr>
    </table>

    <div class="section-title">A. Kind and Extent of Improvements</div>
    <table style="width: 100%;">
        <thead>
            <tr>
                <th style="width: 50%; text-align: left;"></th>
                <th style="width: 25%; text-align: left;">Date Introduced[cite: 1]</th>
                <th style="width: 25%; text-align: left;">Value/Cost (Php)[cite: 1]</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3"><strong>1. Clearings:</strong></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Area Cleared: <span
                        class="underline">{{ $report->improvements['area_cleared'] ?? '________________' }}</span> has.
                </td>
                <td><span
                        class="underline">{{ $report->improvements['area_cleared_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['area_cleared_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Main dike: <span
                        class="underline">{{ $report->improvements['main_dike'] ?? '______________' }}</span> lineal
                    meters</td>
                <td><span
                        class="underline">{{ $report->improvements['main_dike_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['main_dike_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Secondary dikes: <span
                        class="underline">{{ $report->improvements['secondary_dike'] ?? '__________' }}</span> lineal
                    meters[cite: 1]</td>
                <td><span
                        class="underline">{{ $report->improvements['secondary_dike_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['secondary_dike_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td><strong>2. Excavation:</strong> <span
                        class="underline">{{ $report->improvements['excavation_cubic'] ?? '_________________' }}</span>
                    cubic meters[cite: 1]</td>
                <td><span
                        class="underline">{{ $report->improvements['excavation_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['excavation_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="3"><strong>3. Gates:</strong></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Concrete: <span
                        class="underline">{{ $report->improvements['gates_concrete'] ?? '____________________' }}</span>
                    (number)[cite: 1]</td>
                <td><span
                        class="underline">{{ $report->improvements['gates_concrete_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['gates_concrete_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Wooden: <span
                        class="underline">{{ $report->improvements['gates_wooden'] ?? '____________________' }}</span>
                    (number)[cite: 1]</td>
                <td><span
                        class="underline">{{ $report->improvements['gates_wooden_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['gates_wooden_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td><strong>4. House, etc.</strong> <span
                        class="underline">{{ $report->improvements['house_desc'] ?? '_____________________________' }}</span>[cite:
                    1]</td>
                <td><span class="underline">{{ $report->improvements['house_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['house_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td><strong>5. Equipment, etc.</strong> <span
                        class="underline">{{ $report->improvements['equipment_desc'] ?? '_______________________' }}</span>[cite:
                    1]</td>
                <td><span
                        class="underline">{{ $report->improvements['equipment_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['equipment_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td><strong>6. Assessed Value</strong></td>
                <td><strong>TOTAL VALUE:</strong></td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Actual Appraisal - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    - -[cite: 1]</td>
                <td colspan="2"><span
                        class="underline">{{ $report->financial_values['actual_appraisal'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Under Tax Declaration - - - - - - - - - - - - - - - - - - - - - - -
                    -[cite: 1]</td>
                <td colspan="2"><span
                        class="underline">{{ $report->financial_values['tax_declaration'] ?? '________________________' }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="margin: 3px 0;"><strong>7. No. of Permanent Personnel/Workers Employed:</strong> <span
            class="underline">{{ $report->improvements['perm_workers'] ?? '_____________________' }}</span> (Attach
        proof of SSS Contribution/Remittances)[cite: 1]</p>
    <p style="margin: 3px 0;"><strong>8. No. of Non-Permanent Personnel/Workers Employed:</strong> <span
            class="underline">{{ $report->improvements['non_perm_workers'] ?? '________________________' }}</span></p>
    <p style="margin: 3px 0;"><strong>9. No. of Personnel/Workers Registered in (FishR):</strong> <span
            class="underline">{{ $report->improvements['fishr_workers'] ?? '____________________' }}</span>[cite: 1]
    </p>

    <div class="section-title">B. Operation and Production</div>
    <table style="width: 100%;">
        <thead>
            <tr>
                <th style="width: 30%; text-align: left;">SPECIES STOCKED[cite: 1]</th>
                <th style="width: 25%; text-align: left;">SOURCE[cite: 1]</th>
                <th style="width: 20%; text-align: left;">QUANTITY[cite: 1]</th>
                <th style="width: 25%; text-align: left;">VALUE/COST (Php)[cite: 1]</th>
            </tr>
        </thead>
        <tbody>
            @forelse($report->stocking_records ?? [] as $index => $stock)
                <tr>
                    <td>{{ $index + 1 }}. {{ $stock['species'] ?? '_____________________' }}</td>
                    <td>{{ $stock['source'] ?? '________________________' }}</td>
                    <td>{{ $stock['quantity'] ?? '_____________' }}</td>
                    <td>{{ $stock['cost'] ?? '_______________________' }}</td>
                </tr>
            @empty
                <tr>
                    <td>1. _____________________</td>
                    <td>________________________</td>
                    <td>_____________</td>
                    <td>_______________________</td>
                </tr>
                <tr>
                    <td>2. _____________________</td>
                    <td>________________________</td>
                    <td>_____________</td>
                    <td>_______________________</td>
                </tr>
                <tr>
                    <td>3. _____________________</td>
                    <td>________________________</td>
                    <td>_____________</td>
                    <td>_______________________</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 4px;">
        <tr>
            <td style="width: 50%;"><strong>4. Date of Stocking:</strong> <span
                    class="underline">{{ $report->stocking['date'] ?? '______________________________' }}</span>[cite:
                1]</td>
            <td style="width: 50%;"><strong>No. of Kilos harvested:</strong> <span
                    class="underline">{{ $report->harvesting['kilos'] ?? '______________________' }}</span>[cite: 1]
            </td>
        </tr>
        <tr>
            <td><strong>5. Date of Harvest:</strong> <span
                    class="underline">{{ $report->harvesting['date'] ?? '_______________________________' }}</span>[cite:
                1]</td>
            <td><strong>Gross Sales:</strong> <span
                    class="underline">{{ $report->harvesting['sales'] ?? '_________________________________' }}</span>[cite:
                1]</td>
        </tr>
        <tr>
            <td><strong>6. Markets: Domestic:</strong> <span
                    class="underline">{{ $report->marketing['domestic'] ?? '____________________________' }}</span>[cite:
                1]</td>
            <td><strong>No. of Kilos:</strong> <span
                    class="underline">{{ $report->marketing['domestic_kilos'] ?? '____________________________' }}</span>[cite:
                1]</td>
        </tr>
        <tr>
            <td style="padding-left: 45px;"><strong>Export:</strong> <span
                    class="underline">{{ $report->marketing['export'] ?? '______________________________' }}</span>[cite:
                1]</td>
            <td><strong>No. of Kilos:</strong> <span
                    class="underline">{{ $report->marketing['export_kilos'] ?? '____________________________' }}</span>[cite:
                1]</td>
        </tr>
    </table>

    <div class="page-break"></div>

    {{-- PAGE 2 --}}
    <div class="note-header">
        <strong>Note: Section 23(e)</strong> - Within one (1) year and six (6) months from the approval of the FLA/ASC,
        the area leased shall be developed and producing in commercial scale; provided, however, that within five (5)
        years from the approval of the FLA/ASC, the holder must have fully developed the area.[cite: 1]
    </div>

    <div class="section-title">C. Verification of Presence of Facilities that minimize Environmental pollution</div>
    <p style="margin: 2px 0;">
        ( {{ isset($report->pond_types['nursery']) ? 'X' : ' ' }} ) Nursery: <span
            class="underline">{{ $report->pond_types['nursery_has'] ?? '___________________________' }}</span>
        (Has.)[cite: 1]<br>
        ( {{ isset($report->pond_types['transition']) ? 'X' : ' ' }} ) Transition: <span
            class="underline">{{ $report->pond_types['transition_has'] ?? '________________________' }}</span>
        (Has.)[cite: 1]<br>
        ( {{ isset($report->pond_types['rearing']) ? 'X' : ' ' }} ) Rearing: <span
            class="underline">{{ $report->pond_types['rearing_has'] ?? '___________________________' }}</span>
        (Has.)[cite: 1]<br>
        ( {{ isset($report->pond_types['canal']) ? 'X' : ' ' }} ) Canal: <span
            class="underline">{{ $report->pond_types['canal_has'] ?? '______________________________' }}</span>
        (Has.)[cite: 1]<br>
        ( {{ isset($report->pond_types['others']) ? 'X' : ' ' }} ) Others: <span
            class="underline">{{ $report->pond_types['others_has'] ?? '_____________________________' }}</span>
        (Has.)[cite: 1]
    </p>

    <div class="section-title" style="margin-top: 10px;">D. Case status of the area</div>
    <p style="margin: 2px 0;">1. With pending administrative case ____ (
        {{ !empty($report->with_pending_admin_case) ? 'X' : ' ' }} ) Yes or (
        {{ empty($report->with_pending_admin_case) ? 'X' : ' ' }} ) No[cite: 1]</p>
    <p style="margin: 2px 0;">2. With pending judicial case ____________(
        {{ !empty($report->with_pending_judicial_case) ? 'X' : ' ' }} ) Yes or (
        {{ empty($report->with_pending_judicial_case) ? 'X' : ' ' }} ) No[cite: 1]</p>

    <div class="section-title" style="margin-top: 10px;">E. Remarks and Recommendation/s:</div>
    <table class="remarks-lines">
        @php
            $remarksText = $report->remarks ?? '';
            $lines = explode("\n", wordwrap($remarksText, 100, "\n"));
            $totalLines = max(10, count($lines));
        @endphp
        @for ($i = 0; $i < $totalLines; $i++)
            <tr>
                <td>{{ $lines[$i] ?? '' }}</td>
            </tr>
        @endfor
    </table>

    <table style="width: 100%; margin-top: 25px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center;">
                Very truly yours,<br><br><br>
                ________________________________________________<br>
                <em>Inspecting Officer</em>[cite: 1]<br><br><br>
                ________________________________________________<br>
                <em>Date of Inspection</em>[cite: 1]
            </td>
        </tr>
    </table>

    <div class="text-center font-bold" style="margin-top: 30px; margin-bottom: 15px;">
        <h3>C E R T I F I C A T I O N</h3>
    </div>

    <p style="text-align: justify; text-indent: 30px; line-height: 1.4;">
        I, <span
            class="underline">{{ $report->inspecting_officer_name ?? '________________________________________' }}</span>,
        under my official oath, do hereby certify that I have personally conducted a thorough, actual inspection and
        verification of the fishpond area treated in the foregoing report and all statements of facts are true and
        correct.[cite: 1]
    </p>

    <p style="text-align: justify; text-indent: 30px; line-height: 1.4;">
        I am fully aware that any false or misleading statements I have stated in the said report will subject me to
        appropriate disciplinary action which may be summary dismissal from the service.[cite: 1]
    </p>

    <p style="text-align: justify; text-indent: 30px; line-height: 1.4;">
        IN WITNESS WHEREOF, I have hereunto set my signature this _______ day of _________________ at
        ____________________________________________.[cite: 1]
    </p>

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center;">
                ________________________________________________<br>
                <strong>(Signature over Printed Name)</strong>[cite: 1]
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 15px;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                Noted by:<br><br>
                _____________________________________________ <br>
                <strong>Designation</strong>[cite: 1]
            </td>
            <td style="width: 50%; text-align: center; vertical-align: top;">
                <br><br>
                <strong>Notary Public</strong>[cite: 1]
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    {{-- PAGE 3 --}}
    <div style="margin-top: 20px;" class="text-center font-bold">
        <p>SKETCH OF THE AREA SHOWING IMPROVEMENTS WITH RECENT PHOTOS SHOWING THE ACTUAL STATUS OF THE AREA</p>[cite: 1]
    </div>

</body>

</html>
