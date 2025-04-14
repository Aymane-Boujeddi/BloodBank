<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestion des rendez-vous du centre de don de sang">
    <title>Rendez-vous - DonSang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .section-tab {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .section-tab::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 0;
            background-color: #ef4444;
            transition: width 0.3s ease;
        }

        .section-tab.active::before {
            width: 100%;
        }

        .section-tab.active {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .appointment-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .appointment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .appointment-card.pending {
            border-left-color: #f59e0b;
        }

        .appointment-card.confirmed {
            border-left-color: #10b981;
        }

        .appointment-card.urgent {
            border-left-color: #ef4444;
        }

        .search-date {
            transition: all 0.2s ease;
        }

        .search-date:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
        }

        .stats-card {
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-2px);
        }

        .pulse-dot {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.5);
                opacity: 0.5;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .slide-in {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-10px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
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
                        class="px-3 py-2 text-gray-600 hover:text-red-600">
                        <i class="fas fa-tachometer-alt mr-1"></i> Tableau de bord
                    </a>
                    <a href="{{ route('donationCenter.appointments') }}"
                        class="px-3 py-2 text-red-600 border-b-2 border-red-600 font-medium">
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
                        <button class="flex items-center text-gray-700 focus:outline-none">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </div>
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
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
                    class="block px-3 py-2 text-gray-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-tachometer-alt mr-2"></i> Tableau de bord
                </a>
                <a href="{{ route('donationCenter.appointments') }}"
                    class="block px-3 py-2 bg-red-50 text-red-600 rounded-lg">
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
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="stats-card bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En attente</p>
                        <p class="text-2xl font-semibold text-gray-900">12</p>
                    </div>
                </div>
            </div>
            <div class="stats-card bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Confirmés</p>
                        <p class="text-2xl font-semibold text-gray-900">8</p>
                    </div>
                </div>
            </div>
            <div class="stats-card bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-calendar-check text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Aujourd'hui</p>
                        <p class="text-2xl font-semibold text-gray-900">5</p>
                    </div>
                </div>
            </div>
            <div class="stats-card bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-user-clock text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Cette semaine</p>
                        <p class="text-2xl font-semibold text-gray-900">32</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Tabs -->
        <div class="flex space-x-4 mb-6">
            <button id="pendingTab"
                class="section-tab active flex-1 py-4 px-6 rounded-lg font-medium text-center transition-all bg-white shadow-sm"
                onclick="switchSection('pending')">
                <div class="flex items-center justify-center">
                    <i class="fas fa-clock mr-2"></i>
                    <span>Rendez-vous en attente</span>
                    <span
                        class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">12</span>
                </div>
            </button>
            <button id="confirmedTab"
                class="section-tab flex-1 py-4 px-6 rounded-lg font-medium text-center transition-all bg-white shadow-sm"
                onclick="switchSection('confirmed')">
                <div class="flex items-center justify-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>Rendez-vous confirmés</span>
                    <span
                        class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">8</span>
                </div>
            </button>
        </div>

        <!-- Pending Appointments Section -->
        <section id="pendingSection" class="space-y-6 fade-in">
            <!-- Search and Filter Bar -->
            <div class="bg-white rounded-lg shadow-sm p-5">
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text"
                            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            placeholder="Rechercher un donneur...">
                    </div>
                    <div class="flex space-x-4">
                        <div class="relative">
                            <input type="date"
                                class="search-date w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none"
                                onchange="filterByDate('pending', this.value)">
                        </div>
                        <select
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="all">Tous les types</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Time Slots Grid -->
            <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Créneaux disponibles aujourd'hui</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    <button
                        class="p-3 bg-gray-100 rounded-lg text-center hover:bg-red-50 hover:text-red-600 transition-colors">
                        <div class="text-sm font-medium">09:00</div>
                        <div class="text-xs text-gray-500">2 places</div>
                    </button>
                    <button
                        class="p-3 bg-gray-100 rounded-lg text-center hover:bg-red-50 hover:text-red-600 transition-colors">
                        <div class="text-sm font-medium">10:00</div>
                        <div class="text-xs text-gray-500">1 place</div>
                    </button>
                    <button class="p-3 bg-red-50 text-red-600 rounded-lg text-center relative">
                        <div class="text-sm font-medium">11:00</div>
                        <div class="text-xs">Complet</div>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full pulse-dot"></span>
                    </button>
                    <!-- Add more time slots -->
                </div>
            </div>

            <!-- Appointments List -->
            <div class="bg-white rounded-lg shadow-sm divide-y divide-gray-200">
                <!-- Sample Pending Appointment -->
                <div class="appointment-card pending p-4 slide-in" data-date="2024-04-15">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-16 text-center">
                            <div class="text-sm font-medium text-yellow-600">15 Avr</div>
                            <div class="text-xs text-gray-500">09:00</div>
                        </div>
                        <div class="ml-4 flex-grow">
                            <div class="flex items-center">
                                <div class="font-medium">Thomas Moreau</div>
                                <span class="ml-2 px-2 py-0.5 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                    En attente
                                </span>
                                <span class="ml-2 text-xs text-gray-500">
                                    <i class="fas fa-clock mr-1"></i> Il y a 2h
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 mt-1 flex items-center">
                                <span class="inline-block w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                <span class="mr-4">A+ • Premier don</span>
                                <span class="flex items-center">
                                    <i class="fas fa-phone-alt mr-1"></i>
                                    +33 6 12 34 56 78
                                </span>
                            </div>
                        </div>
                        <div class="ml-auto flex items-center space-x-2">
                            <button class="p-2 text-green-600 hover:bg-green-50 rounded-full transition-colors"
                                title="Confirmer">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors"
                                title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors"
                                title="Refuser">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Add more pending appointments here -->
            </div>
        </section>

        <!-- Confirmed Appointments Section -->
        <section id="confirmedSection" class="space-y-6 hidden fade-in">
            <!-- Search and Filter Bar -->
            <div class="bg-white rounded-lg shadow-sm p-5">
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text"
                            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            placeholder="Rechercher un donneur...">
                    </div>
                    <div class="flex space-x-4">
                        <div class="relative">
                            <input type="date"
                                class="search-date w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none"
                                onchange="filterByDate('confirmed', this.value)">
                        </div>
                        <select
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="all">Tous les types</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Appointments List -->
            <div class="bg-white rounded-lg shadow-sm divide-y divide-gray-200">
                <!-- Sample Confirmed Appointment -->
                <div class="appointment-card confirmed p-4 slide-in" data-date="2024-04-15">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-16 text-center">
                            <div class="text-sm font-medium text-green-600">15 Avr</div>
                            <div class="text-xs text-gray-500">14:30</div>
                        </div>
                        <div class="ml-4 flex-grow">
                            <div class="flex items-center">
                                <div class="font-medium">Sophie Martin</div>
                                <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded-full">
                                    Confirmé
                                </span>
                                <span class="ml-2 text-xs text-gray-500">
                                    <i class="fas fa-check mr-1"></i> Confirmé hier
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 mt-1 flex items-center">
                                <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                <span class="mr-4">B+ • Box 2</span>
                                <span class="flex items-center">
                                    <i class="fas fa-phone-alt mr-1"></i>
                                    +33 6 98 76 54 32
                                </span>
                            </div>
                        </div>
                        <div class="ml-auto flex items-center space-x-2">
                            <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors"
                                title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="p-2 text-green-600 hover:bg-green-50 rounded-full transition-colors"
                                title="Marquer comme terminé">
                                <i class="fas fa-check-double"></i>
                            </button>
                            <button class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors"
                                title="Annuler">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Add more confirmed appointments here -->
            </div>
        </section>
    </main>

    <script>
        // Function to switch between sections
        function switchSection(section) {
            const pendingSection = document.getElementById('pendingSection');
            const confirmedSection = document.getElementById('confirmedSection');
            const pendingTab = document.getElementById('pendingTab');
            const confirmedTab = document.getElementById('confirmedTab');

            if (section === 'pending') {
                pendingSection.classList.remove('hidden');
                confirmedSection.classList.add('hidden');
                pendingTab.classList.add('active');
                confirmedTab.classList.remove('active');
            } else {
                pendingSection.classList.add('hidden');
                confirmedSection.classList.remove('hidden');
                pendingTab.classList.remove('active');
                confirmedTab.classList.add('active');
            }

            // Reset animations
            const activeSection = section === 'pending' ? pendingSection : confirmedSection;
            activeSection.classList.remove('fade-in');
            void activeSection.offsetWidth; // Trigger reflow
            activeSection.classList.add('fade-in');
        }

        // Function to filter appointments by date
        function filterByDate(section, date) {
            const appointments = document.querySelectorAll(`#${section}Section .appointment-card`);

            if (!date) {
                appointments.forEach(card => {
                    card.style.display = 'block';
                    card.classList.add('slide-in');
                });
                return;
            }

            appointments.forEach(card => {
                const cardDate = card.getAttribute('data-date');
                if (cardDate === date) {
                    card.style.display = 'block';
                    card.classList.add('slide-in');
                } else {
                    card.style.display = 'none';
                    card.classList.remove('slide-in');
                }
            });
        }

        // Initialize search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInputs = document.querySelectorAll('input[type="text"]');

            searchInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const section = e.target.closest('section');
                    const appointments = section.querySelectorAll('.appointment-card');

                    appointments.forEach(card => {
                        const name = card.querySelector('.font-medium').textContent
                            .toLowerCase();
                        const shouldShow = name.includes(searchTerm);
                        card.style.display = shouldShow ? 'block' : 'none';
                        if (shouldShow) {
                            card.classList.add('slide-in');
                        }
                    });
                });
            });

            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>

</html>
