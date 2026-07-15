<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\InspectionReport;
use App\Models\Lessee;
use Flux\Flux;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $sortField = 'fla_no';
    public $sortDirection = 'asc';

    public $editingReportId = null;
    public $lessee_id;
    public $from, $to;
    public $fla_no, $barangay, $municipality, $province;
    public $date_issued, $date_expire, $date_inspection;
    public $no_hec_granted, $no_hec_developed, $no_hect_undeveloped;
    public $remarks;
    public $with_pending_admin_case = false;
    public $with_pending_judicial_case = false;

    public $items = [];
    public $stocking = [];
    public $harvesting = [];
    public $marketing = [];
    public $site_photos = [];
    public $improvements = [];
    public $financial_values = [];
    public $stocking_records = [];
    public $harvest_records = [];
    public $pond_types = [];
    public $signature_data = null;

    public $messageSubject = '';
    public $messageContent = '';

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

    public function save()
    {
        $validated = $this->validate([
            'lessee_id' => 'required|exists:lessees,id',
            'from' => 'nullable|date',
            'to' => 'nullable|date|after_or_equal:from',
            'fla_no' => 'required|string',
            'barangay' => 'nullable|string',
            'municipality' => 'nullable|string',
            'province' => 'nullable|string',
            'date_issued' => 'nullable|date',
            'date_expire' => 'nullable|date|after_or_equal:date_issued',
            'date_inspection' => 'nullable|date',
            'no_hec_granted' => 'nullable|numeric',
            'no_hec_developed' => 'nullable|numeric',
            'no_hect_undeveloped' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'with_pending_admin_case' => 'boolean',
            'with_pending_judicial_case' => 'boolean',
        ]);

        $dataToSave = collect($validated)
            ->map(function ($value) {
                return is_string($value) ? strtoupper($value) : $value;
            })
            ->toArray();

        $dataToSave['items'] = $this->items;
        $dataToSave['stocking'] = $this->stocking;
        $dataToSave['harvesting'] = $this->harvesting;
        $dataToSave['marketing'] = $this->marketing;
        $dataToSave['site_photos'] = $this->site_photos;
        $dataToSave['improvements'] = $this->improvements;
        $dataToSave['financial_values'] = $this->financial_values;
        $dataToSave['stocking_records'] = $this->stocking_records;
        $dataToSave['harvest_records'] = $this->harvest_records;
        $dataToSave['pond_types'] = $this->pond_types;
        $dataToSave['signature_data'] = $this->signature_data;

        if ($this->editingReportId) {
            InspectionReport::find($this->editingReportId)->update($dataToSave);
            Flux::toast('Inspection Report updated successfully.', variant: 'success');
        } else {
            InspectionReport::create($dataToSave);
            Flux::toast('New Inspection Report added successfully.', variant: 'success');
        }

        $this->resetForm();
        $this->modal('report-modal')->close();
    }

    public function edit($id)
    {
        $this->editingReportId = $id;
        $report = InspectionReport::findOrFail($id);

        $this->lessee_id = $report->lessee_id;
        $this->from = $report->from?->format('Y-m-d');
        $this->to = $report->to?->format('Y-m-d');
        $this->fla_no = $report->fla_no;
        $this->barangay = $report->barangay;
        $this->municipality = $report->municipality;
        $this->province = $report->province;
        $this->date_issued = $report->date_issued?->format('Y-m-d');
        $this->date_expire = $report->date_expire?->format('Y-m-d');
        $this->date_inspection = $report->date_inspection?->format('Y-m-d');
        $this->no_hec_granted = $report->no_hec_granted;
        $this->no_hec_developed = $report->no_hec_developed;
        $this->no_hect_undeveloped = $report->no_hect_undeveloped;
        $this->remarks = $report->remarks;
        $this->with_pending_admin_case = (bool) $report->with_pending_admin_case;
        $this->with_pending_judicial_case = (bool) $report->with_pending_judicial_case;

        $this->items = $report->items ?? [];
        $this->stocking = $report->stocking ?? [];
        $this->harvesting = $report->harvesting ?? [];
        $this->marketing = $report->marketing ?? [];
        $this->site_photos = $report->site_photos ?? [];
        $this->improvements = $report->improvements ?? [];
        $this->financial_values = $report->financial_values ?? [];
        $this->stocking_records = $report->stocking_records ?? [];
        $this->harvest_records = $report->harvest_records ?? [];
        $this->pond_types = $report->pond_types ?? [];
        $this->signature_data = $report->signature_data;

        $this->modal('report-modal')->show();
    }

    public function confirmDelete($id)
    {
        $report = InspectionReport::findOrFail($id);
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

        InspectionReport::destroy($this->deletingReportId);
        $this->modal('delete-confirmation')->close();
        Flux::toast('Inspection Report record deleted.', variant: 'success');
    }

    public function openMessageModal($id)
    {
        $report = InspectionReport::with('lessee')->find($id);
        $this->messageSubject = 'Notice for ' . ($report->lessee->full_name ?? 'Lessee');
        $this->modal('message-modal')->show();
    }

    public function resetForm()
    {
        $this->reset(['editingReportId', 'lessee_id', 'from', 'to', 'fla_no', 'barangay', 'municipality', 'province', 'date_issued', 'date_expire', 'date_inspection', 'no_hec_granted', 'no_hec_developed', 'no_hect_undeveloped', 'remarks', 'with_pending_admin_case', 'with_pending_judicial_case', 'items', 'stocking', 'harvesting', 'marketing', 'site_photos', 'improvements', 'financial_values', 'stocking_records', 'harvest_records', 'pond_types', 'signature_data']);
    }

    public function with(): array
    {
        return [
            'reports' => InspectionReport::query()
                ->with('lessee')
                ->when($this->search, function ($query) {
                    $query
                        ->where('fla_no', 'like', '%' . $this->search . '%')
                        ->orWhere('province', 'like', '%' . $this->search . '%')
                        ->orWhereHas('lessee', function ($q) {
                            $q->where('full_name', 'like', '%' . $this->search . '%');
                        });
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
            'lessees' => Lessee::orderBy('full_name')->get(),
        ];
    }
}; ?>

<div class="w-full">
    <div class="mb-8 w-full flex gap-2">
        <div class="w-120">
            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search reports..." />
        </div>

        <flux:spacer />

        <flux:button icon="document-text" variant="primary" color="emerald" :href="route('inspection.template')">
            Generate Report
        </flux:button>
    </div>

    <flux:table :paginate="$reports">
        <flux:table.columns>
            <flux:table.column sticky sortable :direction="$sortField === 'fla_no' ? $sortDirection : null"
                wire:click="sortBy('fla_no')">FLA / Lessee</flux:table.column>
            <flux:table.column>Coverage Period</flux:table.column>
            <flux:table.column>Location</flux:table.column>
            <flux:table.column>Remarks</flux:table.column>
            <flux:table.column class="w-px whitespace-nowrap">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($reports as $report)
                <flux:table.row :key="$report->id">
                    <flux:table.cell sticky>
                        <div class="flex flex-col">
                            <span class="font-mono text-sm text-zinc-800 dark:text-white leading-tight font-bold">
                                {{ $report->fla_no }}
                            </span>
                            <span class="text-xs text-zinc-500">
                                {{ $report->lessee->full_name ?? 'N/A' }}
                            </span>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">
                            @if ($report->from && $report->to)
                                {{ $report->from->format('M Y') }} - {{ $report->to->format('M Y') }}
                            @else
                                N/A
                            @endif
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
                        <span class="text-xs text-zinc-500 line-clamp-1">{{ $report->remarks ?? 'No remarks' }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            <flux:dropdown>
                                <flux:button icon="ellipsis-horizontal" size="sm" />

                                <flux:menu>
                                    <flux:menu.item icon="pencil-square" wire:click="edit('{{ $report->id }}')">
                                        Edit Report
                                    </flux:menu.item>
                                    <flux:menu.item icon="chat-bubble-bottom-center-text"
                                        wire:click="openMessageModal('{{ $report->id }}')">
                                        Send Notification
                                    </flux:menu.item>
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
                                No inspection reports found
                            </h3>
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                There are currently no registered inspection reports in the system.
                            </p>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

    <flux:modal name="report-modal" class="md:w-[800px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ $editingReportId ? 'Edit Inspection Report' : 'Add New Inspection Report' }}
                </flux:heading>
                <flux:text class="mt-2">Fill in the metrics and operational details for the inspection report.
                </flux:text>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:select label="Lessee" wire:model="lessee_id" placeholder="Choose a lessee..."
                    class="md:col-span-2">
                    @foreach ($lessees as $lessee)
                        <flux:select.option value="{{ $lessee->id }}">{{ $lessee->full_name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input label="Period From" type="date" wire:model="from" />
                <flux:input label="Period To" type="date" wire:model="to" />

                <flux:input label="FLA No." wire:model="fla_no" placeholder="FLA-2024-00123" />
                <flux:input label="Barangay" wire:model="barangay" placeholder="Brgy. San Isidro" />
                <flux:input label="Municipality" wire:model="municipality" placeholder="Davao City" />
                <flux:input label="Province" wire:model="province" placeholder="Davao del Sur" />

                <flux:input label="Date Issued" type="date" wire:model="date_issued" />
                <flux:input label="Date of Expiration" type="date" wire:model="date_expire" />
                <flux:input label="Date of Inspection" type="date" wire:model="date_inspection"
                    class="md:col-span-2" />

                <flux:input label="Hec. Granted" type="number" step="0.01" wire:model="no_hec_granted" />
                <flux:input label="Hec. Developed" type="number" step="0.01" wire:model="no_hec_developed" />
                <flux:input label="Hec. Undeveloped" type="number" step="0.01" wire:model="no_hect_undeveloped"
                    class="md:col-span-2" />

                {{-- Status Switches --}}
                <div class="md:col-span-2 flex flex-col gap-2 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl">
                    <span class="text-xs font-semibold uppercase text-zinc-500 tracking-wider">Legal Status</span>
                    <flux:checkbox label="With Pending Administrative Case" wire:model="with_pending_admin_case" />
                    <flux:checkbox label="With Pending Judicial Case" wire:model="with_pending_judicial_case" />
                </div>

                <flux:textarea label="Remarks" wire:model="remarks"
                    placeholder="Enter general field inspection remarks..." class="md:col-span-2" rows="3" />
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel
                </flux:button>
                <flux:button type="submit" variant="primary" color="emerald">Save Report</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="message-modal" class="md:w-[500px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Send Message</flux:heading>
                <flux:text class="mt-2">Send an official SMS notification regarding inspection report/FLA status.
                </flux:text>
            </div>
            <flux:input label="Subject" wire:model="messageSubject" />
            <flux:textarea label="Content" wire:model="messageContent" rows="5"
                placeholder="Type your message here..." />
            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel
                </flux:button>
                <flux:button icon="paper-airplane" variant="primary" color="emerald" disabled>
                    Send (Future Development)
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="delete-confirmation" class="md:w-[450px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Confirm Deletion</flux:heading>
                <flux:text class="mt-2 text-red-500">Warning: This action is permanent.</flux:text>
            </div>

            <flux:text>To confirm, please type the FLA NO: <span
                    class="font-bold text-zinc-800 dark:text-white">{{ $expectedFlaNo }}</span></flux:text>

            <flux:input wire:model.live="flaConfirmationInput" placeholder="Enter FLA NO. to confirm" />

            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel
                </flux:button>
                <flux:button wire:click="delete" variant="danger"
                    :disabled="$flaConfirmationInput !== $expectedFlaNo">
                    Permanently Delete
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
