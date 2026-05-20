<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Lessee;
use Flux\Flux;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $sortField = 'fla_no';
    public $sortDirection = 'asc';

    // Form properties
    public $editingLesseeId = null;
    public $full_name, $barangay, $municipality, $province, $fla_no;
    public $date_issued, $date_expiration, $hec_granted, $hec_developed, $hec_undeveloped;

    // Message properties
    public $messageSubject = '';
    public $messageContent = '';

    // Delete properties
    public $deletingLesseeId = null;
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
            'full_name' => 'required|string',
            'fla_no' => 'required|unique:lessees,fla_no,' . $this->editingLesseeId,
            'barangay' => 'nullable|string',
            'municipality' => 'nullable|string',
            'province' => 'nullable|string',
            'date_issued' => 'nullable|date',
            'date_expiration' => 'nullable|date',
            'hec_granted' => 'nullable|numeric',
            'hec_developed' => 'nullable|numeric',
            'hec_undeveloped' => 'nullable|numeric',
        ]);

        $dataToSave = collect($validated)->map(function ($value) {
            return is_string($value) ? strtoupper($value) : $value;
        })->toArray();

        if ($this->editingLesseeId) {
            Lessee::find($this->editingLesseeId)->update($dataToSave);
            Flux::toast('Lessee updated successfully.', variant: 'success');
        } else {
            Lessee::create($dataToSave);
            Flux::toast('New lessee added successfully.', variant: 'success');
        }

        $this->resetForm();
        $this->modal('lessee-modal')->close();
    }

    public function edit($id)
    {
        $this->editingLesseeId = $id;
        $lessee = Lessee::findOrFail($id);
        
        $this->full_name = $lessee->full_name;
        $this->barangay = $lessee->barangay;
        $this->municipality = $lessee->municipality;
        $this->province = $lessee->province;
        $this->fla_no = $lessee->fla_no;
        $this->date_issued = $lessee->date_issued?->format('Y-m-d');
        $this->date_expiration = $lessee->date_expiration?->format('Y-m-d');
        $this->hec_granted = $lessee->hec_granted;
        $this->hec_developed = $lessee->hec_developed;
        $this->hec_undeveloped = $lessee->hec_undeveloped;

        $this->modal('lessee-modal')->show();
    }

    public function confirmDelete($id)
    {
        $lessee = Lessee::findOrFail($id);
        $this->deletingLesseeId = $id;
        $this->expectedFlaNo = $lessee->fla_no;
        $this->flaConfirmationInput = '';
        $this->modal('delete-confirmation')->show();
    }

    public function delete()
    {
        if ($this->flaConfirmationInput !== $this->expectedFlaNo) {
            Flux::toast('FLA Number does not match. Delete aborted.', variant: 'danger');
            return;
        }

        Lessee::destroy($this->deletingLesseeId);
        $this->modal('delete-confirmation')->close();
        Flux::toast('Lessee record deleted.', variant: 'success');
    }

    public function openMessageModal($id)
    {
        $lessee = Lessee::find($id);
        $this->messageSubject = "Notice for " . $lessee->full_name;
        $this->modal('message-modal')->show();
    }

    public function resetForm()
    {
        $this->reset(['editingLesseeId', 'full_name', 'barangay', 'municipality', 'province', 'fla_no', 'date_issued', 'date_expiration', 'hec_granted', 'hec_developed', 'hec_undeveloped']);
    }

    public function with(): array
    {
        return [
            'lessees' => Lessee::query()
                ->when($this->search, function ($query) {
                    $query->where('full_name', 'like', '%' . $this->search . '%')
                          ->orWhere('fla_no', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ];
    }
}; ?>

<div class="w-full">
    {{-- Action Bar --}}
    <div class="mb-8 w-full flex gap-2">
        <div class="w-150">
            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search lessees..." />
        </div>

        <flux:spacer />

        <flux:button variant="primary" color="emerald" icon="document-text" :href="route('inspection.template')">
            Generate Report
        </flux:button>
    </div>

    <flux:table :paginate="$lessees">
        <flux:table.columns>
            <flux:table.column sticky sortable :direction="$sortField === 'full_name' ? $sortDirection : null"
                wire:click="sortBy('full_name')">Lessee / FLA</flux:table.column>
            <flux:table.column>Location</flux:table.column>
            <flux:table.column>Report Status</flux:table.column>
            <flux:table.column class="w-px whitespace-nowrap">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($lessees as $lessee)
            <flux:table.row :key="$lessee->id">
                <!-- Column 1: Identity -->
                <flux:table.cell sticky>
                    <div class="flex flex-col">
                        <span class="font-bold text-zinc-800 dark:text-white leading-tight">
                            {{ $lessee->full_name }}
                        </span>
                        <span class="text-xs text-zinc-500 font-mono tracking-tighter">
                            {{ $lessee->fla_no }}
                        </span>
                    </div>
                </flux:table.cell>

                <!-- Column 2: Location -->
                <flux:table.cell>
                    <div class="flex flex-col">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $lessee->municipality }}</span>
                        <span class="text-[10px] text-zinc-400 uppercase tracking-widest">{{ $lessee->province }}</span>
                    </div>
                </flux:table.cell>

                <!-- Column 3: Hectares -->
                <flux:table.cell>

                </flux:table.cell>


                <!-- Column 5: Always Visible Actions -->
                <flux:table.cell>
                    <div class="flex items-center gap-2">
                        <!-- Message Button: Default variant + Outline Icon -->
                        <flux:tooltip content="Send Message">
                            <flux:button icon="chat-bubble-left-right" size="sm"
                                wire:click="openMessageModal('{{ $lessee->id }}')" />
                        </flux:tooltip>

                        <!-- Dropdown Button: Default variant -->
                        <flux:dropdown>
                            <flux:button icon="ellipsis-horizontal" size="sm" />

                            <flux:menu>
                                <flux:menu.item icon="eye">View Details</flux:menu.item>
                                <flux:menu.item icon="pencil-square" wire:click="edit('{{ $lessee->id }}')">
                                    Edit Lessee
                                </flux:menu.item>
                                <flux:menu.separator />
                                <flux:menu.item icon="trash" variant="danger"
                                    wire:click="confirmDelete('{{ $lessee->id }}')">
                                    Delete Record
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                </flux:table.cell>
            </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    {{-- Unified Add/Edit Modal --}}
    <flux:modal name="lessee-modal" class="md:w-[800px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editingLesseeId ? 'Edit Lessee' : 'Add New Lessee' }}</flux:heading>
                <flux:text class="mt-2">Fill in the details for the lessee record.</flux:text>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input label="Full Name" wire:model="full_name" placeholder="Juan Dela Cruz"
                    class="md:col-span-2" />
                <flux:input label="Barangay" wire:model="barangay" placeholder="Brgy. San Isidro" />
                <flux:input label="Municipality" wire:model="municipality" placeholder="Davao City" />
                <flux:input label="Province" wire:model="province" placeholder="Davao del Sur" />
                <flux:input label="FLA No." wire:model="fla_no" placeholder="FLA-2024-00123" />
                <flux:input label="Date Issued" type="date" wire:model="date_issued" />
                <flux:input label="Date of Expiration" type="date" wire:model="date_expiration" />
                <flux:input label="Hec. Granted" type="number" step="0.01" wire:model="hec_granted" />
                <flux:input label="Hec. Developed" type="number" step="0.01" wire:model="hec_developed" />
                <flux:input label="Hec. Undeveloped" type="number" step="0.01" wire:model="hec_undeveloped" />
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel</flux:button>
                <flux:button type="submit" variant="primary" color="emerald">Save Lessee</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Message Modal --}}
    <flux:modal name="message-modal" class="md:w-[500px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Send Message</flux:heading>
                <flux:text class="mt-2">Send an official SMS notification regarding FLA status.</flux:text>
            </div>
            <flux:input label="Subject" wire:model="messageSubject" />
            <flux:textarea label="Content" wire:model="messageContent" rows="5"
                placeholder="Type your message here..." />
            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel</flux:button>
                <flux:button icon="paper-airplane" variant="primary" color="emerald" disabled>Send (Future Development)
                </flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Delete Confirmation Modal --}}
    <flux:modal name="delete-confirmation" class="md:w-[450px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Confirm Deletion</flux:heading>
                <flux:text class="mt-2 text-red-500">Warning: This action is permanent.</flux:text>
            </div>

            <flux:text>To confirm, please type the FLA NO: <span class="font-bold text-zinc-800">{{ $expectedFlaNo
                    }}</span></flux:text>

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