@props(['formData'])

<div>
    <h2 class="text-xl font-bold text-gray-800 mb-2">E. Remarks and Recommendation/s</h2>
    <flux:separator class="my-6" />

    <div class="space-y-6">
        <div class="w-1/2 flex flex-col gap-2">
            <flux:label>Remarks and Recommendation/s</flux:label>
            <flux:textarea placeholder="Enter detailed observations and findings..." rows="10"
                wire:model="formData.remarks" />
        </div>
    </div>
</div>
