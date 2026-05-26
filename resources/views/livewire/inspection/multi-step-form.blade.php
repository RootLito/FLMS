<?php

use function Livewire\Volt\{state, computed, usesFileUploads};
use App\Models\InspectionReport;
use App\Models\Lessee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Flux\Flux; // Import Flux façade for toast notifications

usesFileUploads();

state([
    'step' => 1,
    'totalSteps' => 6,
    'stepsInfo' => [
        1 => ['letter' => 'a', 'title' => 'Kind and Extent of Improvements'],
        2 => ['letter' => 'b', 'title' => 'Operation and Production'],
        3 => ['letter' => 'c', 'title' => 'Verification of Presence '],
        4 => ['letter' => 'd', 'title' => 'Case status of the area'],
        5 => ['letter' => 'e', 'title' => 'Remarks and Recommendation/s'],
        6 => ['letter' => 'f', 'title' => 'Signature and Photo'],
    ],
    'formData' => [
        'lessee_id' => '',
        'fla_no' => '', 'barangay' => '', 'municipality' => '', 'province' => '',
        'date_issued' => '', 'date_expire' => '',
        'no_hec_granted' => '', 'no_hec_developed' => '', 'no_hect_undeveloped' => '',
        
        'improvements' => [
            'clearings_area' => '', 'clearings_date' => '', 'clearings_cost' => '',
            'main_dike_meters' => '', 'main_dike_date' => '', 'main_dike_cost' => '',
            'secondary_dike_meters' => '', 'secondary_dike_date' => '', 'secondary_dike_cost' => '',
            'excavation_cubic' => '', 'excavation_date' => '', 'excavation_cost' => '',
            'gate_concrete' => '', 'gate_concrete_date' => '', 'gate_concrete_cost' => '',
            'gate_wooden' => '', 'gate_wooden_date' => '', 'gate_wooden_cost' => '',
            'house_desc' => '', 'house_date' => '', 'house_cost' => '',
            'equipment_desc' => '', 'equipment_date' => '', 'equipment_cost' => '',
            'permanent_workers' => '', 'non_permanent_workers' => '', 'fishr_registered' => ''
        ],
        'financial_values' => [
            'total_value' => '', 'actual_appraisal' => '', 'under_tax_declaration' => ''
        ],
        'sss_proofs' => [],
        'stocking_records' => [
            ['species' => '', 'source' => '', 'quantity' => '', 'cost' => ''],
            ['species' => '', 'source' => '', 'quantity' => '', 'cost' => ''],
            ['species' => '', 'source' => '', 'quantity' => '', 'cost' => ''],
        ],
        'harvest_records' => [
            'date_stocking' => '', 'kilos_harvested' => '', 'date_harvest' => '', 'gross_sales' => '',
            'market_domestic' => '', 'market_domestic_kilos' => '', 'market_export' => '', 'market_export_kilos' => ''
        ],
        'pond_types' => [
            'nursery' => false, 'nursery_has' => '',
            'transition' => false, 'transition_has' => '',
            'rearing' => false, 'rearing_has' => '',
            'canal' => false, 'canal_has' => '',
            'others' => false, 'others_has' => ''
        ],
        'cases' => [
            'admin_case' => 'No', 'admin_details' => '',
            'judicial_case' => 'No', 'judicial_details' => ''
        ],
        'remarks' => '',
        'officer_name' => '',
        'designation' => '',
        'signature_data' => '',
        'site_photos' => [],
    ]
]);

$updatedFormDataLesseeId = function ($value) {
    if ($value) {
        $lessee = Lessee::find($value);
        if ($lessee) {
            $this->formData['fla_no'] = $lessee->fla_no ?? '';
            $this->formData['barangay'] = $lessee->barangay ?? '';
            $this->formData['municipality'] = $lessee->municipality ?? '';
            $this->formData['province'] = $lessee->province ?? '';
            $this->formData['date_issued'] = $lessee->date_issued?->format('Y-m-d') ?? '';
            $this->formData['date_expire'] = $lessee->date_expiration?->format('Y-m-d') ?? '';
            $this->formData['no_hec_granted'] = $lessee->hec_granted ?? '';
            $this->formData['no_hec_developed'] = $lessee->hec_developed ?? '';
            $this->formData['no_hect_undeveloped'] = $lessee->hec_undeveloped ?? '';
        }
    }
};

$lessees = computed(fn () => Lessee::orderBy('full_name')->get());

$nextStep = function () {
    if ($this->step < $this->totalSteps) {
        $this->step++;
    }
};

$previousStep = function () {
    if ($this->step > 1) {
        $this->step--;
    }
};

