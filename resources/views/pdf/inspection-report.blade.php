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
            font-family: 'Cambria', serif;
            line-height: 1.25;
        }

        body {
            font-family: 'Cambria', serif;
            font-size: 11pt;
        }

        .text-center {
            text-align: center;
        }

        .text-justify {
            text-align: justify;
        }

        .font-bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .indent {
            text-indent: 30px;
        }

        .page-break {
            page-break-before: always;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        td,
        th {
            vertical-align: top;
            padding: 2px 0;
        }
    </style>
</head>

<body>

    {{-- PAGE 1 --}}
    <div class="text-center font-bold" style="margin-bottom: 20px;">
        <h3>REPORT OF INSPECTION AND VERIFICATION OF IMPROVEMENTS</h3>
    </div>

    <table>
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%; text-align: center;">
                ____________________________________<br>
                Date
            </td>
        </tr>
    </table>

    <p style="margin-bottom: 15px;">
        <strong>The Director</strong><br>
        Bureau of Fisheries and Aquatic Resources<br>
        3/F Main Building, Fisheries Building Complex<br>
        Visayas Avenue, Diliman, Quezon City
    </p>

    <p>Sir: </p>

    <p class="text-justify indent" style="margin-bottom: 15px;">
        I have the honor to inform you that an ocular inspection and verification of improvements was conducted by the
        undersigned in the fishpond area covered by FLA/ASC/Fp. A. No. <span
            class="underline">{{ $report->fla_no ?? '________________' }}</span> located in Bgry. <span
            class="underline">{{ $report->barangay ?? '___________________' }}</span>, Municipality of <span
            class="underline">{{ $report->municipality ?? '_______________________' }}</span>, Province of <span
            class="underline">{{ $report->province ?? '__________________________' }}</span>, and I hereby certify that
        the following are the kind and extent of improvements found existing in the area and production thereof.
    </p>

    <table>
        <tr>
            <td style="width: 55%;">Name of Lessee/Applicant: <span
                    class="underline">{{ $report->lessee->full_name ?? '___________________________________' }}</span>
            </td>
            <td style="width: 45%;">FLA/ASC/Fp. A. No. <span
                    class="underline">{{ $report->fla_no ?? '_________________' }}</span></td>
        </tr>
        <tr>
            <td>Address: <span class="underline">{{ $report->barangay }}, {{ $report->municipality }},
                    {{ $report->province }}</span></td>
            <td>Date Issued: <span
                    class="underline">{{ $report->date_issued ? \Carbon\Carbon::parse($report->date_issued)->format('m/d/Y') : '__________________________' }}</span>
            </td>
        </tr>
        <tr>
            <td>No. of hectares granted: <span
                    class="underline">{{ $report->no_hec_granted ?? '_______________________________________' }}</span>
            </td>
            <td>Date of Expiration: <span
                    class="underline">{{ $report->date_expire ? \Carbon\Carbon::parse($report->date_expire)->format('m/d/Y') : '__________________' }}</span>
            </td>
        </tr>
        <tr>
            <td>No. of hectares developed: <span
                    class="underline">{{ $report->no_hec_developed ?? '____________________________________' }}</span>
            </td>
            <td>No. of hectares undeveloped: <span
                    class="underline">{{ $report->no_hect_undeveloped ?? '_______' }}</span></td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width: 50%; text-align: left;">Kind and Extent of Improvements</th>
                <th style="width: 25%; text-align: left;">Date Introduced</th>
                <th style="width: 25%; text-align: left;">Value/Cost (Php)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3">Clearings:</td>
            </tr>
            <tr>
                <td>Area Cleared:<span
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
                <td>Main dike:<span
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
                <td>Secondary dikes:<span
                        class="underline">{{ $report->improvements['secondary_dike'] ?? '__________' }}</span> lineal
                    meters</td>
                <td><span
                        class="underline">{{ $report->improvements['secondary_dike_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['secondary_dike_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td>Excavation:<span
                        class="underline">{{ $report->improvements['excavation_cubic'] ?? '_________________' }}</span>
                    cubic meters</td>
                <td><span
                        class="underline">{{ $report->improvements['excavation_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['excavation_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="3">Gates:</td>
            </tr>
            <tr>
                <td>Concrete: <span
                        class="underline">{{ $report->improvements['gates_concrete'] ?? '____________________' }}</span>
                    (number)</td>
                <td><span
                        class="underline">{{ $report->improvements['gates_concrete_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['gates_concrete_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td>Wooden:<span
                        class="underline">{{ $report->improvements['gates_wooden'] ?? '____________________' }}</span>
                    (number)</td>
                <td><span
                        class="underline">{{ $report->improvements['gates_wooden_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['gates_wooden_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td>House, etc.<span
                        class="underline">{{ $report->improvements['house_desc'] ?? '_____________________________' }}</span>
                </td>
                <td><span class="underline">{{ $report->improvements['house_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['house_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td>Equipment, etc. <span
                        class="underline">{{ $report->improvements['equipment_desc'] ?? '_______________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['equipment_date'] ?? '_____________________' }}</span>
                </td>
                <td><span
                        class="underline">{{ $report->improvements['equipment_cost'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td>Assessed Value</td>
                <td>TOTAL VALUE:</td>
                <td><span
                        class="underline">{{ $report->improvements['total_value'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">Actual Appraisal - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</td>
                <td><span
                        class="underline">{{ $report->financial_values['actual_appraisal'] ?? '________________________' }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">Under Tax Declaration - - - - - - - - - - - - - - - - - - - - - - - -</td>
                <td><span
                        class="underline">{{ $report->financial_values['tax_declaration'] ?? '________________________' }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="margin: 4px 0;">No. of Permanent Personnel/Workers Employed: <span
            class="underline">{{ $report->improvements['perm_workers'] ?? '_____________________' }}</span> (Attach
        proof of SSS Contribution/Remittances)</p>
    <p style="margin: 4px 0;">No. of Non-Permanent Personnel/Workers Employed: <span
            class="underline">{{ $report->improvements['non_perm_workers'] ?? '________________________' }}</span></p>
    <p style="margin: 4px 0;">No. of Personnel/Workers Registered in (FishR): <span
            class="underline">{{ $report->improvements['fishr_workers'] ?? '____________________' }}</span></p>

    <div style="margin-top: 10px;">Operation and Production</div>
    <table>
        <thead>
            <tr>
                <th style="width: 30%; text-align: left;">SPECIES STOCKED</th>
                <th style="width: 25%; text-align: left;">SOURCE</th>
                <th style="width: 20%; text-align: left;">QUANTITY</th>
                <th style="width: 25%; text-align: left;">VALUE/COST (Php)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($report->stocking_records ?? [] as $index => $stock)
                <tr>
                    <td>{{ $stock['species'] ?? '_____________________' }}</td>
                    <td>{{ $stock['source'] ?? '________________________' }}</td>
                    <td>{{ $stock['quantity'] ?? '_____________' }}</td>
                    <td>{{ $stock['cost'] ?? '_______________________' }}</td>
                </tr>
            @empty
                <tr>
                    <td>_____________________</td>
                    <td>________________________</td>
                    <td>_____________</td>
                    <td>_______________________</td>
                </tr>
                <tr>
                    <td>______________________</td>
                    <td>________________________</td>
                    <td>_____________</td>
                    <td>_______________________</td>
                </tr>
                <tr>
                    <td>______________________</td>
                    <td>________________________</td>
                    <td>_____________</td>
                    <td>_______________________</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table>
        <tr>
            <td style="width: 50%;">Date of Stocking: <span
                    class="underline">{{ $report->stocking['date'] ?? '______________________________' }}</span></td>
            <td style="width: 50%;">No. of Kilos harvested:<span
                    class="underline">{{ $report->harvesting['kilos'] ?? '______________________' }}</span></td>
        </tr>
        <tr>
            <td>Date of Harvest: <span
                    class="underline">{{ $report->harvesting['date'] ?? '_______________________________' }}</span>
            </td>
            <td>Gross Sales: <span
                    class="underline">{{ $report->harvesting['sales'] ?? '_________________________________' }}</span>
            </td>
        </tr>
        <tr>
            <td>Markets: Domestic:<span
                    class="underline">{{ $report->marketing['domestic'] ?? '____________________________' }}</span>
            </td>
            <td>No. of Kilos:<span
                    class="underline">{{ $report->marketing['domestic_kilos'] ?? '____________________________' }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding-left: 55px;">Export:<span
                    class="underline">{{ $report->marketing['export'] ?? '______________________________' }}</span>
            </td>
            <td>No. of Kilos:<span
                    class="underline">{{ $report->marketing['export_kilos'] ?? '____________________________' }}</span>
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    {{-- PAGE 2 --}}
    <p style="margin-top: 15px; text-align: justify;">
        Note: Section 23(e) - Within one (1) year and six (6) months from the approval of the FLA/ASC, the area leased
        shall be developed and producing in commercial scale; provided, however, that within five (5) years from the
        approval of the FLA/ASC, the holder must have fully developed the area.
    </p>

    <div style="margin-top: 10px;">Verification of Presence of Facilities that minimize Environmental pollution</div>
    <p style="margin: 4px 0;">( {{ isset($report->pond_types['nursery']) ? 'X' : '  ' }} ) Nursery: <span
            class="underline">{{ $report->pond_types['nursery_has'] ?? '___________________________' }}</span>(Has.)
    </p>
    <p style="margin: 4px 0;">( {{ isset($report->pond_types['transition']) ? 'X' : '  ' }} ) Transition: <span
            class="underline">{{ $report->pond_types['transition_has'] ?? '________________________' }}</span>(Has.)
    </p>
    <p style="margin: 4px 0;">( {{ isset($report->pond_types['rearing']) ? 'X' : '  ' }} ) Rearing: <span
            class="underline">{{ $report->pond_types['rearing_has'] ?? '___________________________' }}</span>(Has.)
    </p>
    <p style="margin: 4px 0;">( {{ isset($report->pond_types['canal']) ? 'X' : '  ' }} ) Canal: <span
            class="underline">{{ $report->pond_types['canal_has'] ?? '______________________________' }}</span>(Has.)
    </p>
    <p style="margin: 4px 0;">( {{ isset($report->pond_types['others']) ? 'X' : '  ' }} ) Others:<span
            class="underline">{{ $report->pond_types['others_has'] ?? '_____________________________' }}</span>(Has.)
    </p>

    <div style="margin-top: 10px;">D. Case status of the area</div>
    <p style="margin: 4px 0;">With pending administrative case ___ (
        {{ !empty($report->with_pending_admin_case) ? 'X' : '  ' }} )Yes or (
        {{ empty($report->with_pending_admin_case) ? 'X' : '  ' }} )No</p>
    <p style="margin: 4px 0;">With pending judicial case ____________(
        {{ !empty($report->with_pending_judicial_case) ? 'X' : '  ' }} )Yes or (
        {{ empty($report->with_pending_judicial_case) ? 'X' : '  ' }} )No</p>

    <div style="margin-top: 10px;">E. Remarks and Recommendation/s:</div>
    <p style="line-height: 2;">
        <span
            class="underline">{{ $report->remarks ?? str_repeat('_____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________', 1) }}</span>
    </p>

    <table style="margin-top: 30px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center;">
                Very truly yours,<br><br><br>
                ________________________________________________<br>
                Inspecting Officer<br><br><br>
                ________________________________________________<br>
                Date of Inspection
            </td>
        </tr>
    </table>

    <div class="text-center font-bold" style="margin-top: 20px; margin-bottom: 20px;">
        <h3>C E R T I F I C A T I O N</h3>
    </div>

    <p class="text-justify indent">
        I, <span
            class="underline">{{ $report->inspecting_officer_name ?? '________________________________________' }}</span>,
        under my official oath, do hereby certify that I have personally conducted a thorough, actual inspection and
        verification of the fishpond area treated in the foregoing report and all statements of facts are true and
        correct.
    </p>

    <p class="text-justify indent">
        I am fully aware that any false or misleading statements I have stated in the said report will subject me to
        appropriate disciplinary action which may be summary dismissal from the service.
    </p>

    <p class="text-justify indent">
        IN WITNESS WHEREOF, I have hereunto set my signature this _______ day of _________________ at
        ____________________________________________.
    </p>

    <table style="margin-top: 30px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center;">
                ________________________________________________<br>
                (Signature over Printed Name)
            </td>
        </tr>
    </table>

    <table style="margin-top: 20px;">
        <tr>
            <td style="width: 50%;">
                Noted by:<br><br>
                _____________________________________________<br>
                Designation
            </td>
            <td style="width: 50%; text-align: center; vertical-align: bottom;">
                <br><br><br>
                Notary Public
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    {{-- PAGE 3 --}}
    <div class="text-center font-bold" style="margin-top: 50px;">
        <p>SKETCH OF THE AREA SHOWING IMPROVEMENTS WITH RECENT PHOTOS SHOWING THE ACTUAL STATUS OF THE AREA</p>
    </div>

</body>

</html>
