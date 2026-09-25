<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Report of Inspection and Verification of Improvements</title>
    <style>
        @page {
            size: 8.5in 13in;
            margin-top: 1.5in;
            margin-bottom: 1.0in;
            margin-left: 0.75in;
            margin-right: 0.75in;
            font-family: 'Cambria', serif;
            font-size: 12pt;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Cambria', serif;
            font-size: 12pt;
            color: #000;
            background-color: #fff;
            line-height: 1.4;
        }

        .page-break {
            page-break-before: always;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-justify {
            text-align: justify;
        }

        .font-bold {
            font-weight: bold;
        }

        .italic {
            font-style: italic;
        }

        .underline-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            text-align: center;
        }

        .indent {
            text-indent: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>

<body>

    <!-- PAGE 1 -->
    <div class="text-center font-bold" style="font-size: 13pt; margin-bottom: 20px;">
        REPORT OF INSPECTION AND VERIFICATION OF IMPROVEMENTS
    </div>

    <!-- DATE -->
    <div style="width: 180px; margin-left: auto; text-align: center; margin-bottom: 20px;">
        <div style="border-bottom: 1px solid #000; padding-bottom: 2px;">
            {{ $report->created_at?->format('F d, Y') }}
        </div>
        <div style="font-size: 11pt;">Date</div>
    </div>

    <!-- RECIPIENT -->
    <div style="margin-bottom: 15px;">
        <strong>The Director</strong><br>
        Bureau of Fisheries and Aquatic Resources<br>
        3/F Main Building, Fisheries Building Complex<br>
        Visayas Avenue, Diliman, Quezon City
    </div>

    <!-- INTRO TEXT -->
    <div class="text-justify" style="margin-bottom: 15px;">
        Sir:<br><br>
        <p class="indent">
            I have the honor to inform you that an ocular inspection and verification of improvements was conducted by
            the undersigned in the fishpond area covered by FLA/ASC/Fp. A. No. <span class="underline-field"
                style="width: 100px;">{{ $report->fla_no }}</span> located in Brgy. <span class="underline-field"
                style="width: 120px;">{{ $report->barangay }}</span>, Municipality of <span class="underline-field"
                style="width: 130px;">{{ $report->municipality }}</span>, Province of <span class="underline-field"
                style="width: 130px;">{{ $report->province }}</span>, and I hereby certify that the following are
            the kind and extent of improvements found existing in the area and production thereof.
        </p>
    </div>

    <!-- LESSEE META DATA -->
    <table style="margin-bottom: 20px;">
        <tr>
            <td style="width: 58%; vertical-align: top; line-height: 1.6;">
                Name of Lessee/Applicant: <span class="underline-field"
                    style="width: 180px;">{{ $report->lessee->name ?? '' }}</span><br>
                Address: <span class="underline-field"
                    style="width: 275px;">{{ $report->lessee->address ?? '' }}</span><br>
                No. of hectares granted: <span class="underline-field"
                    style="width: 120px;">{{ $report->hectares_granted }}</span><br>
                No. of hectares developed: <span class="underline-field"
                    style="width: 100px;">{{ $report->hectares_developed }}</span>
            </td>
            <td style="width: 42%; vertical-align: top; line-height: 1.6;">
                FLA/ASC/Fp. A. No.: <span class="underline-field" style="width: 100px;">{{ $report->fla_no }}</span><br>
                Date Issued: <span class="underline-field" style="width: 120px;">{{ $report->date_issued }}</span><br>
                Date of Expiration: <span class="underline-field"
                    style="width: 90px;">{{ $report->date_of_expiration }}</span><br>
                No. of hectares undeveloped: <span class="underline-field"
                    style="width: 80px;">{{ $report->hectares_undeveloped }}</span>
            </td>
        </tr>
    </table>

    <!-- SECTION A -->
    <div class="font-bold" style="margin-bottom: 5px;">A. Kind and Extent of Improvements</div>

    <table>
        <thead>
            <tr class="font-bold">
                <td style="width: 50%;"></td>
                <td style="width: 25%; text-align: center;">Date Introduced</td>
                <td style="width: 25%; text-align: right;">Value/Cost (Php)</td>
            </tr>
        </thead>
        <tbody>
            <!-- 1. Clearings -->
            <tr>
                <td style="padding: 6px 0; vertical-align: top; line-height: 1.5;">
                    1. Clearings:<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Area Cleared: <span class="underline-field"
                        style="width: 80px;">{{ $report->area_cleared }}</span> has.<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Main dike: <span class="underline-field"
                        style="width: 70px;">{{ $report->main_dike_meters }}</span> lineal meters<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Secondary dikes: <span class="underline-field"
                        style="width: 60px;">{{ $report->secondary_dike_meters }}</span> lineal meters
                </td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->clearings_date }}</td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ number_format($report->clearings_cost, 2) }}</td>
            </tr>

            <!-- 2. Excavation -->
            <tr>
                <td style="padding: 8px 0; vertical-align: bottom;">
                    2. Excavation: <span class="underline-field"
                        style="width: 90px;">{{ $report->excavation_cubic_meters }}</span> cubic meters
                </td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->excavation_date }}</td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ number_format($report->excavation_cost, 2) }}</td>
            </tr>

            <!-- 3. Gates -->
            <tr>
                <td style="padding: 8px 0; vertical-align: top; line-height: 1.5;">
                    3. Gates:<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Concrete: <span class="underline-field"
                        style="width: 80px;">{{ $report->concrete_gates_qty }}</span> (number)<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Wooden: <span class="underline-field"
                        style="width: 90px;">{{ $report->wooden_gates_qty }}</span> (number)
                </td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->gates_date }}</td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ number_format($report->gates_cost, 2) }}</td>
            </tr>

            <!-- 4. House -->
            <tr>
                <td style="padding: 8px 0; vertical-align: bottom;">4. House, etc.</td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->house_date }}</td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ number_format($report->house_cost, 2) }}</td>
            </tr>

            <!-- 5. Equipment -->
            <tr>
                <td style="padding: 8px 0; vertical-align: bottom;">5. Equipment, etc.</td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->equipment_date }}</td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ number_format($report->equipment_cost, 2) }}</td>
            </tr>

            <!-- 6. Assessed Value -->
            <tr>
                <td colspan="2" style="padding-top: 10px; font-weight: bold; vertical-align: bottom;">6. Assessed
                    Value TOTAL VALUE:</td>
                <td
                    style="text-align: right; border-bottom: 1px solid #000; font-weight: bold; vertical-align: bottom; padding-top: 10px;">
                    {{ number_format($report->total_improvements_value, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div style="padding-left: 20px; margin-top: 5px; line-height: 1.6;">
        Actual Appraisal: <span class="underline-field"
            style="width: 140px;">{{ number_format($report->actual_appraisal, 2) }}</span><br>
        Under Tax Declaration: <span class="underline-field"
            style="width: 120px;">{{ number_format($report->tax_declaration_value, 2) }}</span>
    </div>

    <div style="margin-top: 10px; line-height: 1.6;">
        7. No. of Permanent Personnel/Workers Employed: <span class="underline-field"
            style="width: 60px;">{{ $report->permanent_workers }}</span> (Attach proof of SSS
        Contribution/Remittances)<br>
        8. No. of Non-Permanent Personnel/Workers Employed: <span class="underline-field"
            style="width: 60px;">{{ $report->non_permanent_workers }}</span><br>
        9. No. of Personnel/Workers Registered in (FishR): <span class="underline-field"
            style="width: 60px;">{{ $report->fishr_registered_workers }}</span>
    </div>

    <!-- SECTION B -->
    <div class="font-bold" style="margin-top: 15px; margin-bottom: 5px;">B. Operation and Production</div>

    <table style="border-bottom: 1px solid #000; margin-bottom: 10px;">
        <thead>
            <tr class="font-bold" style="border-bottom: 1px solid #000;">
                <td style="width: 30%; padding-bottom: 4px;">SPECIES STOCKED</td>
                <td style="width: 25%; padding-bottom: 4px;">SOURCE</td>
                <td style="width: 20%; padding-bottom: 4px;">QUANTITY</td>
                <td style="width: 25%; text-align: right; padding-bottom: 4px;">VALUE/COST (Php)</td>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 3; $i++)
                @php $stock = $report->stockings[$i-1] ?? null; @endphp
                <tr>
                    <td style="padding: 5px 0; border-bottom: 1px solid #eee;">{{ $i }}.
                        {{ $stock->species ?? '' }}</td>
                    <td style="padding: 5px 0; border-bottom: 1px solid #eee;">{{ $stock->source ?? '' }}</td>
                    <td style="padding: 5px 0; border-bottom: 1px solid #eee;">{{ $stock->quantity ?? '' }}</td>
                    <td style="padding: 5px 0; border-bottom: 1px solid #eee; text-align: right;">
                        {{ isset($stock->cost) ? number_format($stock->cost, 2) : '' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <table>
        <tr>
            <td style="width: 50%; vertical-align: top; line-height: 1.6;">
                4. Date of Stocking: <span class="underline-field"
                    style="width: 120px;">{{ $report->date_of_stocking }}</span><br>
                5. Date of Harvest: <span class="underline-field"
                    style="width: 125px;">{{ $report->date_of_harvest }}</span><br>
                6. Markets: Domestic: <span class="underline-field"
                    style="width: 100px;">{{ $report->market_domestic }}</span><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Export: <span
                    class="underline-field" style="width: 115px;">{{ $report->market_export }}</span>
            </td>
            <td style="width: 50%; vertical-align: top; line-height: 1.6;">
                No. of Kilos harvested: <span class="underline-field"
                    style="width: 100px;">{{ $report->kilos_harvested }}</span><br>
                Gross Sales: <span class="underline-field"
                    style="width: 140px;">{{ number_format($report->gross_sales, 2) }}</span><br>
                No. of Kilos: <span class="underline-field"
                    style="width: 125px;">{{ $report->market_domestic_kilos }}</span><br>
                No. of Kilos: <span class="underline-field"
                    style="width: 125px;">{{ $report->market_export_kilos }}</span>
            </td>
        </tr>
    </table>

    <!-- PAGE 2 -->
    <div class="page-break"></div>

    <p class="text-justify italic" style="margin-bottom: 20px;">
        Note: Section 23(e) - Within one (1) year and six (6) months from the approval of the FLA/ASC, the area leased
        shall be developed and producing in commercial scale; provided, however, that within five (5) years from the
        approval of the FLA/ASC, the holder must have fully developed the area.
    </p>

    <!-- SECTION C -->
    <div class="font-bold" style="margin-bottom: 8px;">C. Verification of Presence of Facilities that minimize
        Environmental pollution</div>
    <div style="padding-left: 20px; line-height: 1.8; margin-bottom: 15px;">
        <div>([ {{ $report->has_nursery ? 'X' : ' ' }} ]) Nursery: <span class="underline-field"
                style="width: 150px;">{{ $report->nursery_has }}</span> (Has.)</div>
        <div>([ {{ $report->has_transition ? 'X' : ' ' }} ]) Transition: <span class="underline-field"
                style="width: 150px;">{{ $report->transition_has }}</span> (Has.)</div>
        <div>([ {{ $report->has_rearing ? 'X' : ' ' }} ]) Rearing: <span class="underline-field"
                style="width: 150px;">{{ $report->rearing_has }}</span> (Has.)</div>
        <div>([ {{ $report->has_canal ? 'X' : ' ' }} ]) Canal: <span class="underline-field"
                style="width: 150px;">{{ $report->canal_has }}</span> (Has.)</div>
        <div>([ {{ $report->has_others ? 'X' : ' ' }} ]) Others: <span class="underline-field"
                style="width: 150px;">{{ $report->others_description }}</span> (Has.)</div>
    </div>

    <!-- SECTION D -->
    <div class="font-bold" style="margin-bottom: 8px;">D. Case status of the area</div>
    <div style="padding-left: 20px; line-height: 1.8; margin-bottom: 20px;">
        <div>1. With pending administrative case: ([ {{ $report->has_admin_case ? 'X' : ' ' }} ]) Yes or ([
            {{ !$report->has_admin_case ? 'X' : ' ' }} ]) No</div>
        <div>2. With pending judicial case: ([ {{ $report->has_judicial_case ? 'X' : ' ' }} ]) Yes or ([
            {{ !$report->has_judicial_case ? 'X' : ' ' }} ]) No</div>
    </div>

    <!-- SECTION E -->
    <div class="font-bold" style="margin-bottom: 8px;">E. Remarks and Recommendation/s:</div>
    <div style="margin-bottom: 30px;">
        <div style="border-bottom: 1px solid #000; height: 25px; margin-bottom: 10px;"></div>
        <div style="border-bottom: 1px solid #000; height: 25px; margin-bottom: 10px;"></div>
        <div style="border-bottom: 1px solid #000; height: 25px; margin-bottom: 10px;"></div>
        <div style="border-bottom: 1px solid #000; height: 25px; margin-bottom: 10px;"></div>
    </div>

    <!-- SIGNATURE -->
    <div class="text-right" style="margin-bottom: 30px;">
        <div style="display: inline-block; text-align: center;">
            Very truly yours,<br><br><br>
            <span class="underline-field font-bold"
                style="width: 250px;">{{ $report->inspecting_officer_name }}</span><br>
            <span class="italic">Inspecting Officer</span><br><br>
            <span class="underline-field" style="width: 250px;">{{ $report->date_of_inspection }}</span><br>
            <span class="italic">Date of Inspection</span>
        </div>
    </div>

    <!-- CERTIFICATION -->
    <div class="text-center font-bold" style="margin-bottom: 15px;">
        C E R T I F I C A T I O N
    </div>

    <p class="text-justify indent" style="margin-bottom: 12px;">
        I, <span class="underline-field" style="width: 180px;">{{ $report->inspecting_officer_name }}</span>, under
        my official oath,
        do hereby certify that I have personally conducted a thorough, actual inspection and verification of the
        fishpond area treated in the foregoing report and all statements of facts are true and correct.
    </p>

    <p class="text-justify indent" style="margin-bottom: 15px;">
        I am fully aware that any false or misleading statements I have stated in the said report will subject me to
        appropriate disciplinary action which may be summary dismissal from the service.
    </p>

    <p class="indent" style="margin-bottom: 25px;">
        IN WITNESS WHEREOF, I have hereunto set my signature this <span class="underline-field"
            style="width: 60px;">{{ date('jS') }}</span> day of <span class="underline-field"
            style="width: 120px;">{{ date('F, Y') }}</span> at <span class="underline-field"
            style="width: 150px;">{{ $report->inspection_location }}</span>.
    </p>

    <div class="text-right" style="margin-bottom: 30px;">
        <div style="display: inline-block; text-align: center;">
            <span class="underline-field" style="width: 250px;">&nbsp;</span><br>
            (Signature over Printed Name)
        </div>
    </div>

    <table>
        <tr>
            <td style="width: 50%; vertical-align: top;">
                Noted by:<br><br><br>
                <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px;"></span><br>
                Designation
            </td>
            <td style="width: 50%; text-align: right; vertical-align: bottom;">
                <strong>Notary Public</strong>
            </td>
        </tr>
    </table>

    <!-- PAGE 3 -->
    <div class="page-break"></div>

    <div class="text-center font-bold"
        style="margin-top: 20px; margin-bottom: 30px; text-transform: uppercase; padding: 0 30px;">
        SKETCH OF THE AREA SHOWING IMPROVEMENTS WITH RECENT PHOTOS SHOWING THE ACTUAL STATUS OF THE AREA
    </div>

    @if ($report->sketch_image_path)
        <div class="text-center">
            <img src="{{ public_path('storage/' . $report->sketch_image_path) }}"
                style="max-width: 100%; max-height: 750px; margin: 0 auto; display: block;">
        </div>
    @endif

</body>

</html>
