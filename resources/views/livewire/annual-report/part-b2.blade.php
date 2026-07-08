@props(['formData'])
<div class="space-y-6" wire:key="b2-harvesting-root" x-data="{
    harvestingCustomRows: @entangle('formData.harvesting.custom_rows').live || []
}">
    <h2 class="text-lg font-bold text-zinc-800">B. Production and Marketing Operation (2. HARVESTING)</h2>
    <flux:separator />

    <div class="grid grid-cols-12 gap-3 text-sm text-zinc-600 px-1 my-6 uppercase font-bold">
        <div class="col-span-2 text-left">Species</div>
        <div class="col-span-2">Date Harvested</div>
        <div class="col-span-2">Area (Has)</div>
        <div class="col-span-2">Qty (Kilos)</div>
        <div class="col-span-1">Pcs/Kg</div>
        <div class="col-span-1">Price</div>
        <div class="col-span-2">Total Value</div>
    </div>

    <div class="space-y-2">
        @foreach (['Bangus', 'Sugpo', 'Shrimp'] as $key)
            <div class="grid grid-cols-12 gap-2 items-center" wire:key="b2-static-{{ $key }}">
                <div class="col-span-2 capitalize font-medium text-sm text-zinc-700 pl-1">{{ $key }}</div>
                <div class="col-span-2">
                    <flux:input size="sm" type="date"
                        wire:model="formData.harvesting.{{ $key }}.date" />
                </div>
                <div class="col-span-2">
                    <flux:input size="sm" wire:model="formData.harvesting.{{ $key }}.area" />
                </div>
                <div class="col-span-2">
                    <flux:input size="sm" wire:model="formData.harvesting.{{ $key }}.qty_kilos" />
                </div>
                <div class="col-span-1">
                    <flux:input size="sm" wire:model="formData.harvesting.{{ $key }}.pcs_per_kg" />
                </div>
                <div class="col-span-1">
                    <flux:input size="sm" wire:model="formData.harvesting.{{ $key }}.price_per_kilo" />
                </div>
                <div class="col-span-2">
                    <flux:input size="sm" placeholder="₱ 0.00"
                        wire:model="formData.harvesting.{{ $key }}.total_value" />
                </div>
            </div>
        @endforeach
    </div>

    <div class="space-y-2">
        <template x-for="(row, index) in harvestingCustomRows" :key="'b2-row-' + index + '-' + (row.id || index)">
            <div class="grid grid-cols-12 gap-2 items-center pt-1" wire:key="b2-custom-container">
                <div class="col-span-2">
                    <flux:input size="sm" placeholder="Specify Species" x-model="row.label" />
                </div>
                <div class="col-span-2">
                    <flux:input size="sm" type="date" x-model="row.date" />
                </div>
                <div class="col-span-2">
                    <flux:input size="sm" placeholder="Area" x-model="row.area" />
                </div>
                <div class="col-span-2">
                    <flux:input size="sm" placeholder="Qty" x-model="row.qty_kilos" />
                </div>
                <div class="col-span-1">
                    <flux:input size="sm" placeholder="Pcs" x-model="row.pcs_per_kg" />
                </div>
                <div class="col-span-1">
                    <flux:input size="sm" placeholder="Price" x-model="row.price_per_kilo" />
                </div>
                <div class="col-span-2 flex items-center gap-2">
                    <flux:input size="sm" class="flex-1" placeholder="₱ 0.00" x-model="row.total_value" />
                    <flux:button type="button" variant="danger" size="sm" square
                        @click="harvestingCustomRows.splice(index, 1)" class="flex-shrink-0">
                        <flux:icon.x-mark class="w-4 h-4" />
                    </flux:button>
                </div>
            </div>
        </template>
    </div>

    <div class="pt-2">
        <flux:button size="sm" variant="primary" color="emerald" icon="plus"
            @click="harvestingCustomRows.push({ id: 'b2-' + Date.now(), label: '', date: '', area: '', qty_kilos: '', pcs_per_kg: '', price_per_kilo: '', total_value: '' })">
            Add Other Species
        </flux:button>
    </div>
</div>
