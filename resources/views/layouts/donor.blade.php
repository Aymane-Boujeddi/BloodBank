<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tableau de bord du donneur de sang">
    <title>{{ $title ?? 'Tableau de bord' }} - DonSang</title>
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
    @stack('styles')
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
                    <a href="{{ route('donor.centers') }}"
                        class="px-3 py-2 {{ request()->routeIs('donor.centers') ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-600' }} hover:text-red-600 font-medium">
                        <i class="fas fa-map-marker-alt mr-1"></i> Centres
                    </a>
                    <a href="{{ route('donor.appointments') }}"
                        class="px-3 py-2 {{ request()->routeIs('donor.appointments') ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-600' }} hover:text-red-600 font-medium">
                        <i class="fas fa-calendar-alt mr-1"></i> Rendez-vous
                    </a>
                    <a href="{{ route('donor.history') }}"
                        class="px-3 py-2 {{ request()->routeIs('donor.history') ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-600' }} hover:text-red-600 font-medium">
                        <i class="fas fa-history mr-1"></i> Historique
                    </a>
                    <a href="{{ route('donor.reviews') }}"
                        class="px-3 py-2 {{ request()->routeIs('donor.reviews') ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-600' }} hover:text-red-600 font-medium">
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
                <a href="{{ route('donor.centers') }}"
                    class="block px-3 py-2 {{ request()->routeIs('donor.centers') ? 'bg-red-50 text-red-600' : 'text-gray-600' }} rounded-lg hover:bg-red-50">
                    <i class="fas fa-map-marker-alt mr-2"></i> Centres
                </a>
                <a href="{{ route('donor.appointments') }}"
                    class="block px-3 py-2 {{ request()->routeIs('donor.appointments') ? 'bg-red-50 text-red-600' : 'text-gray-600' }} rounded-lg hover:bg-red-50">
                    <i class="fas fa-calendar-alt mr-2"></i> Rendez-vous
                </a>
                <a href="{{ route('donor.history') }}"
                    class="block px-3 py-2 {{ request()->routeIs('donor.history') ? 'bg-red-50 text-red-600' : 'text-gray-600' }} rounded-lg hover:bg-red-50">
                    <i class="fas fa-history mr-2"></i> Historique
                </a>
                <a href="{{ route('donor.reviews') }}"
                    class="block px-3 py-2 {{ request()->routeIs('donor.reviews') ? 'bg-red-50 text-red-600' : 'text-gray-600' }} rounded-lg hover:bg-red-50">
                    <i class="fas fa-star mr-2"></i> Avis
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 pt-20 pb-8">
        @yield('content')
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
        });
    </script>
    @stack('scripts')
</body>

</html>
