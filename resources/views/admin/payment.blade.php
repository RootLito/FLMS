<x-layouts.app title="Inspection Report">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative mb-4 w-full">
            <flux:heading size="xl" level="1">Lease Payments</flux:heading>
            <flux:subheading size="lg" class="mb-6">
                View and manage lease payments for fishponds.
            </flux:subheading>
            <flux:separator variant="subtle" />
        </div>
        <livewire:payment.payment-data />
    </div>
</x-layouts.app>