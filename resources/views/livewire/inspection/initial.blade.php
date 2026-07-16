@props(['formData', 'lessees'])

<div class="space-y-6">
    <div>
        <h2 class="text-xl font-bold text-zinc-800 tracking-tight">Initial Details</h2>
    </div>

    <flux:separator />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

        <div class="flex flex-col w-full">
            <div class="flex flex-col w-full mb-4">
                <label for="lessee" class="text-sm font-medium text-zinc-700 mb-2">Name of Lessee/Applicant</label>

                <flux:dropdown>
                    <flux:button class="w-full" align="start">
                        {{ $lessees->firstWhere('id', $formData['lessee_id'])->full_name ?? 'Select Lessee' }}
                    </flux:button>

                    <flux:menu class="w-[var(--flux-dropdown-width)]">
                        @foreach ($lessees as $lessee)
                            <flux:menu.item wire:click="$set('formData.lessee_id', {{ $lessee->id }})"
                                :wire:key="$lessee->id">
                                {{ $lessee->full_name }}
                            </flux:menu.item>
                        @endforeach
                    </flux:menu>
                </flux:dropdown>
            </div>

            <div class="w-full mb-4">
                <flux:input label="FLA/ASC/Fp. A. No." wire:model="formData.fla_no" disabled class="bg-zinc-50/50" />
            </div>

            <div class="w-full mb-4">
                @php
                    $addressParts = array_filter([
                        $formData['barangay'] ?? '',
                        $formData['municipality'] ?? '',
                        $formData['province'] ?? '',
                    ]);
                    $computedLocation = implode(', ', $addressParts);
                @endphp
                <flux:input label="Address" value="{{ $computedLocation }}" disabled
                    placeholder="Address will auto-populate" class="bg-zinc-50/50" />
            </div>

            <div class="w-full flex gap-4">
                <div class="w-full mb-4">
                    <flux:input type="date" label="Date Issued" wire:model="formData.date_issued" disabled
                        class="bg-zinc-50/50" />
                </div>
                <div class="w-full mb-4">
                    <flux:input type="date" label="Date of Expiration" wire:model="formData.date_expire" disabled
                        class="bg-zinc-50/50" />
                </div>
            </div>
        </div>

        <div class="flex flex-col w-full">
            <div class="w-full mb-4">
                <flux:input label="No. of hectares granted" wire:model="formData.no_hec_granted" disabled
                    class="bg-zinc-50/50" />
            </div>
            <div class="w-full mb-4">
                <flux:input label="No. of hectares developed" wire:model="formData.no_hec_developed" disabled
                    class="bg-zinc-50/50" />
            </div>
            <div class="w-full mb-4">
                <flux:input label="No. of hectares undeveloped" wire:model="formData.no_hect_undeveloped" disabled
                    class="bg-zinc-50/50" />
            </div>
        </div>
    </div>
</div>
