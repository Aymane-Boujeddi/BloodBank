<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Historique du donneur de sang">
    <title>Mon historique - DonSang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
        }

        .sidebar {
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .sidebar-link {
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
            margin-bottom: 2px;
        }

        .sidebar-link.active {
            background-color: rgba(239, 68, 68, 0.1);
            border-left-color: #ef4444;
            color: #dc2626;
            font-weight: 500;
        }

        .sidebar-link:hover:not(.active) {
            background-color: rgba(239, 68, 68, 0.05);
            color: #374151;
        }

        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        .card {
            transition: all 0.3s ease;
            border-radius: 0.75rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .action-link {
            transition: all 0.2s ease;
        }

        .action-link:hover {
            transform: translateX(3px);
        }

        /* Styles for when sidebar is hidden on small screens */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .overlay {
                display: none;
            }

            .overlay.open {
                display: block;
            }
        }

        /* Styles for larger screens */
        @media (min-width: 769px) {
            .sidebar {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 16rem;
            }

            #mobile-menu-button {
                display: none;
            }

            .overlay {
                display: none !important;
            }
        }

        .transition-height {
            transition: max-height 0.3s ease-out;
            overflow: hidden;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #ccc;
        }

        .progress-bar {
            height: 4px;
            background: linear-gradient(to right, #ef4444, #f97316);
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar fixed inset-y-0 left-0 z-40 w-64 bg-white overflow-y-auto custom-scrollbar">
            <div class="p-5">
                <!-- Branding in Sidebar -->
                <a href="/" class="flex items-center mb-8">
                    <i class="fas fa-tint text-red-600 text-2xl mr-2"></i>
                    <span class="text-2xl font-semibold text-red-600">Blood</span>
                    <span class="text-2xl font-semibold text-gray-700">Bank</span>
                </a>

                <!-- User Information -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center text-white text-lg font-semibold shadow-sm mr-3">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ auth()->user()->name ?? 'Donneur' }}</p>
                            <p class="text-xs text-gray-600">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1">
                    <a href="{{ route('donor.dashboard') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm rounded-lg">
                        <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i> Tableau de bord
                    </a>
                    <a href="{{ route('donor.centers') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg">
                        <i class="fas fa-map-marker-alt mr-3 w-5 text-center"></i> Centres
                    </a>
                    <a href="{{ route('donor.appointments') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg">
                        <i class="fas fa-calendar-alt mr-3 w-5 text-center"></i> Rendez-vous
                    </a>
                    <a href="{{ route('donor.history') }}"
                        class="sidebar-link active flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg">
                        <i class="fas fa-history mr-3 w-5 text-center"></i> Historique
                    </a>

                    <!-- Separator -->
                    <div class="my-5 border-t border-gray-200"></div>

                    <!-- User Settings -->
                    <p class="px-4 text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Compte</p>

                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg">
                        <i class="fas fa-user mr-3 w-5 text-center"></i> Mon profil
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg">
                        <i class="fas fa-cog mr-3 w-5 text-center"></i> Paramètres
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="block w-full text-left">
                        @csrf
                        <button type="submit"
                            class="sidebar-link flex items-center w-full px-4 py-3 text-sm text-gray-700 rounded-lg text-left">
                            <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i> Déconnexion
                        </button>
                    </form>
                </nav>

                <!-- Help Section -->
                <div class="mt-10 bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-800">Besoin d'aide ?</h4>
                    <p class="text-xs text-gray-600 mt-1">Nous sommes là pour vous aider avec vos questions.</p>
                    <a href="#" class="text-xs text-red-600 mt-2 inline-block hover:text-red-800">
                        <i class="fas fa-question-circle mr-1"></i> Centre d'assistance
                    </a>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="overlay" class="overlay fixed inset-0 bg-black opacity-50 z-30 hidden"></div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm relative z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Mobile Menu Toggle -->
                        <div class="flex items-center md:hidden">
                            <button id="mobile-menu-button"
                                class="p-2 rounded-md text-gray-500 hover:text-red-600 hover:bg-gray-100 focus:outline-none">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>

                        <!-- Page Title - Mobile Only -->
                        <div class="md:hidden">
                            <h2 class="text-lg font-medium text-gray-800">Mon historique</h2>
                        </div>

                        <!-- User Menu -->
                        {{-- <div class="relative ml-3 flex items-center">
                            <div class="border-l border-gray-200 h-8 mx-3 hidden sm:block"></div>

                            <button id="profile-menu-button" class="flex items-center text-gray-700 focus:outline-none ml-1">
                                <div class="h-9 w-9 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-sm">
                                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                                </div>
                                <i class="fas fa-chevron-down ml-2 text-xs hidden sm:inline-block text-gray-400"></i>
                            </button>

                            <!-- Profile Dropdown -->
                            <div id="profile-dropdown"
                                class="origin-top-right absolute right-0 mt-40 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-20">
                                <div class="py-1 divide-y divide-gray-100">
                                    <div class="px-4 py-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ auth()->user()->name ?? 'Anonymous' }}</p>
                                        <p class="text-xs text-gray-500 truncate">
                                            {{ auth()->user()->email ?? 'No email' }}
                                        </p>
                                    </div>
                                    <div class="py-1">
                                        <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                            <i class="fas fa-user-circle mr-2 w-4 text-gray-500"></i> Mon profil
                                        </a>
                                        <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                            <i class="fas fa-cog mr-2 w-4 text-gray-500"></i> Paramètres du compte
                                        </a>
                                    </div>
                                    <div class="py-1">
                                        <form method="POST" action="{{ route('logout') }}"
                                            class="block w-full text-left">
                                            @csrf
                                            <button type="submit"
                                                class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors text-left">
                                                <i class="fas fa-sign-out-alt mr-2 w-4 text-gray-500"></i> Déconnexion
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 main-content">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <!-- Page Header -->
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Mon historique</h1>
                                <p class="mt-1 text-gray-600">Consultez l'historique de vos dons et résultats</p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('donor.centers') }}"
                                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg flex items-center transition-colors shadow-sm text-sm font-medium">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    Nouveau rendez-vous
                                </a>
                            </div>
                        </div>

                        <!-- Optional Navigation Breadcrumbs -->
                        <nav class="hidden sm:flex items-center text-sm text-gray-500 mt-4" aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-1">
                                <li>
                                    <a href="{{ route('donor.dashboard') }}"
                                        class="hover:text-gray-700 transition-colors">Accueil</a>
                                </li>
                                <li>
                                    <span class="mx-1">/</span>
                                </li>
                                <li>
                                    <span class="font-medium text-gray-700">Historique</span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Your existing content here -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column - History List -->
                        <div class="lg:col-span-2">
                            <!-- Donation History -->
                            <div class="card bg-white rounded-xl mb-6 relative overflow-hidden">
                                <div class="absolute top-0 left-0 w-full h-1 progress-bar opacity-70"></div>
                                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                    <h2 class="text-lg font-semibold text-gray-800">Historique des dons</h2>
                                    <span class="text-xs font-medium bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                        5 dons effectués
                                    </span>
                                </div>

                                <div class="divide-y divide-gray-100">
                                    <!-- Donation History Item -->
                                    <div class="p-6 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-start">
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-tint text-red-600"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-800">Don de sang total</p>
                                                    <p class="text-xs text-gray-500 mt-1">15 Mars 2025 - Centre
                                                        Hospitalier Universitaire</p>
                                                    <div class="mt-2">
                                                        <span
                                                            class="inline-block px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">
                                                            Résultats disponibles
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="text-red-600 hover:text-red-800 flex items-center text-sm">
                                                <i class="fas fa-file-medical mr-1"></i> Voir résultats
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Donation History Item -->
                                    <div class="p-6 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-start">
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-tint text-yellow-600"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-800">Don de plasma</p>
                                                    <p class="text-xs text-gray-500 mt-1">28 Janvier 2025 - Clinique
                                                        Saint Louis</p>
                                                    <div class="mt-2">
                                                        <span
                                                            class="inline-block px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">
                                                            Résultats disponibles
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="text-red-600 hover:text-red-800 flex items-center text-sm">
                                                <i class="fas fa-file-medical mr-1"></i> Voir résultats
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Donation History Item -->
                                    <div class="p-6 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-start">
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-tint text-red-600"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-800">Don de sang total</p>
                                                    <p class="text-xs text-gray-500 mt-1">15 Novembre 2024 - Centre
                                                        Hospitalier Universitaire</p>
                                                    <div class="mt-2">
                                                        <span
                                                            class="inline-block px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">
                                                            Résultats disponibles
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="text-red-600 hover:text-red-800 flex items-center text-sm">
                                                <i class="fas fa-file-medical mr-1"></i> Voir résultats
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Donation History Item -->
                                    <div class="p-6 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-start">
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-tint text-red-600"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-800">Don de sang total</p>
                                                    <p class="text-xs text-gray-500 mt-1">30 Août 2024 - Centre Médical
                                                        Pasteur</p>
                                                    <div class="mt-2">
                                                        <span
                                                            class="inline-block px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">
                                                            Résultats disponibles
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="text-red-600 hover:text-red-800 flex items-center text-sm">
                                                <i class="fas fa-file-medical mr-1"></i> Voir résultats
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Donation History Item -->
                                    <div class="p-6 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-start">
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-tint text-blue-600"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-800">Don de plaquettes</p>
                                                    <p class="text-xs text-gray-500 mt-1">14 Mai 2024 - Clinique Saint
                                                        Louis</p>
                                                    <div class="mt-2">
                                                        <span
                                                            class="inline-block px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">
                                                            Résultats disponibles
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="text-red-600 hover:text-red-800 flex items-center text-sm">
                                                <i class="fas fa-file-medical mr-1"></i> Voir résultats
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div class="p-4 border-t border-gray-100 flex justify-center">
                                    <nav class="flex items-center space-x-1">
                                        <a href="#"
                                            class="px-3 py-1 rounded-md bg-red-50 text-red-600 text-sm font-medium">1</a>
                                        <a href="#"
                                            class="px-3 py-1 rounded-md hover:bg-gray-100 text-gray-500 text-sm">2</a>
                                    </nav>
                                </div>
                            </div>

                            <!-- Health Analysis -->
                            <div class="card bg-white rounded-xl relative overflow-hidden">
                                <div class="absolute top-0 left-0 w-full h-1 progress-bar opacity-70"></div>
                                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                    <h2 class="text-lg font-semibold text-gray-800">Analyses de sang</h2>
                                    <span class="text-xs font-medium bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                        Dernière: 15 Mars 2025
                                    </span>
                                </div>

                                <div class="p-6">
                                    <div class="mb-6">
                                        <div class="flex justify-between items-center mb-2">
                                            <p class="text-sm font-medium text-gray-700">Hémoglobine</p>
                                            <p class="text-sm text-gray-600">14.5 g/dL <span
                                                    class="text-green-600 text-xs">(Normal)</span></p>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 80%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Norme: 13.0 - 17.0 g/dL</p>
                                    </div>

                                    <div class="mb-6">
                                        <div class="flex justify-between items-center mb-2">
                                            <p class="text-sm font-medium text-gray-700">Globules blancs</p>
                                            <p class="text-sm text-gray-600">7.2 10^9/L <span
                                                    class="text-green-600 text-xs">(Normal)</span></p>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 60%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Norme: 4.5 - 11.0 10^9/L</p>
                                    </div>

                                    <div class="mb-6">
                                        <div class="flex justify-between items-center mb-2">
                                            <p class="text-sm font-medium text-gray-700">Plaquettes</p>
                                            <p class="text-sm text-gray-600">245 10^9/L <span
                                                    class="text-green-600 text-xs">(Normal)</span></p>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 70%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Norme: 150 - 400 10^9/L</p>
                                    </div>

                                    <div>
                                        <div class="flex justify-between items-center mb-2">
                                            <p class="text-sm font-medium text-gray-700">Fer sérique</p>
                                            <p class="text-sm text-gray-600">95 µg/dL <span
                                                    class="text-green-600 text-xs">(Normal)</span></p>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 65%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Norme: 60 - 170 µg/dL</p>
                                    </div>

                                    <div class="mt-6 text-center">
                                        <a href="#" class="inline-flex items-center text-sm text-red-600 hover:text-red-800">
                                            <i class="fas fa-file-alt mr-2"></i> Voir rapport complet
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Stats -->
                        <div>
                            <!-- Donation Stats -->
                            <div class="card bg-white rounded-xl overflow-hidden relative">
                                <div class="absolute top-0 left-0 w-full h-1 progress-bar opacity-70"></div>
                                <div class="px-6 py-4 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-800">Statistiques de don</h2>
                                </div>
                                <div class="p-6">
                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div class="bg-red-50 rounded-lg p-4 text-center">
                                            <div class="text-3xl font-bold text-red-600">5</div>
                                            <p class="text-xs text-gray-600 mt-1">Dons totaux</p>
                                        </div>
                                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                                            <div class="text-3xl font-bold text-blue-600">2.5L</div>
                                            <p class="text-xs text-gray-600 mt-1">Volume total</p>
                                        </div>
                                        <div class="bg-green-50 rounded-lg p-4 text-center">
                                            <div class="text-3xl font-bold text-green-600">15</div>
                                            <p class="text-xs text-gray-600 mt-1">Vies sauvées</p>
                                        </div>
                                        <div class="bg-purple-50 rounded-lg p-4 text-center">
                                            <div class="text-3xl font-bold text-purple-600">3</div>
                                            <p class="text-xs text-gray-600 mt-1">Centres visités</p>
                                        </div>
                                    </div>

                                    <div class="border-t border-gray-100 pt-5 mt-5">
                                        <h3 class="text-sm font-medium text-gray-700 mb-3">Répartition par type de don
                                        </h3>
                                        <div class="space-y-3">
                                            <div>
                                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                                    <span>Sang total</span>
                                                    <span>3 dons (60%)</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-red-500 h-2 rounded-full" style="width: 60%"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                                    <span>Plasma</span>
                                                    <span>1 don (20%)</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 20%"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                                    <span>Plaquettes</span>
                                                    <span>1 don (20%)</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 20%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6 text-center">
                                        <a href="{{ route('donor.centers') }}"
                                            class="block w-full p-3 bg-red-600 hover:bg-red-700 text-white rounded-lg text-center text-sm font-medium transition-colors">
                                            <i class="fas fa-calendar-plus mr-2"></i> Planifier votre prochain don
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Certificate -->
                            <div class="card bg-white rounded-xl overflow-hidden relative mt-6">
                                <div class="absolute top-0 left-0 w-full h-1 progress-bar opacity-70"></div>
                                <div class="px-6 py-4 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-800">Certificat de reconnaissance</h2>
                                </div>
                                <div class="p-6 text-center">
                                    <div class="relative mx-auto h-32 w-40 mb-4">
                                        <div class="absolute inset-0 bg-gradient-to-br from-red-100 to-red-50 rounded-lg">
                                        </div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div>
                                                <div class="text-red-600 mb-1">
                                                    <i class="fas fa-award text-3xl"></i>
                                                </div>
                                                <p class="text-xs font-semibold text-gray-700">CERTIFICAT</p>
                                                <p class="text-xs text-gray-600 mt-1">Donneur Régulier</p>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="font-medium text-gray-800">Donneur de sang régulier</h3>
                                    <p class="text-sm text-gray-600 mt-1">Merci pour votre contribution!</p>
                                    <div class="flex justify-center space-x-4 mt-4">
                                        <a href="#" class="text-sm text-red-600 hover:text-red-800 flex items-center">
                                            <i class="fas fa-download mr-1"></i> Télécharger
                                        </a>
                                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                            <i class="fas fa-share-alt mr-1"></i> Partager
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const profileMenuButton = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');
            const overlay = document.getElementById('overlay');
            const mainContent = document.querySelector('.main-content');

            // Toggle sidebar function
            const toggleSidebar = () => {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('open');
            };

            // Toggle sidebar on mobile button click
            if (mobileMenuButton && sidebar && overlay) {
                mobileMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // Toggle profile dropdown
            if (profileMenuButton && profileDropdown) {
                profileMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });
            }

            // Close dropdowns/sidebar when clicking outside
            document.addEventListener('click', function(e) {
                // Close profile dropdown
                if (profileMenuButton && profileDropdown && !profileDropdown.classList.contains('hidden') &&
                    !profileMenuButton.contains(e.target) &&
                    !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }

                // Close sidebar on overlay click (mobile only)
                if (overlay && overlay.classList.contains('open') && e.target === overlay) {
                    toggleSidebar();
                }
            });

            // Set active sidebar link based on current URL
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    document.querySelector('.sidebar-link.active')?.classList.remove('active');
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>
