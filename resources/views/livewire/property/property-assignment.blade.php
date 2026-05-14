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

<div class="flex-1 flex flex-col h-screen p-6 overflow-hidden" x-data="{ selectedId: @entangle('selectedLesseeId') }">
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
        <div class="w-150 rounded-xl border overflow-y-auto bg-white dark:bg-neutral-900">
            <div class="space-y-2 p-2">
                @foreach ($lessees as $lessee)
                <div wire:click="selectLessee({{ $lessee->id }})"
                    @class([ 'p-4 rounded-lg cursor-pointer transition-all duration-200'
                    , 'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 shadow-sm'=> $selectedLesseeId ==
                    $lessee->id,
                    'bg-white dark:bg-neutral-800 hover:bg-neutral-100 dark:hover:bg-neutral-700 border
                    border-transparent' => $selectedLesseeId != $lessee->id,
                    ])>
                    <div class="font-bold">{{ $lessee->full_name }}</div>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-xs text-neutral-500">{{ $lessee->fla_no }}</span>
                        @if($lessee->fishpondMap)
                        <flux:badge color="green" size="sm" inset="top bottom">Mapped</flux:badge>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <div class="p-4 border-t">{{ $lessees->links() }}</div>
        </div>

        <div
            class="flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-muted/50 relative overflow-hidden">
            @if($selected)
            <div
                class="p-4 bg-white/90 dark:bg-neutral-900/90 absolute top-4 left-4 z-[1000] rounded-lg shadow border border-neutral-200 dark:border-neutral-700">
                <h3 class="font-bold">{{ $selected->full_name }}</h3>
                <p class="text-xs">{{ $selected->barangay }}, {{ $selected->municipality }}</p>
            </div>
            <div id="display-map" class="w-full h-full z-0" wire:ignore x-data="displayMap"
                x-init="initMap(@js($selected->fishpondMap?->coordinates))"
                x-effect="if(selectedId) updateMap(@js($selected->fishpondMap?->coordinates))"></div>
            @else
            <div class="flex items-center justify-center h-full text-neutral-400">Select a lessee to view map</div>
            @endif
        </div>
    </div>

    <flux:modal name="draw-map-modal" class="fixed inset-0! max-w-[900px]! h-screen! w-screen! p-0!" x-data="editorMap">
        <div class="flex flex-col h-full">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <flux:heading size="lg">Draw Area: {{ $selected?->full_name }}</flux:heading>
                <flux:subheading>Use the search icon on the map to find a location, then draw the boundary.
                </flux:subheading>
            </div>

            <div id="editor-canvas" class="h-full min-h-0 w-full bg-zinc-100 dark:bg-zinc-900 relative" wire:ignore
                x-init="setupEditor()">
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
        
        setupEditor() {
            if (this.map) {
                this.map.remove();
            }

            // Wait for modal to be fully rendered and sized
            setTimeout(() => {
                this.initMap();
            }, 800);
        },

        initMap() {
            const container = document.getElementById('editor-canvas');
            if (!container) {
                console.error('Map container not found');
                return;
            }

            // Ensure container has dimensions
            if (container.offsetWidth === 0 || container.offsetHeight === 0) {
                console.warn('Map container has no dimensions, retrying...');
                setTimeout(() => this.initMap(), 200);
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