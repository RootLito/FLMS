<?php

use Livewire\Volt\Component;
use App\Models\Lessee;
use App\Models\FishpondMap;

new class extends Component {
    public $search = '';
    public $selectedLesseeId = null;

    public function with(): array
    {
        $key = env('MAPTILER_API_KEY');
        $rawUrl = env('MAPTILER_URL');
        $tileUrl = str_replace('{key}', $key, $rawUrl);

        return [
            'tileUrl' => $tileUrl,
            'results' => $this->search 
                ? Lessee::where('full_name', 'like', '%'.$this->search.'%')
                    ->orWhere('fla_no', 'like', '%'.$this->search.'%')
                    ->has('fishpondMap')
                    ->limit(5)
                    ->get()
                : [],
            'allMapped' => Lessee::with('fishpondMap')
                ->has('fishpondMap')
                ->get()
                ->map(fn($lessee) => [
                    'id' => $lessee->id,
                    'full_name' => $lessee->full_name,
                    'fla_no' => $lessee->fla_no,
                    'coordinates' => $lessee->fishpondMap->coordinates,
                    'color' => $lessee->fishpondMap->color ?? '#3b82f6',
                ])
        ];
    }

    public function selectLessee($id)
    {
        $this->selectedLesseeId = $id;
        $this->search = ''; 
        
        $this->dispatch('focus-on-fishpond', lesseeId: $id);
    }

    public function getSelectedLesseeProperty()
    {
        return $this->selectedLesseeId 
            ? Lessee::with('fishpondMap')->find($this->selectedLesseeId) 
            : null;
    }
}; ?>

