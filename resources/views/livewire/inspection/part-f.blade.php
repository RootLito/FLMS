<?php

use Livewire\Volt\Component;
use App\Models\InspectionReport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{usesFileUploads};

usesFileUploads();

new class extends Component {
    public function saveInspection($officerName, $signatureData)
    {
        if (empty($officerName) || empty($signatureData)) {
            throw new \Exception('Officer name and signature are required.');
        }

        $report = InspectionReport::create([
            'inspecting_officer' => $officerName,
        ]);

        $base64Image = preg_replace('/^data:image\/\w+;base64,/', '', $signatureData);
        $decodedImage = base64_decode($base64Image);

        $uuid = (string) Str::uuid();
        $filename = "{$uuid}.png";
        
        $diskName = config('sign-pad.disk_name', 'local');
        $directory = config('sign-pad.signatures_path', 'signatures');
        $fullStoragePath = "{$directory}/{$filename}";

        Storage::disk($diskName)->put($fullStoragePath, $decodedImage);

        $report->signature()->create([
            'uuid' => $uuid,
            'filename' => $filename,
            'from_ips' => [request()->ip()],
            'certified' => config('sign-pad.certify_documents', false),
        ]);

        $this->dispatch('signature-saved');
        session()->flash('status', 'Inspection Report stored and e-signed successfully!');
    }
}; ?>

