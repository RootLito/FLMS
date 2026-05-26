<?php

use function Livewire\Volt\{usesFileUploads};

usesFileUploads();

?>

<div class="">
    <h2 class="text-lg font-semibold text-zinc-800"> A. Kind and Extent of Improvements</h2>
    <flux:separator class="my-6" />
    <div class="grid grid-cols-12 gap-3 text-sm text-zinc-600 px-1 my-6 uppercase font-bold">
        <div class="col-span-6">Kind and Extent of Improvements</div>
        <div class="col-span-3">Date Introduced</div>
        <div class="col-span-3">Value/Cost (Php)</div>
    </div>

    <p class="text-sm font-medium text-zinc-700 mb-2">1. Clearings</p>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6 space-y-2">
            <flux:input placeholder="Area Cleared (has.)" size="sm" wire:model="formData.improvements.clearings_area" />
            <flux:input placeholder="Main dike (lineal meters)" size="sm"
                wire:model="formData.improvements.main_dike_meters" />
            <flux:input placeholder="Secondary dike (lineal meters)" size="sm"
                wire:model="formData.improvements.secondary_dike_meters" />
        </div>
        <div class="col-span-3 space-y-2">
            <flux:input type="date" size="sm" wire:model="formData.improvements.clearings_date" />
            <flux:input type="date" size="sm" wire:model="formData.improvements.main_dike_date" />
            <flux:input type="date" size="sm" wire:model="formData.improvements.secondary_dike_date" />
        </div>
        <div class="col-span-3 space-y-2">
            <flux:input placeholder="₱ 0.00" size="sm" wire:model="formData.improvements.clearings_cost" />
            <flux:input placeholder="₱ 0.00" size="sm" wire:model="formData.improvements.main_dike_cost" />
            <flux:input placeholder="₱ 0.00" size="sm" wire:model="formData.improvements.secondary_dike_cost" />
        </div>
    </div>

    <p class="text-sm font-medium text-zinc-700 mb-2">2. Excavation</p>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6">
            <flux:input placeholder="(cubic meters)" size="sm" wire:model="formData.improvements.excavation_cubic" />
        </div>
        <div class="col-span-3">
            <flux:input type="date" size="sm" wire:model="formData.improvements.excavation_date" />
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" wire:model="formData.improvements.excavation_cost" />
        </div>
    </div>

    <p class="text-sm font-medium text-zinc-700 mb-2">3. Gates</p>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6 space-y-2">
            <flux:input placeholder="Concrete (number)" size="sm" wire:model="formData.improvements.gate_concrete" />
            <flux:input placeholder="Wooden (number)" size="sm" wire:model="formData.improvements.gate_wooden" />
        </div>
        <div class="col-span-3 space-y-2">
            <flux:input type="date" size="sm" wire:model="formData.improvements.gate_concrete_date" />
            <flux:input type="date" size="sm" wire:model="formData.improvements.gate_wooden_date" />
        </div>
        <div class="col-span-3 space-y-2">
            <flux:input placeholder="₱ 0.00" size="sm" wire:model="formData.improvements.gate_concrete_cost" />
            <flux:input placeholder="₱ 0.00" size="sm" wire:model="formData.improvements.gate_wooden_cost" />
        </div>
    </div>

    <p class="text-sm font-medium text-zinc-700 mb-2">4. House, etc.</p>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6">
            <flux:input size="sm" placeholder="Description" wire:model="formData.improvements.house_desc" />
        </div>
        <div class="col-span-3">
            <flux:input type="date" size="sm" wire:model="formData.improvements.house_date" />
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" wire:model="formData.improvements.house_cost" />
        </div>
    </div>

    <p class="text-sm font-medium text-zinc-700 mb-2">5. Equipment, etc.</p>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6">
            <flux:input size="sm" placeholder="Description" wire:model="formData.improvements.equipment_desc" />
        </div>
        <div class="col-span-3">
            <flux:input type="date" size="sm" wire:model="formData.improvements.equipment_date" />
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" wire:model="formData.improvements.equipment_cost" />
        </div>
    </div>

    <div class="grid grid-cols-12 gap-3 items-start mb-2">
        <p class="text-sm font-medium text-zinc-700 mb-2 col-span-6">6. Assessed Value</p>
        <div class="col-span-3">
            <p class="text-sm text-zinc-700 font-black text-end">TOTAL VALUE</p>
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" wire:model="formData.financial_values.total_value" />
        </div>
    </div>

    <div class="grid grid-cols-12 gap-3 items-start mb-2">
        <div class="col-span-6"></div>
        <div class="col-span-3">
            <p class="text-sm text-zinc-700 text-end">Actual Appraisal</p>
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" wire:model="formData.financial_values.actual_appraisal" />
        </div>
    </div>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6"></div>
        <div class="col-span-3">
            <p class="text-sm text-zinc-700 text-end">Under Tax Declaration</p>
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" wire:model="formData.financial_values.under_tax_declaration" />
        </div>
    </div>

    <div class="grid grid-cols-12 gap-3 items-center mb-3">
        <div class="col-span-6">
            <p class="text-sm font-medium text-zinc-700">7. Permanent Personnel/Workers Employed</p>
        </div>
        <div class="col-span-6">
            <flux:input size="sm" placeholder="(number)" wire:model="formData.improvements.permanent_workers" />
        </div>
    </div>

    <div x-data="{ showSlider: false, currentIndex: 0 }" class="mb-6">
        <div class="grid grid-cols-12 gap-3 items-start">
            <div class="col-span-6">
                <p class="text-xs font-semibold text-red-500 mb-1 uppercase tracking-wider">
                    Attach Proof of SSS Contribution/Remittances (Required)
                </p>
                <flux:input type="file" size="sm" multiple accept="image/*" wire:model="formData.sss_proofs" />
                <div wire:loading wire:target="formData.sss_proofs" class="text-xs text-zinc-500 mt-1">
                    Uploading previews...
                </div>
            </div>

            <div class="col-span-6">
                <p class="text-xs font-semibold text-zinc-500 mb-1 uppercase tracking-wider">Preview</p>
                <div class="flex flex-wrap gap-3">
                    @if(!empty($formData['sss_proofs']))
                    @foreach($formData['sss_proofs'] as $index => $file)
                    @php
                    try {
                    $url = $file->temporaryUrl();
                    } catch (\Exception $e) {
                    $url = null;
                    }
                    @endphp

                    @if($url)
                    <div class="relative group h-10 w-10">
                        <img src="{{ $url }}"
                            class="h-full w-full object-cover rounded border border-zinc-300 cursor-pointer hover:ring-2 hover:ring-zinc-400 transition-all"
                            @click="showSlider = true; currentIndex = {{ $index }}" />

                        <button type="button" x-on:click="$wire.formData.sss_proofs.splice({{ $index }}, 1)"
                            class="absolute -top-1.5 -right-1.5 bg-red-500 hover:bg-red-600 text-white rounded-full w-4 h-4 flex items-center justify-center shadow-md transition-colors focus:outline-none z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                stroke="currentColor" class="w-2.5 h-2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    @endif
                    @endforeach
                    @else
                    <span class="text-xs text-zinc-400 italic">No files selected</span>
                    @endif
                </div>
            </div>
        </div>

        <div x-show="showSlider" x-transition.opacity x-cloak @keydown.window.escape="showSlider = false"
            class="fixed inset-0 z-[9999] bg-black/90 flex items-center justify-center p-4">

            <button @click="showSlider = false" class="absolute top-6 right-6 text-white hover:text-zinc-300 z-[10000]">
                <flux:icon.x-mark class="w-10 h-10" />
            </button>

            <button
                @click="currentIndex = (currentIndex > 0) ? currentIndex - 1 : {{ count($formData['sss_proofs'] ?? []) }} - 1"
                class="absolute left-6 text-white p-3 hover:bg-white/10 rounded-full transition-colors">
                <flux:icon.chevron-left class="w-8 h-8" />
            </button>

            <div class="max-w-5xl max-h-[85vh] flex flex-col items-center">
                @if(!empty($formData['sss_proofs']))
                @foreach($formData['sss_proofs'] as $index => $file)
                <?php
                    try {
                        $url = $file->temporaryUrl();
                    } catch (\Exception $e) {
                        $url = null;
                    }
                ?>

                @if($url)
                <img x-show="currentIndex === {{ $index }}" src="{{ $url }}"
                    class="max-w-full max-h-full object-contain shadow-2xl rounded">
                @endif
                @endforeach
                @endif
                <p class="text-white mt-6 bg-zinc-800 px-3 py-1 rounded-full text-xs font-mono">
                    IMAGE <span x-text="currentIndex + 1"></span> / <span>{{ count($formData['sss_proofs'] ?? [])
                        }}</span>
                </p>
            </div>

            <button
                @click="currentIndex = (currentIndex < {{ count($formData['sss_proofs'] ?? []) }} - 1) ? currentIndex + 1 : 0"
                class="absolute right-6 text-white p-3 hover:bg-white/10 rounded-full transition-colors">
                <flux:icon.chevron-right class="w-8 h-8" />
            </button>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-3 items-center mb-2">
        <div class="col-span-6">
            <p class="text-sm font-medium text-zinc-700">8. No. of Non-Permanent Personnel/Workers Employed:</p>
        </div>
        <div class="col-span-6">
            <flux:input size="sm" placeholder="(number)" wire:model="formData.improvements.non_permanent_workers" />
        </div>
    </div>

    <div class="grid grid-cols-12 gap-3 items-center">
        <div class="col-span-6">
            <p class="text-sm font-medium text-zinc-700">9. No. of Personnel/Workers Registered in (FishR): </p>
        </div>
        <div class="col-span-6">
            <flux:input size="sm" placeholder="(number)" wire:model="formData.improvements.fishr_registered" />
        </div>
    </div>
</div>