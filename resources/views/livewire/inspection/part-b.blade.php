<?php

use Livewire\Volt\Component;

new class extends Component {
    
}; ?>

<div class="">
    <h2 class="text-lg font-semibold text-zinc-800"> B. Operation and Production</h2>
    <flux:separator class="my-6" />

    <div class="grid grid-cols-12 gap-3 text-sm  text-zinc-600 px-1 my-6 uppercase font-bold">
        <div class="col-span-3">Species Stocked</div>
        <div class="col-span-3">Source</div>
        <div class="col-span-3">Quantity</div>
        <div class="col-span-3">Value/Cost (Php)</div>
    </div>

    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-3 space-y-2">
            <flux:input size="sm" />
            <flux:input size="sm" />
            <flux:input size="sm" />
        </div>
        <div class="col-span-3 space-y-2">
            <flux:input size="sm" />
            <flux:input size="sm" />
            <flux:input size="sm" />
        </div>
        <div class="col-span-3 space-y-2">
            <flux:input size="sm" />
            <flux:input size="sm" />
            <flux:input size="sm" />
        </div>
        <div class="col-span-3 space-y-2">
            <flux:input placeholder="₱ 0.00" size="sm" />
            <flux:input placeholder="₱ 0.00" size="sm" />
            <flux:input placeholder="₱ 0.00" size="sm" />
        </div>
    </div>

    <div class="grid grid-cols-2 gap-x-3 gap-y-2 mb-4">
        <div>
            <flux:label class="mb-1 ">Date of Stocking:</flux:label>
            <flux:input type="date" size="sm" />
        </div>
        <div>
            <flux:label class="mb-1 ">No. of Kilos Harvested:</flux:label>
            <flux:input placeholder="0.00 kg" size="sm" />
        </div>
        <div>
            <flux:label class="mb-1 ">Date of Harvest:</flux:label>
            <flux:input type="date" size="sm" />
        </div>
        <div>
            <flux:label class="mb-1">Gross Sales:</flux:label>
            <flux:input placeholder="₱ 0.00" size="sm" />
        </div>
    </div>

    <div class="w-full flex items-center gap-2">
        <p class="text-sm  text-zinc-700 mb-2 font-bold">Markets</p>
        <flux:separator />
    </div>
    <div class="grid grid-cols-2 gap-x-3 gap-y-2 mb-4">
        <div>
            <flux:label class="mb-1 ">Domestic:</flux:label>
            <flux:input size="sm" />
        </div>
        <div>
            <flux:label class="mb-1 ">No. of Kilos:</flux:label>
            <flux:input placeholder="0.00 kg" size="sm" />
        </div>
        <div>
            <flux:label class="mb-1 ">Export:</flux:label>
            <flux:input size="sm" />
        </div>
        <div>
            <flux:label class="mb-1">No. of Kilos:</flux:label>
            <flux:input placeholder="0.00 kg" size="sm" />
        </div>
    </div>
</div>