$submit = function () {
    if (empty($this->formData['lessee_id'])) {
        Flux::toast(
            variant: 'warning',
            heading: 'Lessee Required.',
            text: 'Please select a Lessee on Step 1 before submitting the report.',
        );
        return;
    }

    $report = InspectionReport::create([
        'lessee_id' => $this->formData['lessee_id'],
        'fla_no' => $this->formData['fla_no'],
        'barangay' => $this->formData['barangay'],
        'municipality' => $this->formData['municipality'],
        'province' => $this->formData['province'],
        'date_issued' => $this->formData['date_issued'] ?: null,
        'date_expire' => $this->formData['date_expire'] ?: null,
        'no_hec_granted' => $this->formData['no_hec_granted'] ?: null,
        'no_hec_developed' => $this->formData['no_hec_developed'] ?: null,
        'no_hect_undeveloped' => $this->formData['no_hect_undeveloped'] ?: null,
        
        'improvements' => $this->formData['improvements'],
        'financial_values' => $this->formData['financial_values'],
        'stocking_records' => $this->formData['stocking_records'],
        'harvest_records' => $this->formData['harvest_records'],
        'pond_types' => $this->formData['pond_types'],
        
        'with_pending_admin_case' => $this->formData['cases']['admin_case'] === 'Yes',
        'admin_case_details' => $this->formData['cases']['admin_details'],
        'with_pending_judicial_case' => $this->formData['cases']['judicial_case'] === 'Yes',
        'judicial_case_details' => $this->formData['cases']['judicial_details'],
        
        'remarks_recommendation' => $this->formData['remarks'],
        'inspecting_officer' => $this->formData['officer_name'],
        'designation' => $this->formData['designation'],
        'date_inspection' => now(),
    ]);

    // Handle Signature creation
    if (!empty($this->formData['signature_data'])) {
        $base64Image = preg_replace('/^data:image\/\w+;base64,/', '', $this->formData['signature_data']);
        $decodedImage = base64_decode($base64Image);
        $uuid = (string) Str::uuid();
        $filename = "{$uuid}.png";
        
        Storage::disk(config('sign-pad.disk_name', 'local'))
            ->put(config('sign-pad.signatures_path', 'signatures')."/{$filename}", $decodedImage);

        $report->signature()->create([
            'uuid' => $uuid,
            'filename' => $filename,
            'from_ips' => [request()->ip()],
            'certified' => config('sign-pad.certify_documents', false),
        ]);
    }

    // Trigger Success Message with Flux Toast
    Flux::toast(
        variant: 'success',
        heading: 'Report Stored.',
        text: 'Inspection Report stored successfully for the lessee!',
    );

    // CLEAR ALL FIELDS & RESET STATE
    $this->formData = [
        'lessee_id' => '',
        'fla_no' => '', 'barangay' => '', 'municipality' => '', 'province' => '',
        'date_issued' => '', 'date_expire' => '',
        'no_hec_granted' => '', 'no_hec_developed' => '', 'no_hect_undeveloped' => '',
        'improvements' => [
            'clearings_area' => '', 'clearings_date' => '', 'clearings_cost' => '',
            'main_dike_meters' => '', 'main_dike_date' => '', 'main_dike_cost' => '',
            'secondary_dike_meters' => '', 'secondary_dike_date' => '', 'secondary_dike_cost' => '',
            'excavation_cubic' => '', 'excavation_date' => '', 'excavation_cost' => '',
            'gate_concrete' => '', 'gate_concrete_date' => '', 'gate_concrete_cost' => '',
            'gate_wooden' => '', 'gate_wooden_date' => '', 'gate_wooden_cost' => '',
            'house_desc' => '', 'house_date' => '', 'house_cost' => '',
            'equipment_desc' => '', 'equipment_date' => '', 'equipment_cost' => '',
            'permanent_workers' => '', 'non_permanent_workers' => '', 'fishr_registered' => ''
        ],
        'financial_values' => [
            'total_value' => '', 'actual_appraisal' => '', 'under_tax_declaration' => ''
        ],
        'sss_proofs' => [],
        'stocking_records' => [
            ['species' => '', 'source' => '', 'quantity' => '', 'cost' => ''],
            ['species' => '', 'source' => '', 'quantity' => '', 'cost' => ''],
            ['species' => '', 'source' => '', 'quantity' => '', 'cost' => ''],
        ],
        'harvest_records' => [
            'date_stocking' => '', 'kilos_harvested' => '', 'date_harvest' => '', 'gross_sales' => '',
            'market_domestic' => '', 'market_domestic_kilos' => '', 'market_export' => '', 'market_export_kilos' => ''
        ],
        'pond_types' => [
            'nursery' => false, 'nursery_has' => '',
            'transition' => false, 'transition_has' => '',
            'rearing' => false, 'rearing_has' => '',
            'canal' => false, 'canal_has' => '',
            'others' => false, 'others_has' => ''
        ],
        'cases' => [
            'admin_case' => 'No', 'admin_details' => '',
            'judicial_case' => 'No', 'judicial_details' => ''
        ],
        'remarks' => '',
        'officer_name' => '',
        'designation' => '',
        'signature_data' => '',
        'site_photos' => [],
    ];

    // Go back to step 1
    $this->step = 1;
};

