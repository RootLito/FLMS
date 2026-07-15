<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\AnnualReport;
use App\Models\Lessee;
use Flux\Flux;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $deletingReportId = null;
    public $flaConfirmationInput = '';
    public $expectedFlaNo = '';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete($id)
    {
        $report = AnnualReport::findOrFail($id);
        $this->deletingReportId = $id;
        $this->expectedFlaNo = $report->fla_no;
        $this->flaConfirmationInput = '';
        $this->modal('delete-confirmation')->show();
    }

    public function delete()
    {
        if ($this->flaConfirmationInput !== $this->expectedFlaNo) {
            Flux::toast('FLA Number does not match. Delete aborted.', variant: 'danger');
            return;
        }

        AnnualReport::destroy($this->deletingReportId);
        $this->modal('delete-confirmation')->close();
        Flux::toast('Annual Report deleted successfully.', variant: 'success');
    }

    public function with(): array
    {
        return [
            'reports' => AnnualReport::query()
                ->with('lessee')
                ->when($this->search, function ($query) {
                    $query->where('fla_no', 'like', '%' . $this->search . '%')->orWhereHas('lessee', function ($q) {
                        $q->where('full_name', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ];
    }
}; ?>

<div class="w-full">
    <div class="mb-8 w-full flex gap-2">
        <div class="w-120">
            <flux:input wire:model.live="search" icon="magnifying-glass"
                placeholder="Search reports by FLA or Lessee..." />
        </div>

        <flux:spacer />

        <flux:button variant="primary" color="emerald" icon="document-text" :href="route('annual.template')">
            Generate Report
        </flux:button>
    </div>

    <flux:table :paginate="$reports">
        <flux:table.columns>
            <flux:table.column sticky sortable :direction="$sortField === 'fla_no' ? $sortDirection : null"
                wire:click="sortBy('fla_no')">Lessee / FLA</flux:table.column>
            <flux:table.column>Coverage Period</flux:table.column>
            <flux:table.column>Location</flux:table.column>
            <flux:table.column sortable :direction="$sortField === 'created_at' ? $sortDirection : null"
                wire:click="sortBy('created_at')">Submitted Date</flux:table.column>
            <flux:table.column class="w-px whitespace-nowrap">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($reports as $report)
                <flux:table.row :key="$report->id">
                    <flux:table.cell sticky>
                        <div class="flex flex-col">
                            <span class="font-bold text-zinc-800 dark:text-white leading-tight">
                                {{ $report->lessee->full_name ?? 'N/A' }}
                            </span>
                            <span class="text-xs text-zinc-500 font-mono tracking-tighter">
                                {{ $report->fla_no }}
                            </span>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">
                            {{ $report->from }} - {{ $report->to }}
                        </span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex flex-col">
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $report->municipality }}</span>
                            <span
                                class="text-[10px] text-zinc-400 uppercase tracking-widest">{{ $report->province }}</span>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">
                            {{ $report->created_at?->format('M d, Y') }}
                        </span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            <flux:dropdown>
                                <flux:button icon="ellipsis-horizontal" size="sm" />

                                <flux:menu>
                                    <flux:menu.item icon="eye">View Submission</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item icon="trash" variant="danger"
                                        wire:click="confirmDelete('{{ $report->id }}')">
                                        Delete Report
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row class="[border-bottom:none] [&_td]:border-b-0">
                    <flux:table.cell colspan="5" class="py-16 text-center">
                        <div class="mx-auto flex max-w-sm flex-col items-center justify-center">
                            <div class="rounded-full bg-zinc-50 p-4 dark:bg-zinc-800/50">
                                <flux:icon name="document-text" class="size-8 text-zinc-400 dark:text-zinc-500"
                                    variant="outline" />
                            </div>
                            <h3 class="mt-4 text-sm font-semibold text-zinc-900 dark:text-white">
                                No submissions found
                            </h3>
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                There are currently no records available for this coverage period.
                            </p>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

    <flux:modal name="delete-confirmation" class="md:w-[450px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Confirm Deletion</flux:heading>
                <flux:text class="mt-2 text-red-500">Warning: This action will permanently remove this annual report
                    entry.</flux:text>
            </div>

            <flux:text>To confirm, please type the FLA NO: <span
                    class="font-bold text-zinc-800">{{ $expectedFlaNo }}</span></flux:text>

            <flux:input wire:model.live="flaConfirmationInput" placeholder="Enter FLA NO. to confirm" />

            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel</flux:button>
                <flux:button wire:click="delete" variant="danger" :disabled="$flaConfirmationInput !== $expectedFlaNo">
                    Permanently Delete
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
