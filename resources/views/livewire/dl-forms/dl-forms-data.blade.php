<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Form as FormModel;
use Illuminate\Support\Facades\File;
use Flux\Flux;

new class extends Component {
    use WithFileUploads, WithPagination;

    public string $search = '';
    public $name = '';
    public $type = '';
    public $file;

    public ?int $editingFormId = null;
    public string $renameInput = '';

    public ?int $confirmingDeleteId = null;
    public ?int $confirmingRenameId = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'file' => 'required|file|max:10240',
        ];
    }

    public function uploadDocument()
    {
        $this->validate();

        $extension = $this->file->getClientOriginalExtension();
        $safeFilename = time() . '_' . uniqid() . '.' . $extension;

        $this->file->storeAs('forms', $safeFilename, 'public');

        FormModel::create([
            'name' => $this->name,
            'type' => $this->type,
            'filename' => $safeFilename,
        ]);

        Flux::toast('Form uploaded successfully.', variant: 'success');
        $this->dispatch('modal-close', name: 'upload-modal');
        $this->reset(['name', 'type', 'file']);
    }

    public function startRename(int $id, string $currentName)
    {
        $this->editingFormId = $id;
        $this->renameInput = $currentName;
    }

    public function cancelRename()
    {
        $this->editingFormId = null;
        $this->renameInput = '';
    }

    public function triggerRenameConfirmation(int $id)
    {
        $this->validate(['renameInput' => 'required|string|max:255']);
        $this->confirmingRenameId = $id;
        $this->dispatch('modal-show', name: 'rename-confirmation-modal');
    }

    public function confirmRename()
    {
        $formRecord = FormModel::findOrFail($this->confirmingRenameId);
        $formRecord->update(['name' => $this->renameInput]);

        Flux::toast('Form renamed successfully.', variant: 'success');
        $this->dispatch('modal-close', name: 'rename-confirmation-modal');
        $this->reset(['editingFormId', 'renameInput', 'confirmingRenameId']);
    }

    public function download(int $id)
    {
        $formRecord = FormModel::findOrFail($id);
        $filePath = storage_path('app/public/forms/' . $formRecord->filename);

        if (!File::exists($filePath)) {
            Flux::toast('File could not be found in storage.', variant: 'danger');
            return;
        }

        return response()->download($filePath, $formRecord->name . '.' . File::extension($filePath));
    }

    public function triggerDelete(int $id)
    {
        $this->confirmingDeleteId = $id;
        $this->dispatch('modal-show', name: 'delete-confirmation-modal');
    }

    public function confirmDelete()
    {
        $formRecord = FormModel::findOrFail($this->confirmingDeleteId);
        $filePath = storage_path('app/public/forms/' . $formRecord->filename);

        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $formRecord->delete();

        Flux::toast('Form permanently deleted.', variant: 'success');
        $this->dispatch('modal-close', name: 'delete-confirmation-modal');
        $this->reset('confirmingDeleteId');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function with(): array
    {
        $query = FormModel::query();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')->orWhere('type', 'like', '%' . $this->search . '%');
            });
        }

        return [
            'forms' => $query->latest()->paginate(10),
        ];
    }
}; ?>

