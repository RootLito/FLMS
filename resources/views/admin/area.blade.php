<x-layouts.app title="Area">
    <div class="flex h-full w-full flex-col gap-4 rounded-xl ">
        <div class="relative mb-4 w-full">
            <flux:heading size="xl" level="1">Areas</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage your area settings</flux:subheading>
        <flux:separator variant="subtle" />
        </div>
        <livewire:area.fishpond-map />
    </div>

</x-layouts.app>