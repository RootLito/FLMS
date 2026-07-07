<?php

use function Livewire\Volt\{state, computed, usesFileUploads};
use App\Models\AnnualReport;
use App\Models\Lessee;
use Flux\Flux;

usesFileUploads();

state([
    'step' => 1,
    'totalSteps' => 5,
    'stepsInfo' => [
        1 => ['letter' => 'i', 'title' => 'Initial Details'],
        2 => ['letter' => 'a', 'title' => 'Kind & Extent of Improvements'],
        3 => ['letter' => 'b1', 'title' => 'Stocking Records'],
        4 => ['letter' => 'b2', 'title' => 'Harvesting Records'],
        5 => ['letter' => 'b3', 'title' => 'Marketing Records'],
    ],
    'formData' => [
        // Step 1: Initial Header Info
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

        // Step 2: Part A - Kind & Extent of Improvements
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

        // Step 3: Part B1 - Stocking Operations
        'stocking' => [
            'bangus' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'fry' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'fingerlings' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'sugpo' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'shrimp' => ['date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
            'others' => ['label' => '', 'date' => '', 'source' => '', 'area' => '', 'quantity' => '', 'cost' => ''],
        ],

        // Step 4: Part B2 - Harvesting Operations
        'harvesting' => [
            'bangus' => ['date' => '', 'area' => '', 'qty_kilos' => '', 'pcs_per_kg' => '', 'price_per_kilo' => '', 'total_value' => ''],
            'sugpo' => ['date' => '', 'area' => '', 'qty_kilos' => '', 'pcs_per_kg' => '', 'price_per_kilo' => '', 'total_value' => ''],
            'shrimp' => ['date' => '', 'area' => '', 'qty_kilos' => '', 'pcs_per_kg' => '', 'price_per_kilo' => '', 'total_value' => ''],
            'others' => ['label' => '', 'date' => '', 'area' => '', 'qty_kilos' => '', 'pcs_per_kg' => '', 'price_per_kilo' => '', 'total_value' => ''],
        ],

        // Step 5: Part B3 - Marketing Operations
        'marketing' => [
            'bangus' => ['local_qty' => '', 'local_val' => '', 'export_qty' => '', 'export_val' => ''],
            'sugpo' => ['local_qty' => '', 'local_val' => '', 'export_qty' => '', 'export_val' => ''],
            'shrimp' => ['local_qty' => '', 'local_val' => '', 'export_qty' => '', 'export_val' => ''],
            'others' => ['local_qty' => '', 'local_val' => '', 'export_qty' => '', 'export_val' => ''],
        ],
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

$submit = function () {
    if (empty($this->formData['lessee_id'])) {
        Flux::toast(variant: 'warning', heading: 'Error', text: 'Please select a Lessee.');
        return;
    }
    // AnnualReport::create($this->formData);
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
            <x-annual-report.initial :formData="$formData" :lessees="$this->lessees" />
        @elseif ($step === 2)
            <x-annual-report.part-a :formData="$formData" />
        @elseif ($step === 3)
            <x-annual-report.part-b1 :formData="$formData" />
        @elseif ($step === 4)
            <x-annual-report.part-b2 :formData="$formData" />
        @elseif ($step === 5)
            <x-annual-report.part-b3 :formData="$formData" />
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
</flux:card>
