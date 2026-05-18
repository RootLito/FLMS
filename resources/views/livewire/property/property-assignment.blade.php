<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Lessee;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $selectedLesseeId = null;

    public function with(): array
    {
        $key = env('MAPTILER_API_KEY');
        $rawUrl = env('MAPTILER_URL');
        $tileUrl = str_replace('{key}', $key, $rawUrl);

        return [
            'tileUrl' => $tileUrl,
            'lessees' => Lessee::where('full_name', 'like', "%{$this->search}%")
                ->with('fishpondMap')
                ->paginate(10),
        ];
    }

    public function selectLessee($id)
    {
        $this->selectedLesseeId = $id;

        $selected = Lessee::with('fishpondMap')->find($id);
        $this->dispatch('lessee-selected', $selected?->fishpondMap?->coordinates ?? []);
    }

    public function getSelectedLesseeProperty()
    {
        return $this->selectedLesseeId 
            ? Lessee::with('fishpondMap')->find($this->selectedLesseeId) 
            : null;
    }

    public function saveMap($coordinates)
    {
        if (!$this->selectedLesseeId) return;

        $lessee = Lessee::find($this->selectedLesseeId);
        $lessee->fishpondMap()->updateOrCreate(
            ['lessee_id' => $this->selectedLesseeId],
            ['coordinates' => $coordinates]
        );

        $this->dispatch('map-saved');
    }
}; ?>

<div class="flex-1 flex flex-col h-screen overflow-hidden" x-data="{ selectedId: @entangle('selectedLesseeId') }">
    <div class="mb-8 w-full flex gap-2 items-center">
        <div class="w-150">
            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search lessees..." />
        </div>
        <flux:spacer />
        @php $selected = $this->selectedLessee; @endphp

        <flux:modal.trigger name="draw-map-modal">
            <flux:button variant="primary" icon="pencil-square" :disabled="!$selectedLesseeId">
                {{ $selected?->fishpondMap ? 'Update Area' : 'Draw Area' }}
            </flux:button>
        </flux:modal.trigger>
    </div>

    <div class="w-full flex-1 flex gap-4 min-h-0">
        <div class="w-150 rounded-xl overflow-y-auto bg-white dark:bg-neutral-900">
            <div class="space-y-2">
                @foreach ($lessees as $lessee)
                <div wire:click="selectLessee({{ $lessee->id }})"
                    @class([ 'p-4 rounded-xl cursor-pointer transition-all duration-200 border-2 relative overflow-hidden'
                    , 'bg-blue-50/50 border-blue-500 ring-1 ring-blue-200 dark:bg-blue-900/10 dark:ring-blue-800'=>
                    $selectedLesseeId == $lessee->id,
                    'bg-white border-neutral-100 hover:border-blue-300 dark:bg-neutral-800 dark:border-neutral-700' =>
                    $selectedLesseeId != $lessee->id,
                    ])>

                    @if($selectedLesseeId == $lessee->id)
                    <div class="absolute top-0 right-0">
                        <div
                            class="bg-blue-500 text-white text-[10px] px-2 py-0.5 rounded-bl-lg font-bold uppercase tracking-wider">
                            Selected
                        </div>
                    </div>
                    @endif

                    <div class="flex items-start gap-3">
                        <div @class([ 'flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold'
                            , 'bg-blue-500 text-white'=> $selectedLesseeId == $lessee->id,
                            'bg-neutral-100 text-neutral-500 dark:bg-neutral-700' => $selectedLesseeId != $lessee->id,
                            ])>
                            {{ substr($lessee->full_name, 0, 1) }}
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-neutral-900 dark:text-white truncate">
                                    {{ $lessee->full_name }}
                                </h3>
                            </div>

                            <div class="grid grid-cols-2 gap-2 mt-3 text-xs">
                                <div class="flex flex-col">
                                    <span
                                        class="text-neutral-400 dark:text-neutral-500 uppercase tracking-tight font-semibold"
                                        style="font-size: 0.65rem;">FLA Number</span>
                                    <span class="text-neutral-700 dark:text-neutral-300 font-mono">{{ $lessee->fla_no
                                        }}</span>
                                </div>

                                <div class="flex flex-col items-end">
                                    <span
                                        class="text-neutral-400 dark:text-neutral-500 uppercase tracking-tight font-semibold"
                                        style="font-size: 0.65rem;">Mapping Status</span>
                                    <div>
                                        @if($lessee->fishpondMap)
                                        <span
                                            class="flex items-center gap-1 text-green-600 dark:text-green-400 font-medium">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Mapped
                                        </span>
                                        @else
                                        <span class="text-neutral-400 italic">Unmapped</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="p-4">{{ $lessees->links() }}</div>
        </div>

        <div
            class="flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 relative overflow-hidden">
            @if($selected)
            <div
                class="p-4 bg-white/90 dark:bg-neutral-900/90 absolute top-4 right-4 z-[1000] rounded-lg shadow border border-neutral-200 dark:border-neutral-700">
                <h3 class="font-bold">{{ $selected->full_name }}</h3>
                <p class="text-xs">{{ $selected->barangay }}, {{ $selected->municipality }}</p>
            </div>
            <div id="display-map" class="w-full h-full z-0" wire:ignore x-data="displayMap"
                x-init="initMap(@js($selected->fishpondMap?->coordinates))"></div>
            @else
            <div class="flex items-center justify-center h-full text-neutral-400">Select a lessee to view map</div>
            @endif
        </div>
    </div>

    <flux:modal name="draw-map-modal" class="fixed inset-0! max-w-[900px]! h-screen! w-screen! p-0!" x-data="editorMap" x-init="init()">
        <div class="flex flex-col h-full">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <flux:heading size="lg">Draw Area: {{ $selected?->full_name }}</flux:heading>
                <flux:subheading>Use the search icon on the map to find a location, then draw the boundary.
                </flux:subheading>
            </div>

            <div id="editor-canvas" class="h-full min-h-0 w-full bg-zinc-100 dark:bg-zinc-900 relative" wire:ignore>
            </div>

            <div class="p-6 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button variant="primary" x-on:click="save">Save Changes</flux:button>
            </div>
        </div>
    </flux:modal>
