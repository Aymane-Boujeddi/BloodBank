@extends('layouts.donor')

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    
    <style>
        /* Ensure the map container has explicit dimensions and positioning */
        #map {
            height: 500px;
            width: 100%;
            border-radius: 0.5rem;
            position: relative !important;
            z-index: 10;
            border: 1px solid #e5e7eb;
        }
        
        /* Ensure z-index hierarchy for map components */
        .leaflet-pane {
            z-index: 400;
        }
        .leaflet-control {
            z-index: 800;
        }
        
        /* Rest of your styles */
        .location-search-container {
            position: relative;
            margin-bottom: 1rem;
        }
        .location-search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
        }
        .location-search-results div {
            padding: 0.75rem 1rem;
            cursor: pointer;
        }
        .location-search-results div:hover {
            background-color: #f7fafc;
        }
        .coordinates-display {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            position: absolute;
            bottom: 10px;
            right: 10px;
            z-index: 1000;
            font-size: 14px;
        }
        .marker-pin {
            background-color: #e53e3e;
            width: 30px;
            height: 30px;
            border-radius: 50% 50% 50% 0;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: rotate(-45deg);
            margin: -15px 0 0 -15px;
        }
        .marker-pin::after {
            content: '';
            width: 14px;
            height: 14px;
            margin: 8px 0 0 8px;
            background: #fff;
            position: absolute;
            border-radius: 50%;
        }
    </style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Définir l'emplacement du centre</h1>
            <p class="text-gray-600">Placez le marqueur sur la carte pour indiquer l'emplacement exact de votre centre de don de sang</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
            <form action="{{ route('donationCenter.saveLocation') }}" method="POST" id="location-form">
                @csrf
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $center->latitude ?? '') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $center->longitude ?? '') }}">
                
                <div class="mb-4">
                    <label for="location-search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher un lieu</label>
                    <div class="location-search-container">
                        <input type="text" id="location-search" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            placeholder="Entrez une adresse pour rechercher...">
                        <div class="location-search-results hidden" id="search-results"></div>
                    </div>
                </div>

                <!-- Map container with inline styles as fallback -->
                <div class="relative mb-6">
                    <div id="map" style="height:500px; width:100%; position:relative; border:1px solid #e5e7eb;"></div>
                    <div class="coordinates-display" id="coordinates-display">
                        Latitude: <span id="lat-display">-</span> | Longitude: <span id="lng-display">-</span>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i> Déplacez le marqueur pour préciser l'emplacement exact
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('donationCenter.profile') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Enregistrer l'emplacement
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        L'emplacement exact de votre centre aidera les donneurs à vous trouver plus facilement et à planifier leur visite.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Load Leaflet synchronously -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Initialize map with multiple fallback approaches
        
        // Approach 1: Standard initialization (defer until page load)
        document.addEventListener('DOMContentLoaded', initMap);
        
        // Approach 2: Window load fallback (wait for all resources)
        window.addEventListener('load', function() {
            // If map not initialized by DOMContentLoaded, try again
            if (!window.mapInitialized) {
                console.log('Trying window.load fallback for map initialization');
                initMap();
            }
        });
        
        // Approach 3: Immediate initialization with short delay
        setTimeout(function() {
            if (!window.mapInitialized) {
                console.log('Trying immediate timeout fallback for map initialization');
                initMap();
            }
        }, 500);
        
        function initMap() {
            // Prevent multiple initializations
            if (window.mapInitialized) return;
            
            console.log('Starting map initialization');
            const mapElement = document.getElementById('map');
            
            if (!mapElement) {
                console.error('Map container not found');
                return;
            }
            
            // Ensure container is visible and has dimensions
            mapElement.style.display = 'block';
            
            try {
                // Create map with specific settings
                const map = L.map('map', {
                    center: [31.7917, -7.0926],  // Morocco center
                    zoom: 5,
                    zoomControl: true,
                    attributionControl: true
                });
                
                console.log('Basic map initialized');
                
                // Add tile layer with error catching
                const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                });
                
                tileLayer.on('tileerror', function(error) {
                    console.error('Tile loading error:', error);
                });
                
                tileLayer.addTo(map);
                console.log('Tile layer added');
                
                // Simple marker (no custom icon initially to reduce complexity)
                let marker;
                const latInput = document.getElementById('latitude');
                const lngInput = document.getElementById('longitude');
                const latDisplay = document.getElementById('lat-display');
                const lngDisplay = document.getElementById('lng-display');
                
                // Initial coordinates setup
                if (latInput.value && lngInput.value) {
                    const lat = parseFloat(latInput.value);
                    const lng = parseFloat(lngInput.value);
                    marker = L.marker([lat, lng], {draggable: true}).addTo(map);
                    map.setView([lat, lng], 16);
                    updateCoordinatesDisplay(lat, lng);
                } else {
                    marker = L.marker([31.7917, -7.0926], {draggable: true}).addTo(map);
                    marker.setOpacity(0);
                }
                
                // Basic event handling
                marker.on('dragend', function() {
                    const position = marker.getLatLng();
                    updateCoordinates(position.lat, position.lng);
                    marker.setOpacity(1);
                });
                
                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    marker.setOpacity(1);
                    updateCoordinates(e.latlng.lat, e.latlng.lng);
                });
                
                // Helper functions
                function updateCoordinates(lat, lng) {
                    latInput.value = lat.toFixed(6);
                    lngInput.value = lng.toFixed(6);
                    updateCoordinatesDisplay(lat, lng);
                }
                
                function updateCoordinatesDisplay(lat, lng) {
                    latDisplay.textContent = lat.toFixed(6);
                    lngDisplay.textContent = lng.toFixed(6);
                }
                
                // Simple location search
                const searchInput = document.getElementById('location-search');
                const searchResults = document.getElementById('search-results');
                
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    if (searchInput.value.length < 3) {
                        searchResults.innerHTML = '';
                        searchResults.classList.add('hidden');
                        return;
                    }
                    
                    searchTimeout = setTimeout(function() {
                        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchInput.value)}&limit=5`)
                            .then(response => response.json())
                            .then(data => {
                                searchResults.innerHTML = '';
                                
                                if (data.length === 0) {
                                    searchResults.innerHTML = '<div class="text-gray-500">Aucun résultat trouvé</div>';
                                } else {
                                    data.forEach(function(item) {
                                        const div = document.createElement('div');
                                        div.textContent = item.display_name;
                                        div.addEventListener('click', function() {
                                            const lat = parseFloat(item.lat);
                                            const lng = parseFloat(item.lon);
                                            map.setView([lat, lng], 16);
                                            marker.setLatLng([lat, lng]);
                                            marker.setOpacity(1);
                                            updateCoordinates(lat, lng);
                                            searchInput.value = item.display_name;
                                            searchResults.classList.add('hidden');
                                        });
                                        searchResults.appendChild(div);
                                    });
                                }
                                
                                searchResults.classList.remove('hidden');
                            })
                            .catch(function(error) {
                                console.error('Error searching for location:', error);
                            });
                    }, 500);
                });
                
                // Ensure the map container is sized correctly
                setTimeout(function() {
                    map.invalidateSize();
                    console.log('Map size refreshed');
                }, 100);
                
                // Mark as initialized
                window.mapInitialized = true;
                console.log('Map initialization complete');
                
            } catch (error) {
                console.error('Error in map initialization:', error);
                
                // Fallback to static map if interactive fails
                if (!window.mapFallbackAttempted) {
                    window.mapFallbackAttempted = true;
                    mapElement.innerHTML = `
                        <div class="bg-gray-100 h-full w-full rounded-lg flex items-center justify-center flex-col p-6 text-center">
                            <div class="text-red-500 mb-2"><i class="fas fa-exclamation-triangle text-xl"></i></div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Carte non disponible</h3>
                            <p class="text-gray-600 mb-4">Impossible de charger la carte interactive.</p>
                            <p class="text-sm text-gray-500">Veuillez saisir les coordonnées manuellement :</p>
                            <div class="mt-4 flex space-x-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                                    <input type="text" id="manual-lat" class="px-3 py-2 border rounded" 
                                        onchange="document.getElementById('latitude').value = this.value">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                                    <input type="text" id="manual-lng" class="px-3 py-2 border rounded"
                                        onchange="document.getElementById('longitude').value = this.value">
                                </div>
                            </div>
                        </div>
                    `;
                }
            }
        }
    </script>
@endpush