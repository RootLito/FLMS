<?php

use function Livewire\Volt\{state, computed, usesFileUploads};
use App\Models\AnnualReport;
use App\Models\Lessee;
use Flux\Flux;

usesFileUploads();

state([
    'step' => 1,
    'totalSteps' => 6,
    'stepsInfo' => [
        1 => ['letter' => 'i', 'title' => 'Initial Details'],
        2 => ['letter' => 'a', 'title' => 'Kind & Extent of Improvements'],
        3 => ['letter' => 'b1', 'title' => 'Stocking Records'],
        4 => ['letter' => 'b2', 'title' => 'Harvesting Records'],
        5 => ['letter' => 'b3', 'title' => 'Marketing Records'],
        6 => ['letter' => 'c', 'title' => 'Documentation & Authentication'],
    ],
    'formData' => [
        'lessee_id' => '',
        'report_year_from' => '',
        'report_year_to' => '',
        'fla_no' => '',
        'location' => '',
        'date_issued' => '',
        'expiry_date' => '',
        'area_granted' => '',
        'area_developed' => '',
        'pond_breakdown' => [
            'nursery' => '',
            'transition' => '',
            'rearing' => '',
        ],
        'area_undeveloped' => '',

        'improvements' => [
            'clearings_area' => '',
            'clearings_date' => '',
            'clearings_cost' => '',
            'dike_main' => '',
            'dike_main_date' => '',
            'dike_main_cost' => '',
            'dike_secondary' => '',
            'dike_secondary_date' => '',
            'dike_secondary_cost' => '',
            'excavation' => '',
            'excavation_date' => '',
            'excavation_cost' => '',
            'gate_concrete' => '',
            'gate_concrete_date' => '',
            'gate_concrete_cost' => '',
            'gate_wooden' => '',
            'gate_wooden_date' => '',
            'gate_wooden_cost' => '',
            'building_desc' => '',
            'building_date' => '',
            'building_cost' => '',
            'equipment_desc' => '',
            'equipment_date' => '',
            'equipment_cost' => '',
        ],
        'financial' => [
            'total_value' => '',
            'actual_appraisal' => '',
            'tax_declaration' => '',
        ],
        'workers' => [
            'caretakers' => '',
            'laborers' => '',
        ],

        'stocking' => [
            'bangus' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'fry' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'fingerlings' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'sugpo' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'shrimp' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'custom_rows' => [],
        ],

        'harvesting' => [
            'bangus' => ['date' => '', 'area' => '', 'qty_kilos' => '', 'pcs_per_kg' => '', 'price_per_kilo' => '', 'total_value' => ''],
            'sugpo' => ['date' => '', 'area' => '', 'qty_kilos' => '', 'pcs_per_kg' => '', 'price_per_kilo' => '', 'total_value' => ''],
            'shrimp' => ['date' => '', 'area' => '', 'qty_kilos' => '', 'pcs_per_kg' => '', 'price_per_kilo' => '', 'total_value' => ''],
            'custom_rows' => [],
        ],

        'marketing' => [
            'bangus' => ['local_qty' => '', 'local_val' => '', 'export_qty' => '', 'export_val' => ''],
            'sugpo' => ['local_qty' => '', 'local_val' => '', 'export_qty' => '', 'export_val' => ''],
            'shrimp' => ['local_qty' => '', 'local_val' => '', 'export_qty' => '', 'export_val' => ''],
            'custom_rows' => [],
        ],

        'remarks' => '',
        'site_photos' => [],
        'signature_data' => '',
    ],
]);

$updatedFormDataLesseeId = function ($value) {
    if (empty($value)) {
        $this->formData['fla_no'] = '';
        $this->formData['location'] = '';
        $this->formData['date_issued'] = '';
        $this->formData['expiry_date'] = '';
        $this->formData['area_granted'] = '';
        $this->formData['area_developed'] = '';
        $this->formData['area_undeveloped'] = '';
        return;
    }

    if ($lessee = Lessee::find($value)) {
        $this->formData['fla_no'] = $lessee->fla_no ?? '';
        $this->formData['location'] = implode(', ', array_filter([$lessee->barangay, $lessee->municipality, $lessee->province]));
        $this->formData['date_issued'] = $lessee->date_issued?->format('Y-m-d') ?? '';
        $this->formData['expiry_date'] = $lessee->date_expiration?->format('Y-m-d') ?? '';
        $this->formData['area_granted'] = $lessee->hec_granted ?? '';
        $this->formData['area_developed'] = $lessee->hec_developed ?? '';
        $this->formData['area_undeveloped'] = $lessee->hec_undeveloped ?? '';
    }
};

