@props(['formData', 'lessees'])

<div class="space-y-6" wire:key="c-documentation-root">
    <h2 class="text-lg font-bold text-zinc-800">C. Documentation and Authentication</h2>
    <flux:separator />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

        <div class="flex flex-col gap-y-4 w-full">
            <div>
                <flux:textarea label="Remarks" wire:model="formData.remarks"
                    placeholder="Enter any observations or additional notes..." rows="4" class="shadow-sm" />
            </div>

            <div>
                <p class="text-sm font-medium text-zinc-700">Representative Site Photo/s</p>
                <div class="mt-2 p-4 border-dashed border-zinc-200 bg-zinc-50 shadow-sm rounded">
                    <flux:input type="file" multiple accept="image/*" wire:model="formData.site_photos"/>
                    <div wire:loading wire:target="formData.site_photos" class="text-xs text-zinc-500 mt-1">
                        Uploading site images...
                    </div>
                </div>
            </div>

            <div>
                <p class="text-sm font-medium text-zinc-700">Preview</p>
                <div
                    class="flex flex-wrap gap-2 mt-2 p-2 border border-zinc-200 rounded-lg min-h-[80px] bg-white shadow-sm">
                    @if (!empty($formData['site_photos']))
                        <div class="grid grid-cols-4 gap-2 w-full">
                            @foreach ($formData['site_photos'] as $index => $file)
                                @php
                                    try {
                                        $url = $file->temporaryUrl();
                                    } catch (\Exception $e) {
                                        $url = null;
                                    }
                                @endphp

                                @if ($url)
                                    <div class="relative group h-16 w-16">
                                        <img src="{{ $url }}"
                                            class="h-full w-full object-cover rounded border border-zinc-300 shadow-sm" />
                                        <button type="button" wire:click="removePhoto({{ $index }})"
                                            class="absolute -top-1 -right-1 bg-red-600 text-white rounded-full p-0.5 shadow hover:bg-red-700 transition-colors">
                                            <flux:icon.x-mark class="w-3 h-3" />
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center justify-center w-full h-16">
                            <span class="text-xs text-zinc-400 italic">No files selected</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-y-4 w-full">
            <div>
                <p class="text-sm font-medium text-zinc-700">Lessee Signature Authentication</p>

                <div class="mt-2 border border-zinc-300 rounded-md bg-white overflow-hidden shadow-sm"
                    x-data="{
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
                <label class="block text-sm font-medium text-zinc-700 mb-2">Full Name (Printed)</label>
                <div
                    class="w-full bg-zinc-50 border border-zinc-200 rounded py-2 px-3 text-zinc-800 font-semibold shadow-sm select-none uppercase tracking-wide text-sm">
                    {{ collect($lessees)->firstWhere('id', $formData['lessee_id'])['full_name'] ?? 'No Lessee Selected' }}
                </div>
            </div>
        </div>

    </div>
</div>
