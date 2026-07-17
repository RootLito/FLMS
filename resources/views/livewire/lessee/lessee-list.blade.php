<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Lessee;
use Flux\Flux;
use Illuminate\Support\Facades\Mail;
use App\Mail\LesseeNotificationMail;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $sortField = 'fla_no';
    public $sortDirection = 'asc';

    public $editingLesseeId = null;
    public $full_name, $email, $contact_number, $barangay, $municipality, $province, $fla_no;
    public $date_issued, $date_expiration, $hec_granted, $hec_developed, $hec_undeveloped;

    public $messageEmail = '';
    public $messageSubject = '';
    public $messageContent = '';
    public $noticeType = 'Notice for Payment';

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
            'email' => 'nullable|email|max:255',
            'contact_number' => 'nullable|string|max:50',
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

        $dataToSave = collect($validated)
            ->map(function ($value, $key) {
                if ($key === 'email') {
                    return is_string($value) ? strtolower($value) : $value;
                }
                return is_string($value) ? strtoupper($value) : $value;
            })
            ->toArray();

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
        $this->email = $lessee->email;
        $this->contact_number = $lessee->contact_number;
        $this->barangay = $lessee->barangay;
        $this->municipality = $lessee->municipality;
        $this->province = $lessee->province;
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
        $lessee = Lessee::findOrFail($id);
        $this->messageEmail = $lessee->email ?? '';
        $this->messageSubject = 'Notice for ' . $lessee->full_name;
        $this->updatedNoticeType($this->noticeType);
        $this->modal('message-modal')->show();
    }

    public function updatedNoticeType($value)
    {
        if ($value === 'Notice for Payment') {
            $this->messageContent = "Dear Lessee,\n\nThis serves as an official notice that your FLA account has a pending balance due. Please settle your dues to ensure clear compliance.\n\nThank you.";
        } elseif ($value === 'Notice for Renewal') {
            $this->messageContent = "Dear Lessee,\n\nYour Forest Land Agreement (FLA) validity is nearing expiration. Kindly begin compiling the requirements for renewal to maintain active registration.\n\nBest regards.";
        } elseif ($value === 'Notice for Termination') {
            $this->messageContent = "NOTICE OF AGREEMENT TERMINATION\n\nDear Lessee,\n\nPlease look into this formal warning regarding persistent non-compliance parameters on your FLA agreement. Unresolved clauses will initiate final termination processes.\n\nUrgent action required.";
        }
    }

    public function sendNotification()
    {
        $this->validate([
            'messageEmail' => 'required|email',
            'messageSubject' => 'required|string',
            'messageContent' => 'required|string',
        ]);

        $viewMap = [
            'Notice for Payment' => 'emails.payment',
            'Notice for Renewal' => 'emails.renewal',
            'Notice for Termination' => 'emails.termination',
        ];

        $viewName = $viewMap[$this->noticeType] ?? 'emails.payment';

        Mail::to($this->messageEmail)->send(new LesseeNotificationMail($this->messageSubject, $this->messageContent, $viewName));

        Flux::toast('Email notification transmitted successfully.', variant: 'success');
        $this->modal('message-modal')->close();
    }

    public function resetForm()
    {
        $this->reset(['editingLesseeId', 'full_name', 'email', 'contact_number', 'barangay', 'municipality', 'province', 'fla_no', 'date_issued', 'date_expiration', 'hec_granted', 'hec_developed', 'hec_undeveloped']);
    }

    public function with(): array
    {
        return [
            'lessees' => Lessee::query()
                ->when($this->search, function ($query) {
                    $query->where('full_name', 'like', '%' . $this->search . '%')->orWhere('fla_no', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ];
    }
}; ?>

<div class="w-full">
    <div class="mb-8 w-full flex gap-2">
        <div class="w-120">
            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search lessees..." />
        </div>

        <flux:spacer />

        <flux:button icon="arrow-down-tray">Export</flux:button>
        <flux:button variant="primary" color="emerald" icon="plus" wire:click="resetForm"
            x-on:click="$flux.modal('lessee-modal').show()">Add new lessee</flux:button>
    </div>

    <flux:table :paginate="$lessees">
        <flux:table.columns>
            <flux:table.column sticky sortable :direction="$sortField === 'full_name' ? $sortDirection : null"
                wire:click="sortBy('full_name')">Lessee / FLA</flux:table.column>
            <flux:table.column>Location</flux:table.column>
            <flux:table.column>Hectares (Dev/Total)</flux:table.column>
            <flux:table.column sortable :direction="$sortField === 'date_expiration' ? $sortDirection : null"
                wire:click="sortBy('date_expiration')">Validity</flux:table.column>
            <flux:table.column class="w-px whitespace-nowrap">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($lessees as $lessee)
                <flux:table.row :key="$lessee->id">
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

                    <flux:table.cell>
                        <div class="flex flex-col">
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $lessee->municipality }}</span>
                            <span
                                class="text-[10px] text-zinc-400 uppercase tracking-widest">{{ $lessee->province }}</span>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            <span
                                class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $lessee->hec_developed }}</span>
                            <span class="text-zinc-400 text-xs">/</span>
                            <span class="text-zinc-500 text-xs">{{ $lessee->hec_granted }} ha</span>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-1.5 text-xs text-zinc-500">
                                <flux:icon.calendar-days variant="micro" class="size-3.5" />
                                <span>Issued: {{ $lessee->date_issued?->format('M d, Y') }}</span>
                            </div>
                            <div @class([
                                'flex items-center gap-1.5 text-xs font-medium',
                                'text-orange-600 dark:text-orange-400' =>
                                    $lessee->date_expiration?->isFuture() &&
                                    $lessee->date_expiration?->diffInMonths(now()) < 6,
                                'text-red-600 dark:text-red-400' => $lessee->date_expiration?->isPast(),
                                'text-zinc-400' =>
                                    !$lessee->date_expiration?->isPast() &&
                                    $lessee->date_expiration?->diffInMonths(now()) >= 6,
                            ])>
                                <flux:icon.calendar variant="micro" class="size-3.5" />
                                <span>Expires: {{ $lessee->date_expiration?->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            <flux:tooltip content="Send Message">
                                <flux:button icon="envelope" size="sm" variant="filled"
                                    wire:click="openMessageModal('{{ $lessee->id }}')" />
                            </flux:tooltip>

                            <flux:dropdown>
                                <flux:button icon="ellipsis-horizontal" size="sm" variant="filled" />

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
            @empty
                <flux:table.row class="[border-bottom:none] [&_td]:border-b-0">
                    <flux:table.cell colspan="5" class="py-16 text-center">
                        <div class="mx-auto flex max-w-sm flex-col items-center justify-center">
                            <div class="rounded-full bg-zinc-50 p-4 dark:bg-zinc-800/50">
                                <flux:icon name="users" class="size-8 text-zinc-400 dark:text-zinc-500"
                                    variant="outline" />
                            </div>
                            <h3 class="mt-4 text-sm font-semibold text-zinc-900 dark:text-white">
                                No lessees found
                            </h3>
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                There are currently no registered lessees in the system.
                            </p>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

    <flux:modal name="lessee-modal" class="md:w-[800px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editingLesseeId ? 'Edit Lessee' : 'Add New Lessee' }}</flux:heading>
                <flux:text class="mt-2">Fill in the details for the lessee record.</flux:text>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input label="Full Name" wire:model="full_name" placeholder="Juan Dela Cruz"
                    class="md:col-span-2" />
                <flux:input label="Email Address" type="email" wire:model="email" placeholder="juan@example.com" />
                <flux:input label="Contact Number" wire:model="contact_number" placeholder="09123456789" />
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
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel
                </flux:button>
                <flux:button type="submit" variant="primary" color="emerald">Save Lessee</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="message-modal" class="md:w-[500px]">
        <form wire:submit.prevent="sendNotification" class="space-y-6">
            <div>
                <flux:heading size="lg">Send Email</flux:heading>
                <flux:text class="mt-2">Send an official email notification regarding FLA status.</flux:text>
            </div>

            <flux:input label="Recipient Email" type="email" wire:model="messageEmail"
                placeholder="lessee@example.com" />

            <flux:input label="Subject" wire:model="messageSubject" />

            <div class="space-y-2">
                <flux:label>Notice Type</flux:label>
                <flux:dropdown class="w-full">
                    <button type="button"
                        class="w-full flex justify-between items-center text-left rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                        <span>{{ $noticeType }}</span>
                        <flux:icon.chevron-down variant="micro" class="text-zinc-400" />
                    </button>
                    <flux:menu class="min-w-[var(--trigger-width)]">
                        <flux:menu.radio.group wire:model.live="noticeType">
                            <flux:menu.radio value="Notice for Payment">Notice for Payment</flux:menu.radio>
                            <flux:menu.radio value="Notice for Renewal">Notice for Renewal</flux:menu.radio>
                            <flux:menu.radio value="Notice for Termination">Notice for Termination</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>
            </div>

            <flux:textarea label="Content" wire:model="messageContent" rows="6"
                placeholder="Type your message here..." />

            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel
                </flux:button>
                <flux:button type="submit" icon="paper-airplane" variant="primary" color="emerald">Send
                    Notification
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="delete-confirmation" class="md:w-[450px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Confirm Deletion</flux:heading>
                <flux:text class="mt-2 text-red-500">Warning: This action is permanent.</flux:text>
            </div>

            <flux:text>To confirm, please type the FLA NO: <span
                    class="font-bold text-zinc-800">{{ $expectedFlaNo }}</span></flux:text>

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
