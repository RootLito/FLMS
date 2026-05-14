<x-layouts.app title="Status">
    <div class="flex h-full w-full flex-col gap-4 rounded-xl ">
        <div class="relative mb-4 w-full">
            <flux:heading size="xl" level="1">Property Assignment</flux:heading>
            <flux:subheading size="lg" class="mb-6">
                Manage property assignments for fishponds, including lessee occupancy and status details.
            </flux:subheading>
            <flux:separator variant="subtle" />
        </div>
        <livewire:property.property-assignment />
    </div>
</x-layouts.app>