<div>
    <h2 class="text-xl font-bold text-gray-800 mb-2">F. Documentation and Authentication</h2>
    <flux:separator class="my-6" />

    @if (session()->has('status'))
    <div class="mb-4 p-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-md">
        {{ session('status') }}
    </div>
    @endif

    <div class="flex flex-col gap-y-8" x-data="{ showSlider: false, currentIndex: 0 }">
        <div class="w-full grid grid-cols-2 gap-8">

            <div class="flex flex-col gap-y-4">
                <div>
                    <p class="text-sm font-medium text-zinc-700">Action Officer Signature</p>

                    <div class="mt-2 border border-zinc-300 rounded-md bg-white overflow-hidden" x-data="{
                            isDrawing: false,
                            canvas: null,
                            ctx: null,
                            init() {
                                this.canvas = $refs.canvas;
                                this.ctx = this.canvas.getContext('2d');
                                this.resizeCanvas();
                                window.addEventListener('resize', () => this.resizeCanvas());
                                
                                this.ctx.strokeStyle = '#0f172a';
                                this.ctx.lineWidth = 2.5;
                                this.ctx.lineCap = 'round';

                                let existingSig = @js($this->formData['signature_data'] ?? '');
                                if (existingSig) {
                                    const img = new Image();
                                    img.onload = () => this.ctx.drawImage(img, 0, 0);
                                    img.src = existingSig;
                                }
                            },
                            resizeCanvas() {
                                const rect = this.canvas.parentElement.getBoundingClientRect();
                                this.canvas.width = rect.width;
                                this.canvas.height = 192;
                                this.ctx.strokeStyle = '#0f172a';
                                this.ctx.lineWidth = 2.5;
                                this.ctx.lineCap = 'round';
                                
                                let existingSig = @js($this->formData['signature_data'] ?? '');
                                if (existingSig) {
                                    const img = new Image();
                                    img.onload = () => this.ctx.drawImage(img, 0, 0);
                                    img.src = existingSig;
                                }
                            },
                            getMousePos(e) {
                                const rect = this.canvas.getBoundingClientRect();
                                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                                const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                                return {
                                    x: clientX - rect.left,
                                    y: clientY - rect.top
                                };
                            },
                            startDrawing(e) {
                                this.isDrawing = true;
                                const pos = this.getMousePos(e);
                                this.ctx.beginPath();
                                this.ctx.moveTo(pos.x, pos.y);
                            },
                            draw(e) {
                                if (!this.isDrawing) return;
                                e.preventDefault();
                                const pos = this.getMousePos(e);
                                this.ctx.lineTo(pos.x, pos.y);
                                this.ctx.stroke();
                            },
                            stopDrawing() {
                                if (!this.isDrawing) return;
                                this.isDrawing = false;
                                @this.set('formData.signature_data', this.canvas.toDataURL());
                            },
                            clearCanvas() {
                                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                                @this.set('formData.signature_data', '');
                            }
                         }" @signature-saved.window="clearCanvas()">

                        <div class="h-48 w-full bg-white relative">
                            <canvas x-ref="canvas" @mousedown="startDrawing($event)" @mousemove="draw($event)"
                                @mouseup="stopDrawing()" @mouseleave="stopDrawing()" @touchstart="startDrawing($event)"
                                @touchmove="draw($event)" @touchend="stopDrawing()"
                                class="absolute inset-0 w-full h-full cursor-crosshair touch-none">
                            </canvas>
                        </div>

                        <div class="flex justify-between items-center bg-zinc-50 border-t border-zinc-200 px-3 py-2">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold">Sign Above</span>
                            <button type="button" @click="clearCanvas()"
                                class="text-xs text-red-600 font-medium uppercase hover:text-red-800">Clear</button>
                        </div>
                    </div>
                </div>

                <div>
                    <flux:input wire:model="formData.officer_name" label="Full Name (Printed)"
                        placeholder="e.g. JUAN DELA CRUZ" />
                </div>
            </div>

            <div class="flex flex-col gap-y-4">
                <div>
                    <p class="text-sm font-medium text-zinc-700">Representative Site Photo/s</p>
                    <div class="mt-2 p-4 border-2 border-dashed border-zinc-200 rounded-lg bg-zinc-50">
                        <flux:input type="file" multiple accept="image/*" wire:model="formData.site_photos" />
                        <div wire:loading wire:target="formData.site_photos" class="text-xs text-zinc-500 mt-1">
                            Uploading site images...
                        </div>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-medium text-zinc-700">Preview</p>
                    <div class="flex flex-wrap gap-2 mt-2 p-2 border border-zinc-200 rounded-lg min-h-[80px] bg-white">
                        @if(!empty($formData['site_photos']))
                        @foreach($formData['site_photos'] as $index => $file)
                        <?php
                            try {
                                $url = $file->temporaryUrl();
                            } catch (\Exception $e) {
                                $url = null;
                            }
                        ?>

                        @if($url)
                        <img src="{{ $url }}"
                            class="h-16 w-16 object-cover rounded border border-zinc-300 cursor-pointer hover:ring-2 hover:ring-zinc-400 transition-all"
                            @click="showSlider = true; currentIndex = {{ $index }}" />
                        @endif
                        @endforeach
                        @else
                        <div class="flex items-center justify-center w-full h-16">
                            <span class="text-xs text-zinc-400 italic">No files selected</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div x-show="showSlider" x-transition.opacity x-cloak @keydown.window.escape="showSlider = false"
            class="fixed inset-0 z-[9999] bg-black/90 flex items-center justify-center p-4">

            <button @click="showSlider = false" class="absolute top-6 right-6 text-white hover:text-zinc-300 z-[10000]">
                <flux:icon.x-mark class="w-10 h-10" />
            </button>

            <button
                @click="currentIndex = (currentIndex > 0) ? currentIndex - 1 : {{ count($formData['site_photos'] ?? []) }} - 1"
                class="absolute left-6 text-white p-3 hover:bg-white/10 rounded-full transition-colors">
                <flux:icon.chevron-left class="w-8 h-8" />
            </button>

            <div class="max-w-5xl max-h-[85vh] flex flex-col items-center">
                @if(!empty($formData['site_photos']))
                @foreach($formData['site_photos'] as $index => $file)
                <?php
                    try {
                        $url = $file->temporaryUrl();
                    } catch (\Exception $e) {
                        $url = null;
                    }
                ?>

                @if($url)
                <img x-show="currentIndex === {{ $index }}" src="{{ $url }}"
                    class="max-w-full max-h-full object-contain shadow-2xl rounded">
                @endif
                @endforeach
                @endif
                <p class="text-white mt-6 bg-zinc-800 px-3 py-1 rounded-full text-xs font-mono">
                    IMAGE <span x-text="currentIndex + 1"></span> / <span>{{ count($formData['site_photos'] ?? [])
                        }}</span>
                </p>
            </div>

            <button
                @click="currentIndex = (currentIndex < {{ count($formData['site_photos'] ?? []) }} - 1) ? currentIndex + 1 : 0"
                class="absolute right-6 text-white p-3 hover:bg-white/10 rounded-full transition-colors">
                <flux:icon.chevron-right class="w-8 h-8" />
            </button>
        </div>
    </div>
</div>