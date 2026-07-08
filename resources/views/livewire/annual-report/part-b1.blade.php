@props(['formData'])
<div class="space-y-6" wire:key="b1-stocking-root" x-data="{
    stockingCustomRows: @entangle('formData.stocking.custom_rows').live || []
}">
    <h2 class="text-lg font-bold text-zinc-800">B. Production and Marketing Operation (1. STOCKING)</h2>
    <flux:separator />

    <div class="grid grid-cols-12 gap-3 text-sm text-zinc-600 px-1 my-6 uppercase font-bold">
        <div class="col-span-3">Species</div>
        <div class="col-span-2">Date Stocked</div>
        <div class="col-span-3">Source/Place</div>
        <div class="col-span-1">Area (Has)</div>
        <div class="col-span-1">Quantity (No.)</div>
        <div class="col-span-2">Value / Cost (Php)</div>
    </div>

    <div class="space-y-2">
        @foreach (['Bangus', 'Fry', 'Fingerlings', 'Sugpo', 'Shrimp'] as $key)
            <div class="grid grid-cols-12 gap-3 items-center" wire:key="b1-static-{{ $key }}">
                <div class="col-span-3 capitalize font-medium text-sm text-zinc-700 pl-1">{{ $key }}</div>
                <div class="col-span-2">
                    <flux:input size="sm" type="date" wire:model="formData.stocking.{{ $key }}.date" />
                </div>
                <div class="col-span-3">
                    <flux:input size="sm" wire:model="formData.stocking.{{ $key }}.source" />
                </div>
                <div class="col-span-1">
                    <flux:input size="sm" wire:model="formData.stocking.{{ $key }}.area" />
                </div>
                <div class="col-span-1">
                    <flux:input size="sm" wire:model="formData.stocking.{{ $key }}.quantity" />
                </div>
                <div class="col-span-2">
                    <flux:input size="sm" placeholder="₱ 0.00"
                        wire:model="formData.stocking.{{ $key }}.cost" />
                </div>
            </div>
        @endforeach
    </div>

    <div class="space-y-2">
        <template x-for="(row, index) in stockingCustomRows" :key="'b1-row-' + index + '-' + (row.id || index)">
            <div class="grid grid-cols-12 gap-3 items-center pt-1" wire:key="b1-custom-container">
                <div class="col-span-3">
                    <flux:input size="sm" placeholder="Specify Species" x-model="row.label" />
                </div>
                <div class="col-span-2">
                    <flux:input size="sm" type="date" x-model="row.date" />
                </div>
                <div class="col-span-3">
                    <flux:input size="sm" placeholder="Source" x-model="row.source" />
                </div>
                <div class="col-span-1">
                    <flux:input size="sm" placeholder="Area" x-model="row.area" />
                </div>
                <div class="col-span-1">
                    <flux:input size="sm" placeholder="Quantity" x-model="row.quantity" />
                </div>
                <div class="col-span-2 flex items-center gap-2">
                    <flux:input size="sm" class="flex-1" placeholder="₱ 0.00" x-model="row.cost" />
                    <flux:button type="button" variant="danger" size="sm" square
                        @click="stockingCustomRows.splice(index, 1)" class="flex-shrink-0">
                        <flux:icon.x-mark class="w-4 h-4" />
                    </flux:button>
                </div>
            </div>
        </template>
    </div>

    <div class="pt-2">
        <flux:button size="sm" variant="primary" color="emerald" icon="plus"
            @click="stockingCustomRows.push({ id: 'b1-' + Date.now(), label: '', date: '', source: '', area: '', quantity: '', cost: '' })">
            Add Other Species
        </flux:button>
    </div>
</div>
