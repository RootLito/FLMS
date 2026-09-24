<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Report of Inspection and Verification of Improvements</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: 8.5in 13in;
            margin-top: 1.5in;
            margin-bottom: 1.0in;
            margin-left: 0.75in;
            margin-right: 0.75in;
            font-family: 'Cambria';
            font-size: 12pt;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Cambria';
            font-size: 12pt;
            color: #000;
        }


        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body class="bg-white text-black">

    <!-- PAGE 1 -->
    <div class="text-center font-bold mb-4" style="font-size: 13pt;">
        <p>REPORT OF INSPECTION AND VERIFICATION OF IMPROVEMENTS</p>
    </div>

    <!-- DATE -->
    <div class="ml-auto w-48 text-center flex flex-col mb-6">
        <span class="w-full border-b border-black">{{ $report->created_at?->format('F d, Y') }}</span>
        <span>Date</span>
    </div>

    <!-- RECIPIENT -->
    <div class="mb-4">
        <strong>The Director</strong><br>
        Bureau of Fisheries and Aquatic Resources<br>
        3/F Main Building, Fisheries Building Complex<br>
        Visayas Avenue, Diliman, Quezon City
    </div>

    <!-- INTRO TEXT -->
    <div class="mb-4 text-justify">
        Sir:<br><br>
        <p class="indent-8">
            I have the honor to inform you that an ocular inspection and verification of improvements was conducted by
            the undersigned in the fishpond area covered by FLA/ASC/Fp. A. No. <span
                class="underline">{{ $report->fla_no }}</span> located in Brgy. <span
                class="underline">{{ $report->barangay }}</span>, Municipality of <span
                class="underline">{{ $report->municipality }}</span>, Province of <span
                class="underline">{{ $report->province }}</span>, and I hereby certify that the following are
            the kind and extent of improvements found existing in the area and production thereof.
        </p>
    </div>

    <!-- LESSEE META DATA -->
    <div class="flex gap-12">
        <div class="flex-1">
            Name of Lessee/Applicant: <span class="underline-field w-40">{{ $report->lessee->name ?? '' }}</span><br>
            Address: <span class="underline-field w-56">{{ $report->lessee->address ?? '' }}</span><br>
            No. of hectares granted: <span class="underline-field w-28">{{ $report->hectares_granted }}</span><br>
            No. of hectares developed: <span class="underline-field w-24">{{ $report->hectares_developed }}</span>
        </div>
        <div class="w-18">
            <div class="w-full flex items-baseline">
        <span class="whitespace-nowrap">
            FLA/ASC/Fp. A. No.
        </span>

        <span class="relative flex-1 ml-1">
            {{ $report->fla_no }}
            <span class="absolute left-0 right-0 bottom-0 border-b border-black"></span>
        </span>
    </div>
            Date Issued: <span class="underline-field w-36">{{ $report->date_issued }}</span><br>
            Date of Expiration: <span class="underline-field w-32">{{ $report->date_of_expiration }}</span><br>
            No. of hectares undeveloped: <span class="underline-field w-20">{{ $report->hectares_undeveloped }}</span>
        </div>
    </div>

    <!-- SECTION A -->
    <div class="font-bold mb-1">A. Kind and Extent of Improvements</div>
    <div class="grid grid-cols-12 font-bold mb-1 pl-4">
        <div class="col-span-6"></div>
        <div class="col-span-3 text-center">Date Introduced</div>
        <div class="col-span-3 text-right">Value/Cost (Php)</div>
    </div>

    <div class="pl-4 space-y-1">
        <!-- 1. Clearings -->
        <div class="grid grid-cols-12 items-end">
            <div class="col-span-6">
                1. Clearings:<br>
                <span class="pl-4">Area Cleared: <span
                        class="underline-field w-24">{{ $report->area_cleared }}</span> has.</span><br>
                <span class="pl-4">Main dike: <span
                        class="underline-field w-24">{{ $report->main_dike_meters }}</span> lineal meters</span><br>
                <span class="pl-4">Secondary dikes: <span
                        class="underline-field w-20">{{ $report->secondary_dike_meters }}</span> lineal meters</span>
            </div>
            <div class="col-span-3 text-center border-b border-black">{{ $report->clearings_date }}</div>
            <div class="col-span-3 text-right border-b border-black">{{ number_format($report->clearings_cost, 2) }}
            </div>
        </div>

        <!-- 2. Excavation -->
        <div class="grid grid-cols-12 items-end">
            <div class="col-span-6">2. Excavation: <span
                    class="underline-field w-24">{{ $report->excavation_cubic_meters }}</span> cubic meters</div>
            <div class="col-span-3 text-center border-b border-black">{{ $report->excavation_date }}</div>
            <div class="col-span-3 text-right border-b border-black">{{ number_format($report->excavation_cost, 2) }}
            </div>
        </div>

        <!-- 3. Gates -->
        <div class="grid grid-cols-12 items-end">
            <div class="col-span-6">
                3. Gates:<br>
                <span class="pl-4">Concrete: <span
                        class="underline-field w-24">{{ $report->concrete_gates_qty }}</span> (number)</span><br>
                <span class="pl-4">Wooden: <span class="underline-field w-24">{{ $report->wooden_gates_qty }}</span>
                    (number)</span>
            </div>
            <div class="col-span-3 text-center border-b border-black">{{ $report->gates_date }}</div>
            <div class="col-span-3 text-right border-b border-black">{{ number_format($report->gates_cost, 2) }}</div>
        </div>

        <!-- 4. House -->
        <div class="grid grid-cols-12 items-end">
            <div class="col-span-6">4. House, etc.</div>
            <div class="col-span-3 text-center border-b border-black">{{ $report->house_date }}</div>
            <div class="col-span-3 text-right border-b border-black">{{ number_format($report->house_cost, 2) }}</div>
        </div>

        <!-- 5. Equipment -->
        <div class="grid grid-cols-12 items-end">
            <div class="col-span-6">5. Equipment, etc.</div>
            <div class="col-span-3 text-center border-b border-black">{{ $report->equipment_date }}</div>
            <div class="col-span-3 text-right border-b border-black">{{ number_format($report->equipment_cost, 2) }}
            </div>
        </div>

        <!-- 6. Assessed Value -->
        <div class="grid grid-cols-12 items-end font-bold pt-2">
            <div class="col-span-6">6. Assessed Value TOTAL VALUE:</div>
            <div class="col-span-6 text-right border-b border-black">
                {{ number_format($report->total_improvements_value, 2) }}</div>
        </div>
        <div class="pl-4">
            Actual Appraisal: <span
                class="underline-field w-32">{{ number_format($report->actual_appraisal, 2) }}</span><br>
            Under Tax Declaration: <span
                class="underline-field w-32">{{ number_format($report->tax_declaration_value, 2) }}</span>
        </div>

        <!-- 7-9 Workers -->
        <div class="pt-1">
            7. No. of Permanent Personnel/Workers Employed: <span
                class="underline-field w-20">{{ $report->permanent_workers }}</span> (Attach proof of SSS
            Contribution/Remittances)<br>
            8. No. of Non-Permanent Personnel/Workers Employed: <span
                class="underline-field w-20">{{ $report->non_permanent_workers }}</span><br>
            9. No. of Personnel/Workers Registered in (FishR): <span
                class="underline-field w-20">{{ $report->fishr_registered_workers }}</span>
        </div>
    </div>

    <!-- SECTION B -->
    <div class="font-bold mt-4 mb-1">B. Operation and Production</div>
    <div class="grid grid-cols-12 font-bold border-b border-black pb-1 mb-1">
        <div class="col-span-3">SPECIES STOCKED</div>
        <div class="col-span-3">SOURCE</div>
        <div class="col-span-3">QUANTITY</div>
        <div class="col-span-3 text-right">VALUE/COST (Php)</div>
    </div>

    @for ($i = 1; $i <= 3; $i++)
        @php $stock = $report->stockings[$i-1] ?? null; @endphp
        <div class="grid grid-cols-12 border-b border-gray-300 py-1">
            <div class="col-span-3">{{ $i }}. {{ $stock->species ?? '' }}</div>
            <div class="col-span-3">{{ $stock->source ?? '' }}</div>
            <div class="col-span-3">{{ $stock->quantity ?? '' }}</div>
            <div class="col-span-3 text-right">{{ isset($stock->cost) ? number_format($stock->cost, 2) : '' }}</div>
        </div>
    @endfor

    <div class="grid grid-cols-2 gap-4 mt-2">
        <div>
            4. Date of Stocking: <span class="underline-field w-32">{{ $report->date_of_stocking }}</span><br>
            5. Date of Harvest: <span class="underline-field w-32">{{ $report->date_of_harvest }}</span><br>
            6. Markets: Domestic: <span class="underline-field w-32">{{ $report->market_domestic }}</span><br>
            <span class="pl-14">Export: <span class="underline-field w-32">{{ $report->market_export }}</span></span>
        </div>
        <div>
            No. of Kilos harvested: <span class="underline-field w-28">{{ $report->kilos_harvested }}</span><br>
            Gross Sales: <span class="underline-field w-36">{{ number_format($report->gross_sales, 2) }}</span><br>
            No. of Kilos: <span class="underline-field w-28">{{ $report->market_domestic_kilos }}</span><br>
            No. of Kilos: <span class="underline-field w-28">{{ $report->market_export_kilos }}</span>
        </div>
    </div>

    <!-- PAGE 2 -->
    <div class="page-break"></div>

    <p class="text-justify italic mb-4">
        Note: Section 23(e) - Within one (1) year and six (6) months from the approval of the FLA/ASC, the area leased
        shall be developed and producing in commercial scale; provided, however, that within five (5) years from the
        approval of the FLA/ASC, the holder must have fully developed the area.
    </p>

    <!-- SECTION C -->
    <div class="font-bold mb-2">C. Verification of Presence of Facilities that minimize Environmental pollution</div>
    <div class="pl-4 space-y-1 mb-4">
        <div>([ {{ $report->has_nursery ? 'X' : ' ' }} ]) Nursery: <span
                class="underline-field w-40">{{ $report->nursery_has }}</span> (Has.)</div>
        <div>([ {{ $report->has_transition ? 'X' : ' ' }} ]) Transition: <span
                class="underline-field w-40">{{ $report->transition_has }}</span> (Has.)</div>
        <div>([ {{ $report->has_rearing ? 'X' : ' ' }} ]) Rearing: <span
                class="underline-field w-40">{{ $report->rearing_has }}</span> (Has.)</div>
        <div>([ {{ $report->has_canal ? 'X' : ' ' }} ]) Canal: <span
                class="underline-field w-40">{{ $report->canal_has }}</span> (Has.)</div>
        <div>([ {{ $report->has_others ? 'X' : ' ' }} ]) Others: <span
                class="underline-field w-40">{{ $report->others_description }}</span> (Has.)</div>
    </div>

    <!-- SECTION D -->
    <div class="font-bold mb-2">D. Case status of the area</div>
    <div class="pl-4 space-y-1 mb-4">
        <div>1. With pending administrative case: ([ {{ $report->has_admin_case ? 'X' : ' ' }} ]) Yes or ([
            {{ !$report->has_admin_case ? 'X' : ' ' }} ]) No</div>
        <div>2. With pending judicial case: ([ {{ $report->has_judicial_case ? 'X' : ' ' }} ]) Yes or ([
            {{ !$report->has_judicial_case ? 'X' : ' ' }} ]) No</div>
    </div>

    <!-- SECTION E -->
    <div class="font-bold mb-2">E. Remarks and Recommendation/s:</div>
    <div class="space-y-4 mb-8">
        <div class="line-leader h-5"></div>
        <div class="line-leader h-5"></div>
        <div class="line-leader h-5"></div>
        <div class="line-leader h-5"></div>
    </div>

    <!-- SIGNATURE -->
    <div class="flex justify-end mb-8 text-center">
        <div>
            Very truly yours,<br><br><br>
            <span
                class="underline-field w-64 border-b border-black inline-block font-bold">{{ $report->inspecting_officer_name }}</span><br>
            <em>Inspecting Officer</em><br><br>
            <span
                class="underline-field w-64 border-b border-black inline-block">{{ $report->date_of_inspection }}</span><br>
            <em>Date of Inspection</em>
        </div>
    </div>

    <!-- CERTIFICATION -->
    <div class="text-center font-bold mb-4">
        <p>C E R T I F I C A T I O N</p>
    </div>

    <p class="text-justify mb-3 indent-8">
        I, <span class="underline-field w-48">{{ $report->inspecting_officer_name }}</span>, under my official oath,
        do hereby certify that I have personally conducted a thorough, actual inspection and verification of the
        fishpond area treated in the foregoing report and all statements of facts are true and correct.
    </p>

    <p class="text-justify mb-4 indent-8">
        I am fully aware that any false or misleading statements I have stated in the said report will subject me to
        appropriate disciplinary action which may be summary dismissal from the service.
    </p>

    <p class="mb-6 indent-8">
        IN WITNESS WHEREOF, I have hereunto set my signature this <span
            class="underline-field w-16">{{ date('jS') }}</span> day of <span
            class="underline-field w-32">{{ date('F, Y') }}</span> at <span
            class="underline-field w-48">{{ $report->inspection_location }}</span>.
    </p>

    <div class="text-right mb-6">
        <span class="underline-field w-64 border-b border-black inline-block">&nbsp;</span><br>
        (Signature over Printed Name)
    </div>

    <div class="grid grid-cols-2 mt-8">
        <div>
            Noted by:<br><br><br>
            <span class="line-leader inline-block w-48"></span><br>
            Designation
        </div>
        <div class="text-right">
            <br><br><br>
            <strong>Notary Public</strong>
        </div>
    </div>

    <!-- PAGE 3 -->
    <div class="page-break"></div>

    <div class="text-center font-bold mt-6 mb-8 uppercase px-8">
        SKETCH OF THE AREA SHOWING IMPROVEMENTS WITH RECENT PHOTOS SHOWING THE ACTUAL STATUS OF THE AREA
    </div>

    @if ($report->sketch_image_path)
        <div class="text-center">
            <img src="{{ public_path('storage/' . $report->sketch_image_path) }}"
                class="max-w-full max-h-[750px] mx-auto">
        </div>
    @endif

</body>

</html>