?>
<flux:card class="w-full h-full flex flex-col !p-0 overflow-hidden">
    <div class="p-6 border-b border-gray-200 bg-gray-50/50 dark:bg-zinc-800/50">
        <nav aria-label="Progress">
            <ol role="list"
                class="divide-y divide-gray-200 dark:divide-zinc-700 rounded-lg border border-gray-200 dark:border-zinc-700 md:flex md:divide-y-0 bg-white dark:bg-zinc-900">
                @foreach($stepsInfo as $index => $info)
                @php
                $isActive = $step === $index;
                $isCompleted = $step > $index;
                @endphp
                <li class="relative md:flex md:flex-1">
                    <div class="flex items-center w-full p-4 text-sm font-medium">
                        <span class="flex flex-shrink-0 items-center justify-center">
                            @if($isCompleted || $isActive)
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-600 dark:bg-emerald-500 text-white font-semibold shadow-sm">
                                @if($isCompleted)
                                <flux:icon.check class="h-5 w-5 text-white" variant="mini" />
                                @else
                                {{ strtoupper($info['letter']) }}
                                @endif
                            </span>
                            @else
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 dark:border-zinc-600 text-gray-500 dark:text-zinc-400">
                                {{ strtoupper($info['letter']) }}
                            </span>
                            @endif
                        </span>
                        <span class="ml-4 flex min-w-0 flex-col">
                            <span
                                class="text-sm font-medium line-clamp-1 {{ $isActive || $isCompleted ? 'text-emerald-700 dark:text-emerald-300' : 'text-zinc-500 dark:text-zinc-400' }}"
                                title="{{ $info['title'] }}">
                                {{ $info['title'] }}
                            </span>
                        </span>
                    </div>
                    @if(!$loop->last)
                    <div class="absolute top-0 right-0 hidden h-full w-5 md:block" aria-hidden="true">
                        <svg class="h-full w-full text-gray-300 dark:text-zinc-700" viewBox="0 0 22 80" fill="none"
                            preserveAspectRatio="none">
                            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    @endif
                </li>
                @endforeach
            </ol>
        </nav>
    </div>

    <div class="p-8 flex-1 overflow-y-auto">
        @if ($step === 1)
        <x-inspection.part-a :formData="$formData" :lessees="$this->lessees" />
        @elseif ($step === 2)
        <x-inspection.part-b :formData="$formData" />
        @elseif ($step === 3)
        <x-inspection.part-c :formData="$formData" />
        @elseif ($step === 4)
        <x-inspection.part-d :formData="$formData" />
        @elseif ($step === 5)
        <x-inspection.part-e :formData="$formData" />
        @elseif ($step === 6)
        <x-inspection.part-f :formData="$formData" />
        @endif
    </div>

    <div
        class="p-6 bg-gray-50 dark:bg-zinc-800/50 border-t border-gray-200 dark:border-zinc-700 flex justify-between items-center">
        <flux:button variant="primary" :color="$step === 1 ? '' : 'emerald'" wire:click="previousStep"
            :disabled="$step === 1" icon="chevron-left">
            Previous
        </flux:button>
        <flux:text font-weight="medium" inset="none" class="text-gray-500 dark:text-zinc-400">
            Step {{ $step }} of {{ $totalSteps }}
        </flux:text>
        @if ($step === $totalSteps)
        <flux:modal.trigger name="confirm-submit">
            <flux:button variant="primary" color="emerald" icon-trailing="check">
                Submit
            </flux:button>
        </flux:modal.trigger>
        @else
        <flux:button variant="primary" color="emerald" icon-trailing="chevron-right" wire:click="nextStep">
            Next
        </flux:button>
        @endif
    </div>

    <flux:modal name="confirm-submit" class="md:max-w-lg">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Confirm Submission</flux:heading>
                <flux:subheading>Are you sure you want to submit? Please review your entries.</flux:subheading>
            </div>

            <div class="flex space-x-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button variant="primary" color="emerald"
                    x-on:click="Flux.modal('confirm-submit').close(); $wire.submit()">
                    Confirm & Submit
                </flux:button>
            </div>
        </div>
    </flux:modal>
</flux:card>