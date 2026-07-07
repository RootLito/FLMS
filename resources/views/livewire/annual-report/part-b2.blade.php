@props(['formData'])
<div class="space-y-6">
    <h2 class="text-lg font-bold text-zinc-800">B. Production (2. HARVESTING)</h2>
    <flux:separator />

    <div class="grid grid-cols-12 gap-2 text-xs font-bold text-zinc-600 uppercase mb-2 border-b pb-1 text-center">
        <div class="col-span-2 text-left">Species</div>
        <div class="col-span-2">Date Harvested</div>
        <div class="col-span-2">Area (Has)</div>
        <div class="col-span-2">Qty (Kilos)</div>
        <div class="col-span-1">Pcs/Kg</div>
        <div class="col-span-1">Price</div>
        <div class="col-span-2">Total Value</div>
    </div>

    @foreach(['bangus', 'sugpo', 'shrimp'] as $key)
    <div class="grid grid-cols-12 gap-2 items-center">
        <div class="col-span-2 capitalize font-medium text-sm text-zinc-700">{{ $key }}</div>
        <div class="col-span-2"><flux:input size="sm" type="date" wire:model="formData.harvesting.{{ $key }}.date" /></div>
        <div class="col-span-2"><flux:input size="sm" wire:model="formData.harvesting.{{ $key }}.area" /></div>
        <div class="col-span-2"><flux:input size="sm" wire:model="formData.harvesting.{{ $key }}.qty_kilos" /></div>
        <div class="col-span-1"><flux:input size="sm" wire:model="formData.harvesting.{{ $key }}.pcs_per_kg" /></div>
        <div class="col-span-1"><flux:input size="sm" wire:model="formData.harvesting.{{ $key }}.price_per_kilo" /></div>
        <div class="col-span-2"><flux:input size="sm" placeholder="₱" wire:model="formData.harvesting.{{ $key }}.total_value" /></div>
    </div>
    @endforeach

    <div class="grid grid-cols-12 gap-2 items-center pt-2 border-t border-dashed">
        <div class="col-span-2"><flux:input size="sm" placeholder="Others (Specify)" wire:model="formData.harvesting.others.label" /></div>
        <div class="col-span-2"><flux:input size="sm" type="date" wire:model="formData.harvesting.others.date" /></div>
        <div class="col-span-2"><flux:input size="sm" wire:model="formData.harvesting.others.area" /></div>
        <div class="col-span-2"><flux:input size="sm" wire:model="formData.harvesting.others.qty_kilos" /></div>
        <div class="col-span-1"><flux:input size="sm" wire:model="formData.harvesting.others.pcs_per_kg" /></div>
        <div class="col-span-1"><flux:input size="sm" wire:model="formData.harvesting.others.price_per_kilo" /></div>
        <div class="col-span-2"><flux:input size="sm" placeholder="₱" wire:model="formData.harvesting.others.total_value" /></div>
    </div>
</div>