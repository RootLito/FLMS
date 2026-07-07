@props(['formData'])
<div class="space-y-6">
    <h2 class="text-lg font-bold text-zinc-800">B. Production and Marketing Operation (1. STOCKING)</h2>
    <flux:separator />

    <div class="grid grid-cols-12 gap-2 text-xs font-bold text-zinc-600 uppercase mb-2 border-b pb-1 text-center">
        <div class="col-span-2 text-left">Species</div>
        <div class="col-span-2">Date Stocked</div>
        <div class="col-span-3">Source/Place</div>
        <div class="col-span-1">Area (Has)</div>
        <div class="col-span-2">Quantity (No.)</div>
        <div class="col-span-2">Cost (Php)</div>
    </div>

    @foreach(['bangus', 'fry', 'fingerlings', 'sugpo', 'shrimp'] as $key)
    <div class="grid grid-cols-12 gap-2 items-center">
        <div class="col-span-2 capitalize font-medium text-sm text-zinc-700">{{ $key }}</div>
        <div class="col-span-2"><flux:input size="sm" type="date" wire:model="formData.stocking.{{ $key }}.date" /></div>
        <div class="col-span-3"><flux:input size="sm" wire:model="formData.stocking.{{ $key }}.source" /></div>
        <div class="col-span-1"><flux:input size="sm" wire:model="formData.stocking.{{ $key }}.area" /></div>
        <div class="col-span-2"><flux:input size="sm" wire:model="formData.stocking.{{ $key }}.quantity" /></div>
        <div class="col-span-2"><flux:input size="sm" placeholder="₱" wire:model="formData.stocking.{{ $key }}.cost" /></div>
    </div>
    @endforeach

    <div class="grid grid-cols-12 gap-2 items-center pt-2 border-t border-dashed">
        <div class="col-span-2"><flux:input size="sm" placeholder="Others (Specify)" wire:model="formData.stocking.others.label" /></div>
        <div class="col-span-2"><flux:input size="sm" type="date" wire:model="formData.stocking.others.date" /></div>
        <div class="col-span-3"><flux:input size="sm" wire:model="formData.stocking.others.source" /></div>
        <div class="col-span-1"><flux:input size="sm" wire:model="formData.stocking.others.area" /></div>
        <div class="col-span-2"><flux:input size="sm" wire:model="formData.stocking.others.quantity" /></div>
        <div class="col-span-2"><flux:input size="sm" placeholder="₱" wire:model="formData.stocking.others.cost" /></div>
    </div>
</div>