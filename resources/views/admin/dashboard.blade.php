<x-layouts.app title="Dashboard">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative mb-4 w-full">
            <div class="flex justify-between items-center">
                <div>
                    <flux:heading size="xl" level="1">Dashboard</flux:heading>
                    <flux:subheading size="lg" class="mb-6">Overview of system records, activities, and fishpond
                        area.</flux:subheading>
                </div>

                <flux:dropdown>
                    <flux:button icon="calendar" icon:trailing="chevron-down" size="sm" class="h-10">Fiscal Year: 2026
                    </flux:button>
                    <flux:menu>
                        <flux:menu.radio.group>
                            <flux:menu.radio checked>FY 2026</flux:menu.radio>
                            <flux:menu.radio>FY 2025</flux:menu.radio>
                            <flux:menu.radio>FY 2024</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>
            </div>
            <flux:separator variant="subtle" />
        </div>
        <div class="grid grid-cols-4 grid-rows-3 gap-4 h-full">
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-sm font-semibold">Total collected this year</h2>
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-950/50 rounded-md">
                        <flux:icon.banknotes class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-sm font-semibold">Total unpaid balance</h2>
                    <div class="p-2 bg-amber-100 dark:bg-amber-950/50 rounded-md">
                        <flux:icon.wallet class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-sm font-semibold">Overdue</h2>
                    <div class="p-2 bg-rose-100 dark:bg-rose-950/50 rounded-md">
                        <flux:icon.exclamation-triangle class="w-6 h-6 text-rose-600 dark:text-rose-400" />
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-sm font-semibold">Active lessee</h2>
                    <div class="p-2 bg-sky-100 dark:bg-sky-950/50 rounded-md">
                        <flux:icon.users class="w-6 h-6 text-sky-600 dark:text-sky-400" />
                    </div>
                </div>
            </div>

            <div class="col-span-2 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-sm font-semibold">Collection efficiency</h2>
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-950/50 rounded-md">
                        <flux:icon.arrow-trending-up class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                    </div>
                </div>
            </div>

            <div
                class="col-start-3 col-span-2 row-start-2 row-span-2 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-sm font-semibold">Monthly collection</h2>
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-950/50 rounded-md">
                        <flux:icon.chart-bar class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                </div>
            </div>


            <div class="col-span-2 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-sm font-semibold">Assessment status</h2>
                    <div class="p-2 bg-sky-100 dark:bg-sky-950/50 rounded-md">
                        <flux:icon.clipboard-document-check class="w-6 h-6 text-sky-600 dark:text-sky-400" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
