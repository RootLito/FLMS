<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <h2 class="text-xl font-bold text-gray-800 mb-2">C. Verification of Presence of Facilities that minimize
        Environmental pollution</h2>
    <flux:separator class="my-6" />

    <div class="flex flex-col gap-y-4 mb-4"
        x-data="{ nursery: false, transition: false, rearing: false, canal: false, others: false }">
        <div class="w-1/2">
            <flux:checkbox label="Nursery:" class="mb-1" x-model="nursery" />
            <flux:input placeholder="(Has.)" size="sm" ::disabled="!nursery" />
        </div>

        <div class="w-1/2">
            <flux:checkbox label="Transition:" class="mb-1" x-model="transition" />
            <flux:input placeholder="(Has.)" size="sm" ::disabled="!transition" />
        </div>

        <div class="w-1/2">
            <flux:checkbox label="Rearing:" class="mb-1" x-model="rearing" />
            <flux:input placeholder="(Has.)" size="sm" ::disabled="!rearing" />
        </div>

        <div class="w-1/2">
            <flux:checkbox label="Canal:" class="mb-1" x-model="canal" />
            <flux:input placeholder="(Has.)" size="sm" ::disabled="!canal" />
        </div>

        <div class="w-1/2">
            <flux:checkbox label="Others:" class="mb-1" x-model="others" />
            <flux:input placeholder="(Has.)" size="sm" ::disabled="!others" />
        </div>
    </div>
</div>