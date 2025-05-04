<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BloodBank')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/center-layout.css') }}" rel="stylesheet" />
    
    @stack('head')
</head>

<body class="bg-gray-50 font-['Inter'] bg-[#f5f7fa]">
    <div class="flex h-screen">
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-white overflow-y-auto custom-scrollbar transition-transform duration-300 ease-in-out shadow-[0_0_20px_rgba(0,0,0,0.05)]">
            <div class="p-5">
                <a href="{{ route('donationCenter.dashboard') }}" class="flex items-center mb-8">
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
                    <a href="{{ route('donationCenter.dashboard') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm rounded-lg {{ request()->routeIs('donationCenter.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i> Tableau de bord
                    </a>
                    <a href="{{ route('donationCenter.appointments') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg {{ request()->routeIs('donationCenter.appointments') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt mr-3 w-5 text-center"></i> Rendez-vous
                    </a>
                    <a href="{{ route('donationCenter.centerResultsPage') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg {{ request()->routeIs('donationCenter.centerResultsPage') ? 'active' : '' }}">
                        <i class="fas fa-vials mr-3 w-5 text-center"></i> Résultats
                    </a>
                    <a href="{{ route('donationCenter.profile') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg {{ request()->routeIs('donationCenter.profile') ? 'active' : '' }}">
                        <i class="fas fa-user mr-3 w-5 text-center"></i> Profil
                    </a>
                  

                    <div class="my-5 border-t border-gray-200"></div>

                    <form method="POST" action="{{ route('logout') }}" class="block w-full text-left">
                        @csrf
                        <button type="submit"
                            class="sidebar-link flex items-center w-full px-4 py-3 text-sm text-gray-700 rounded-lg text-left">
                            <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i> Déconnexion
                        </button>
                    </form>
                </nav>

                <div class="mt-10 bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-800">Support technique</h4>
                    <p class="text-xs text-gray-600 mt-1">Besoin d'aide avec votre centre ?</p>
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
                                <span class="text-sm text-gray-500 font-normal ml-2">Centre de Don</span>
                            </h1>
                        </div>
                        <div class="flex items-center md:hidden">
                            <button id="mobile-menu-button"
                                class="p-2 rounded-md text-gray-500 hover:text-red-600 hover:bg-gray-100 focus:outline-none">
                                <i class="fas fa-bars text-xl"></i> 
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <main
                class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 transition-[margin-left] duration-300 ease-in-out md:ml-64">
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
            const profileMenuButton = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');
            const overlay = document.getElementById('overlay');
            const mainContent = document.querySelector('.main-content');

            const toggleSidebar = () => {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('open');
            };

            if (mobileMenuButton && sidebar && overlay) {
                mobileMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            if (profileMenuButton && profileDropdown) {
                profileMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });
            }

            document.addEventListener('click', function(e) {
                if (profileMenuButton && profileDropdown && !profileDropdown.classList.contains('hidden') &&
                    !profileMenuButton.contains(e.target) &&
                    !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }

                if (overlay && overlay.classList.contains('open') && e.target === overlay) {
                    toggleSidebar();
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.remove('open');
                    overlay.classList.remove('open');
                } else if (!sidebar.classList.contains('open')) {
                    sidebar.classList.add('-translate-x-full');
                }
            });

            @yield('page-scripts')
        });
    </script>
    @stack('scripts')
</body>

</html>
