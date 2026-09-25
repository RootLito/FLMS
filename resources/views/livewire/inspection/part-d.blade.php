@props(['formData'])

<div class="space-y-6">
    <h2 class="text-xl font-bold text-gray-800 mb-2">D. Case status of the area</h2>
    <flux:separator class="my-6" />

    <div class="flex flex-col gap-y-4 mb-4">
        <div class="w-1/2">
            <p class="text-sm font-medium text-zinc-700 mb-2">1. With pending administrative case</p>
            <flux:radio.group wire:model.live="formData.case_status.admin_case" class="mb-4">
                <flux:radio label="Yes" value="Yes" />
                <flux:radio label="No" value="No" />
            </flux:radio.group>
            <flux:textarea placeholder="Details..."
                :disabled="($formData['case_status']['admin_case'] ?? 'No') !== 'Yes'"
                wire:model="formData.case_status.admin_details" />
        </div>

        <div class="w-1/2">
            <p class="text-sm font-medium text-zinc-700 mb-2">2. With pending judicial case</p>
            <flux:radio.group wire:model.live="formData.case_status.judicial_case" class="mb-4">
                <flux:radio label="Yes" value="Yes" />
                <flux:radio label="No" value="No" />
            </flux:radio.group>
            <flux:textarea placeholder="Details..."
                :disabled="($formData['case_status']['judicial_case'] ?? 'No') !== 'Yes'"
                wire:model="formData.case_status.judicial_details" />
        </div>
    </div>
</div>
