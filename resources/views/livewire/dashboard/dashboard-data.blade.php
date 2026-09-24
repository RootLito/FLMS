<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $fiscalYear = '2026';
    
    public array $yearlyData = [
        '2026' => [
            'total_collected' => '₱1,245,800.00',
            'collected_change' => '+12.5% from last year',
            'unpaid_balance' => '₱312,400.00',
            'unpaid_count' => '14 accounts pending',
            'overdue' => '₱85,200.00',
            'overdue_count' => '5 accounts overdue',
            'active_lessees' => '42',
            'lessees_subtitle' => 'Across 68 fishpond units',
            'collection_efficiency' => '84.2%',
            'efficiency_subtitle' => 'Target: 90.0% for FY 2026',
            'assessment_status' => '96% Evaluated',
            'assessment_subtitle' => '65 of 68 units fully assessed',
            'monthly_labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'monthly_amounts' => [95000, 110000, 125000, 98000, 140000, 135000, 50000, 145000, 152800, 0, 0, 0]
        ],
        '2025' => [
            'total_collected' => '₱1,110,500.00',
            'collected_change' => '+8.1% from last year',
            'unpaid_balance' => '₱240,100.00',
            'unpaid_count' => '9 accounts pending',
            'overdue' => '₱62,000.00',
            'overdue_count' => '3 accounts overdue',
            'active_lessees' => '39',
            'lessees_subtitle' => 'Across 65 fishpond units',
            'collection_efficiency' => '88.5%',
            'efficiency_subtitle' => 'Target: 85.0% for FY 2025',
            'assessment_status' => '100% Evaluated',
            'assessment_subtitle' => '65 of 65 units fully assessed',
            'monthly_labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'monthly_amounts' => [85000, 92000, 105000, 90000, 115000, 100000, 110000, 120000, 118500, 95000, 90000, 90000]
        ],
        '2024' => [
            'total_collected' => '₱980,200.00',
            'collected_change' => '+5.4% from last year',
            'unpaid_balance' => '₱195,000.00',
            'unpaid_count' => '6 accounts pending',
            'overdue' => '₱45,000.00',
            'overdue_count' => '2 accounts overdue',
            'active_lessees' => '36',
            'lessees_subtitle' => 'Across 60 fishpond units',
            'collection_efficiency' => '83.4%',
            'efficiency_subtitle' => 'Target: 80.0% for FY 2024',
            'assessment_status' => '100% Evaluated',
            'assessment_subtitle' => '60 of 60 units fully assessed',
            'monthly_labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'monthly_amounts' => [75000, 80000, 88000, 82000, 90000, 85000, 95000, 91000, 88200, 80000, 78000, 78000]
        ]
    ];

    public function with(): array
    {
        return [
            'metrics' => $this->yearlyData[$this->fiscalYear] ?? $this->yearlyData['2026']
        ];
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <div class="relative mb-4 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">Dashboard</flux:heading>
                <flux:subheading size="lg" class="mb-6">Overview of system records, activities, and fishpond area.</flux:subheading>
            </div>

            <flux:dropdown>
                <flux:button icon="calendar" icon:trailing="chevron-down" size="sm" class="h-10">
                    Fiscal Year: {{ $fiscalYear }}
                </flux:button>
                <flux:menu>
                    <flux:menu.radio.group wire:model.live="fiscalYear">
                        <flux:menu.radio value="2026">FY 2026</flux:menu.radio>
                        <flux:menu.radio value="2025">FY 2025</flux:menu.radio>
                        <flux:menu.radio value="2024">FY 2024</flux:menu.radio>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>
        </div>
        <flux:separator variant="subtle" />
    </div>

    <div class="grid grid-cols-4 grid-rows-3 gap-4 h-full">
        <!-- Total collected this year -->
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4 flex flex-col justify-between">
            <div class="flex justify-between items-center">
                <h2 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">Total collected this year</h2>
                <div class="p-2 bg-emerald-100 dark:bg-emerald-950/50 rounded-md">
                    <flux:icon.banknotes class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
            <div>
                <div class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $metrics['total_collected'] }}</div>
                <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 font-medium">{{ $metrics['collected_change'] }}</p>
            </div>
        </div>

        <!-- Total unpaid balance -->
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4 flex flex-col justify-between">
            <div class="flex justify-between items-center">
                <h2 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">Total unpaid balance</h2>
                <div class="p-2 bg-amber-100 dark:bg-amber-950/50 rounded-md">
                    <flux:icon.wallet class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                </div>
            </div>
            <div>
                <div class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $metrics['unpaid_balance'] }}</div>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $metrics['unpaid_count'] }}</p>
            </div>
        </div>

        <!-- Overdue -->
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4 flex flex-col justify-between">
            <div class="flex justify-between items-center">
                <h2 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">Overdue</h2>
                <div class="p-2 bg-rose-100 dark:bg-rose-950/50 rounded-md">
                    <flux:icon.exclamation-triangle class="w-6 h-6 text-rose-600 dark:text-rose-400" />
                </div>
            </div>
            <div>
                <div class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $metrics['overdue'] }}</div>
                <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 font-medium">{{ $metrics['overdue_count'] }}</p>
            </div>
        </div>

        <!-- Active lessee -->
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4 flex flex-col justify-between">
            <div class="flex justify-between items-center">
                <h2 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">Active lessee</h2>
                <div class="p-2 bg-sky-100 dark:bg-sky-950/50 rounded-md">
                    <flux:icon.users class="w-6 h-6 text-sky-600 dark:text-sky-400" />
                </div>
            </div>
            <div>
                <div class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $metrics['active_lessees'] }}</div>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $metrics['lessees_subtitle'] }}</p>
            </div>
        </div>

        <!-- Collection efficiency -->
        <div class="col-span-2 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4 flex flex-col justify-between">
            <div class="flex justify-between items-center">
                <h2 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">Collection efficiency</h2>
                <div class="p-2 bg-indigo-100 dark:bg-indigo-950/50 rounded-md">
                    <flux:icon.arrow-trending-up class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                </div>
            </div>
            <div>
                <div class="flex items-baseline gap-3">
                    <span class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $metrics['collection_efficiency'] }}</span>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $metrics['efficiency_subtitle'] }}</span>
                </div>
                <div class="w-full bg-neutral-200 dark:bg-neutral-700 h-2 rounded-full mt-2 overflow-hidden">
                    <div class="bg-indigo-600 dark:bg-indigo-500 h-full rounded-full transition-all duration-500" style="width: {{ $metrics['collection_efficiency'] }};"></div>
                </div>
            </div>
        </div>

        <!-- Monthly collection (Chart.js Bar Chart) -->
        <div class="col-start-3 col-span-2 row-start-2 row-span-2 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4 flex flex-col justify-between"
             x-data="{
                 chart: null,
                 init() {
                     let canvas = document.getElementById('monthlyCollectionChart');
                     
                     // Destroy any existing chart instance tied to this canvas before rebuilding
                     let existingChart = Chart.getChart(canvas);
                     if (existingChart) {
                         existingChart.destroy();
                     }

                     let ctx = canvas.getContext('2d');
                     this.chart = new Chart(ctx, {
                         type: 'bar',
                         data: {
                             labels: @js($metrics['monthly_labels']),
                             datasets: [{
                                 label: 'Collection (₱)',
                                 data: @js($metrics['monthly_amounts']),
                                 backgroundColor: 'rgba(16, 185, 129, 0.8)',
                                 hoverBackgroundColor: 'rgba(16, 185, 129, 1)',
                                 borderRadius: 4,
                             }]
                         },
                         options: {
                             responsive: true,
                             maintainAspectRatio: false,
                             plugins: {
                                 legend: { display: false },
                                 tooltip: {
                                     callbacks: {
                                         label: function(context) {
                                             return ' ₱' + (context.raw || 0).toLocaleString();
                                         }
                                     }
                                 }
                             },
                             scales: {
                                 x: {
                                     grid: { display: false },
                                     ticks: { font: { size: 10 }, color: '#9ca3af' }
                                 },
                                 y: {
                                     beginAtZero: true,
                                     grid: { color: 'rgba(156, 163, 175, 0.1)' },
                                     ticks: {
                                         font: { size: 10 },
                                         color: '#9ca3af',
                                         callback: function(value) {
                                             return '₱' + (value / 1000) + 'k';
                                         }
                                     }
                                 }
                             }
                         }
                     });
                 }
             }">
            <div class="flex justify-between items-center">
                <h2 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">Monthly collection</h2>
                <div class="p-2 bg-emerald-100 dark:bg-emerald-950/50 rounded-md">
                    <flux:icon.chart-bar class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
            
            <div class="relative w-full flex-1 pt-2 mt-4z`">
                <canvas id="monthlyCollectionChart"></canvas>
            </div>
        </div>

        <!-- Assessment status -->
        <div class="col-span-2 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 p-4 flex flex-col justify-between">
            <div class="flex justify-between items-center">
                <h2 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">Assessment status</h2>
                <div class="p-2 bg-sky-100 dark:bg-sky-950/50 rounded-md">
                    <flux:icon.clipboard-document-check class="w-6 h-6 text-sky-600 dark:text-sky-400" />
                </div>
            </div>
            <div>
                <div class="flex items-baseline gap-3">
                    <span class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $metrics['assessment_status'] }}</span>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $metrics['assessment_subtitle'] }}</span>
                </div>
                <div class="w-full bg-neutral-200 dark:bg-neutral-700 h-2 rounded-full mt-2 overflow-hidden">
                    <div class="bg-sky-600 dark:bg-sky-500 h-full rounded-full transition-all duration-500" style="width: 96%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>