<div class="flex h-[calc(100vh-100px)] w-full gap-4" x-data="fishpondMap({ 
        initialData: @js($allMapped),
        selectedId: @entangle('selectedLesseeId') 
     })">

    <div
        class="w-1/3 flex flex-col gap-4 bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-y-auto">
        <div class="px-2 mb-2">
            <flux:heading size="lg">Fishpond details</flux:heading>
            <flux:text class="text-zinc-500">Use the map search control in the upper right to find any place, and the
                sidebar search to find a mapped lessee.</flux:text>
        </div>
        <div class="relative">
            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                placeholder="Search mapped lessees..." />

            @if(!empty($search))
            <div
                class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg">
                @forelse($results as $result)
                <button wire:click="selectLessee({{ $result->id }})"
                    class="w-full text-left px-4 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 first:rounded-t-lg last:rounded-b-lg">
                    <div class="text-sm font-bold">{{ $result->full_name }}</div>
                    <div class="text-xs text-zinc-500">{{ $result->fla_no }}</div>
                </button>
                @empty
                <div class="px-4 py-2 text-sm text-zinc-500">No mapped lessees found.</div>
                @endforelse
            </div>
            @endif  
        </div>
        
        <div class="flex-1">
            @if($this->selectedLessee)
            <div class="animate-in fade-in slide-in-from-left-2" wire:key="details-{{ $this->selectedLessee->id }}">
                <flux:heading size="lg">{{ $this->selectedLessee->full_name }}</flux:heading>
                <flux:text class="mb-4">{{ $this->selectedLessee->fla_no }}</flux:text>

                <div class="space-y-3">
                    <flux:card variant="subtle">
                        <div class="text-xs text-zinc-500 uppercase">Location</div>
                        <div class="font-medium">{{ $this->selectedLessee->barangay }}, {{
                            $this->selectedLessee->municipality }}</div>
                        <div class="text-xs text-zinc-400">{{ $this->selectedLessee->province }}</div>
                    </flux:card>

                    <div class="grid grid-cols-2 gap-2">
                        <flux:card variant="subtle">
                            <div class="text-xs text-zinc-500 font-medium">Hectares</div>
                            <div class="text-xl font-bold">{{ $this->selectedLessee->hec_granted }}</div>
                        </flux:card>
                        <flux:card variant="subtle">
                            <div class="text-xs text-zinc-500 font-medium">Status</div>
                            <div class="text-sm font-bold text-emerald-600">Active</div>
                        </flux:card>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                        <flux:icon.calendar variant="micro" />
                        <span>Expires: {{ $this->selectedLessee->date_expiration?->format('M d, Y') ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
            @else
            <div class="h-full flex flex-col items-center justify-center text-zinc-400 text-center p-8">
                <flux:icon.map class="size-12 mb-2 opacity-20" />
                <p>Select a fishpond on the map or search to view details.</p>
            </div>
            @endif
        </div>
    </div>
    <div
        class="flex-1 bg-zinc-100 dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden relative">
        <div id="map" class="w-full h-full z-0" wire:ignore></div>
    </div>
</div>

@script
<script>
    const TILER_URL = @js($tileUrl);

    Alpine.data('fishpondMap', ({ initialData }) => ({
        map: null,
        polygons: {},

        init() {
            // No automatic init here to ensure the DOM is ready
            // We follow the pattern of waiting for the component to be fully settled
            this.setupMap();
        },

        setupMap() {
            // Cleanup existing instance to prevent "Map container is already initialized"
            if (this.map) {
                this.map.remove();
                this.map = null;
            }

            // Wait for dimensions to settle (especially important if in modals or dynamic layouts)
            setTimeout(() => {
                this.initMap();
            }, 500);
        },

        initMap(attempt = 0) {
            const container = document.getElementById('map');
            
            if (!container) {
                console.error('Map container #map not found');
                return;
            }

            // Dimension Check (Retry Logic)
            if (container.offsetWidth === 0 || container.offsetHeight === 0) {
                if (attempt >= 10) {
                    console.warn('Map init aborted: Container has no dimensions after 10 retries.');
                    return;
                }
                setTimeout(() => this.initMap(attempt + 1), 200);
                return;
            }

            // Initialize Leaflet
            this.map = L.map('map').setView([7.1907, 125.4553], 11);

            L.tileLayer(TILER_URL, {
                attribution: '&copy; MapTiler'
            }).addTo(this.map);

            // Add search/geocoder control
            L.Control.geocoder({
                defaultMarkGeocode: true,
                position: 'topright'
            })
            .on('markgeocode', (e) => {
                const center = e.geocode.center || e.geocode.bbox.getCenter();
                this.map.setView(center, 14);
            })
            .addTo(this.map);

            // Clear and Plot Polygons
            this.polygons = {};
            initialData.forEach(item => {
                const poly = L.polygon(item.coordinates, {
                    color: item.color,
                    fillOpacity: 0.4,
                    weight: 2
                }).addTo(this.map);

                // --- Hover Effects ---
                poly.on('mouseover', () => poly.setStyle({ fillOpacity: 0.7, weight: 3 }));
                poly.on('mouseout', () => poly.setStyle({ fillOpacity: 0.4, weight: 2 }));

                // --- Click Event (Updates Sidebar via Livewire) ---
                poly.on('click', () => {
                    this.$wire.selectLessee(item.id);
                });

                // Set pointer cursor
                if (poly._path) poly._path.style.cursor = 'pointer';

                this.polygons[item.id] = poly;
            });

            // Auto-zoom to fit all fishponds
            const group = L.featureGroup(Object.values(this.polygons));
            if (group.getLayers().length) {
                this.map.fitBounds(group.getBounds(), { padding: [30, 30] });
            }

            // Handle Focus Event (triggered from Search or external selection)
            window.addEventListener('focus-on-fishpond', (event) => {
                const id = event.detail.lesseeId;
                if (this.polygons[id]) {
                    this.map.fitBounds(this.polygons[id].getBounds(), { padding: [50, 50] });
                }
            });

            // CRITICAL: Refresh Leaflet's internal size tracking
            // setTimeout(() => {
            //     this.map.invalidateSize();
            //     console.log('Fishpond display map initialized');
            // }, 300);
        }
    }));
</script>
@endscript