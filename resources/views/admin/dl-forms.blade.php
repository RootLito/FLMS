<x-layouts.app title="Inspection Report">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative mb-4 w-full">
            <flux:heading size="xl" level="1">Downloadable Forms</flux:heading>
            <flux:subheading size="lg" class="mb-6">
                View and manage download forms for fishpond lessee.
            </flux:subheading>
            <flux:separator variant="subtle" />
        </div>
        <livewire:dl-forms.dl-forms-data />
    </div>
</x-layouts.app>