<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tableau de bord du donneur de sang">
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
                        Espace Donneur</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('donor.dashboard') }}"
                        class="px-3 py-2 text-red-600 border-b-2 border-red-600 font-medium">
                        <i class="fas fa-tachometer-alt mr-1"></i> Tableau de bord
                    </a>
                    <a href="#" class="px-3 py-2 text-gray-600 hover:text-red-600">
                        <i class="fas fa-calendar-alt mr-1"></i> Mes rendez-vous
                    </a>
                    <a href="#" class="px-3 py-2 text-gray-600 hover:text-red-600">
                        <i class="fas fa-tint mr-1"></i> Mes dons
                    </a>
                    <a href="#" class="px-3 py-2 text-gray-600 hover:text-red-600">
                        <i class="fas fa-hospital mr-1"></i> Centres
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
                <a href="{{ route('donor.dashboard') }}"
                    class="block px-3 py-2 bg-red-50 text-red-600 rounded-lg">
                    <i class="fas fa-tachometer-alt mr-2"></i> Tableau de bord
                </a>
                <a href="#" class="block px-3 py-2 text-gray-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-calendar-alt mr-2"></i> Mes rendez-vous
                </a>
                <a href="#" class="block px-3 py-2 text-gray-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-tint mr-2"></i> Mes dons
                </a>
                <a href="#" class="block px-3 py-2 text-gray-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-hospital mr-2"></i> Centres
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
                <p class="text-gray-600">Bienvenue, {{ auth()->user()->name ?? 'Donneur' }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="#"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Prendre rendez-vous
                </a>
            </div>
        </div>

        <!-- Main Dashboard Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left and Middle Column (Combined for mobile, separated on larger screens) -->
            <div class="lg:col-span-2">
                <!-- Blood type and donation info -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="px-5 py-4 flex justify-between items-center border-b border-gray-100">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800">Mon profil de donneur</h3>
                            <p class="text-sm text-gray-500">Informations relatives à votre groupe sanguin</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-800 text-xl font-bold">
                            {{ auth()->user()->donor->bloodType->name ?? 'A+' }}
                        </div>
                    </div>
                    <div class="p-5">
                        <dl>
                            <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-100">
                                <dt class="text-sm font-medium text-gray-500">Groupe sanguin</dt>
                                <dd class="text-sm text-gray-900 col-span-2">
                                    {{ auth()->user()->donor->bloodType->name ?? 'A+' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-100">
                                <dt class="text-sm font-medium text-gray-500">Total de dons</dt>
                                <dd class="text-sm text-gray-900 col-span-2">6</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 py-3 border-b border-gray-100">
                                <dt class="text-sm font-medium text-gray-500">Dernier don</dt>
                                <dd class="text-sm text-gray-900 col-span-2">15 Mars 2025</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 py-3">
                                <dt class="text-sm font-medium text-gray-500">Prochain don possible</dt>
                                <dd class="text-sm text-gray-900 col-span-2">15 Juin 2025</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                    <!-- Total Donations -->
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 p-2 rounded-full">
                                <i class="fas fa-heartbeat text-red-600 text-lg"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-500">Total dons</p>
                                <p class="text-lg font-semibold text-gray-900">6</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lives Saved -->
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 p-2 rounded-full">
                                <i class="fas fa-users text-blue-600 text-lg"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-500">Vies sauvées</p>
                                <p class="text-lg font-semibold text-gray-900">18</p>
                            </div>
                        </div>
                    </div>

                    <!-- Badge Level -->
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 p-2 rounded-full">
                                <i class="fas fa-medal text-yellow-500 text-lg"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-500">Niveau</p>
                                <p class="text-lg font-semibold text-gray-900">Argent</p>
                            </div>
                        </div>
                    </div>

                    <!-- Next Eligibility -->
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 p-2 rounded-full">
                                <i class="fas fa-calendar-check text-green-600 text-lg"></i>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-500">Prochaine éligibilité</p>
                                <p class="text-lg font-semibold text-gray-900">15 Juin 2025</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <!-- Upcoming Appointments -->
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-5 py-4 flex justify-between border-b border-gray-100">
                            <h3 class="text-lg font-medium text-gray-800">Prochain rendez-vous</h3>
                            <a href="#" class="text-sm text-red-600 hover:text-red-800">Voir tous</a>
                        </div>
                        <div class="p-5">
                            <!-- If no appointments -->
                            <div class="py-6 text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                    <i class="fas fa-calendar text-red-600"></i>
                                </div>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Pas de rendez-vous</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Vous n'avez pas de rendez-vous prévu actuellement.
                                </p>
                                <div class="mt-4">
                                    <button type="button"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                                        Prendre rendez-vous
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nearby Centers -->
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-5 py-4 flex justify-between border-b border-gray-100">
                            <h3 class="text-lg font-medium text-gray-800">Centres à proximité</h3>
                            <a href="#" class="text-sm text-red-600 hover:text-red-800">Voir tous</a>
                        </div>
                        <div class="p-5">
                            <ul class="divide-y divide-gray-100">
                                <li class="py-3">
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
                                <li class="py-3">
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
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="px-5 py-4 flex justify-between border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-800">Historique des dons</h3>
                        <select class="text-sm border rounded p-1">
                            <option selected>Tous</option>
                            <option>Cette année</option>
                            <option>2024</option>
                        </select>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Date
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Centre
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
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
                    <div class="px-5 py-3 border-t border-gray-100 text-center">
                        <a href="#" class="text-sm text-red-600 hover:text-red-900">
                            Voir tout l'historique <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <!-- Donor Status Card -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-800">Statut du donneur</h3>
                    </div>
                    <div class="p-5 text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-4">
                            <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                        </div>
                        <h4 class="font-medium text-lg text-gray-900 mb-1">Éligible au don</h4>
                        <p class="text-sm text-gray-500 mb-4">Vous pouvez donner votre sang dès aujourd'hui</p>
                        <button
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md transition-colors">
                            Prendre rendez-vous maintenant
                        </button>
                    </div>
                </div>

                <!-- Blood Type Compatibility -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-800">Compatibilité sanguine</h3>
                    </div>
                    <div class="p-5">
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-900 mb-2">Votre groupe sanguin: <span
                                    class="text-red-600 font-semibold">{{ auth()->user()->donor->bloodType->name ?? 'A+' }}</span>
                            </p>
                            <div class="bg-gray-100 p-3 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Peut donner à:</h4>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">A+</span>
                                    <span
                                        class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">AB+</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="bg-gray-100 p-3 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Peut recevoir de:</h4>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">A+</span>
                                    <span
                                        class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">A-</span>
                                    <span
                                        class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">O+</span>
                                    <span
                                        class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">O-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Blood Drives -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-800">Collectes à venir</h3>
                    </div>
                    <div class="p-5">
                        <ul class="divide-y divide-gray-100">
                            <li class="py-3">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-red-100 w-10 h-10 rounded-lg flex items-center justify-center text-red-800 font-medium">
                                        <div class="text-xs leading-none">
                                            <div>AVR</div>
                                            <div class="text-sm font-bold">20</div>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Journée du don à Paris</h4>
                                        <p class="text-xs text-gray-500">Place de la République • 10h - 18h</p>
                                    </div>
                                </div>
                            </li>
                            <li class="py-3">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-red-100 w-10 h-10 rounded-lg flex items-center justify-center text-red-800 font-medium">
                                        <div class="text-xs leading-none">
                                            <div>MAI</div>
                                            <div class="text-sm font-bold">05</div>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Collecte entreprise TechParis</h4>
                                        <p class="text-xs text-gray-500">15 rue des Entrepreneurs • 9h - 16h</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="px-5 py-3 border-t border-gray-100 text-center">
                        <a href="#" class="text-sm text-red-600 hover:text-red-900">
                            Voir toutes les collectes <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-800">Actions rapides</h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-2">
                            <a href="#" class="flex items-center p-2 rounded-lg hover:bg-red-50 transition-colors">
                                <div class="bg-red-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-calendar-alt text-red-600"></i>
                                </div>
                                <span class="text-sm">Prendre rendez-vous</span>
                            </a>
                            <a href="#" class="flex items-center p-2 rounded-lg hover:bg-red-50 transition-colors">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-certificate text-blue-600"></i>
                                </div>
                                <span class="text-sm">Obtenir mon certificat</span>
                            </a>
                            <a href="#" class="flex items-center p-2 rounded-lg hover:bg-red-50 transition-colors">
                                <div class="bg-green-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-user-md text-green-600"></i>
                                </div>
                                <span class="text-sm">Consulter mes résultats</span>
                            </a>
                            <a href="#" class="flex items-center p-2 rounded-lg hover:bg-red-50 transition-colors">
                                <div class="bg-purple-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-share-alt text-purple-600"></i>
                                </div>
                                <span class="text-sm">Inviter un ami à donner</span>
                            </a>
                        </div>
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