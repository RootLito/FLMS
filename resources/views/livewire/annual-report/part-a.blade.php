@props(['formData'])
<div class="space-y-6">
    <h2 class="text-lg font-bold text-zinc-800">A. Kind and Extent of Improvements</h2>
    <flux:separator />
    
    <div class="grid grid-cols-12 gap-3 text-xs font-bold text-zinc-500 uppercase tracking-wider border-b pb-2">
        <div class="col-span-5">Item Definition</div>
        <div class="col-span-4">Date Introduced</div>
        <div class="col-span-3">Value / Cost (Php)</div>
    </div>

    <div class="grid grid-cols-12 gap-3 items-center">
        <div class="col-span-5"><flux:input size="sm" placeholder="1. Clearings: Area Cleared (has.)" wire:model="formData.improvements.clearings_area" /></div>
        <div class="col-span-4"><flux:input size="sm" type="date" wire:model="formData.improvements.clearings_date" /></div>
        <div class="col-span-3"><flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.clearings_cost" /></div>
    </div>

    <div class="space-y-2">
        <p class="text-xs font-bold text-zinc-700">2. Dikes</p>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-5 pl-4"><flux:input size="sm" placeholder="Main (lineal meters)" wire:model="formData.improvements.dike_main" /></div>
            <div class="col-span-4"><flux:input size="sm" type="date" wire:model="formData.improvements.dike_main_date" /></div>
            <div class="col-span-3"><flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.dike_main_cost" /></div>
        </div>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-5 pl-4"><flux:input size="sm" placeholder="Secondary (lineal meters)" wire:model="formData.improvements.dike_secondary" /></div>
            <div class="col-span-4"><flux:input size="sm" type="date" wire:model="formData.improvements.dike_secondary_date" /></div>
            <div class="col-span-3"><flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.dike_secondary_cost" /></div>
        </div>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-5 pl-4"><flux:input size="sm" placeholder="Excavation (cubic meters)" wire:model="formData.improvements.excavation" /></div>
            <div class="col-span-4"><flux:input size="sm" type="date" wire:model="formData.improvements.excavation_date" /></div>
            <div class="col-span-3"><flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.excavation_cost" /></div>
        </div>
    </div>

    <div class="space-y-2">
        <p class="text-xs font-bold text-zinc-700">3. Gates & Buildings</p>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-5 pl-4"><flux:input size="sm" placeholder="Concrete Gate (qty)" wire:model="formData.improvements.gate_concrete" /></div>
            <div class="col-span-4"><flux:input size="sm" type="date" wire:model="formData.improvements.gate_concrete_date" /></div>
            <div class="col-span-3"><flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.gate_concrete_cost" /></div>
        </div>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-5 pl-4"><flux:input size="sm" placeholder="Wooden Gate (qty)" wire:model="formData.improvements.gate_wooden" /></div>
            <div class="col-span-4"><flux:input size="sm" type="date" wire:model="formData.improvements.gate_wooden_date" /></div>
            <div class="col-span-3"><flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.gate_wooden_cost" /></div>
        </div>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-5 pl-4"><flux:input size="sm" placeholder="House/Building, etc." wire:model="formData.improvements.building_desc" /></div>
            <div class="col-span-4"><flux:input size="sm" type="date" wire:model="formData.improvements.building_date" /></div>
            <div class="col-span-3"><flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.building_cost" /></div>
        </div>
        <div class="grid grid-cols-12 gap-3 items-center">
            <div class="col-span-5 pl-4"><flux:input size="sm" placeholder="Equipment/Tools/Banca, etc." wire:model="formData.improvements.equipment_desc" /></div>
            <div class="col-span-4"><flux:input size="sm" type="date" wire:model="formData.improvements.equipment_date" /></div>
            <div class="col-span-3"><flux:input size="sm" placeholder="₱ 0.00" wire:model="formData.improvements.equipment_cost" /></div>
        </div>
    </div>

    <div class="bg-zinc-50 p-4 rounded-lg space-y-3">
        <p class="text-xs font-bold text-zinc-700">4. Assessed Values</p>
        <div class="grid grid-cols-3 gap-4">
            <flux:input size="sm" label="TOTAL VALUE" placeholder="₱ 0.00" wire:model="formData.financial.total_value" />
            <flux:input size="sm" label="Actual Appraisal" placeholder="₱ 0.00" wire:model="formData.financial.actual_appraisal" />
            <flux:input size="sm" label="Under Tax Declaration" placeholder="₱ 0.00" wire:model="formData.financial.tax_declaration" />
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <flux:input size="sm" label="5. a. Caretaker/s (Count)" wire:model="formData.workers.caretakers" />
        <flux:input size="sm" label="5. b. Laborer/s (Count)" wire:model="formData.workers.laborers" />
    </div>
</div>