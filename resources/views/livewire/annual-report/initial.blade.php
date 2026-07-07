@props(['formData', 'lessees'])

<div class="space-y-6">
    <div>
        <h2 class="text-xl font-bold text-zinc-800 tracking-tight">Initial Details</h2>
    </div>

    <flux:separator />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

        <div class="flex flex-col w-full">
            <div class="flex flex-col w-full mb-4">
                <label for="lessee" class="mb-2">Lessee</label>

                <flux:dropdown>
                    <flux:button class="w-full" align="start" >
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
                <flux:input label="FLA No." wire:model="formData.fla_no" disabled class="bg-zinc-50/50" />
            </div>

            <div class="w-full mb-4">
                <flux:input label="Location / Fishpond Address" wire:model="formData.location" disabled
                    class="bg-zinc-50/50" />
            </div>

            <div class="w-full mb-4">
                <flux:input type="date" label="Date Issued" wire:model="formData.date_issued" disabled
                    class="bg-zinc-50/50" />
            </div>

            <div class="w-full mb-4">
                <flux:input type="date" label="Expiry Date" wire:model="formData.expiry_date" disabled
                    class="bg-zinc-50/50" />
            </div>

            <div class="w-full mb-4">
                <flux:input label="Area Granted (has.)" wire:model="formData.area_granted" disabled
                    class="bg-zinc-50/50" />
            </div>
        </div>

        <div class="flex flex-col w-full">
            <div class="flex gap-4 w-full mb-4">
                <div class="flex-1">
                    <flux:input type="date" label="Report Period From" wire:model="formData.report_year_from" />
                </div>
                <div class="flex-1">
                    <flux:input type="date" label="Report Period To" wire:model="formData.report_year_to" />
                </div>
            </div>

            <div class="w-full mb-4">
                <flux:input label="Total Area Developed (has.)" wire:model="formData.area_developed" disabled
                    class="bg-zinc-50/50 font-semibold" />
            </div>

            <div class="w-full mb-4">
                <flux:input label="Area Undeveloped (has.)" wire:model="formData.area_undeveloped" disabled
                    class="bg-zinc-50/50" />
            </div>

            <div class="flex flex-col w-full">
                <div class="w-full mb-4">
                    <flux:input label="a. Nursery (has.)" wire:model="formData.pond_breakdown.nursery"
                        placeholder="0.00" />
                </div>
                <div class="w-full mb-4">
                    <flux:input label="b. Transition (has.)" wire:model="formData.pond_breakdown.transition"
                        placeholder="0.00" />
                </div>
                <div class="w-full mb-4">
                    <flux:input label="c. Rearing (has.)" wire:model="formData.pond_breakdown.rearing"
                        placeholder="0.00" />
                </div>
            </div>
        </div>

    </div>
</div>
