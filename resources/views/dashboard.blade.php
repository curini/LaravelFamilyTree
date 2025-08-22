<x-layouts.app :title="__('Dashboard')">
    <div class="flex flex-col gap-6 p-6">
        <h1 class="text-3xl font-bold">{{ __('Welcome') }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow">
                <div class="aspect-video bg-gray-100 flex items-center justify-center rounded-lg">
                    <div id="map" class="w-full rounded-lg shadow" x-data x-init="window.initMap()" wire:ignore></div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($person as $key => $stat)
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow hover:shadow-md transition">
                        <h2 class="text-sm font-semibold text-gray-600">{{ $key }}</h2>
                        <p class="text-xl font-bold {{ $stat['color'] }} mt-2">
                            {{ $stat['value'] }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-full">No statistics available.</p>
                @endforelse
            </div>
        </div>
    </div>
    <script>
        window.initMap = function() {
            const mapElement = document.getElementById('map');

            if (!mapElement) {
                return;
            }

            if (window.leafletMap) {
                window.leafletMap.remove();
            }

            window.leafletMap = L.map(mapElement).setView([20, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
            }).addTo(window.leafletMap);

            const markers = @json($markers ?? []);

            if (Array.isArray(markers)) {
                markers.forEach(({ latitude, longitude, total }) => {
                    const radius = 5 + total * 2;
                    L.circleMarker([latitude, longitude], {
                        radius,
                        color: '#2563eb',
                        fillColor: '#3b82f6',
                        fillOpacity: 0.6,
                    })
                    .bindPopup(`${total} ville${total > 1 ? 's' : ''}`)
                    .addTo(window.leafletMap);
                });
            }
        }
    </script>
</x-layouts.app>