<div class="w-full">
    <div class="mb-8 w-full flex justify-between items-center gap-4">
        <div class="w-120">
            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Search forms..." />
        </div>
        <flux:spacer />
        <flux:button variant="primary" color="emerald" icon="arrow-up-tray" x-on:click="$flux.modal('upload-modal').show()">
            Upload Form
        </flux:button>
    </div>

    <flux:table :paginate="$forms">
        <flux:table.columns>
            <flux:table.column>Document Name</flux:table.column>
            <flux:table.column>Type</flux:table.column>
            <flux:table.column>Date Uploaded</flux:table.column>
            <flux:table.column class="w-px whitespace-nowrap text-right">Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($forms as $formItem)
                <flux:table.row :key="$formItem->id">
                    <flux:table.cell>
                        @if ($editingFormId === $formItem->id)
                            <div class="flex items-center gap-2 max-w-md px-2" wire:key="inline-edit-{{ $formItem->id }}">
                                <flux:input wire:model.defer="renameInput"
                                    wire:keydown.enter="triggerRenameConfirmation({{ $formItem->id }})"
                                    wire:keydown.escape="cancelRename" size="sm" class="flex-1" />
                                <flux:button size="sm" icon="check" variant="ghost" color="emerald"
                                    wire:click="triggerRenameConfirmation({{ $formItem->id }})" />
                                <flux:button size="sm" icon="x-mark" variant="ghost" wire:click="cancelRename" />
                            </div>
                        @else
                            <div class="flex items-center gap-2 group">
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $formItem->name }}</span>
                                <button
                                    wire:click="startRename({{ $formItem->id }}, '{{ addslashes($formItem->name) }}')"
                                    class="opacity-0 group-hover:opacity-100 transition-opacity text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                    <flux:icon.pencil-square variant="micro" class="size-4" />
                                </button>
                            </div>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        <span class="text-zinc-600 dark:text-zinc-400 text-sm font-medium">{{ $formItem->type }}</span>
                    </flux:table.cell>

                    <flux:table.cell>
                        <span
                            class="text-zinc-500 dark:text-zinc-400 text-xs">{{ $formItem->created_at->format('M d, Y h:i A') }}</span>
                    </flux:table.cell>

                    <flux:table.cell class="text-right flex items-center gap-2 justify-end">
                        <flux:button wire:click="download({{ $formItem->id }})" icon="arrow-down-tray" size="sm"
                            variant="ghost" tooltip="Download" />
                        <flux:button wire:click="triggerDelete({{ $formItem->id }})" icon="trash" size="sm"
                            variant="ghost" color="danger" tooltip="Delete" />
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row class="[border-bottom:none] [&_td]:border-b-0">
                    <flux:table.cell colspan="4" class="py-16 text-center">
                        <div class="mx-auto flex max-w-sm flex-col items-center justify-center">
                            <div class="rounded-full bg-zinc-50 p-4 dark:bg-zinc-800/50">
                                <flux:icon name="document-duplicate" class="size-8 text-zinc-400 dark:text-zinc-500"
                                    variant="outline" />
                            </div>
                            <h3 class="mt-4 text-sm font-semibold text-zinc-900 dark:text-white">
                                No documents uploaded
                            </h3>
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                There are currently no files or forms uploaded to this section.
                            </p>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

    <flux:modal name="upload-modal" class="md:w-[500px]">
        <form wire:submit.prevent="uploadDocument" class="space-y-6">
            <div>
                <flux:heading size="lg">Add New Payment</flux:heading>
                <flux:text class="mt-1">Add reference document templates to public/forms directory storage paths.
                </flux:text>
            </div>

            <div class="space-y-4">
                <flux:input label="Name" wire:model="name" placeholder="e.g., Fishpond Application Form" />
                <flux:input label="Type" wire:model="type" placeholder="e.g., Application, Clearance, Renewal" />

                <flux:field>
                    <flux:label>File Upload</flux:label>
                    <input id="file-upload-input" type="file" wire:model="file"
                        class="w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 dark:file:bg-zinc-800 dark:file:text-zinc-300" />
                    <div wire:loading wire:target="file" class="mt-1 text-xs text-blue-500 dark:text-blue-400">
                        Uploading file to server...
                    </div>
                    <flux:error name="file" />
                </flux:field>
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel</flux:button>
                <flux:button type="submit" variant="primary" color="emerald" wire:loading.attr="disabled"
                    wire:target="file">
                    <span wire:loading.remove wire:target="file">Upload Asset</span>
                    <span wire:loading wire:target="file">Processing Upload...</span>
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="rename-confirmation-modal" class="md:w-[400px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Confirm rename</flux:heading>
                <flux:text class="mt-2">Are you sure you want to alter the name details of this file catalog template?
                </flux:text>
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2"
                    wire:click="cancelRename">cancel</flux:button>
                <flux:button wire:click="confirmRename" variant="primary" color="emerald">confirm</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="delete-confirmation-modal" class="md:w-[400px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Confirm File Deletion</flux:heading>
                <flux:text class="mt-2 text-red-600 dark:text-red-400 font-medium">Warning: This operation will
                    permanently delete the template file from the server.</flux:text>
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:button x-on:click="$dispatch('modal-close')" variant="ghost" class="mr-2">Cancel
                </flux:button>
                <flux:button wire:click="confirmDelete" variant="danger">Confirm Delete</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
