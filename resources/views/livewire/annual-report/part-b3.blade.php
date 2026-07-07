@props(['formData'])
<div class="space-y-6">
    <h2 class="text-lg font-bold text-zinc-800">B. Production (3. MARKETING)</h2>
    <flux:separator />

    <div class="grid grid-cols-12 gap-2 text-center border-b pb-2">
        <div class="col-span-4"></div>
        <div class="col-span-4 bg-zinc-50 py-1 text-xs font-bold rounded border text-zinc-600 uppercase">Local Consumption</div>
        <div class="col-span-4 bg-zinc-50 py-1 text-xs font-bold rounded border text-zinc-600 uppercase">Export</div>
    </div>
    
    <div class="grid grid-cols-12 gap-2 text-xs font-bold text-zinc-500 uppercase text-center my-1">
        <div class="col-span-4 text-left">Species</div>
        <div class="col-span-2">Qty (Kilos)</div>
        <div class="col-span-2">Value (Php)</div>
        <div class="col-span-2">Qty (Kilos)</div>
        <div class="col-span-2">Value (Php)</div>
    </div>

    @foreach(['bangus', 'sugpo', 'shrimp', 'others'] as $key)
    <div class="grid grid-cols-12 gap-2 items-center">
        <div class="col-span-4 capitalize font-medium text-sm text-zinc-700">{{ $key }}</div>
        <div class="col-span-2"><flux:input size="sm" wire:model="formData.marketing.{{ $key }}.local_qty" /></div>
        <div class="col-span-2"><flux:input size="sm" placeholder="₱" wire:model="formData.marketing.{{ $key }}.local_val" /></div>
        <div class="col-span-2"><flux:input size="sm" wire:model="formData.marketing.{{ $key }}.export_qty" /></div>
        <div class="col-span-2"><flux:input size="sm" placeholder="₱" wire:model="formData.marketing.{{ $key }}.export_val" /></div>
    </div>
    @endforeach
</div>