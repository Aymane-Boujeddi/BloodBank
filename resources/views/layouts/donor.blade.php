<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tableau de bord du donneur de sang">
    <title>@yield('page-title', 'Tableau de bord') - BloodBank</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/donor-layout.css') }}" rel="stylesheet" />
    @stack('styles')
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <aside id="sidebar"
            class="sidebar fixed inset-y-0 left-0 z-40 w-64 bg-white overflow-y-auto custom-scrollbar">
            <div class="p-5">
                <a href="{{ route('donor.dashboard') }}" class="flex items-center mb-8">
                    <i class="fas fa-tint text-red-600 text-2xl mr-2"></i>
                    <span class="text-2xl font-semibold text-red-600">Blood</span>
                    <span class="text-2xl font-semibold text-gray-700">Bank</span>
                </a>

                <div class="mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center text-white text-lg font-semibold shadow-sm mr-3">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ auth()->user()->name ?? 'Donneur' }}</p>
                            <p class="text-xs text-gray-600">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                    </div>
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('donor.dashboard') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm rounded-lg {{ request()->routeIs('donor.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i> Tableau de bord
                    </a>
                    <a href="{{ route('donor.centers') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg {{ request()->routeIs('donor.centers') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt mr-3 w-5 text-center"></i> Centres
                    </a>
                    <a href="{{ route('donor.appointments') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg {{ request()->routeIs('donor.appointments') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt mr-3 w-5 text-center"></i> Rendez-vous
                    </a>
                    <a href="{{ route('donor.history') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg {{ request()->routeIs('donor.history') ? 'active' : '' }}">
                        <i class="fas fa-history mr-3 w-5 text-center"></i> Historique
                    </a>
                  

                    <div class="my-5 border-t border-gray-200"></div>

                    <p class="px-4 text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Compte</p>

                   
                   
                    <form method="POST" action="{{ route('logout') }}" class="block w-full text-left">
                        @csrf
                        <button type="submit"
                            class="sidebar-link flex items-center w-full px-4 py-3 text-sm text-gray-700 rounded-lg text-left">
                            <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i> Déconnexion
                        </button>
                    </form>
                </nav>

                <div class="mt-10 bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-800">Besoin d'aide ?</h4>
                    <p class="text-xs text-gray-600 mt-1">Nous sommes là pour vous aider avec vos questions.</p>
                    <a href="#" class="text-xs text-red-600 mt-2 inline-block hover:text-red-800">
                        <i class="fas fa-question-circle mr-1"></i> Centre d'assistance
                    </a>
                </div>
            </div>
        </aside>

        <div id="overlay" class="overlay fixed inset-0 bg-black opacity-50 z-30 hidden"></div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm relative z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex-1">
                            <h1 class="text-xl font-semibold text-gray-800">
                                <span class="text-red-600">@yield('page-title', 'Dashboard')</span>
                            </h1>
                        </div>
                        <div class="flex items-center md:hidden">
                            <button id="mobile-menu-button"
                                class="p-2 rounded-md text-gray-500 hover:text-red-600 hover:bg-gray-100 focus:outline-none">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>

                        <div class="md:hidden">
                            <h2 class="text-lg font-medium text-gray-800">{{ $title ?? 'Tableau de bord' }}</h2>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 main-content">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @yield('modals')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const overlay = document.getElementById('overlay');

            if (mobileMenuButton && sidebar && overlay) {
                mobileMenuButton.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('open');
                });
                
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('open');
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
