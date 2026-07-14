<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Payment;
use App\Models\Lessee;
use Flux\Flux;

new class extends Component {
    use WithPagination;

    public string $search = '';
    public string $startDate = '';
    public string $endDate = '';
    public string $sortField = 'date';
    public string $sortDirection = 'desc';

    public ?int $editingPaymentId = null;
    public string $expectedInvoiceId = '';
    public string $invoiceConfirmationInput = '';

    public ?int $lessee_id = null;
    public string $date = '';
    public string $amount = '';
    public string $payment_method = '';
    public string $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
    ];

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedStartDate()
    {
        $this->resetPage();
    }
    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetForm()
    {
        $this->editingPaymentId = null;
        $this->lessee_id = null;
        $this->date = now()->format('Y-m-d');
        $this->amount = '';
        $this->payment_method = '';
        $this->status = '';
        $this->resetErrorBag();
    }

    public function edit(int $id)
    {
        $this->resetForm();
        $this->editingPaymentId = $id;

        $payment = Payment::findOrFail($id);
        $this->lessee_id = $payment->lessee_id;
        $this->date = $payment->date->format('Y-m-d');
        $this->amount = (string) $payment->amount;
        $this->payment_method = $payment->payment_method;
        $this->status = $payment->status;

        $this->dispatch('modal-show', name: 'payment-modal');
    }

    public function save()
    {
        $rules = [
            'lessee_id' => 'required|exists:lessees,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'status' => 'required|string|in:FB Messenger,In person',
        ];

        $validated = $this->validate($rules);

        if ($this->editingPaymentId) {
            Payment::findOrFail($this->editingPaymentId)->update($validated);
            Flux::toast('Payment modified successfully.', variant: 'success');
        } else {
            Payment::create($validated);
            Flux::toast('Payment recorded successfully.', variant: 'success');
        }

        $this->dispatch('modal-close', name: 'payment-modal');
        $this->resetForm();
    }

    public function confirmDelete(int $id)
    {
        $payment = Payment::findOrFail($id);
        $this->editingPaymentId = $id;
        $this->expectedInvoiceId = $payment->invoice_id;
        $this->invoiceConfirmationInput = '';

        $this->dispatch('modal-show', name: 'delete-confirmation');
    }

    public function delete()
    {
        if ($this->invoiceConfirmationInput !== $this->expectedInvoiceId) {
            return;
        }

        Payment::destroy($this->editingPaymentId);
        Flux::toast('Payment record permanently deleted.', variant: 'danger');
        $this->dispatch('modal-close', name: 'delete-confirmation');
        $this->resetForm();
    }

    public function with(): array
    {
        $query = Payment::with('lessee');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->whereHas('lessee', function ($lq) {
                    $lq->where('full_name', 'like', '%' . $this->search . '%');
                })->orWhere('invoice_id', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->startDate)) {
            $query->whereDate('date', '>=', $this->startDate);
        }
        if (!empty($this->endDate)) {
            $query->whereDate('date', '<=', $this->endDate);
        }

        if ($this->sortField === 'full_name') {
            $query->join('lessees', 'payments.lessee_id', '=', 'lessees.id')->orderBy('lessees.full_name', $this->sortDirection)->select('payments.*');
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return [
            'payments' => $query->paginate(10),
            'lessees' => Lessee::orderBy('full_name')->get(),
        ];
    }
}; ?>

