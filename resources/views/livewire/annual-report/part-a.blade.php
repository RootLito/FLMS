@props(['formData'])
<div class="space-y-6">
    <h2 class="text-lg font-bold text-zinc-800">A. Kind and Extent of Improvements</h2>
    <flux:separator />

    <div class="grid grid-cols-12 gap-3 text-sm text-zinc-600 px-1 my-6 uppercase font-bold">
        <div class="col-span-6">Kind and Extent of Improvements</div>
        <div class="col-span-3">Date Introduced</div>
        <div class="col-span-3">Value / Cost (Php)</div>
    </div>

    <div class="space-y-2">
        <p class="text-sm font-medium text-zinc-700 mb-2">1. Clearings</p>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-6">
                <flux:input size="sm" placeholder="Clearings: Area Cleared (has.)"
                    wire:model="formData.improvements.clearings_area" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" type="date" wire:model="formData.improvements.clearings_date" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.clearings_cost" />
            </div>
        </div>
    </div>

    <div class="space-y-2">
        <p class="text-sm font-medium text-zinc-700 mb-2">2. Dikes</p>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-6 pl-4">
                <flux:input size="sm" placeholder="Main (lineal meters)"
                    wire:model="formData.improvements.dike_main" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" type="date" wire:model="formData.improvements.dike_main_date" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.dike_main_cost" />
            </div>
        </div>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-6 pl-4">
                <flux:input size="sm" placeholder="Secondary (lineal meters)"
                    wire:model="formData.improvements.dike_secondary" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" type="date" wire:model="formData.improvements.dike_secondary_date" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" placeholder="₱ 0.00"
                    wire:model="formData.improvements.dike_secondary_cost" />
            </div>
        </div>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-6 pl-4">
                <flux:input size="sm" placeholder="Excavation (cubic meters)"
                    wire:model="formData.improvements.excavation" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" type="date" wire:model="formData.improvements.excavation_date" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.excavation_cost" />
            </div>
        </div>
    </div>

    <div class="space-y-2">
        <p class="text-sm font-medium text-zinc-700 mb-2">3. Gates & Buildings</p>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-6 pl-4">
                <flux:input size="sm" placeholder="Concrete Gate (qty)"
                    wire:model="formData.improvements.gate_concrete" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" type="date" wire:model="formData.improvements.gate_concrete_date" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.gate_concrete_cost" />
            </div>
        </div>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-6 pl-4">
                <flux:input size="sm" placeholder="Wooden Gate (qty)"
                    wire:model="formData.improvements.gate_wooden" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" type="date" wire:model="formData.improvements.gate_wooden_date" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.gate_wooden_cost" />
            </div>
        </div>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-6 pl-4">
                <flux:input size="sm" placeholder="House/Building, etc."
                    wire:model="formData.improvements.building_desc" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" type="date" wire:model="formData.improvements.building_date" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.building_cost" />
            </div>
        </div>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-6 pl-4">
                <flux:input size="sm" placeholder="Equipment/Tools/Banca, etc."
                    wire:model="formData.improvements.equipment_desc" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" type="date" wire:model="formData.improvements.equipment_date" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.equipment_cost" />
            </div>
        </div>
    </div>

    <div class="space-y-2">
        <p class="text-sm font-medium text-zinc-700 mb-2">4. Assessed Values</p>
        <div class="grid grid-cols-12 gap-3 items-end">
            <div class="col-span-6">
                <flux:input size="sm" label="TOTAL VALUE" placeholder="₱ 0.00"
                    wire:model="formData.financial.total_value" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" label="Actual Appraisal" placeholder="₱ 0.00"
                    wire:model="formData.financial.actual_appraisal" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" label="Under Tax Declaration" placeholder="₱ 0.00"
                    wire:model="formData.financial.tax_declaration" />
            </div>
        </div>
    </div>

    <div class="space-y-2">
        <p class="text-sm font-medium text-zinc-700 mb-2">5. Personnel Counts</p>
        <div class="grid grid-cols-12 gap-3">
            <div class="col-span-6">
                <flux:input size="sm" label="a. Caretaker/s (Count)" wire:model="formData.workers.caretakers" />
            </div>
            <div class="col-span-3">
                <flux:input size="sm" label="b. Laborer/s (Count)" wire:model="formData.workers.laborers" />
            </div>
            <div class="col-span-3"></div>
        </div>
    </div>
</div>
