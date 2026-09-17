<div class="space-y-6" x-data="{ showSlider: false, currentIndex: 0 }">
    <h2 class="text-xl font-bold text-gray-800 mb-2">F. Documentation and Authentication</h2>
    <flux:separator class="my-6" />

    <div class="flex flex-col gap-y-8">
        <div class="w-full grid grid-cols-2 gap-8">
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
                    <div class="flex flex-wrap gap-3 mt-2 p-3 border border-zinc-200 rounded-lg min-h-[90px] bg-white">

                        {{-- 1. EXISTING PHOTOS FROM DATABASE --}}
                        @if (!empty($existingPhotos))
                            @foreach ($existingPhotos as $index => $photoPath)
                                <div class="relative group">
                                    <img src="{{ Storage::url($photoPath) }}"
                                        class="h-16 w-16 object-cover rounded border border-zinc-300 cursor-pointer hover:ring-2 hover:ring-zinc-400 transition-all"
                                        @click="showSlider = true; currentIndex = {{ $index }}" />

                                    {{-- Remove Button for Existing Photo --}}
                                    <button type="button" wire:click="removeExistingPhoto({{ $index }})"
                                        class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-1 shadow-md hover:bg-red-700 focus:outline-none w-5 h-5 flex items-center justify-center text-xs">
                                        &times;
                                    </button>
                                </div>
                            @endforeach
                        @endif

                        {{-- 2. NEWLY UPLOADED TEMPORARY PHOTOS --}}
                        @if (!empty($formData['site_photos']))
                            @foreach ($formData['site_photos'] as $newIndex => $file)
                                @php
                                    try {
                                        $url = $file->temporaryUrl();
                                    } catch (\Exception $e) {
                                        $url = null;
                                    }
                                    $totalExisting = count($existingPhotos ?? []);
                                    $currentIndexComputed = $totalExisting + $newIndex;
                                @endphp
                                @if ($url)
                                    <div class="relative group">
                                        <img src="{{ $url }}"
                                            class="h-16 w-16 object-cover rounded border border-zinc-300 cursor-pointer hover:ring-2 hover:ring-zinc-400 transition-all"
                                            @click="showSlider = true; currentIndex = {{ $currentIndexComputed }}" />

                                        {{-- Remove Button for New Photo --}}
                                        <button type="button" wire:click="removePhoto({{ $newIndex }})"
                                            class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-1 shadow-md hover:bg-red-700 focus:outline-none w-5 h-5 flex items-center justify-center text-xs">
                                            &times;
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        @endif

                        {{-- EMPTY STATE --}}
                        @if (empty($existingPhotos) && empty($formData['site_photos']))
                            <div class="flex items-center justify-center w-full h-16">
                                <span class="text-xs text-zinc-400 italic">No files selected</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

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
                    
                            let existingSig = @js($formData['signature_data'] ?? '');
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
                    
                            let existingSig = @js($formData['signature_data'] ?? '');
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
                    }"
                        @signature-saved.window="clearCanvas()">

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

                <div>
                    <flux:input wire:model="formData.designation" label="Designation" />
                </div>
            </div>
        </div>
    </div>
</div>
