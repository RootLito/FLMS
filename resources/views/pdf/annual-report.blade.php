<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Annual Report of Fishfarm/Fishpond Operation</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
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
        ANNUAL REPORT OF FISHFARM/FISHPOND OPERATION
    </div>

    <!-- PERIOD COVERED -->
    <div style="width: 280px; margin-left: auto; text-align: center; margin-bottom: 20px;">
        <div style="border-bottom: 1px solid #000; padding-bottom: 2px; min-height: 18px;">
            {{ $report->from?->format('F d, Y') }} to {{ $report->to?->format('F d, Y') }}
        </div>
        <div style="font-size: 11pt;">Period Covered</div>
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
            I have the honor to submit the annual report of operation and improvements for the fishpond area covered by FLA/ASC/Fp. A. No.
            <u>&nbsp;&nbsp;{{ ucwords(strtolower($report->fla_no)) }}&nbsp;&nbsp;</u>
            located in Brgy. <u>&nbsp;&nbsp;{{ ucwords(strtolower($report->barangay)) }}&nbsp;&nbsp;</u>,
            Municipality of <u>&nbsp;&nbsp;{{ ucwords(strtolower($report->municipality)) }}&nbsp;&nbsp;</u>,
            Province of <u>&nbsp;&nbsp;{{ ucwords(strtolower($report->province)) }}&nbsp;&nbsp;</u>,
            for the period stated above.
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
                            <span style="text-decoration: underline;">{{ ucwords(strtolower($report->lessee->full_name ?? '')) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 2px; line-height: 1.1;">
                            <span>Address: </span>
                            <span style="text-decoration: underline;">{{ ucwords(strtolower(implode(', ', array_filter([$report->lessee->barangay ?? '', $report->lessee->municipality ?? '', $report->lessee->province ?? ''])))) }}</span>
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
                            <span style="text-decoration: underline;">{{ $report->date_issued?->format('F d, Y') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 2px; line-height: 1.1;">
                            <span>Date of Expiration: </span>
                            <span style="text-decoration: underline;">{{ $report->date_expire?->format('F d, Y') }}</span>
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

    <!-- SECTION A: ITEMS / IMPROVEMENTS -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; line-height: 1.25;">
        <thead>
            <tr class="font-bold">
                <td style="width: 45%; vertical-align: top;">A. Kind and Extent of Improvements</td>
                <td style="width: 25%; text-align: center; vertical-align: top;">Date Introduced</td>
                <td style="width: 5%;"></td>
                <td style="width: 25%; text-align: right; vertical-align: top;">Value/Cost (Php)</td>
            </tr>
        </thead>
        <tbody>
            @php
                $items = is_array($report->items) ? $report->items : [];
            @endphp
            @if(count($items) > 0)
                @foreach($items as $index => $item)
                    <tr>
                        <td style="padding: 2px 0 2px 15px;">
                            {{ (int)$index + 1 }}. {{ $item['name'] ?? '' }}: <span style="text-decoration: underline;">{{ $item['extent'] ?? '' }}</span>
                        </td>
                        <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                            {{ $item['date'] ?? '' }}
                        </td>
                        <td></td>
                        <td style="text-align: right; border-bottom: 1px solid #000; vertical-align: bottom;">
                            {{ isset($item['cost']) && $item['cost'] !== '' ? number_format((float)$item['cost'], 2) : '' }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="padding: 5px 0 5px 15px; font-style: italic;">No improvements listed.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- SECTION B: STOCKING -->
    <div class="font-bold" style="margin-bottom: 5px;">B. Stocking Operation</div>
    <table style="margin-bottom: 15px;">
        <thead>
            <tr class="font-bold">
                <td style="width: 30%; padding-bottom: 2px;">SPECIES STOCKED</td>
                <td style="width: 25%; padding-bottom: 2px;">SOURCE</td>
                <td style="width: 20%; padding-bottom: 2px;">QUANTITY</td>
                <td style="width: 25%; text-align: right; padding-bottom: 2px;">VALUE/COST (Php)</td>
            </tr>
        </thead>
        <tbody>
            @php
                $stockings = is_array($report->stocking) ? $report->stocking : [];
            @endphp
            @if(count($stockings) > 0)
                @foreach($stockings as $index => $stock)
                    <tr>
                        <td style="padding: 2px 0; border-bottom: 1px solid #000;">{{ (int)$index + 1 }}. {{ $stock['species'] ?? '' }}</td>
                        <td style="padding: 2px 0; border-bottom: 1px solid #000;">{{ $stock['source'] ?? '' }}</td>
                        <td style="padding: 2px 0; border-bottom: 1px solid #000;">{{ $stock['quantity'] ?? '' }}</td>
                        <td style="padding: 2px 0; border-bottom: 1px solid #000; text-align: right;">
                            {{ isset($stock['cost']) && $stock['cost'] !== '' ? number_format((float)$stock['cost'], 2) : '' }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="padding: 5px 0; font-style: italic; border-bottom: 1px solid #000;">No stocking data recorded.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- PAGE 2 -->
    <div class="page-break"></div>

    <!-- SECTION C: HARVESTING -->
    <div class="font-bold" style="margin-bottom: 5px;">C. Harvesting Operation</div>
    <table style="margin-bottom: 15px;">
        <thead>
            <tr class="font-bold">
                <td style="width: 30%; padding-bottom: 2px;">SPECIES HARVESTED</td>
                <td style="width: 25%; padding-bottom: 2px;">DATE OF HARVEST</td>
                <td style="width: 20%; padding-bottom: 2px;">KILOS HARVESTED</td>
                <td style="width: 25%; text-align: right; padding-bottom: 2px;">GROSS SALES (Php)</td>
            </tr>
        </thead>
        <tbody>
            @php
                $harvestings = is_array($report->harvesting) ? $report->harvesting : [];
            @endphp
            @if(count($harvestings) > 0)
                @foreach($harvestings as $index => $harvest)
                    <tr>
                        <td style="padding: 2px 0; border-bottom: 1px solid #000;">{{ (int)$index + 1 }}. {{ $harvest['species'] ?? '' }}</td>
                        <td style="padding: 2px 0; border-bottom: 1px solid #000;">{{ $harvest['date'] ?? '' }}</td>
                        <td style="padding: 2px 0; border-bottom: 1px solid #000;">{{ $harvest['kilos'] ?? '' }}</td>
                        <td style="padding: 2px 0; border-bottom: 1px solid #000; text-align: right;">
                            {{ isset($harvest['sales']) && $harvest['sales'] !== '' ? number_format((float)$harvest['sales'], 2) : '' }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="padding: 5px 0; font-style: italic; border-bottom: 1px solid #000;">No harvesting data recorded.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- SECTION D: MARKETING -->
    <div class="font-bold" style="margin-bottom: 5px;">D. Marketing Disposition</div>
    <table style="margin-bottom: 20px;">
        <thead>
            <tr class="font-bold">
                <td style="width: 40%; padding-bottom: 2px;">MARKET OUTLET / TYPE</td>
                <td style="width: 35%; padding-bottom: 2px;">DESTINATION</td>
                <td style="width: 25%; text-align: right; padding-bottom: 2px;">QUANTITY (Kilos)</td>
            </tr>
        </thead>
        <tbody>
            @php
                $marketings = is_array($report->marketing) ? $report->marketing : [];
            @endphp
            @if(count($marketings) > 0)
                @foreach($marketings as $index => $market)
                    <tr>
                        <td style="padding: 2px 0; border-bottom: 1px solid #000;">{{ (int)$index + 1 }}. {{ $market['outlet'] ?? '' }}</td>
                        <td style="padding: 2px 0; border-bottom: 1px solid #000;">{{ $market['destination'] ?? '' }}</td>
                        <td style="padding: 2px 0; border-bottom: 1px solid #000; text-align: right;">{{ $market['kilos'] ?? '' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" style="padding: 5px 0; font-style: italic; border-bottom: 1px solid #000;">No marketing data recorded.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- SECTION E: REMARKS -->
    <div class="font-bold" style="margin-bottom: 6px;">E. Remarks / Observations:</div>
    <div style="margin-bottom: 25px; border: 1px solid #ccc; padding: 10px; min-height: 80px; font-size: 11pt;">
        {{ $report->remarks ?? 'None recorded.' }}
    </div>

    <!-- SIGNATURE -->
    <div class="text-right" style="margin-bottom: 25px;">
        <div style="display: inline-block; text-align: center;">
            Very truly yours,<br><br><br>
            @if(!empty($report->signature_data))
                <img src="{{ $report->signature_data }}" style="max-height: 50px; display: block; margin: 0 auto;"><br>
            @endif
            <span class="underline-field font-bold" style="width: 250px;">{{ $report->lessee->full_name ?? '' }}</span><br>
            <span class="italic">Lessee / Permittee</span><br>
        </div>
    </div>

    <!-- PAGE 3: SITE PHOTOS -->
    @php
        $sitePhotos = is_array($report->site_photos) ? $report->site_photos : [];
    @endphp
    @if (!empty($sitePhotos))
        <div class="page-break"></div>

        <div class="text-center font-bold" style="margin-top: 20px; margin-bottom: 30px; padding: 0 20px; line-height: 1.4;">
            RECENT PHOTOS SHOWING THE ACTUAL STATUS OF THE AREA
        </div>

        <table style="width: 100%;">
            @foreach (array_chunk($sitePhotos, 2) as $photoRow)
                <tr>
                    @foreach ($photoRow as $photo)
                        <td style="width: 50%; text-align: center; padding: 10px; vertical-align: top;">
                            <img src="{{ public_path('storage/' . $photo) }}" style="max-width: 100%; max-height: 350px; margin: 0 auto; display: block; border: 1px solid #ddd; padding: 4px;">
                        </td>
                    @endforeach
                    @if(count($photoRow) == 1)
                        <td style="width: 50%;"></td>
                    @endif
                </tr>
            @endforeach
        </table>
    @endif

</body>

</html>