<?php

use Livewire\Volt\Component;

new class extends Component {
}; ?>

<div class="">
    <h2 class="text-lg font-semibold text-zinc-800"> A. Kind and Extent of Improvements</h2>
    <flux:separator class="my-6" />
    <div class="grid grid-cols-12 gap-3 text-sm  text-zinc-600 px-1 my-6 uppercase font-bold">
        <div class="col-span-6">Kind and Extent of Improvements</div>
        <div class="col-span-3">Date Introduced</div>
        <div class="col-span-3">Value/Cost (Php)</div>
    </div>
    <p class="text-sm font-medium text-zinc-700 mb-2">1. Clearings</p>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6 space-y-2">
            <flux:input placeholder="Area Cleared (has.)" size="sm" />
            <flux:input placeholder="Main dike (lineal meters)" size="sm" />
            <flux:input placeholder="Secondary dike (lineal meters)" size="sm" />
        </div>
        <div class="col-span-3 space-y-2">
            <flux:input type="date" size="sm" />
            <flux:input type="date" size="sm" />
            <flux:input type="date" size="sm" />
        </div>
        <div class="col-span-3 space-y-2">
            <flux:input placeholder="₱ 0.00" size="sm" />
            <flux:input placeholder="₱ 0.00" size="sm" />
            <flux:input placeholder="₱ 0.00" size="sm" />
        </div>
    </div>


    <p class="text-sm font-medium text-zinc-700 mb-2">2. Excavation</p>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6">
            <flux:input placeholder="(cubic meters)" size="sm" />
        </div>
        <div class="col-span-3">
            <flux:input type="date" size="sm" />
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" />
        </div>
    </div>


    <p class="text-sm font-medium text-zinc-700 mb-2">3. Gates</p>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6 space-y-2">
            <flux:input placeholder="Concrete (number)" size="sm" />
            <flux:input placeholder="Wooden (number)" size="sm" />
        </div>
        <div class="col-span-3 space-y-2">
            <flux:input type="date" size="sm" />
            <flux:input type="date" size="sm" />
        </div>
        <div class="col-span-3 space-y-2">
            <flux:input placeholder="₱ 0.00" size="sm" />
            <flux:input placeholder="₱ 0.00" size="sm" />
        </div>
    </div>


    <p class="text-sm font-medium text-zinc-700 mb-2">4. House, etc.</p>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6 space-y-2">
            <flux:input size="sm" placeholder="Description" />
        </div>
        <div class="col-span-3">
            <flux:input type="date" size="sm" />
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" />
        </div>
    </div>

    <p class="text-sm font-medium text-zinc-700 mb-2">5. Equipment, etc.</p>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6 space-y-2">
            <flux:input size="sm" placeholder="Description" />
        </div>
        <div class="col-span-3">
            <flux:input type="date" size="sm" />
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" />
        </div>
    </div>


    <div class="grid grid-cols-12 gap-3 items-start mb-2">
        <p class="text-sm font-medium text-zinc-700 mb-2 col-span-6">6. Assessed Value</p>
        <div class="col-span-3">
            <p class="text-sm text-zinc-700 font-black  text-end">TOTAL VALUE</p>
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" />
        </div>
    </div>

    <div class="grid grid-cols-12 gap-3 items-start mb-2">
        <div class="col-span-6"></div>
        <div class="col-span-3">
            <p class="text-sm text-zinc-700 text-end">Actual Appraisal</p>
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" />
        </div>
    </div>
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <div class="col-span-6"></div>
        <div class="col-span-3">
            <p class="text-sm text-zinc-700 text-end">Under Tax Declaration</p>
        </div>
        <div class="col-span-3">
            <flux:input placeholder="₱ 0.00" size="sm" />
        </div>
    </div>



    <!-- 7. Permanent Personnel -->
    <div class="grid grid-cols-12 gap-3 items-center mb-3">
        <div class="col-span-6">
            <p class="text-sm font-medium text-zinc-700">7. Permanent Personnel/Workers Employed</p>
            {{-- <p class="text-xs text-zinc-500">Attach proof of SSS</p> --}}
        </div>
        <div class="col-span-6">
            <flux:input size="sm" placeholder="(number)" />
        </div>
    </div>

    <!-- Attachment & Slider Logic (Under 7) -->
    <div x-data="{ 
        showSlider: false, 
        currentIndex: 0, 
        images: [],
        handleFiles(event) {
            const files = Array.from(event.target.files);
            this.images = files.map(file => URL.createObjectURL(file));
        }
    }" class="mb-6">
        <!-- Attachment Row (6/6) -->
        <div class="grid grid-cols-12 gap-3 items-start">
            <div class="col-span-6">
                <p class="text-xs font-semibold text-red-500 mb-1 uppercase tracking-wider">Attach Proof of SSS
                    Contribution/Remittances (Required)</p>
                <flux:input type="file" size="sm" multiple accept="image/*" @change="handleFiles" />
            </div>
            <div class="col-span-6">
                <p class="text-xs font-semibold text-zinc-500 mb-1 uppercase tracking-wider">Preview</p>
                <div class="flex flex-wrap gap-2">
                    <template x-for="(img, index) in images" :key="index">
                        <img :src="img"
                            class="h-10 w-10 object-cover rounded border border-zinc-300 cursor-pointer hover:ring-2 hover:ring-zinc-400 transition-all"
                            @click="showSlider = true; currentIndex = index" />
                    </template>
                    <template x-if="images.length === 0">
                        <span class="text-xs text-zinc-400 italic">No files selected</span>
                    </template>
                </div>
            </div>
        </div>

        <!-- Fullscreen Slider Overlay -->
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


    <!-- 8. Non-Permanent Personnel -->
    <div class="grid grid-cols-12 gap-3 items-center mb-2">
        <div class="col-span-6">
            <p class="text-sm font-medium text-zinc-700">8. No. of Non-Permanent Personnel/Workers Employed:</p>
        </div>
        <div class="col-span-6">
            <flux:input size="sm" placeholder="(number)" />
        </div>
    </div>

    <!-- 9. Registered in FishR -->
    <div class="grid grid-cols-12 gap-3 items-center ">
        <div class="col-span-6">
            <p class="text-sm font-medium text-zinc-700">9. No. of Personnel/Workers Registered in (FishR): </p>
        </div>
        <div class="col-span-6">
            <flux:input size="sm" placeholder="(number)" />
        </div>
    </div>
</div>