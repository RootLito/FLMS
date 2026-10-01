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
            text-align: center;
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
            padding: 2px 3px;
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
    <div class="text-center font-bold" style="font-size: 11pt; margin-bottom: 4px;">
        ANNUAL REPORT ON FISHPOND DEVELOPMENT, OPERATION & PRODUCTION
    </div>
    <div class="text-center font-bold" style="font-size: 10pt; margin-bottom: 15px;">
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
            FLA. No. <span class="underline" style="width: 200px;">{{ $report->fla_no }}</span>
            located at <span class="underline"
                style="width: 380px;">{{ ucwords(strtolower(implode(', ', array_filter([$report->barangay ?? '', $report->municipality ?? '', $report->province ?? ''])))) }}</span>.
        </p>
    </div>

    <!-- META DETAILS GRID -->
    <table style="width: 100%; margin-bottom: 10px; font-size: 9.5pt;">
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
                    style="width: 180px;">{{ $report->area_nursery ?? '' }}</span> (has.)<br>
                &nbsp;&nbsp;b. Transition: <span class="underline"
                    style="width: 168px;">{{ $report->area_transition ?? '' }}</span> (has.)<br>
                &nbsp;&nbsp;c. Rearing: <span class="underline"
                    style="width: 183px;">{{ $report->area_rearing ?? '' }}</span> (has.)<br>
                Area Undeveloped: <span class="underline"
                    style="width: 180px;">{{ $report->no_hect_undeveloped }}</span> (has.)
            </td>
        </tr>
    </table>

    <!-- SECTION A -->
    <div class="section-header">A. KIND AND EXTENT OF IMPROVEMENTS</div>

    <table class="table-form" style="margin-bottom: 10px;">
        <thead>
            <tr class="font-bold">
                <th style="text-align: left; width: 45%;">ITEM</th>
                <th style="text-align: center; width: 30%;">DATE INTRODUCED</th>
                <th style="text-align: right; width: 25%;">VALUE/COST</th>
            </tr>
        </thead>
        <tbody>
            @php
                $items = is_array($report->items) ? $report->items : [];
                $itemDict = collect($items)->keyBy('name');
            @endphp
            <tr>
                <td>1. Clearings: Area Cleared: <span class="underline"
                        style="width: 120px;">{{ $itemDict['Clearings']['extent'] ?? '' }}</span> (has.)</td>
                <td class="text-center border-line">{{ $itemDict['Clearings']['date'] ?? '' }}</td>
                <td class="text-right border-line">
                    {{ isset($itemDict['Clearings']['cost']) && $itemDict['Clearings']['cost'] !== '' ? number_format((float) $itemDict['Clearings']['cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td>2. Dikes:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Main: <span class="underline"
                        style="width: 180px;">{{ $itemDict['Dikes Main']['extent'] ?? '' }}</span> lineal meters</td>
                <td class="text-center border-line">{{ $itemDict['Dikes Main']['date'] ?? '' }}</td>
                <td class="text-right border-line">
                    {{ isset($itemDict['Dikes Main']['cost']) && $itemDict['Dikes Main']['cost'] !== '' ? number_format((float) $itemDict['Dikes Main']['cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Secondary: <span class="underline"
                        style="width: 155px;">{{ $itemDict['Dikes Secondary']['extent'] ?? '' }}</span> lineal meters
                </td>
                <td class="text-center border-line">{{ $itemDict['Dikes Secondary']['date'] ?? '' }}</td>
                <td class="text-right border-line">
                    {{ isset($itemDict['Dikes Secondary']['cost']) && $itemDict['Dikes Secondary']['cost'] !== '' ? number_format((float) $itemDict['Dikes Secondary']['cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Excavation: <span class="underline"
                        style="width: 150px;">{{ $itemDict['Excavation']['extent'] ?? '' }}</span> cubic meters</td>
                <td class="text-center border-line">{{ $itemDict['Excavation']['date'] ?? '' }}</td>
                <td class="text-right border-line">
                    {{ isset($itemDict['Excavation']['cost']) && $itemDict['Excavation']['cost'] !== '' ? number_format((float) $itemDict['Excavation']['cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td>3. Gates:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Concrete: <span class="underline"
                        style="width: 200px;">{{ $itemDict['Concrete Gates']['extent'] ?? '' }}</span></td>
                <td class="text-center border-line">{{ $itemDict['Concrete Gates']['date'] ?? '' }}</td>
                <td class="text-right border-line">
                    {{ isset($itemDict['Concrete Gates']['cost']) && $itemDict['Concrete Gates']['cost'] !== '' ? number_format((float) $itemDict['Concrete Gates']['cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px;">Wooden: <span class="underline"
                        style="width: 205px;">{{ $itemDict['Wooden Gates']['extent'] ?? '' }}</span></td>
                <td class="text-center border-line">{{ $itemDict['Wooden Gates']['date'] ?? '' }}</td>
                <td class="text-right border-line">
                    {{ isset($itemDict['Wooden Gates']['cost']) && $itemDict['Wooden Gates']['cost'] !== '' ? number_format((float) $itemDict['Wooden Gates']['cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td>House/Building, etc. <span class="underline"
                        style="width: 180px;">{{ $itemDict['House/Building']['extent'] ?? '' }}</span></td>
                <td class="text-center border-line">{{ $itemDict['House/Building']['date'] ?? '' }}</td>
                <td class="text-right border-line">
                    {{ isset($itemDict['House/Building']['cost']) && $itemDict['House/Building']['cost'] !== '' ? number_format((float) $itemDict['House/Building']['cost'], 2) : '' }}
                </td>
            </tr>
            <tr>
                <td>Equipment/Tools/Banca, etc. <span class="underline"
                        style="width: 140px;">{{ $itemDict['Equipment/Tools/Banca']['extent'] ?? '' }}</span></td>
                <td class="text-center border-line">{{ $itemDict['Equipment/Tools/Banca']['date'] ?? '' }}</td>
                <td class="text-right border-line">
                    {{ isset($itemDict['Equipment/Tools/Banca']['cost']) && $itemDict['Equipment/Tools/Banca']['cost'] !== '' ? number_format((float) $itemDict['Equipment/Tools/Banca']['cost'], 2) : '' }}
                </td>
            </tr>
            <tr class="font-bold">
                <td class="text-right" colspan="2">TOTAL&nbsp;&nbsp;&nbsp;&nbsp;Php</td>
                <td class="text-right border-line">
                    {{ number_format((float) ($report->total_improvements_cost ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td colspan="3">4. Assessed Value:</td>
            </tr>
            <tr>
                <td style="padding-left: 15px;" colspan="2">Actual Appraisal
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Php
                </td>
                <td class="text-right border-line">{{ number_format((float) ($report->actual_appraisal ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td style="padding-left: 15px;" colspan="2">Under Tax Declaration:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Php
                </td>
                <td class="text-right border-line">{{ number_format((float) ($report->tax_declaration_value ?? 0), 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    5. Number of Workers Employed:<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;a. Caretaker/s <span class="underline"
                        style="width: 200px;">{{ $report->caretakers_count ?? '' }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;b. Laborer/s <span class="underline"
                        style="width: 200px;">{{ $report->laborers_count ?? '' }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- SECTION B -->
    <div class="section-header">B. PRODUCTION AND MARKETING OPERATION</div>
    <div class="sub-header">1. STOCKING:</div>

    <table class="table-form" style="margin-bottom: 10px;">
        <thead>
            <tr class="font-bold">
                <th style="text-align: left; width: 18%;">Species</th>
                <th style="text-align: center; width: 16%;">Date Stocked</th>
                <th style="text-align: center; width: 20%;">Source/Place</th>
                <th style="text-align: center; width: 16%;">Area Stocked (Has.)</th>
                <th style="text-align: center; width: 15%;">Quantity (No.)</th>
                <th style="text-align: right; width: 15%;">Cost (Php)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $stockings = is_array($report->stocking) ? $report->stocking : [];
                $stockDict = collect($stockings)->keyBy('species');
                $standardSpecies = ['Bangus', 'Fry', 'Fingerlings', 'Sugpo', 'Shrimp', 'Others (Specify)'];
                $totalStockCost = 0;
            @endphp
            @foreach ($standardSpecies as $spec)
                @php
                    $item = $stockDict->get($spec, []);
                    $cost = isset($item['cost']) && $item['cost'] !== '' ? (float) $item['cost'] : 0;
                    $totalStockCost += $cost;
                @endphp
                <tr>
                    <td class="font-bold">{{ $spec }}</td>
                    <td class="text-center border-line">{{ $item['date_stocked'] ?? '' }}</td>
                    <td class="text-center border-line">{{ $item['source'] ?? '' }}</td>
                    <td class="text-center border-line">{{ $item['area_stocked'] ?? '' }}</td>
                    <td class="text-center border-line">{{ $item['quantity'] ?? '' }}</td>
                    <td class="text-right border-line">{{ $cost > 0 ? number_format($cost, 2) : '' }}</td>
                </tr>
            @endforeach
            <tr class="font-bold">
                <td colspan="5">TOTAL</td>
                <td class="text-right border-line">{{ number_format($totalStockCost, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- PAGE 2 -->
    <div class="page-break"></div>

    <div class="sub-header">2. HARVESTING:</div>
    <table class="table-form" style="margin-bottom: 15px;">
        <thead>
            <tr class="font-bold">
                <th style="text-align: left; width: 18%;">Species</th>
                <th style="text-align: center; width: 15%;">Date Harvested</th>
                <th style="text-align: center; width: 15%;">Area Harvested</th>
                <th style="text-align: center; width: 14%;">Quantity (Kilos)</th>
                <th style="text-align: center; width: 12%;">No. of Pcs./Kg.</th>
                <th style="text-align: center; width: 13%;">Price/Kilo</th>
                <th style="text-align: right; width: 13%;">Total Value</th>
            </tr>
        </thead>
        <tbody>
            @php
                $harvestings = is_array($report->harvesting) ? $report->harvesting : [];
                $harvestDict = collect($harvestings)->keyBy('species');
                $harvestSpecies = ['Bangus', 'Sugpo', 'Shrimp', 'Others (Specify)'];
                $totalHarvestValue = 0;
            @endphp
            @foreach ($harvestSpecies as $spec)
                @php
                    $item = $harvestDict->get($spec, []);
                    $val = isset($item['sales']) && $item['sales'] !== '' ? (float) $item['sales'] : 0;
                    $totalHarvestValue += $val;
                @endphp
                <tr>
                    <td class="font-bold">{{ $spec }}</td>
                    <td class="text-center border-line">{{ $item['date'] ?? '' }}</td>
                    <td class="text-center border-line">{{ $item['area_harvested'] ?? '' }}</td>
                    <td class="text-center border-line">{{ $item['kilos'] ?? '' }}</td>
                    <td class="text-center border-line">{{ $item['pcs_per_kg'] ?? '' }}</td>
                    <td class="text-center border-line">
                        {{ isset($item['price_per_kilo']) && $item['price_per_kilo'] !== '' ? number_format((float) $item['price_per_kilo'], 2) : '' }}
                    </td>
                    <td class="text-right border-line">{{ $val > 0 ? number_format($val, 2) : '' }}</td>
                </tr>
            @endforeach
            <tr class="font-bold">
                <td colspan="6">TOTAL</td>
                <td class="text-right border-line">{{ number_format($totalHarvestValue, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="sub-header">3. MARKETING:</div>
    <table class="table-form" style="margin-bottom: 15px;">
        <thead>
            <tr class="font-bold">
                <th rowspan="2" style="text-align: left; width: 20%; vertical-align: bottom;">Species</th>
                <th colspan="2" style="text-align: center; width: 40%; border-bottom: 1px solid #000;">Local
                    Consumption</th>
                <th colspan="2" style="text-align: center; width: 40%; border-bottom: 1px solid #000;">Export</th>
            </tr>
            <tr class="font-bold">
                <th style="text-align: center; width: 20%;">Quantity (Kilos)</th>
                <th style="text-align: center; width: 20%;">Value (Php)</th>
                <th style="text-align: center; width: 20%;">Quantity (Kilos)</th>
                <th style="text-align: center; width: 20%;">Value (Php)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $marketings = is_array($report->marketing) ? $report->marketing : [];
                $marketDict = collect($marketings)->keyBy('species');
                $marketSpecies = ['Bangus', 'Sugpo', 'Shrimp', 'Others'];
            @endphp
            @foreach ($marketSpecies as $spec)
                @php
                    $item = $marketDict->get($spec, []);
                @endphp
                <tr>
                    <td class="font-bold">{{ $spec }}</td>
                    <td class="text-center border-line">{{ $item['local_kilos'] ?? '' }}</td>
                    <td class="text-center border-line">
                        {{ isset($item['local_value']) && $item['local_value'] !== '' ? number_format((float) $item['local_value'], 2) : '' }}
                    </td>
                    <td class="text-center border-line">{{ $item['export_kilos'] ?? '' }}</td>
                    <td class="text-center border-line">
                        {{ isset($item['export_value']) && $item['export_value'] !== '' ? number_format((float) $item['export_value'], 2) : '' }}
                    </td>
                </tr>
            @endforeach
            <tr class="font-bold">
                <td>TOTAL</td>
                <td class="border-line"></td>
                <td class="border-line"></td>
                <td class="border-line"></td>
                <td class="border-line"></td>
            </tr>
        </tbody>
    </table>

    <!-- STATUTORY NOTE -->
    <div style="font-size: 8.5pt; text-align: justify; margin-bottom: 12px; font-style: italic;">
        <strong>Note: Section 23(e)</strong> - Within one (1) year and six (6) months from the approval of the FLA/ASC,
        the area leased shall be developed and producing in commercial scale; provided, however, that within five (5)
        years from the approval of the FLA/ASC, the holder must have fully developed the area.
    </div>

    <!-- REMARKS -->
    <div class="font-bold" style="font-size: 9.5pt; margin-bottom: 4px;">REMARKS:</div>
    <div style="min-height: 50px; text-align: justify; font-size: 9.5pt; margin-bottom: 15px;" class="border-line">
        {{ $report->remarks ?? '' }}
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
        SKETCH OF THE AREA / RECENT SITE PHOTOS
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
                                style="max-width: 100%; max-height: 400px; margin: 0 auto; display: block; border: 1px solid #ddd; padding: 4px;">
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