</div>

@script
<script>
    const TILER_URL = @js($tileUrl);

    Alpine.data('editorMap', () => ({
        map: null,
        activeLayer: null,

        init() {
            window.addEventListener('modal-show', (event) => {
                if (event.detail?.name === 'draw-map-modal') {
                    this.setupEditor();
                }
            });
        },

        setupEditor() {
            if (this.map) {
                this.map.remove();
            }

            // Wait for modal to be fully rendered and sized
            setTimeout(() => {
                this.initMap();
            }, 800);
        },

        initMap(attempt = 0) {
            const container = document.getElementById('editor-canvas');
            if (!container) {
                console.error('Map container not found');
                return;
            }

            // Ensure container has dimensions
            if (container.offsetWidth === 0 || container.offsetHeight === 0) {
                if (attempt >= 10) {
                    console.warn('Map init aborted after 10 retries. The container may still be hidden.');
                    return;
                }
                console.warn('Map container has no dimensions, retrying...');
                setTimeout(() => this.initMap(attempt + 1), 200);
                return;
            }

            // Init Map
            this.map = L.map('editor-canvas').setView([8.0, 124.5], 8);
            
            L.tileLayer(TILER_URL, { 
                attribution: '&copy; MapTiler' 
            }).addTo(this.map);

            // 1. ADD SEARCH (GEOCODER)
            L.Control.geocoder({
                defaultMarkGeocode: true,
                position: 'topleft'
            })
            .on('markgeocode', (e) => {
                const bbox = e.geocode.bbox;
                const poly = L.polygon([
                    bbox.getSouthEast(),
                    bbox.getNorthEast(),
                    bbox.getNorthWest(),
                    bbox.getSouthWest()
                ]);
                this.map.fitBounds(poly.getBounds());
            })
            .addTo(this.map);

            // 2. ADD DRAWING CONTROLS (Geoman)
            this.map.pm.addControls({
                position: 'topleft',
                drawCircle: false,
                drawMarker: false,
                drawPolyline: false,
                drawRectangle: true,
                drawPolygon: true,
                editMode: true,
                removalMode: true,
            });

            // 3. LOAD EXISTING DATA
            const existing = @js($selected?->fishpondMap?->coordinates);
            if (existing && existing.length > 0) {
                this.activeLayer = L.polygon(existing, { color: '#3b82f6' }).addTo(this.map);
                this.map.fitBounds(this.activeLayer.getBounds());
            }

            // Handle new drawings
            this.map.on('pm:create', (e) => {
                if (this.activeLayer) this.map.removeLayer(this.activeLayer);
                this.activeLayer = e.layer;
            });

            // CRITICAL: Refresh Leaflet's internal size tracking
            setTimeout(() => {
                this.map.invalidateSize();
                console.log('Map initialized and sized');
            }, 300);
        },

        async save() {
            if (!this.activeLayer) {
                alert('Please draw an area first');
                return;
            }
            const latLngs = this.activeLayer.getLatLngs()[0];
            const coords = latLngs.map(p => ({ lat: p.lat, lng: p.lng }));
            
            await $wire.saveMap(coords);
            $flux.modal('draw-map-modal').close();
        }
    }));

    Alpine.data('displayMap', () => ({
        map: null,
        initMap(coords) {
            if(this.map) return;
            this.map = L.map(this.$el).setView([8.0, 124.5], 7);
            L.tileLayer(TILER_URL, { attribution: '&copy; MapTiler' }).addTo(this.map);
            this.updateMap(coords);

            window.addEventListener('lessee-selected', (event) => {
                this.updateMap(event.detail?.[0] ?? []);
            });
        },
        updateMap(coords) {
            if(!this.map) return;
            
            // Clear existing layers except the tile layer
            this.map.eachLayer((layer) => {
                if (layer instanceof L.Polygon) this.map.removeLayer(layer);
            });

            if (coords && coords.length > 0) {
                const poly = L.polygon(coords, { color: '#10b981', fillOpacity: 0.4 }).addTo(this.map);
                this.map.fitBounds(poly.getBounds(), { padding: [20, 20] });
            }
        }
    }));
</script>
@endscript