@props(['formData'])
<div class="space-y-6" wire:key="b3-marketing-root" x-data="{
    marketingCustomRows: @entangle('formData.marketing.custom_rows').live || []
}">
    <h2 class="text-lg font-bold text-zinc-800">B. Production and Marketing Operation (3. MARKETING)</h2>
    <flux:separator />

    <div class="grid grid-cols-5 gap-2 text-center">
        <div></div>
        <div class="col-span-2 bg-zinc-50 py-4 text-xs font-bold rounded border border-zinc-200 text-zinc-600 uppercase tracking-wide">
            Local Consumption
        </div>
        <div class="col-span-2 bg-zinc-50 py-4 text-xs font-bold rounded border border-zinc-200 text-zinc-600 uppercase tracking-wide">
            Export
        </div>
    </div>

    <div class="grid grid-cols-5 gap-2 text-sm text-zinc-600 px-1 my-6 uppercase font-bold">
        <div class="text-left">Species</div>
        <div class="text-center">Qty (Kilos)</div>
        <div class="text-center">Value (Php)</div>
        <div class="text-center">Qty (Kilos)</div>
        <div class="text-center">Value (Php)</div>
    </div>

    <div class="space-y-2">
        @foreach (['Bangus', 'Sugpo', 'Shrimp'] as $key)
            @php $lowerKey = strtolower($key); @endphp
            <div class="grid grid-cols-5 gap-2 items-center" wire:key="b3-static-{{ $lowerKey }}">
                <div class="capitalize font-medium text-sm text-zinc-700 pl-1">{{ $key }}</div>
                <div>
                    <flux:input size="sm" wire:model="formData.marketing.{{ $lowerKey }}.local_qty" />
                </div>
                <div>
                    <flux:input size="sm" placeholder="₱ 0.00"
                        wire:model="formData.marketing.{{ $lowerKey }}.local_val" />
                </div>
                <div>
                    <flux:input size="sm" wire:model="formData.marketing.{{ $lowerKey }}.export_qty" />
                </div>
                <div>
                    <flux:input size="sm" placeholder="₱ 0.00"
                        wire:model="formData.marketing.{{ $lowerKey }}.export_val" />
                </div>
            </div>
        @endforeach
    </div>

    <div class="space-y-2">
        <template x-for="(row, index) in marketingCustomRows" :key="'b3-row-' + index + '-' + (row.id || index)">
            <div class="grid grid-cols-5 gap-2 items-center pt-1" wire:key="b3-custom-container">
                <div>
                    <flux:input size="sm" placeholder="Specify Species" x-model="row.label" />
                </div>
                <div>
                    <flux:input size="sm" placeholder="Qty" x-model="row.local_qty" />
                </div>
                <div>
                    <flux:input size="sm" placeholder="₱ 0.00" x-model="row.local_val" />
                </div>
                <div>
                    <flux:input size="sm" placeholder="Qty" x-model="row.export_qty" />
                </div>
                <div class="flex items-center gap-2">
                    <flux:input size="sm" class="flex-1" placeholder="₱ 0.00" x-model="row.export_val" />
                    <flux:button type="button" variant="danger" size="sm" square
                        @click="marketingCustomRows.splice(index, 1)" class="flex-shrink-0">
                        <flux:icon.x-mark class="w-4 h-4" />
                    </flux:button>
                </div>
            </div>
        </template>
    </div>

    <div class="pt-2">
        <flux:button size="sm" variant="primary" color="emerald" icon="plus"
            @click="marketingCustomRows.push({ id: 'b3-' + Date.now(), label: '', local_qty: '', local_val: '', export_qty: '', export_val: '' })">
            Add Other Species
        </flux:button>
    </div>
</div>