<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <h2 class="text-xl font-bold text-gray-800 mb-2">F. Documentation and Authentication</h2>
    <flux:separator class="my-6" />

    <div class="flex flex-col gap-y-8" x-data="{ 
            showSlider: false, 
            currentIndex: 0, 
            images: [],
            handleFiles(event) {
                const files = Array.from(event.target.files);
                this.images = files.map(file => URL.createObjectURL(file));
            }
        }">

        <!-- Photo Section -->
        <div class="w-full grid grid-cols-2 gap-8">
            <div>
                <p class="text-sm font-medium text-zinc-700">Representative SitePhoto/s</p>
                <div class="mt-2 p-4 border-2 border-dashed border-zinc-200 rounded-lg bg-zinc-50">
                    <flux:input type="file" multiple accept="image/*" @change="handleFiles" />
                </div>
            </div>

            <div>
                <p class="text-sm font-medium text-zinc-700">Preview</p>
                <div class="flex flex-wrap gap-2 mt-2 p-2 border border-zinc-200 rounded-lg min-h-[80px] bg-white">
                    <template x-for="(img, index) in images" :key="index">
                        <img :src="img"
                            class="h-16 w-16 object-cover rounded border border-zinc-300 cursor-pointer hover:ring-2 hover:ring-zinc-400 transition-all"
                            @click="showSlider = true; currentIndex = index" />
                    </template>
                    <template x-if="images.length === 0">
                        <div class="flex items-center justify-center w-full h-16">
                            <span class="text-xs text-zinc-400 italic">No files selected</span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="w-1/2">
            <p class="text-sm font-medium text-zinc-700">Action Officer Signature</p>
            <div class="mt-2 border border-zinc-300 rounded-md bg-white overflow-hidden">
                <div class="h-48 w-full bg-white flex items-center justify-center text-zinc-300 italic text-sm">
                    Signature Area
                </div>
                <div class="flex justify-between items-center bg-zinc-50 border-t border-zinc-200 px-3 py-2">
                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold">Sign Above</span>
                    <button type="button" class="text-xs text-red-600 font-medium uppercase">Clear</button>
                </div>
            </div>
            <div class="mt-4">
                <flux:input label="Full Name (Printed)" placeholder="e.g. JUAN DELA CRUZ" />
            </div>
        </div>

        <div x-show="showSlider" x-transition.opacity x-cloak @keydown.window.escape="showSlider = false"
            class="fixed inset-0 z-[9999] bg-black/90 flex items-center justify-center p-4">

            <!-- Close Button -->
            <button @click="showSlider = false"
                class="absolute top-6 right-6 text-white hover:text-zinc-300 focus:outline-none z-[10000]">
                <flux:icon.x-mark class="w-10 h-10" />
            </button>

            <!-- Slider Controls -->
            <button x-show="images.length > 1"
                @click="currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1"
                class="absolute left-6 text-white p-3 hover:bg-white/10 rounded-full transition-colors">
                <flux:icon.chevron-left class="w-8 h-8" />
            </button>

            <!-- Main Image Container -->
            <div class="max-w-5xl max-h-[85vh] flex flex-col items-center">
                <img :src="images[currentIndex]" class="max-w-full max-h-full object-contain shadow-2xl rounded">
                <p class="text-white mt-6 bg-zinc-800 px-3 py-1 rounded-full text-xs font-mono">
                    IMAGE <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                </p>
            </div>

            <button x-show="images.length > 1"
                @click="currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0"
                class="absolute right-6 text-white p-3 hover:bg-white/10 rounded-full transition-colors">
                <flux:icon.chevron-right class="w-8 h-8" />
            </button>
        </div>
    </div>
</div>