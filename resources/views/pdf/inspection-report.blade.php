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
            line-height: 1.35;

            margin-top: 1.5in;
            margin-bottom: 1.0in;
            margin-left: 0.75in;
            margin-right: 0.75in;
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

        td {
            vertical-align: bottom;
        }
    </style>
</head>

<body>

    <!-- PAGE 1 -->
    <div class="text-center font-bold" style="font-size: 12pt; margin-bottom: 25px;">
        REPORT OF INSPECTION AND VERIFICATION OF IMPROVEMENTS
    </div>

    <!-- DATE -->
    <div style="width: 220px; margin-left: auto; text-align: center; margin-bottom: 20px;">
        <div style="border-bottom: 1px solid #000; padding-bottom: 2px; min-height: 18px;">
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
            the undersigned in the fishpond area covered by FLA/ASC/Fp. A. No.
            <u>&nbsp;&nbsp;{{ ucwords(strtolower($report->fla_no)) }}&nbsp;&nbsp;</u>
            located in Brgy. <u>&nbsp;&nbsp;{{ ucwords(strtolower($report->barangay)) }}&nbsp;&nbsp;</u>,
            Municipality of <u>&nbsp;&nbsp;{{ ucwords(strtolower($report->municipality)) }}&nbsp;&nbsp;</u>,
            Province of <u>&nbsp;&nbsp;{{ ucwords(strtolower($report->province)) }}&nbsp;&nbsp;</u>,
            and I hereby certify that the following are the kind and extent of improvements found existing in the area
            and production thereof.
        </p>
    </div>

    <!-- LESSEE META DATA -->
    <table style="width: 100%; margin-bottom: 20px; border-collapse: collapse;">
        <tr>
            <td style="width: 58%; vertical-align: top;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding-bottom: 2px; line-height: 1.1;">
                            <span>Name of Lessee/Applicant: </span>
                            <span
                                style="text-decoration: underline;">{{ ucwords(strtolower($report->lessee->full_name ?? '')) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 2px; line-height: 1.1;">
                            <span>Address: </span>
                            <span
                                style="text-decoration: underline;">{{ ucwords(strtolower(implode(', ', array_filter([$report->lessee->barangay ?? '', $report->lessee->municipality ?? '', $report->lessee->province ?? ''])))) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 2px; line-height: 1.1;">
                            <span>No. of hectares granted: </span>
                            <span style="text-decoration: underline;">{{ $report->no_hec_granted }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 0px; line-height: 1.1;">
                            <span>No. of hectares developed: </span>
                            <span style="text-decoration: underline;">{{ $report->no_hec_developed }}</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 42%; vertical-align: top;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding-bottom: 2px; line-height: 1.1;">
                            <span>FLA/ASC/Fp. A. No.: </span>
                            <span style="text-decoration: underline;">{{ $report->fla_no }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 2px; line-height: 1.1;">
                            <span>Date Issued: </span>
                            <span
                                style="text-decoration: underline;">{{ $report->date_issued?->format('F d, Y') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 2px; line-height: 1.1;">
                            <span>Date of Expiration: </span>
                            <span
                                style="text-decoration: underline;">{{ $report->date_expire?->format('F d, Y') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 0px; line-height: 1.1;">
                            <span>No. of hectares undeveloped: </span>
                            <span style="text-decoration: underline;">{{ $report->no_hect_undeveloped }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- SECTION A -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px; line-height: 1.25;">
        <thead>
            <tr class="font-bold">
                <td style="width: 45%; vertical-align: top;">A. Kind and Extent of Improvements</td>
                <td style="width: 25%; text-align: center; vertical-align: top;">Date Introduced</td>
                <td style="width: 5%;"></td>
                <td style="width: 25%; text-align: right; vertical-align: top;">Value/Cost (Php)</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 2px 0 2px 15px;">1. Clearings:</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="padding: 1px 0 1px 35px;">
                    Area Cleared: <span style="text-decoration: underline;">{{ $report->area_cleared }}</span> has.
                </td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->clearings_area_date }}
                </td>
                <td></td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ isset($report->clearings_area_cost) ? number_format($report->clearings_area_cost, 2) : '' }}
                </td>
            </tr>
            <tr>
                <td style="padding: 1px 0 1px 35px;">
                    Main dike: <span style="text-decoration: underline;">{{ $report->main_dike_meters }}</span> lineal
                    meters
                </td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->clearings_main_dike_date }}
                </td>
                <td></td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ isset($report->clearings_main_dike_cost) ? number_format($report->clearings_main_dike_cost, 2) : '' }}
                </td>
            </tr>
            <tr>
                <td style="padding: 1px 0 1px 35px;">
                    Secondary dikes: <span
                        style="text-decoration: underline;">{{ $report->secondary_dike_meters }}</span> lineal meters
                </td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->clearings_secondary_dike_date }}
                </td>
                <td></td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ isset($report->clearings_secondary_dike_cost) ? number_format($report->clearings_secondary_dike_cost, 2) : '' }}
                </td>
            </tr>

            <tr>
                <td style="padding: 2px 0 2px 15px; vertical-align: bottom;">
                    2. Excavation: <span
                        style="text-decoration: underline;">{{ $report->excavation_cubic_meters }}</span> cubic meters
                </td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->excavation_date }}
                </td>
                <td></td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ isset($report->excavation_cost) ? number_format($report->excavation_cost, 2) : '' }}
                </td>
            </tr>

            <tr>
                <td style="padding: 2px 0 2px 15px;">3. Gates:</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="padding: 1px 0 1px 35px;">
                    Concrete: <span style="text-decoration: underline;">{{ $report->concrete_gates_qty }}</span>
                    (number)
                </td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->gates_concrete_date }}
                </td>
                <td></td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ isset($report->gates_concrete_cost) ? number_format($report->gates_concrete_cost, 2) : '' }}
                </td>
            </tr>
            <tr>
                <td style="padding: 1px 0 1px 35px;">
                    Wooden: <span style="text-decoration: underline;">{{ $report->wooden_gates_qty }}</span> (number)
                </td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->gates_wooden_date }}
                </td>
                <td></td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ isset($report->gates_wooden_cost) ? number_format($report->gates_wooden_cost, 2) : '' }}
                </td>
            </tr>

            <tr>
                <td style="padding: 2px 0 2px 15px; vertical-align: bottom;">4. House, etc.</td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->house_date }}
                </td>
                <td></td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ isset($report->house_cost) ? number_format($report->house_cost, 2) : '' }}
                </td>
            </tr>

            <tr>
                <td style="padding: 2px 0 2px 15px; vertical-align: bottom;">5. Equipment, etc.</td>
                <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ $report->equipment_date }}
                </td>
                <td></td>
                <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                    {{ isset($report->equipment_cost) ? number_format($report->equipment_cost, 2) : '' }}
                </td>
            </tr>

            <tr>
                <td style="padding: 4px 0 0 15px; vertical-align: bottom;">6. Assessed Value</td>
                <td style="padding-top: 4px; font-weight: bold; text-align: right; vertical-align: bottom;">TOTAL VALUE:
                </td>
                <td></td>
                <td
                    style="text-align: right; border-bottom: 1px solid #000; font-weight: bold; vertical-align: bottom; padding-top: 4px;">
                    {{ isset($report->total_improvements_value) ? number_format($report->total_improvements_value, 2) : '' }}
                </td>
            </tr>

            <tr>
                <td colspan="2" style="padding: 2px 0 2px 35px; vertical-align: bottom;">
                    Actual Appraisal - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                </td>
                <td></td>
                <td style="text-align: right; border-bottom: 1px solid #000; padding-top: 2px; vertical-align: bottom;">
                    {{ isset($report->actual_appraisal_value) ? number_format($report->actual_appraisal_value, 2) : '' }}
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 2px 0 2px 35px; vertical-align: bottom;">
                    Under Tax Declaration - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                </td>
                <td></td>
                <td style="text-align: right; border-bottom: 1px solid #000; padding-top: 2px; vertical-align: bottom;">
                    {{ isset($report->tax_declaration_value) ? number_format($report->tax_declaration_value, 2) : '' }}
                </td>
            </tr>

            <tr>
                <td colspan="4" style="padding: 8px 0 0 15px;">
                    7. No. of Permanent Personnel/Workers Employed: <span
                        style="text-decoration: underline;">{{ $report->permanent_workers_count }}</span> (Attach proof
                    of SSS Contribution/Remittances)
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding: 3px 0 0 15px;">
                    8. No. of Non-Permanent Personnel/Workers Employed: <span
                        style="text-decoration: underline;">{{ $report->non_permanent_workers_count }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding: 3px 0 0 15px;">
                    9. No. of Personnel/Workers Registered in (FishR): <span
                        style="text-decoration: underline;">{{ $report->fishr_registered_count }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- SECTION B -->
    <div class="font-bold" style="margin-bottom: 5px;">B. Operation and Production</div>

    <table style="margin-bottom: 8px;">
        <thead>
            <tr class="font-bold">
                <td style="width: 30%; padding-bottom: 2px;">SPECIES STOCKED</td>
                <td style="width: 25%; padding-bottom: 2px;">SOURCE</td>
                <td style="width: 20%; padding-bottom: 2px;">QUANTITY</td>
                <td style="width: 25%; text-align: right; padding-bottom: 2px;">VALUE/COST (Php)</td>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 3; $i++)
                @php $stock = $report->stockings[$i-1] ?? null; @endphp
                <tr>
                    <td style="padding: 2px 0; border-bottom: 1px solid #000;">{{ $i }}.
                        {{ $stock->species ?? '' }}</td>
                    <td style="padding: 2px 0; border-bottom: 1px solid #000;">{{ $stock->source ?? '' }}</td>
                    <td style="padding: 2px 0; border-bottom: 1px solid #000;">{{ $stock->quantity ?? '' }}</td>
                    <td style="padding: 2px 0; border-bottom: 1px solid #000; text-align: right;">
                        {{ isset($stock->cost) ? number_format($stock->cost, 2) : '' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <table>
        <tr>
            <td style="width: 50%; vertical-align: top; line-height: 1.5;">
                4. Date of Stocking: <span class="underline-field"
                    style="width: 120px;">{{ $report->date_of_stocking }}</span><br>
                5. Date of Harvest: <span class="underline-field"
                    style="width: 125px;">{{ $report->date_of_harvest }}</span><br>
                6. Markets: Domestic: <span class="underline-field"
                    style="width: 100px;">{{ $report->market_domestic }}</span><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Export: <span
                    class="underline-field" style="width: 115px;">{{ $report->market_export }}</span>
            </td>
            <td style="width: 50%; vertical-align: top; line-height: 1.5;">
                No. of Kilos harvested: <span class="underline-field"
                    style="width: 100px;">{{ $report->kilos_harvested }}</span><br>
                Gross Sales: <span class="underline-field"
                    style="width: 140px;">{{ isset($report->gross_sales) ? number_format($report->gross_sales, 2) : '' }}</span><br>
                No. of Kilos: <span class="underline-field"
                    style="width: 125px;">{{ $report->market_domestic_kilos }}</span><br>
                No. of Kilos: <span class="underline-field"
                    style="width: 125px;">{{ $report->market_export_kilos }}</span>
            </td>
        </tr>
    </table>


    <!-- PAGE 2 -->
    <div class="page-break"></div>

    <p class="text-justify italic" style="font-size: 10pt; line-height: 1.3; margin-bottom: 15px;">
        Note: Section 23(e) - Within one (1) year and six (6) months from the approval of the FLA/ASC, the area leased
        shall be developed and producing in commercial scale; provided, however, that within five (5) years from the
        approval of the FLA/ASC, the holder must have fully developed the area.
    </p>

    <!-- SECTION C -->
    <div class="font-bold" style="margin-bottom: 6px;">C. Verification of Presence of Facilities that minimize
        Environmental pollution</div>
    <div style="padding-left: 20px; line-height: 1.6; margin-bottom: 15px;">
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
    <div class="font-bold" style="margin-bottom: 6px;">D. Case status of the area</div>
    <div style="padding-left: 20px; line-height: 1.6; margin-bottom: 15px;">
        <div>1. With pending administrative case ____([ {{ $report->has_admin_case ? 'X' : ' ' }} ]) Yes or ([
            {{ !$report->has_admin_case ? 'X' : ' ' }} ]) No</div>
        <div>2. With pending judicial case ____([ {{ $report->has_judicial_case ? 'X' : ' ' }} ]) Yes or ([
            {{ !$report->has_judicial_case ? 'X' : ' ' }} ]) No</div>
    </div>

    <!-- SECTION E -->
    <div class="font-bold" style="margin-bottom: 6px;">E. Remarks and Recommendation/s:</div>
    <div style="margin-bottom: 25px;">
        <div style="border-bottom: 1px solid #000; height: 22px;"></div>
        <div style="border-bottom: 1px solid #000; height: 22px;"></div>
        <div style="border-bottom: 1px solid #000; height: 22px;"></div>
        <div style="border-bottom: 1px solid #000; height: 22px;"></div>
    </div>

    <!-- SIGNATURE -->
    <div class="text-right" style="margin-bottom: 25px;">
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
    <div class="text-center font-bold" style="margin-bottom: 12px;">
        C E R T I F I C A T I O N
    </div>

    <p class="text-justify indent" style="margin-bottom: 10px; line-height: 1.4;">
        I, <span class="underline-field" style="width: 180px;">{{ $report->inspecting_officer_name }}</span>, under
        my official oath, do hereby certify that I have personally conducted a thorough, actual inspection and
        verification of the fishpond area treated in the foregoing report and all statements of facts are true and
        correct.
    </p>

    <p class="text-justify indent" style="margin-bottom: 12px; line-height: 1.4;">
        I am fully aware that any false or misleading statements I have stated in the said report will subject me to
        appropriate disciplinary action which may be summary dismissal from the service.
    </p>

    <p class="indent" style="margin-bottom: 20px;">
        IN WITNESS WHEREOF, I have hereunto set my signature this <span class="underline-field"
            style="width: 60px;">{{ date('jS') }}</span> day of <span class="underline-field"
            style="width: 120px;">{{ date('F, Y') }}</span> at <span class="underline-field"
            style="width: 150px;">{{ $report->inspection_location }}</span>.
    </p>

    <div class="text-right" style="margin-bottom: 25px;">
        <div style="display: inline-block; text-align: center;">
            <span class="underline-field" style="width: 250px;">&nbsp;</span><br>
            (Signature over Printed Name)
        </div>
    </div>

    <table>
        <tr>
            <td style="width: 50%; vertical-align: top; line-height: 1.4;">
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
        style="margin-top: 20px; margin-bottom: 30px; padding: 0 20px; line-height: 1.4;">
        SKETCH OF THE AREA SHOWING IMPROVEMENTS WITH RECENT PHOTOS SHOWING THE ACTUAL STATUS OF THE AREA
    </div>

    @if ($report->sketch_image_path)
        <div class="text-center">
            <img src="{{ public_path('storage/' . $report->sketch_image_path) }}"
                style="max-width: 100%; max-height: 700px; margin: 0 auto; display: block;">
        </div>
    @endif

</body>

</html>
