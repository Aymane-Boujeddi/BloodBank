<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tableau de bord du donneur de sang">
    <title>Tableau de bord - DonSang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 fixed w-full z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-tint text-red-600 text-xl mr-2"></i>
                        <span class="text-xl font-medium text-red-600">Don</span><span
                            class="text-xl font-medium text-gray-700">Sang</span>
                    </div>
                </div>
                <div class="hidden md:ml-6 md:flex md:items-center">
                    <a href="{{ route('donor.dashboard') }}"
                        class="px-3 py-2 text-red-600 border-b-2 border-red-600 font-medium">
                        Tableau de bord
                    </a>
                    <a href="#" class="px-3 py-2 text-gray-600 hover:text-red-600">
                        Mes rendez-vous
                    </a>
                    <a href="#" class="px-3 py-2 text-gray-600 hover:text-red-600">
                        Mes dons
                    </a>
                    <a href="#" class="px-3 py-2 text-gray-600 hover:text-red-600">
                        Centres
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
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-user mr-2 w-4 text-gray-500"></i> Mon profil
                                </a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-cog mr-2 w-4 text-gray-500"></i> Paramètres
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}" class="block w-full text-left">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors text-left">
                                        <i class="fas fa-sign-out-alt mr-2 w-4 text-gray-500"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-red-600 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('donor.dashboard') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-red-600 text-red-600 bg-red-50 font-medium">
                    <i class="fas fa-tachometer-alt mr-2"></i> Tableau de bord
                </a>
                <a href="#"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300">
                    <i class="fas fa-calendar-alt mr-2"></i> Mes rendez-vous
                </a>
                <a href="#"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300">
                    <i class="fas fa-tint mr-2"></i> Mes dons
                </a>
                <a href="#"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300">
                    <i class="fas fa-hospital mr-2"></i> Centres
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-10">
        <div class="md:flex md:items-center md:justify-between mb-4">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate">
                    Tableau de bord
                </h2>
                <p class="text-sm text-gray-500">
                    Bienvenue, {{ auth()->user()->name ?? 'Donneur' }}
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="#"
                    class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Prendre rendez-vous
                </a>
            </div>
        </div>

        <!-- Blood type and donation info -->
        <div class="bg-white shadow overflow-hidden rounded-lg mt-6">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Mon profil de donneur</h3>
                    <p class="mt-1 text-sm text-gray-500">Informations relatives à votre groupe sanguin</p>
                </div>
                <div class="flex items-center">
                    <div
                        class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-800 text-xl font-bold">
                        {{ auth()->user()->donor->bloodType->name ?? 'A+' }}
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Groupe sanguin</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ auth()->user()->donor->bloodType->name ?? 'A+' }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Total de dons</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">6</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Dernier don</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">15 Mars 2025</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Prochain don possible</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">15 Juin 2025</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Donations -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-heartbeat text-red-600 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total dons</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">6</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lives Saved -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Vies sauvées</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">18</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Badge Level -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-medal text-yellow-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Niveau</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">Argent</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Eligibility -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-check text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Prochaine éligibilité</dt>
                                <dd class="text-sm flex items-baseline">
                                    <div class="text-lg font-semibold text-gray-900">15 Juin 2025</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2">
            <!-- Upcoming Appointments -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Prochain rendez-vous</h3>
                    <a href="#" class="text-sm text-red-600 hover:text-red-800">Voir tous</a>
                </div>
                <div class="border-t border-gray-200">
                    <!-- If no appointments -->
                    <div class="px-6 py-10 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <i class="fas fa-calendar text-red-600"></i>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Pas de rendez-vous</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Vous n'avez pas de rendez-vous prévu actuellement.
                        </p>
                        <div class="mt-6">
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                                Prendre rendez-vous
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nearby Centers -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Centres à proximité</h3>
                    <a href="#" class="text-sm text-red-600 hover:text-red-800">Voir tous</a>
                </div>
                <div class="border-t border-gray-200">
                    <ul class="divide-y divide-gray-200">
                        <li class="py-4 px-4">
                            <div class="flex justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">Centre Hospitalier Universitaire</h4>
                                    <p class="text-xs text-gray-500">123 Avenue de la République, Paris</p>
                                    <div class="flex items-center mt-1">
                                        <i class="far fa-clock text-gray-400 mr-1"></i>
                                        <span class="text-xs text-gray-500">9h - 18h</span>
                                        <span class="mx-2">•</span>
                                        <span class="text-xs text-red-600 font-medium">2.3 km</span>
                                    </div>
                                </div>
                                <button
                                    class="ml-4 bg-red-600 text-white text-xs px-3 py-1 rounded-full hover:bg-red-700">
                                    RDV
                                </button>
                            </div>
                        </li>
                        <li class="py-4 px-4">
                            <div class="flex justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">Clinique Saint Michel</h4>
                                    <p class="text-xs text-gray-500">45 Rue des Lilas, Paris</p>
                                    <div class="flex items-center mt-1">
                                        <i class="far fa-clock text-gray-400 mr-1"></i>
                                        <span class="text-xs text-gray-500">8h - 19h30</span>
                                        <span class="mx-2">•</span>
                                        <span class="text-xs text-red-600 font-medium">3.7 km</span>
                                    </div>
                                </div>
                                <button
                                    class="ml-4 bg-red-600 text-white text-xs px-3 py-1 rounded-full hover:bg-red-700">
                                    RDV
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="mt-6 bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Historique des dons</h3>
                <select class="text-sm border rounded p-1">
                    <option selected>Tous</option>
                    <option>Cette année</option>
                    <option>2024</option>
                </select>
            </div>
            <div class="border-t border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Centre
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    15 Mars 2025
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Centre Hospitalier Universitaire
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                        Sang total
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-red-600 hover:text-red-900">
                                        Détails
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    10 Décembre 2024
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Clinique Saint Michel
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                        Sang total
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-red-600 hover:text-red-900">
                                        Détails
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="px-4 py-3 border-t border-gray-200 text-center">
                <a href="#" class="text-sm text-red-600 hover:text-red-900">
                    Voir tout l'historique <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
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
</body>

</html>