$lessees = computed(fn() => Lessee::orderBy('full_name')->get());

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

$removePhoto = function ($index) {
    if (isset($this->formData['site_photos'][$index])) {
        array_splice($this->formData['site_photos'], $index, 1);
    }
};

$submit = function () {
    if (empty($this->formData['lessee_id'])) {
        Flux::toast(variant: 'warning', heading: 'Error', text: 'Please select a Lessee.');
        return;
    }

    if (empty($this->formData['signature_data'])) {
        Flux::toast(variant: 'warning', heading: 'Error', text: 'Lessee signature verification is required.');
        return;
    }

    Flux::modal('confirm-save-modal')->show();
};

$confirmSubmit = function () {
    $savedPhotoPaths = [];
    if (!empty($this->formData['site_photos'])) {
        foreach ($this->formData['site_photos'] as $photoFile) {
            if (method_exists($photoFile, 'store')) {
                $savedPhotoPaths[] = $photoFile->store('site_photos', 'public');
            }
        }
    }

    $locationParts = explode(', ', $this->formData['location']);
    $barangay = $locationParts[0] ?? null;
    $municipality = $locationParts[1] ?? null;
    $province = $locationParts[2] ?? null;

    $itemsData = [
        'pond_breakdown' => $this->formData['pond_breakdown'],
        'improvements' => $this->formData['improvements'],
        'financial' => $this->formData['financial'],
        'workers' => $this->formData['workers'],
    ];

    AnnualReport::create([
        'lessee_id' => $this->formData['lessee_id'],
        'from' => $this->formData['report_year_from'] ?: null,
        'to' => $this->formData['report_year_to'] ?: null,
        'fla_no' => $this->formData['fla_no'],
        'barangay' => $barangay,
        'municipality' => $municipality,
        'province' => $province,
        'date_issued' => $this->formData['date_issued'] ?: null,
        'date_expire' => $this->formData['expiry_date'] ?: null,
        'no_hec_granted' => $this->formData['area_granted'] ?: null,
        'no_hec_developed' => $this->formData['area_developed'] ?: null,
        'no_hect_undeveloped' => $this->formData['area_undeveloped'] ?: null,
        'items' => $itemsData,
        'stocking' => $this->formData['stocking'],
        'harvesting' => $this->formData['harvesting'],
        'marketing' => $this->formData['marketing'],
        'remarks' => $this->formData['remarks'],
        'site_photos' => $savedPhotoPaths,
        'signature_data' => $this->formData['signature_data'],
    ]);

    $this->reset('step');
    $this->formData = [
        'lessee_id' => '',
        'report_year_from' => '',
        'report_year_to' => '',
        'fla_no' => '',
        'location' => '',
        'date_issued' => '',
        'expiry_date' => '',
        'area_granted' => '',
        'area_developed' => '',
        'area_undeveloped' => '',
        'pond_breakdown' => ['nursery' => '', 'transition' => '', 'rearing' => ''],
        'improvements' => [
            'clearings_area' => '',
            'clearings_date' => '',
            'clearings_cost' => '',
            'dike_main' => '',
            'dike_main_date' => '',
            'dike_main_cost' => '',
            'dike_secondary' => '',
            'dike_secondary_date' => '',
            'dike_secondary_cost' => '',
            'excavation' => '',
            'excavation_date' => '',
            'excavation_cost' => '',
            'gate_concrete' => '',
            'gate_concrete_date' => '',
            'gate_concrete_cost' => '',
            'gate_wooden' => '',
            'gate_wooden_date' => '',
            'gate_wooden_cost' => '',
            'building_desc' => '',
            'building_date' => '',
            'building_cost' => '',
            'equipment_desc' => '',
            'equipment_date' => '',
            'equipment_cost' => '',
        ],
        'financial' => ['total_value' => '', 'actual_appraisal' => '', 'tax_declaration' => ''],
        'workers' => ['caretakers' => '', 'laborers' => ''],
        'stocking' => [
            'bangus' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'fry' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'fingerlings' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'sugpo' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'shrimp' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'custom_rows' => [],
        ],
        'harvesting' => [
            'bangus' => ['date' => '', 'area' => '', 'qty_kilos' => '', 'pcs_per_kg' => '', 'price_per_kilo' => '', 'total_value' => ''],
            'sugpo' => ['date' => '', 'area' => '', 'qty_kilos' => '', 'pcs_per_kg' => '', 'price_per_kilo' => '', 'total_value' => ''],
            'shrimp' => ['date' => '', 'area' => '', 'qty_kilos' => '', 'pcs_per_kg' => '', 'price_per_kilo' => '', 'total_value' => ''],
            'custom_rows' => [],
        ],
        'marketing' => [
            'bangus' => ['local_qty' => '', 'local_val' => '', 'export_qty' => '', 'export_val' => ''],
            'sugpo' => ['local_qty' => '', 'local_val' => '', 'export_qty' => '', 'export_val' => ''],
            'shrimp' => ['local_qty' => '', 'local_val' => '', 'export_qty' => '', 'export_val' => ''],
            'custom_rows' => [],
        ],
        'remarks' => '',
        'site_photos' => [],
        'signature_data' => '',
    ];

    Flux::toast(variant: 'success', heading: 'Submitted', text: 'Annual Report saved successfully!');
    $this->step = 1;
};
?>

