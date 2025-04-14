<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tableau de bord du centre de don de sang">
    <title>Tableau de bord - DonSang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        .transition-height {
            transition: max-height 0.3s ease-out;
            overflow: hidden;
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
                        <span class="text-xl font-semibold text-red-600">Don</span><span
                            class="text-xl font-semibold text-gray-700">Sang</span>
                    </a>
                    <span class="hidden md:inline-block text-sm text-gray-500 ml-2">|
                        {{ auth()->user()->donationCenter->center_name ?? 'Centre de don' }}</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('donationCenter.dashboard') }}"
                        class="px-3 py-2 text-red-600 border-b-2 border-red-600 font-medium">
                        <i class="fas fa-tachometer-alt mr-1"></i> Tableau de bord
                    </a>
                    <a href="{{ route('donationCenter.appointments') }}"
                        class="px-3 py-2 text-gray-600 hover:text-red-600">
                        <i class="fas fa-calendar-alt mr-1"></i> Rendez-vous
                    </a>
                    <a href="" class="px-3 py-2 text-gray-600 hover:text-red-600">
                        <i class="fas fa-vials mr-1"></i> Inventaire
                    </a>
                    <a href="" class="px-3 py-2 text-gray-600 hover:text-red-600">
                        <i class="fas fa-users mr-1"></i> Donneurs
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
                                <a href="{{ route('donationCenter.profile') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-user mr-2 w-4 text-gray-500"></i> Mon profil
                                </a>
                                <a href="{{ route('donationCenter.settings') }}"
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
                <a href="{{ route('donationCenter.dashboard') }}"
                    class="block px-3 py-2 bg-red-50 text-red-600 rounded-lg">
                    <i class="fas fa-tachometer-alt mr-2"></i> Tableau de bord
                </a>
                <a href="{{ route('donationCenter.appointments') }}"
                    class="block px-3 py-2 text-gray-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-calendar-alt mr-2"></i> Rendez-vous
                </a>
                <a href="" class="block px-3 py-2 text-gray-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-vials mr-2"></i> Inventaire
                </a>
                <a href="" class="block px-3 py-2 text-gray-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-users mr-2"></i> Donneurs
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 pt-20 pb-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
                <p class="text-gray-600">Bienvenue,
                    {{ auth()->user()->donationCenter->center_name ?? 'Centre de don' }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('donationCenter.appointments') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Nouveau rendez-vous
                </a>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left and Middle Column -->
            <div class="lg:col-span-2">
                <!-- Basic KPI Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <!-- Today's Donations -->
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 p-2 rounded-full">
                                <i class="fas fa-hand-holding-heart text-red-600 text-lg"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-500">Dons aujourd'hui</p>
                                <div class="flex items-center">
                                    <p class="text-lg font-semibold text-gray-900">12</p>
                                    <span class="ml-2 text-xs text-green-600"><i class="fas fa-arrow-up"></i>
                                        +25%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Registered Donors -->
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 p-2 rounded-full">
                                <i class="fas fa-users text-blue-600 text-lg"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-500">Donneurs</p>
                                <div class="flex items-center">
                                    <p class="text-lg font-semibold text-gray-900">245</p>
                                    <span class="ml-2 text-xs text-green-600"><i class="fas fa-arrow-up"></i>
                                        +18</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Next Appointments -->
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 p-2 rounded-full">
                                <i class="fas fa-calendar-check text-green-600 text-lg"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-500">RDV à venir</p>
                                <div class="flex items-center">
                                    <p class="text-lg font-semibold text-gray-900">32</p>
                                    <span class="ml-2 text-xs text-yellow-600"><i
                                            class="fas fa-exclamation-triangle"></i> 5</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Summary -->
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 p-2 rounded-full">
                                <i class="fas fa-calendar-day text-purple-600 text-lg"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-500">Aujourd'hui</p>
                                <p class="text-lg font-semibold text-gray-900">{{ now()->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blood Inventory Status -->
                <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Inventaire des groupes sanguins</h2>
                        <select class="text-sm border rounded p-1">
                            <option selected>Ce mois</option>
                            <option>Derniers 7 jours</option>
                            <option>Derniers 30 jours</option>
                            <option>Cette année</option>
                        </select>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Groupe sanguin
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Stock
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Statut
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">O-</div>
                                            <div class="ml-2 text-xs text-gray-500">Universel</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">2 unités</div>
                                        <div class="text-xs text-gray-500">Objectif: 10</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                            Critique
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-red-600 hover:text-red-900">
                                            Alerte
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">A+</div>
                                            <div class="ml-2 text-xs text-gray-500">Commun</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">15 unités</div>
                                        <div class="text-xs text-gray-500">Objectif: 20</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                            Modéré
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-gray-600 hover:text-gray-900">
                                            Rappel
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">B+</div>
                                            <div class="ml-2 text-xs text-gray-500">Commun</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">12 unités</div>
                                        <div class="text-xs text-gray-500">Objectif: 15</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            Suffisant
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-gray-600 hover:text-gray-900">
                                            Rappel
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t border-gray-100 text-center">
                        <a href="#" class="text-sm text-red-600 hover:text-red-900">
                            Voir tout l'inventaire <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Activités récentes</h2>
                        <a href="#" class="text-sm text-red-600 hover:text-red-800">Voir tout</a>
                    </div>
                    <div class="space-y-4">
                        <div class="flex">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-plus text-blue-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Marie Dupont</span> a pris rendez-vous
                                </p>
                                <p class="text-xs text-gray-500">Il y a 25 minutes</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Paul Martin</span> a complété son don
                                </p>
                                <p class="text-xs text-gray-500">Il y a 1 heure</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Thomas Bernard</span> a reporté son rendez-vous
                                </p>
                                <p class="text-xs text-gray-500">Il y a 2 heures</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <!-- Center Status Card -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-800">Statut du centre</h3>
                    </div>
                    <div class="p-5 text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-4">
                            <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                        </div>
                        <h4 class="font-medium text-lg text-gray-900 mb-1">Centre ouvert</h4>
                        <p class="text-sm text-gray-500 mb-4">Horaires: 8h00 - 18h00</p>
                        <button
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md transition-colors">
                            Changer le statut
                        </button>
                    </div>
                </div>

                <!-- Today's Appointments Summary -->
                <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Rendez-vous aujourd'hui</h2>
                    <div class="space-y-3">
                        <div class="block rounded-lg p-2">
                            <div class="text-sm font-medium">Matin (8h - 12h)</div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>6 rendez-vous</span>
                                <span>75% réservé</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-green-500 h-1 rounded-full" style="width: 75%"></div>
                            </div>
                        </div>

                        <div class="block rounded-lg p-2">
                            <div class="text-sm font-medium">Après-midi (14h - 18h)</div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>5 rendez-vous</span>
                                <span>50% réservé</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-yellow-500 h-1 rounded-full" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('donationCenter.appointments') }}"
                            class="text-sm text-red-600 hover:text-red-700 font-medium">
                            Voir tous les rendez-vous
                        </a>
                    </div>
                </div>

                <!-- Need Priority & Collection Targets -->
                <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Besoins prioritaires</h2>
                        <button class="text-sm text-red-600 hover:text-red-700">Modifier</button>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <!-- O- -->
                        <div class="p-3 border rounded-lg border-red-300 bg-red-50">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold mr-3">
                                    O-</div>
                                <div>
                                    <div class="text-sm font-medium">Très urgent</div>
                                    <div class="text-xs text-gray-500">1/8 collectées</div>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: 12.5%"></div>
                            </div>
                        </div>

                        <!-- AB- -->
                        <div class="p-3 border rounded-lg border-red-300 bg-red-50">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold mr-3">
                                    AB-</div>
                                <div>
                                    <div class="text-sm font-medium">Urgent</div>
                                    <div class="text-xs text-gray-500">2/6 collectées</div>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: 33%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-bullhorn mr-2"></i> Lancer un appel aux donneurs
                        </button>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm p-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Actions rapides</h2>
                    <div class="space-y-2">
                        <a href="{{ route('donationCenter.appointments') }}"
                            class="flex items-center p-2 rounded-lg hover:bg-red-50 transition-colors">
                            <div class="bg-red-100 p-2 rounded-full mr-3">
                                <i class="fas fa-calendar-alt text-red-600"></i>
                            </div>
                            <span class="text-sm">Gérer les rendez-vous</span>
                        </a>
                        <a href="#" class="flex items-center p-2 rounded-lg hover:bg-red-50 transition-colors">
                            <div class="bg-blue-100 p-2 rounded-full mr-3">
                                <i class="fas fa-bullhorn text-blue-600"></i>
                            </div>
                            <span class="text-sm">Lancer un appel aux dons</span>
                        </a>
                        <a href="#" class="flex items-center p-2 rounded-lg hover:bg-red-50 transition-colors">
                            <div class="bg-green-100 p-2 rounded-full mr-3">
                                <i class="fas fa-file-export text-green-600"></i>
                            </div>
                            <span class="text-sm">Exporter les données</span>
                        </a>
                    </div>
                </div>
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
