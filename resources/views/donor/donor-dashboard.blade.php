<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tableau de bord du donneur de sang">
    <title>Tableau de bord - DonSang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-link {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-link.active {
            background-color: rgba(239, 68, 68, 0.1);
            border-left: 3px solid #ef4444;
            color: #ef4444;
        }

        .sidebar-link:hover:not(.active) {
            background-color: rgba(239, 68, 68, 0.05);
        }

        #map {
            height: 400px;
            width: 100%;
            border-radius: 0.5rem;
        }

        .rating {
            color: #fbbf24;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Top Navigation Bar -->
    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <i class="fas fa-tint text-red-600 text-xl mr-2"></i>
                        <span class="text-xl font-semibold text-red-600">Don</span>
                        <span class="text-xl font-semibold text-gray-700">Sang</span>
                    </a>
                    <span class="hidden md:inline-block text-sm text-gray-500 ml-2">| Espace Donneur</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('donor.dashboard') }}"
                        class="px-3 py-2 text-red-600 border-b-2 border-red-600 font-medium">
                        <i class="fas fa-map-marker-alt mr-1"></i> Centres
                    </a>
                    <a href="#appointments" class="px-3 py-2 text-gray-600 hover:text-red-600">
                        <i class="fas fa-calendar-alt mr-1"></i> Rendez-vous
                    </a>
                    <a href="#history" class="px-3 py-2 text-gray-600 hover:text-red-600">
                        <i class="fas fa-history mr-1"></i> Historique
                    </a>
                    <a href="#reviews" class="px-3 py-2 text-gray-600 hover:text-red-600">
                        <i class="fas fa-star mr-1"></i> Avis
                    </a>

                    <!-- User Menu -->
                    <div class="relative ml-3">
                        <button id="profile-menu-button" class="flex items-center text-gray-700 focus:outline-none">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </div>
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>

                        <!-- Profile Dropdown -->
                        <div id="profile-dropdown"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                            <div class="py-1">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ auth()->user()->name ?? 'Anonymous' }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? 'No email' }}
                                    </p>
                                </div>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2 w-4 text-gray-500"></i> Mon profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block w-full">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-left">
                                        <i class="fas fa-sign-out-alt mr-2 w-4 text-gray-500"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-red-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t shadow-md">
            <div class="container mx-auto px-6 py-2 space-y-1">
                <a href="{{ route('donor.dashboard') }}" class="block px-3 py-2 bg-red-50 text-red-600 rounded-lg">
                    <i class="fas fa-map-marker-alt mr-2"></i> Centres
                </a>
                <a href="#appointments" class="block px-3 py-2 text-gray-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-calendar-alt mr-2"></i> Rendez-vous
                </a>
                <a href="#history" class="block px-3 py-2 text-gray-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-history mr-2"></i> Historique
                </a>
                <a href="#reviews" class="block px-3 py-2 text-gray-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-star mr-2"></i> Avis
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 pt-20 pb-8">
        <!-- Map Section -->
        <section class="mb-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium text-gray-800">Centres de don à proximité</h2>
                </div>
                <div class="p-5">
                    <div id="map" class="mb-4"></div>
                    <div class="flex flex-wrap gap-4">
                        <!-- Centre Cards -->
                        <div class="w-full md:w-[calc(50%-0.5rem)] bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-900">Centre Hospitalier Universitaire</h3>
                                    <p class="text-sm text-gray-500">123 Avenue de la République, Paris</p>
                                    <div class="flex items-center mt-2 text-sm">
                                        <span class="text-green-600 font-medium">Ouvert</span>
                                        <span class="mx-2">•</span>
                                        <span>9h - 18h</span>
                                        <span class="mx-2">•</span>
                                        <span class="text-red-600">2.3 km</span>
                                    </div>
                                    <div class="mt-2">
                                        <div class="rating text-sm">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span class="text-gray-600 ml-1">(42 avis)</span>
                                        </div>
                                    </div>
                                </div>
                                <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                    Réserver
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Appointments Section -->
        <section id="appointments" class="mb-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium text-gray-800">Mes rendez-vous</h2>
                </div>
                <div class="p-5">
                    <!-- Upcoming Appointment -->
                    <div class="mb-6 p-4 border border-green-200 rounded-lg bg-green-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-green-600 text-sm font-medium">Prochain rendez-vous</span>
                                <h3 class="font-medium text-gray-900 mt-1">Centre Hospitalier Universitaire</h3>
                                <p class="text-sm text-gray-600 mt-1">Mercredi 20 Avril 2024 - 14:30</p>
                                <div class="mt-2 space-x-2">
                                    <button class="text-sm text-red-600 hover:text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Annuler
                                    </button>
                                    <button class="text-sm text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-calendar-alt mr-1"></i> Reprogrammer
                                    </button>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="#" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-map-marker-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Available Slots -->
                    <div class="border rounded-lg">
                        <div class="px-4 py-3 bg-gray-50 border-b">
                            <h3 class="font-medium text-gray-800">Créneaux disponibles</h3>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="text-center p-3 border rounded-lg hover:border-red-500 cursor-pointer">
                                    <div class="font-medium">Lun</div>
                                    <div class="text-sm text-gray-500">24 Avr</div>
                                </div>
                                <!-- Add more date slots -->
                            </div>
                            <div class="mt-4 space-y-2">
                                <button class="w-full p-2 text-left rounded-lg hover:bg-red-50">
                                    <span class="text-sm font-medium">09:00</span>
                                    <span class="text-sm text-gray-500 ml-2">Disponible</span>
                                </button>
                                <!-- Add more time slots -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Health History Section -->
        <section id="history" class="mb-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium text-gray-800">Historique et résultats</h2>
                </div>
                <div class="p-5">
                    <div class="space-y-4">
                        <!-- Donation History Item -->
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-900">Don de sang total</h3>
                                    <p class="text-sm text-gray-500">15 Mars 2024 - Centre Hospitalier Universitaire
                                    </p>
                                    <div class="mt-2">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Résultats disponibles
                                        </span>
                                    </div>
                                </div>
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-file-medical mr-1"></i> Voir résultats
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Reviews Section -->
        <section id="reviews" class="mb-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium text-gray-800">Avis et commentaires</h2>
                </div>
                <div class="p-5">
                    <!-- Add Review Form -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-800 mb-2">Donnez votre avis</h3>
                        <div class="space-y-3">
                            <div class="rating text-2xl">
                                <i class="far fa-star cursor-pointer hover:text-yellow-400"></i>
                                <i class="far fa-star cursor-pointer hover:text-yellow-400"></i>
                                <i class="far fa-star cursor-pointer hover:text-yellow-400"></i>
                                <i class="far fa-star cursor-pointer hover:text-yellow-400"></i>
                                <i class="far fa-star cursor-pointer hover:text-yellow-400"></i>
                            </div>
                            <textarea class="w-full p-3 border rounded-lg" rows="3" placeholder="Partagez votre expérience..."></textarea>
                            <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                Publier
                            </button>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="rating text-sm mb-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p class="text-sm text-gray-800 mb-1">Personnel très accueillant et professionnel.
                                    </p>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <span>Marie D.</span>
                                        <span class="mx-1">•</span>
                                        <span>Il y a 2 jours</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Profile menu toggle
            const profileMenuButton = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');

            if (profileMenuButton && profileDropdown) {
                profileMenuButton.addEventListener('click', () => {
                    profileDropdown.classList.toggle('hidden');
                });
            }

            // Initialize map
            const map = L.map('map').setView([48.8566, 2.3522], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add markers for blood donation centers
            const centers = [{
                lat: 48.8566,
                lng: 2.3522,
                name: 'Centre Hospitalier Universitaire',
                address: '123 Avenue de la République, Paris'
            }];

            centers.forEach(center => {
                L.marker([center.lat, center.lng])
                    .bindPopup(`<b>${center.name}</b><br>${center.address}`)
                    .addTo(map);
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (profileMenuButton && profileDropdown && !profileDropdown.classList.contains('hidden') &&
                    !profileMenuButton.contains(e.target) &&
                    !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }

                if (mobileMenuButton && mobileMenu && !mobileMenu.classList.contains('hidden') &&
                    !mobileMenuButton.contains(e.target) &&
                    !mobileMenu.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });

            // Star rating functionality
            const stars = document.querySelectorAll('.rating .fa-star');
            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.classList.remove('far');
                            s.classList.add('fas');
                        } else {
                            s.classList.remove('fas');
                            s.classList.add('far');
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