<flux:card class="w-full h-full flex flex-col !p-0 overflow-hidden">
    <div class="p-6 border-b border-gray-200 bg-gray-50/50 dark:bg-zinc-800/50">
        <nav aria-label="Progress">
            <ol role="list"
                class="divide-y divide-gray-200 dark:divide-zinc-700 rounded-lg border border-gray-200 dark:border-zinc-700 md:flex md:divide-y-0 bg-white dark:bg-zinc-900">
                @foreach ($stepsInfo as $index => $info)
                    @php
                        $isActive = $step === $index;
                        $isCompleted = $step > $index;
                    @endphp
                    <li class="relative md:flex md:flex-1">
                        <div class="flex items-center w-full p-4 text-sm font-medium">
                            <span class="flex flex-shrink-0 items-center justify-center">
                                @if ($isCompleted || $isActive)
                                    <span
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-600 dark:bg-emerald-500 text-white font-semibold shadow-sm">
                                        @if ($isCompleted)
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
                        @if (!$loop->last)
                            <div class="absolute top-0 right-0 hidden h-full w-5 md:block" aria-hidden="true">
                                <svg class="h-full w-full text-gray-300 dark:text-zinc-700" viewBox="0 0 22 80"
                                    fill="none" preserveAspectRatio="none">
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
            <div wire:key="step-1-container">
                <x-annual-report.initial :formData="$formData" :lessees="$this->lessees" />
            </div>
        @elseif ($step === 2)
            <div wire:key="step-2-container">
                <x-annual-report.part-a :formData="$formData" />
            </div>
        @elseif ($step === 3)
            <div wire:key="step-3-container">
                <x-annual-report.part-b1 :formData="$formData" />
            </div>
        @elseif ($step === 4)
            <div wire:key="step-4-container">
                <x-annual-report.part-b2 :formData="$formData" />
            </div>
        @elseif ($step === 5)
            <div wire:key="step-5-container">
                <x-annual-report.part-b3 :formData="$formData" />
            </div>
        @elseif ($step === 6)
            <div wire:key="step-6-container">
                <x-annual-report.part-c :formData="$formData" :lessees="$this->lessees" />
            </div>
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
            <flux:button variant="primary" color="emerald" icon-trailing="check" wire:click="submit">
                Submit
            </flux:button>
        @else
            <flux:button variant="primary" color="emerald" icon-trailing="chevron-right" wire:click="nextStep">
                Next
            </flux:button>
        @endif
    </div>

    <flux:modal name="confirm-save-modal" class="md:max-w-lg">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Submit Annual Report?</flux:heading>
                <flux:subheading>Please make sure all data collected across sections is accurate before finalizing.
                </flux:subheading>
            </div>

            <div class="flex space-x-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button variant="primary" color="emerald"
                    x-on:click="Flux.modal('confirm-save-modal').close(); $wire.confirmSubmit()">
                    Confirm & Save
                </flux:button>
            </div>
        </div>
    </flux:modal>
</flux:card>
