<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DonSang')</title>
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
    </style>
    @stack('head')
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar fixed inset-y-0 left-0 z-40 w-64 bg-white overflow-y-auto custom-scrollbar">
            <div class="p-5">
                <!-- Branding in Sidebar -->
                <a href="{{ route('donationCenter.dashboard') }}" class="flex items-center mb-8">
                    <i class="fas fa-tint text-red-600 text-2xl mr-2"></i>
                    <span class="text-2xl font-semibold text-red-600">Don</span>
                    <span class="text-2xl font-semibold text-gray-700">Sang</span>
                </a>

                <!-- Navigation Links -->
                <nav class="space-y-1">
                    <a href="{{ route('donationCenter.dashboard') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm rounded-lg {{ request()->routeIs('donationCenter.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i> Tableau de bord
                    </a>
                    <a href="{{ route('donationCenter.appointments') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg {{ request()->routeIs('donationCenter.appointments') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt mr-3 w-5 text-center"></i> Rendez-vous
                    </a>
                    <a href="{{ route('donationCenter.results') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg {{ request()->routeIs('donationCenter.results') ? 'active' : '' }}">
                        <i class="fas fa-vials mr-3 w-5 text-center"></i> Résultats
                    </a>
                    <a href="{{ route('donationCenter.profile') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg {{ request()->routeIs('donationCenter.profile') ? 'active' : '' }}">
                        <i class="fas fa-user mr-3 w-5 text-center"></i> Profil
                    </a>
                    <a href="{{ route('donationCenter.settings') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg {{ request()->routeIs('donationCenter.settings') ? 'active' : '' }}">
                        <i class="fas fa-cog mr-3 w-5 text-center"></i> Paramètres
                    </a>

                    <!-- Separator -->
                    <div class="my-5 border-t border-gray-200"></div>

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
                    <h4 class="text-sm font-medium text-gray-800">Support technique</h4>
                    <p class="text-xs text-gray-600 mt-1">Besoin d'aide avec votre centre ?</p>
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

                   
                    </div>
                </div>
            </header>

            <!-- Main Content -->
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

            // Handle window resize to properly show/hide sidebar on screen size change
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) { // md breakpoint
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