<div class="w-full">
    <div class="mb-8 w-full flex gap-4 ">
        <div class="flex flex-1 flex-wrap items-center gap-3 w-full">
            <div class="w-120">
                <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                    placeholder="Search name or Invoice ID..." />
            </div>

            <div class="flex items-center gap-2">
                <flux:input type="date" wire:model.live="startDate" />
            </div>

            <div class="flex items-center gap-2">
                <flux:input type="date" wire:model.live="endDate" />
            </div>
        </div>

        <div class="flex items-center gap-2">
            <flux:button icon="arrow-down-tray">Export</flux:button>
            <flux:button variant="primary" color="emerald" icon="plus" wire:click="resetForm"
                x-on:click="$flux.modal('payment-modal').show()">Add new payment</flux:button>
        </div>
    </div>

    <flux:table :paginate="$payments">
        <flux:table.columns>
            <flux:table.column sticky sortable :direction="$sortField === 'invoice_id' ? $sortDirection : null"
                wire:click="sortBy('invoice_id')">Invoice ID</flux:table.column>
            <flux:table.column sortable :direction="$sortField === 'full_name' ? $sortDirection : null"
                wire:click="sortBy('full_name')">Name / FLA</flux:table.column>
            <flux:table.column sortable :direction="$sortField === 'date' ? $sortDirection : null"
                wire:click="sortBy('date')">Date Paid</flux:table.column>
            <flux:table.column sortable :direction="$sortField === 'amount' ? $sortDirection : null"
                wire:click="sortBy('amount')">Amount</flux:table.column>
            <flux:table.column>Payment Method</flux:table.column>
            <flux:table.column sortable :direction="$sortField === 'status' ? $sortDirection : null"
                wire:click="sortBy('status')">Verification</flux:table.column>
            <flux:table.column class="w-px whitespace-nowrap">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($payments as $payment)
                <flux:table.row :key="$payment->id">
                    <flux:table.cell sticky>
                        <span class="font-mono font-bold text-zinc-900 dark:text-zinc-100">
                            {{ $payment->invoice_id }}
                        </span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex flex-col">
                            <span class="font-semibold text-zinc-800 dark:text-white leading-tight">
                                {{ $payment->lessee->full_name }}
                            </span>
                            <span class="text-xs text-zinc-400 font-mono">
                                {{ $payment->lessee->fla_no }}
                            </span>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="text-zinc-700 dark:text-zinc-300">
                            {{ $payment->date->format('l, M d, Y h:i:s A') }}
                        </span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="font-semibold text-zinc-700 dark:text-zinc-100">
                            ₱{{ number_format($payment->amount, 2) }}
                        </span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="text-zinc-600 dark:text-zinc-400 text-sm">
                            {{ $payment->payment_method }}
                        </span>
                    </flux:table.cell>

                    <flux:table.cell>
                        @if ($payment->status === 'FB Messenger')
                            <flux:badge color="sky">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-4 shrink-0 mr-1.5">
                                    <path
                                        d="M12 2C6.36 2 2 6.13 2 11.7c0 2.9 1.17 5.57 3.12 7.48.16.15.25.37.24.6l-.08 2.22c-.02.43.4.77.8.61l2.43-1c.18-.07.38-.08.57-.02 1-.32 1.9-.49 2.92-.49 5.64 0 10-4.13 10-9.7C22 6.13 17.64 2 12 2zm1.2 12.63l-2.3-2.45-4.5 2.45 4.9-5.2 2.3 2.45 4.5-2.45-4.9 5.2z" />
                                </svg>
                                {{ $payment->status }}
                            </flux:badge>
                        @elseif ($payment->status === 'In person')
                            <flux:badge color="emerald" icon="users">
                                {{ $payment->status }}
                            </flux:badge>
                        @else
                            <flux:badge color="zinc">
                                {{ $payment->status }}
                            </flux:badge>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex items-center gap-1">
                            <flux:button icon="pencil-square" size="sm" variant="filled"
                                wire:click="edit({{ $payment->id }})"
                                class="text-sky-500 hover:text-sky-600 dark:text-sky-400 dark:hover:text-sky-300" />

                            <flux:button icon="trash" size="sm" variant="filled"
                                wire:click="confirmDelete({{ $payment->id }})"
                                class="text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300">
                            </flux:button>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:modal name="payment-modal" class="md:w-[600px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editingPaymentId ? 'Modify Payment Record' : 'Add New Payment' }}
                </flux:heading>
                <flux:text class="mt-2">Provide financial processing details for this fishpond lease agreement ledger.
                </flux:text>
            </div>

            <div class="space-y-4">
                <flux:field>
                    <flux:label>Assign Lessee Record</flux:label>
                    <flux:dropdown>
                        <flux:button class="w-full">
                            <div class="flex items-center justify-between w-full">
                                <span>{{ $lessee_id ? $lessees->firstWhere('id', $lessee_id)?->full_name ?? 'Choose a lessee profile...' : 'Choose a lessee profile...' }}</span>
                                <flux:icon.chevron-down class="size-4 text-zinc-400" />
                            </div>
                        </flux:button>
                        <flux:menu class="max-h-60 overflow-y-auto">
                            @foreach ($lessees as $lessee)
                                <flux:menu.item wire:click="$set('lessee_id', {{ $lessee->id }})">
                                    {{ $lessee->full_name }} ({{ $lessee->fla_no }})
                                </flux:menu.item>
                            @endforeach
                        </flux:menu>
                    </flux:dropdown>
                    <flux:error name="lessee_id" />
                </flux:field>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input label="Payment Date" type="date" wire:model="date" />
                    <flux:input label="Payment Amount" type="number" step="0.01" wire:model="amount"
                        placeholder="0.00" icon="banknotes" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label>Payment Method</flux:label>
                        <flux:dropdown>
                            <flux:button class="w-full">
                                <div class="flex items-center justify-between w-full">
                                    <span>{{ $payment_method ?: 'Select channel...' }}</span>
                                    <flux:icon.chevron-down class="size-4 text-zinc-400" />
                                </div>
                            </flux:button>
                            <flux:menu>
                                <flux:menu.item wire:click="$set('payment_method', 'Cash Payment')">Cash Payment
                                </flux:menu.item>
                                <flux:menu.item wire:click="$set('payment_method', 'GCash E-wallet')">GCash E-wallet
                                </flux:menu.item>
                                <flux:menu.item wire:click="$set('payment_method', 'LBP LinkBiz Portal')">LBP LinkBiz
                                    Portal</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                        <flux:error name="payment_method" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Verify</flux:label>
                        <flux:dropdown>
                            <flux:button class="w-full">
                                <div class="flex items-center justify-between w-full">
                                    <span>{{ $status ?: 'Select verification route...' }}</span>
                                    <flux:icon.chevron-down class="size-4 text-zinc-400" />
                                </div>
                            </flux:button>
                            <flux:menu>
                                <flux:menu.item wire:click="$set('status', 'FB Messenger')">FB Messenger
                                </flux:menu.item>
                                <flux:menu.item wire:click="$set('status', 'In person')">In person</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                        <flux:error name="status" />
                    </flux:field>
                </div>
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel</flux:button>
                <flux:button type="submit" variant="primary" color="emerald">Commit Record</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="delete-confirmation" class="md:w-[450px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Confirm Payment Deletion</flux:heading>
                <flux:text class="mt-2 text-red-600 dark:text-red-400 font-medium">Critical Warning: This payment
                    record
                    will be permanently wiped.</flux:text>
            </div>

            <flux:text>To securely complete this destruction operation, type the target Invoice ID confirmation string:
                <span
                    class="font-mono font-bold text-zinc-900 dark:text-white bg-zinc-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">{{ $expectedInvoiceId }}</span>
            </flux:text>

            <flux:input wire:model.live="invoiceConfirmationInput"
                placeholder="Type Invoice ID pattern to authorize deletion" />

            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel
                </flux:button>
                <flux:button wire:click="delete" variant="danger"
                    :disabled="$invoiceConfirmationInput !== $expectedInvoiceId">
                    Permanent Delete
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
