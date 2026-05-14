<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative mb-4 w-full">
            <flux:heading size="xl" level="1">Lessee Management</flux:heading>
            <flux:subheading size="lg" class="mb-6">
                Manage fishpond lessees and oversee lessee occupancy and status details.
            </flux:subheading>
            <flux:separator variant="subtle" />
        </div>
        <livewire:lessee.lessee-list />
    </div>
</x-layouts.app>