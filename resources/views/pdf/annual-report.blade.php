<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Annual Report on Fishpond Development, Operation & Production</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <style>
        @page {
            size: 8.5in 13in;
            margin-top: 1.0in;
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
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            color: #000;
            background-color: #fff;
            line-height: 1.2;
            margin-top: 1.0in;
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

        .underline {
            border-bottom: 1px solid #000;
            display: inline-block;
        }

        .indent {
            text-indent: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-form td,
        .table-form th {
            font-size: 9pt;
        }

        .border-line {
            border-bottom: 1px solid #000;
        }

        .section-header {
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 8px;
            font-size: 10pt;
        }

        .sub-header {
            font-weight: bold;
            margin-top: 8px;
            margin-bottom: 4px;
            font-size: 9.5pt;
        }
    </style>
</head>

<body>

    <!-- PAGE 1 -->
    <div class="text-center font-bold" style="font-size: 11pt;">
        ANNUAL REPORT ON FISHPOND DEVELOPMENT, OPERATION & PRODUCTION
    </div>
    <div class="text-center font-bold" style="font-size: 10pt; margin-bottom: 48px;">
        FROM <span class="underline" style="width: 180px;">{{ $report->from?->format('F d, Y') }}</span> TO <span
            class="underline" style="width: 180px;">{{ $report->to?->format('F d, Y') }}</span>
    </div>

    <!-- RECIPIENT -->
    <div style="margin-bottom: 12px; font-size: 9.5pt;">
        <strong>The Director</strong><br>
        Bureau of Fisheries and Aquatic Resources<br>
        3/F Main Building, Fisheries Building Complex<br>
        Visayas Avenue, Diliman, Quezon City
    </div>

    <!-- INTRO TEXT -->
    <div class="text-justify" style="margin-bottom: 10px; font-size: 9.5pt;">
        Sir/Madam:<br>
        <p class="indent" style="margin-top: 4px;">
            I have the honor to submit herewith the annual report on the extent of development, operation and production
            of the fishpond area leased under
            FLA. No. <span class="underline" style="width: 300px;">{{ $report->fla_no }}</span>
            located at <span class="underline"
                style="width: 400px;">{{ ucwords(strtolower(implode(', ', array_filter([$report->barangay ?? '', $report->municipality ?? '', $report->province ?? ''])))) }}</span>.
        </p>
    </div>

    <!-- META DETAILS GRID -->
    <table style="width: 100%; margin-bottom: 16px; font-size: 9.5pt;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                Date Issued: <span class="underline"
                    style="width: 220px;">{{ $report->date_issued?->format('F d, Y') }}</span><br>
                Area Granted: <span class="underline" style="width: 212px;">{{ $report->no_hec_granted }}</span>
            </td>
            <td style="width: 50%; vertical-align: top;">
                Expiry Date: <span class="underline"
                    style="width: 220px;">{{ $report->date_expire?->format('F d, Y') }}</span><br>
                Area Developed: <span class="underline" style="width: 195px;">{{ $report->no_hec_developed }}</span>
                (has.)<br>
                &nbsp;&nbsp;a. Nursery: <span class="underline"
                    style="width: 180px;">{{ $pondBreakdown['nursery'] ?? '' }}</span> (has.)<br>
                &nbsp;&nbsp;b. Transition: <span class="underline"
                    style="width: 168px;">{{ $pondBreakdown['transition'] ?? '' }}</span> (has.)<br>
                &nbsp;&nbsp;c. Rearing: <span class="underline"
                    style="width: 183px;">{{ $pondBreakdown['rearing'] ?? '' }}</span> (has.)<br>
                Area Undeveloped: <span class="underline"
                    style="width: 180px;">{{ $report->no_hect_undeveloped }}</span> (has.)
            </td>
        </tr>
    </table>

    <!-- SECTION A -->
    <div class="section-header" style="margin-bottom: 16px;"><u>A. KIND AND EXTENT OF IMPROVEMENTS</u></div>

    <table class="table-form" style="margin-bottom: 32px; width: 100%;">
        <thead>
            <tr class="font-bold">
                <th style="text-align: left; width: 45%;">ITEM</th>
                <th style="text-align: center; width: 28%;">DATE INTRODUCED</th>
                <th style="width: 15px;"></th>
                <th style="text-align: center; width: 27%;">VALUE/COST</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1. Clearings:</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Main: <span class="underline"
                        style="width: 180px;">{{ $improvements['clearings_area'] ?? '' }}</span> (has.)</td>
                <td class="text-center border-line">{{ $improvements['clearings_date'] ?? '' }}</td>
                <td></td>
                <td class="text-center border-line">
                    {{ isset($improvements['clearings_cost']) && $improvements['clearings_cost'] !== '' ? number_format((float) $improvements['clearings_cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td>2. Dikes:</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Main: <span class="underline"
                        style="width: 180px;">{{ $improvements['dike_main'] ?? '' }}</span> lineal meters</td>
                <td class="text-center border-line">{{ $improvements['dike_main_date'] ?? '' }}</td>
                <td></td>
                <td class="text-center border-line">
                    {{ isset($improvements['dike_main_cost']) && $improvements['dike_main_cost'] !== '' ? number_format((float) $improvements['dike_main_cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Secondary: <span class="underline"
                        style="width: 155px;">{{ $improvements['dike_secondary'] ?? '' }}</span> lineal meters
                </td>
                <td class="text-center border-line">{{ $improvements['dike_secondary_date'] ?? '' }}</td>
                <td></td>
                <td class="text-center border-line">
                    {{ isset($improvements['dike_secondary_cost']) && $improvements['dike_secondary_cost'] !== '' ? number_format((float) $improvements['dike_secondary_cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Excavation: <span class="underline"
                        style="width: 150px;">{{ $improvements['excavation'] ?? '' }}</span> cubic meters</td>
                <td class="text-center border-line">{{ $improvements['excavation_date'] ?? '' }}</td>
                <td></td>
                <td class="text-center border-line">
                    {{ isset($improvements['excavation_cost']) && $improvements['excavation_cost'] !== '' ? number_format((float) $improvements['excavation_cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td>3. Gates:</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Concrete: <span class="underline"
                        style="width: 200px;">{{ $improvements['gate_concrete'] ?? '' }}</span></td>
                <td class="text-center border-line">{{ $improvements['gate_concrete_date'] ?? '' }}</td>
                <td></td>
                <td class="text-center border-line">
                    {{ isset($improvements['gate_concrete_cost']) && $improvements['gate_concrete_cost'] !== '' ? number_format((float) $improvements['gate_concrete_cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Wooden: <span class="underline"
                        style="width: 205px;">{{ $improvements['gate_wooden'] ?? '' }}</span></td>
                <td class="text-center border-line">{{ $improvements['gate_wooden_date'] ?? '' }}</td>
                <td></td>
                <td class="text-center border-line">
                    {{ isset($improvements['gate_wooden_cost']) && $improvements['gate_wooden_cost'] !== '' ? number_format((float) $improvements['gate_wooden_cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td>House/Building, etc. <span class="underline"
                        style="width: 180px;">{{ $improvements['building_desc'] ?? '' }}</span></td>
                <td class="text-center border-line">{{ $improvements['building_date'] ?? '' }}</td>
                <td></td>
                <td class="text-center border-line">
                    {{ isset($improvements['building_cost']) && $improvements['building_cost'] !== '' ? number_format((float) $improvements['building_cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td>Equipment/Tools/Banca, etc. <span class="underline"
                        style="width: 140px;">{{ $improvements['equipment_desc'] ?? '' }}</span></td>
                <td class="text-center border-line">{{ $improvements['equipment_date'] ?? '' }}</td>
                <td></td>
                <td class="text-center border-line">
                    {{ isset($improvements['equipment_cost']) && $improvements['equipment_cost'] !== '' ? number_format((float) $improvements['equipment_cost'], 2) : '' }}
                </td>
            </tr>
            <tr class="font-bold">
                <td class="text-right" colspan="2">TOTAL Php</td>
                <td></td>
                <td class="text-center border-line">
                    {{ number_format((float) ($financial['total_value'] ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td colspan="4">4. Assessed Value:</td>
            </tr>
            <tr>
                <td style="padding-left: 15px;" colspan="3">Actual Appraisal &nbsp;- - - - - - - - - - - - - - - - -
                    - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - Php
                </td>
                <td class="text-center border-line">
                    {{ number_format((float) ($financial['actual_appraisal'] ?? 0), 2) }}
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;" colspan="3">Under Tax Declaration: &nbsp; - - - - - - - - - - - - - -
                    - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - Php
                </td>
                <td class="text-center border-line">
                    {{ number_format((float) ($financial['tax_declaration'] ?? 0), 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    5. Number of Workers Employed:<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;a. Caretaker/s <span class="underline"
                        style="width: 200px;  ">{{ $workers['caretakers'] ?? '' }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;b. Laborer/s <span class="underline"
                        style="width: 200px;">{{ $workers['laborers'] ?? '' }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="section-header"><u>B. PRODUCTION AND MARKETING OPERATION</u></div>
    <div class="sub-header" style="margin: 18px 0;">1. STOCKING:</div>

    <table class="table-form" style="margin-bottom: 10px; width: 100%;">
        <thead>
            <tr class="font-bold">
                <th style="text-align: left; width: 14%; padding-top: 10px;">Species</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 12%; padding-top: 10px;">Date Stocked</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 22%; padding-top: 10px;">Source/Place</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 16%; padding-top: 10px;">Area Stocked (Has.)</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 15%; padding-top: 10px;">Quantity (No.)</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 21%; padding-top: 10px;">Cost (Php)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocking as $spec => $item)
                <tr>
                    <td style="padding-top: 10px;">{{ $spec }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $item['date'] }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $item['source'] }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $item['area'] }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $item['quantity'] }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">
                        {{ $item['cost'] > 0 ? number_format($item['cost'], 2) : '' }}
                    </td>
                </tr>
            @endforeach

            @foreach ($customRows as $custom)
                <tr>
                    <td style="padding-top: 10px;">{{ $custom['label'] ?? '' }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $custom['date'] ?? '' }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $custom['source'] ?? '' }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $custom['area'] ?? '' }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $custom['quantity'] ?? '' }}
                    </td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">
                        {{ isset($custom['cost']) && $custom['cost'] > 0 ? number_format((float) $custom['cost'], 2) : '' }}
                    </td>
                </tr>
            @endforeach

            @for ($i = count($customRows); $i < 3; $i++)
                <tr>
                    <td style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                </tr>
            @endfor

            <tr class="font-bold">
                <td style="padding-top: 10px;">TOTAL</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="text-center border-line" style="padding-top: 10px;">
                    {{ number_format($totalStockCost, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <div class="sub-header" style="margin: 18px 0;">2. HARVESTING:</div>
    <!-- HARVESTING TABLE -->
    <table class="table-form" style="margin-bottom: 24px; width: 100%;">
        <thead>
            <tr class="font-bold">
                <th style="text-align: left; width: 18%; padding-top: 10px;">Species</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 12%; padding-top: 10px;">Date Harvested</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 15%; padding-top: 10px;">Area Harvested</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 14%; padding-top: 10px;">Quantity (Kilos)</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 12%; padding-top: 10px;">No. of Pcs./Kg.</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 10%; padding-top: 10px;">Price/Kilo</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 16%; padding-top: 10px;">Total Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($harvestData as $spec => $item)
                <tr>
                    <td style="padding-top: 10px;">{{ $spec }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $item['date'] }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $item['area_harvested'] }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $item['kilos'] }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $item['pcs_per_kg'] }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">
                        {{ !is_null($item['price_per_kilo']) ? number_format($item['price_per_kilo'], 2) : '' }}
                    </td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">
                        {{ $item['total_value'] > 0 ? number_format($item['total_value'], 2) : '' }}
                    </td>
                </tr>
            @endforeach

            {{-- Custom Harvest Rows --}}
            @foreach ($customHarvestRows as $custom)
                @php
                    $val =
                        isset($custom['total_value']) && $custom['total_value'] !== ''
                            ? (float) $custom['total_value']
                            : 0;
                    $price =
                        isset($custom['price_per_kilo']) && $custom['price_per_kilo'] !== ''
                            ? (float) $custom['price_per_kilo']
                            : null;
                @endphp
                <tr>
                    <td style="padding-top: 10px;">{{ $custom['label'] ?? '' }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $custom['date'] ?? '' }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $custom['area'] ?? '' }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $custom['qty_kilos'] ?? '' }}
                    </td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $custom['pcs_per_kg'] ?? '' }}
                    </td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">
                        {{ !is_null($price) ? number_format($price, 2) : '' }}
                    </td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">
                        {{ $val > 0 ? number_format($val, 2) : '' }}
                    </td>
                </tr>
            @endforeach

            @for ($i = count($customHarvestRows); $i < 3; $i++)
                <tr>
                    <td style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                </tr>
            @endfor

            <tr class="font-bold">
                <td style="padding-top: 10px;">TOTAL</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="text-center border-line" style="padding-top: 10px;">
                    {{ number_format($totalHarvestValue, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="sub-header" style="margin: 18px 0;">3. MARKETING:</div>

    <!-- MARKETING TABLE -->
    <table class="table-form" style="margin-bottom: 24px; width: 100%;">
        <thead>
            <tr class="font-bold">
                <th rowspan="2" style="text-align: left; width: 20%; vertical-align: bottom; padding-top: 10px;">
                    Species</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th colspan="3" style="text-align: center; border-bottom: 1px solid #000;">Local Consumption</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th colspan="3" style="text-align: center; border-bottom: 1px solid #000;">Export</th>
            </tr>
            <tr class="font-bold">
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 20%; padding-top: 10px;">Quantity (Kilos)</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 20%; padding-top: 10px;">Value (Php)</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 20%; padding-top: 10px;">Quantity (Kilos)</th>
                <th style="width: 10px; padding-top: 10px;"></th>
                <th style="text-align: center; width: 20%; padding-top: 10px;">Value (Php)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($marketingData as $spec => $item)
                <tr>
                    <td style="padding-top: 10px;">{{ $spec }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $item['local_kilos'] }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">
                        {{ !is_null($item['local_value']) ? number_format($item['local_value'], 2) : '' }}
                    </td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $item['export_kilos'] }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">
                        {{ !is_null($item['export_value']) ? number_format($item['export_value'], 2) : '' }}
                    </td>
                </tr>
            @endforeach

            {{-- Custom Marketing Rows --}}
            @foreach ($customMarketingRows as $custom)
                @php
                    $localVal =
                        isset($custom['local_val']) && $custom['local_val'] !== ''
                            ? (float) $custom['local_val']
                            : null;
                    $exportVal =
                        isset($custom['export_val']) && $custom['export_val'] !== ''
                            ? (float) $custom['export_val']
                            : null;
                @endphp
                <tr>
                    <td style="padding-top: 10px;">{{ $custom['label'] ?? '' }}</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $custom['local_qty'] ?? '' }}
                    </td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">
                        {{ !is_null($localVal) ? number_format($localVal, 2) : '' }}
                    </td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">{{ $custom['export_qty'] ?? '' }}
                    </td>
                    <td style="padding-top: 10px;"></td>
                    <td class="text-center border-line" style="padding-top: 10px;">
                        {{ !is_null($exportVal) ? number_format($exportVal, 2) : '' }}
                    </td>
                </tr>
            @endforeach

            @for ($i = count($customMarketingRows); $i < 3; $i++)
                <tr>
                    <td style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;"></td>
                    <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                </tr>
            @endfor

            <tr class="font-bold">
                <td style="padding-top: 10px;">TOTAL</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
                <td style="padding-top: 10px;"></td>
                <td class="border-line" style="padding-top: 10px;">&nbsp;</td>
            </tr>
        </tbody>
    </table>

    <!-- STATUTORY NOTE -->
    <div style="font-size: 8.5pt; text-align: justify; margin-bottom: 12px; font-style: italic;">
        <strong>Note: Section 23(e)</strong> - Within one (1) year and six (6) months from the approval of the
        FLA/ASC,
        the area leased shall be developed and producing in commercial scale; provided, however, that within five
        (5)
        years from the approval of the FLA/ASC, the holder must have fully developed the area.
    </div>

    <!-- REMARKS -->
    <div class="font-bold" style="font-size: 9.5pt; margin-bottom: 4px;">REMARKS:</div>

    <div style="
            font-size: 9.5pt;
            text-align: justify;
            line-height: 1.8;
            margin-bottom: 15px;
        ">
        <span
            style="
                border-bottom: 1px solid #000;
                display: inline;
            ">
            {{ $report->remarks ?? '' }}
        </span>
    </div>

    <!-- SIGNATURE -->
    <div class="text-right" style="margin-bottom: 20px;">
        <div style="display: inline-block; text-align: center; width: 300px;">
            Very truly yours,<br><br><br>
            @if (!empty($report->signature_data))
                <img src="{{ $report->signature_data }}"
                    style="max-height: 45px; display: block; margin: 0 auto;"><br>
            @endif
            <span class="underline font-bold" style="width: 280px;">{{ $report->lessee->full_name ?? '' }}</span><br>
            <span class="italic" style="font-size: 9pt;">(Signature of Lessee over Printed Name)</span>
        </div>
    </div>

    <!-- JURAT / NOTARY SECTION -->
    <div style="font-size: 9pt; line-height: 1.3;">
        <p class="indent">
            SUBSCRIBED AND SWORN to before me this <span class="underline"
                style="width: 100px;">{{ $report->jurat_day ?? '' }}</span> day of <span class="underline"
                style="width: 140px;">{{ $report->jurat_month_year ?? '' }}</span> at <span class="underline"
                style="width: 150px;">{{ $report->jurat_place ?? '' }}</span> Affiant exhibited to me his/her
            Community Tax Certificate No. <span class="underline"
                style="width: 140px;">{{ $report->ctc_no ?? '' }}</span> issued on <span class="underline"
                style="width: 120px;">{{ $report->ctc_date_issued ?? '' }}</span> at <span class="underline"
                style="width: 130px;">{{ $report->ctc_place_issued ?? '' }}</span>.
        </p>

        <table style="width: 100%; margin-top: 25px;">
            <tr>
                <td style="width: 40%; vertical-align: top;">
                    Doc. No. <span class="underline" style="width: 120px;">{{ $report->doc_no ?? '' }}</span><br>
                    Book No. <span class="underline" style="width: 115px;">{{ $report->book_no ?? '' }}</span><br>
                    Page No. <span class="underline" style="width: 115px;">{{ $report->page_no ?? '' }}</span><br>
                    Series of <span class="underline" style="width: 118px;">{{ $report->series_of ?? '' }}</span>
                </td>
                <td style="width: 60%; text-align: center; vertical-align: bottom;">
                    <span class="underline" style="width: 250px;"></span><br>
                    Notary Public
                </td>
            </tr>
        </table>
    </div>

    <!-- PAGE 3: SKETCH OF THE AREA / SITE PHOTOS -->
    <div class="page-break"></div>

    <div class="text-center font-bold" style="font-size: 11pt; margin-top: 10px; margin-bottom: 25px;">
        SKETCH OF THE AREA
    </div>

    @php
        $sitePhotos = is_array($report->site_photos) ? $report->site_photos : [];
        $sketchPhoto = $report->sketch_photo ?? null;
    @endphp

    @if (!empty($sitePhotos))
        <table style="width: 100%;">
            @foreach (array_chunk($sitePhotos, 2) as $photoRow)
                <tr>
                    @foreach ($photoRow as $photo)
                        <td style="width: 50%; text-align: center; padding: 10px; vertical-align: top;">
                            <img src="{{ public_path('storage/' . $photo) }}"
                                style="max-width: 100%; max-height: 400px; margin: 0 auto; display: block; ">
                        </td>
                    @endforeach
                    @if (count($photoRow) == 1)
                        <td style="width: 50%;"></td>
                    @endif
                </tr>
            @endforeach
        </table>
    @elseif ($sketchPhoto)
        <div class="text-center" style="margin-top: 20px;">
            <img src="{{ public_path('storage/' . $sketchPhoto) }}"
                style="max-width: 90%; max-height: 800px; margin: 0 auto; display: block; border: 1px solid #ccc; padding: 5px;">
        </div>
    @else
        <div class="text-center italic" style="margin-top: 50px; color: #666;">
            No photo or sketch attached.
        </div>
    @endif

</body>

</html>
