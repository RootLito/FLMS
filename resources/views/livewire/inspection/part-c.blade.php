@props(['formData'])

<div>
    <h2 class="text-xl font-bold text-gray-800 mb-2">C. Verification of Presence of Facilities</h2>
    <flux:separator class="my-6" />

    <div class="flex flex-col gap-y-4 mb-4">
        <div class="w-1/2">
            <flux:checkbox label="Nursery:" class="mb-1" wire:model.live="formData.verification.pond_types.nursery" />
            <flux:input placeholder="(Has.)" size="sm"
                :disabled="!data_get($formData, 'verification.pond_types.nursery', false)"
                wire:model="formData.verification.pond_types.nursery_has" />
        </div>

        <div class="w-1/2">
            <flux:checkbox label="Transition:" class="mb-1"
                wire:model.live="formData.verification.pond_types.transition" />
            <flux:input placeholder="(Has.)" size="sm"
                :disabled="!data_get($formData, 'verification.pond_types.transition', false)"
                wire:model="formData.verification.pond_types.transition_has" />
        </div>

        <div class="w-1/2">
            <flux:checkbox label="Rearing:" class="mb-1" wire:model.live="formData.verification.pond_types.rearing" />
            <flux:input placeholder="(Has.)" size="sm"
                :disabled="!data_get($formData, 'verification.pond_types.rearing', false)"
                wire:model="formData.verification.pond_types.rearing_has" />
        </div>

        <div class="w-1/2">
            <flux:checkbox label="Canal:" class="mb-1" wire:model.live="formData.verification.pond_types.canal" />
            <flux:input placeholder="(Has.)" size="sm"
                :disabled="!data_get($formData, 'verification.pond_types.canal', false)"
                wire:model="formData.verification.pond_types.canal_has" />
        </div>

        <div class="w-1/2">
            <flux:checkbox label="Others:" class="mb-1" wire:model.live="formData.verification.pond_types.others" />
            <flux:input placeholder="(Has.)" size="sm"
                :disabled="!data_get($formData, 'verification.pond_types.others', false)"
                wire:model="formData.verification.pond_types.others_has" />
        </div>
    </div>
</div>
