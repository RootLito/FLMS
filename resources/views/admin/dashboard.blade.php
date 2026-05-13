<x-layouts.app title="Dashboard">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative mb-4 w-full">
            <flux:heading size="xl" level="1">Dashboard</flux:heading>
            <flux:subheading size="lg" class="mb-6">Overview of system records, activities, and fishpond area.</flux:subheading>
            <flux:separator variant="subtle" />
        </div>
        <div class="grid grid-cols-4 grid-rows-3 gap-4 h-full">
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50"></div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50"></div>
            <div
                class="col-start-3 col-span-2 row-start-1 row-span-3 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50">
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50"></div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50"></div>
            <div class="col-span-2 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50"></div>
        </div>
    </div>
</x-layouts.app>