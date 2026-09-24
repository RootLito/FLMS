<x-layouts.app title="Inspection Report Template">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative mb-4 w-full flex items-center">
            <div class="absolute left-0">
                <flux:button variant="danger" icon="arrow-left" href="{{ route('annual.report') }}">
                    Back
                </flux:button>
            </div>

            <flux:heading size="xl" level="1" class="w-full text-center">ANNUAL REPORT ON FISHPOND DEVELOPMENT, OPERATION & PRODUCTION</flux:heading>
        </div>

        <livewire:annual-report.multi-step-form />
    </div>
</x-layouts.app>
