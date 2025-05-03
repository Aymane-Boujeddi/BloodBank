<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodBank - Complétez votre profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/scrollreveal"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            height: 300px;
            width: 100%;
            border-radius: 0.5rem;
            position: relative !important;
            z-index: 10;
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

        .coordinates-display {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 0.5rem;
            border-radius: 0.25rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            position: absolute;
            bottom: 10px;
            right: 10px;
            z-index: 1000;
            font-size: 0.875rem;
        }
    </style>
</head>

<body class="font-sans">
    <!-- Barre de Navigation -->
    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/" class="text-red-600 text-2xl font-bold">BloodBank</a>
                </div>

                <!-- Menu Mobile -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                    <a href="/about" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                    <a href="/contact" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-600">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-red-600 transition">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>

                <!-- Menu Mobile Content -->
                <div class="hidden md:hidden absolute top-full left-0 right-0 bg-white shadow-md p-6" id="mobile-menu">
                    <div class="flex flex-col space-y-4">
                        <a href="/" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                        <a href="/about" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                        <a href="/contact" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                        @auth
                            <span class="text-gray-600">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-red-600 transition">
                                    Déconnexion
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Profile Completion Section -->
    <section class="min-h-screen pt-24 pb-12 bg-gradient-to-br from-red-50 via-red-100 to-white flex items-center">
        <div class="container mx-auto px-6 my-8">
            <div class="max-w-2xl mx-auto">
                <!-- Logo et Titre -->
                <div class="text-center mb-8">
                    <div class="inline-block p-4 bg-red-100 rounded-full mb-4">
                        <i class="fas fa-hospital text-red-600 text-4xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">Complétez le profil de votre centre</h2>
                    <p class="text-gray-600 mt-2">Ajoutez les informations de votre centre de don pour être visible par
                        les donneurs</p>
                </div>

                <!-- Progress Steps -->
                <div class="flex items-center justify-center mb-8">
                    <div class="flex items-center">
                        <div class="rounded-full h-8 w-8 flex items-center justify-center bg-green-500 text-white">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="h-1 w-16 bg-green-500"></div>
                    </div>
                    <div class="flex items-center">
                        <div class="rounded-full h-8 w-8 flex items-center justify-center bg-red-600 text-white">
                            2
                        </div>
                    </div>
                </div>

                <!-- Formulaire de Complétion de Profil -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700 font-medium">Veuillez corriger les erreurs suivantes
                                        :</p>
                                    <ul class="mt-1 text-xs text-red-600 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('center-profile.complete') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Center information heading -->
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations du centre de don</h3>

                        <!-- Center Name -->
                        <div>
                            <label for="center_name" class="block text-sm font-medium text-gray-700 mb-2">Nom du
                                centre</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-hospital-alt text-gray-400"></i>
                                </div>
                                <input type="text" id="center_name" name="center_name"
                                    value="{{ old('center_name') }}"
                                    class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('center_name') border-red-500 @enderror"
                                    placeholder="Nom de votre centre de don">
                            </div>
                            @error('center_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                                <textarea id="address" name="address" rows="2"
                                    class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('address') border-red-500 @enderror"
                                    placeholder="Adresse complète du centre">{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Numéro de
                                téléphone</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="text" id="phone_number" name="phone_number"
                                    value="{{ old('phone_number') }}"
                                    class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('phone_number') border-red-500 @enderror"
                                    placeholder="Numéro de téléphone du centre">
                            </div>
                            @error('phone_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Opening Hours -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Horaires d'ouverture</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                    <select id="opening_time" name="opening_time"
                                        class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('opening_time') border-red-500 @enderror">
                                        <option value="" disabled {{ old('opening_time') ? '' : 'selected' }}>
                                            Heure d'ouverture</option>
                                        @for ($i = 0; $i < 24; $i++)
                                            <option value="{{ sprintf('%02d:00', $i) }}"
                                                {{ old('opening_time') == sprintf('%02d:00', $i) ? 'selected' : '' }}>
                                                {{ sprintf('%02d:00', $i) }}
                                            </option>
                                        @endfor
                                    </select>
                                    <label for="opening_time" class="block text-xs text-gray-500 mt-1 ml-1">Heure
                                        d'ouverture</label>
                                </div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                    <select id="closing_time" name="closing_time"
                                        class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('closing_time') border-red-500 @enderror">
                                        <option value="" disabled {{ old('closing_time') ? '' : 'selected' }}>
                                            Heure de fermeture</option>
                                        @for ($i = 0; $i < 24; $i++)
                                            <option value="{{ sprintf('%02d:00', $i) }}"
                                                {{ old('closing_time') == sprintf('%02d:00', $i) ? 'selected' : '' }}>
                                                {{ sprintf('%02d:00', $i) }}
                                            </option>
                                        @endfor
                                    </select>
                                    <label for="closing_time" class="block text-xs text-gray-500 mt-1 ml-1">Heure de
                                        fermeture</label>
                                </div>
                            </div>
                            @error('opening_time')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @error('closing_time')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Available Days -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jours d'ouverture</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 pt-1">
                                @php
                                    $days = [
                                        'Monday' => 'Lundi',
                                        'Tuesday' => 'Mardi',
                                        'Wednesday' => 'Mercredi',
                                        'Thursday' => 'Jeudi',
                                        'Friday' => 'Vendredi',
                                        'Saturday' => 'Samedi',
                                        'Sunday' => 'Dimanche',
                                    ];
                                @endphp

                                @foreach ($days as $value => $label)
                                    <div class="flex items-center">
                                        <input type="checkbox" id="day_{{ $value }}" name="available_days[]"
                                            value="{{ $value }}"
                                            class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                                            {{ is_array(old('available_days')) && in_array($value, old('available_days')) ? 'checked' : '' }}>
                                        <label for="day_{{ $value }}"
                                            class="ml-2 text-sm text-gray-700">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('available_days')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hourly Rate -->
                        <div>
                            <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">Capacité
                                horaire</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-clock text-gray-400"></i>
                                </div>
                                <input type="number" id="hourly_rate" name="hourly_rate" min="1"
                                    max="100" value="{{ old('hourly_rate', 1) }}"
                                    class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('hourly_rate') border-red-500 @enderror"
                                    placeholder="Nombre de donneurs par heure">
                                <div class="text-xs text-gray-500 mt-1 ml-1">Nombre maximum de donneurs pouvant être
                                    accueillis par heure</div>
                            </div>
                            @error('hourly_rate')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location heading -->
                        <h3 class="text-lg font-semibold text-gray-800 pt-4 mb-2">Emplacement du centre</h3>
                        <p class="text-sm text-gray-500 mb-4">Cliquez sur la carte pour définir l'emplacement exact de
                            votre centre de don</p>

                        <!-- Replace it with a simpler instruction -->
                        <div class="text-sm text-gray-600 mb-4">
                            <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                            Cliquez directement sur la carte pour définir l'emplacement de votre centre.
                        </div>

                        <!-- Map -->
                        <div class="relative mt-4">
                            <div id="map" class="border border-gray-300"></div>
                            <div class="coordinates-display" id="coordinates-display">
                                <span class="text-xs font-medium">Coordonnées</span><br>
                                <span class="text-xs">Lat: <span id="lat-display">-</span></span><br>
                                <span class="text-xs">Lng: <span id="lng-display">-</span></span>
                            </div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                        </div>
                        @error('latitude')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('longitude')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Bouton de soumission -->
                        <div class="flex items-center justify-between pt-6">
                            <a href="{{ route('donationCenter.dashboard') }}"
                                class="text-gray-600 hover:text-gray-800 transition">
                                Je complèterai plus tard
                            </a>
                            <button type="submit"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition transform hover:scale-105">
                                Compléter le profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Pied de Page -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">BloodBank</h3>
                    <p class="text-gray-400">Ensemble, sauvons des vies</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liens utiles</h4>
                    <ul class="space-y-2">
                        <li><a href="/about" class="text-gray-400 hover:text-white">À propos</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Légal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Mentions légales</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Confidentialité</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Suivez-nous</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Wait for page to load
        window.onload = function() {
            // Create a simple map
            var map = L.map('map').setView([31.7917, -7.0926], 5);

            // Add map tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Create a marker variable
            var marker = null;

            // Get form inputs
            var latInput = document.getElementById('latitude');
            var lngInput = document.getElementById('longitude');
            var latDisplay = document.getElementById('lat-display');
            var lngDisplay = document.getElementById('lng-display');

            // Show marker if we already have coordinates
            if (latInput.value && lngInput.value) {
                marker = L.marker([latInput.value, lngInput.value]).addTo(map);
                latDisplay.textContent = latInput.value;
                lngDisplay.textContent = lngInput.value;
            }

            // When user clicks the map
            map.on('click', function(e) {
                // Get the coordinates
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                // If we already have a marker, remove it
                if (marker) {
                    map.removeLayer(marker);
                }

                // Add a new marker at the clicked position
                marker = L.marker([lat, lng]).addTo(map);

                // Update our form values
                latInput.value = lat.toFixed(6);
                lngInput.value = lng.toFixed(6);

                // Show coordinates to user
                latDisplay.textContent = lat.toFixed(6);
                lngDisplay.textContent = lng.toFixed(6);
            });
        };
    </script>
</body>

</html>
