<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Centre - DonSang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .fc-event {
            cursor: pointer;
        }

        .blood-drop {
            position: relative;
            width: 100px;
            height: 100px;
            background: #ef4444;
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            transform: rotate(45deg);
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Barre de Navigation -->
    <nav class="fixed w-full z-50 glass-effect">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-red-600 text-2xl font-bold flex items-center">
                        <i class="fas fa-hospital-alt mr-2 text-3xl"></i>
                        Centre Saint-Louis
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-2 bg-white rounded-full px-4 py-2 shadow-sm">
                        <i class="fas fa-user-md text-red-600"></i>
                        <span class="text-gray-700">Dr. Martin</span>
                    </div>
                    <button class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition shadow-lg">
                        Déconnexion
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Menu Latéral et Contenu Principal -->
    <div class="flex min-h-screen pt-20">
        <!-- Menu Latéral -->
        <aside class="w-72 bg-white shadow-lg fixed h-full">
            <div class="p-6">
                <div class="mb-8">
                    <div class="blood-drop mx-auto mb-4"></div>
                    <h2 class="text-center font-semibold text-lg">Centre Saint-Louis</h2>
                    <p class="text-center text-gray-600 text-sm">Centre de Don Principal</p>
                </div>
                <nav>
                    <ul class="space-y-3">
                        <li>
                            <button onclick="showSection('dashboard')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-chart-line text-xl"></i>
                                <span>Tableau de Bord</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('appointments')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-calendar-alt text-xl"></i>
                                <span>Rendez-vous</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('inventory')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-box text-xl"></i>
                                <span>Stocks</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('alerts')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-bell text-xl"></i>
                                <span>Alertes</span>
                                <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full ml-auto">3</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('settings')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-cog text-xl"></i>
                                <span>Paramètres</span>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Contenu Principal -->
        <main class="flex-1 ml-72 p-8 bg-gray-50">
            <!-- Tableau de Bord -->
            <section id="dashboard" class="section-content">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Tableau de Bord</h2>
                    <div class="flex space-x-4">
                        <button
                            class="flex items-center px-4 py-2 bg-white rounded-lg shadow-sm hover:shadow-md transition">
                            <i class="fas fa-download mr-2 text-red-600"></i>
                            <span class="text-gray-700">Exporter</span>
                        </button>
                    </div>
                </div>

                <!-- Statistiques Rapides -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-friends text-blue-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">47</span>
                        </div>
                        <p class="text-gray-600">Donneurs aujourd'hui</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-vial text-green-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">152</span>
                        </div>
                        <p class="text-gray-600">Poches collectées</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar-check text-yellow-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">28</span>
                        </div>
                        <p class="text-gray-600">RDV à venir</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">2</span>
                        </div>
                        <p class="text-gray-600">Alertes actives</p>
                    </div>
                </div>

                <!-- Graphiques -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Dons par Groupe Sanguin</h3>
                        <canvas id="bloodTypeChart" height="200"></canvas>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Évolution des Dons</h3>
                        <canvas id="donationTrendChart" height="200"></canvas>
                    </div>
                </div>
            </section>

            <!-- Gestion des Rendez-vous -->
            <section id="appointments" class="section-content hidden">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Gestion des Rendez-vous</h2>
                    <button class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                        + Nouveau RDV
                    </button>
                </div>

                <!-- Calendrier -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <div id="calendar"></div>
                </div>

                <!-- Liste des RDV du jour -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4">Rendez-vous du jour</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donneur
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4">09:00</td>
                                    <td class="px-6 py-4">Jean Dupont</td>
                                    <td class="px-6 py-4">Sang total</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-sm text-green-800 bg-green-100 rounded-full">
                                            Confirmé
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="text-blue-600 hover:text-blue-700 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Gestion des Stocks -->
            <section id="inventory" class="section-content hidden">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Gestion des Stocks</h2>
                    <button class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                        Mettre à jour
                    </button>
                </div>

                <!-- Niveaux de stock -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-2xl font-bold">A+</span>
                            <span class="text-green-600">Normal</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-600 h-2.5 rounded-full" style="width: 85%"></div>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">85 unités disponibles</p>
                    </div>
                    <!-- Répéter pour chaque groupe sanguin -->
                </div>

                <!-- Formulaire de mise à jour -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-4">Mise à jour des stocks</h3>
                    <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Groupe Sanguin</label>
                            <select class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600">
                                <option>A+</option>
                                <option>A-</option>
                                <option>B+</option>
                                <option>B-</option>
                                <option>AB+</option>
                                <option>AB-</option>
                                <option>O+</option>
                                <option>O-</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantité</label>
                            <input type="number"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date d'expiration</label>
                            <input type="date"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type d'opération</label>
                            <select class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600">
                                <option>Entrée</option>
                                <option>Sortie</option>
                            </select>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Alertes et Notifications -->
            <section id="alerts" class="section-content hidden">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Alertes et Notifications</h2>
                    <button class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                        Nouvelle Alerte
                    </button>
                </div>

                <!-- Alertes actives -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-4">Alertes Actives</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-red-800">Besoin urgent O-</h4>
                                    <p class="text-sm text-red-600">Stock critique - moins de 10 unités disponibles</p>
                                </div>
                            </div>
                            <button class="text-red-600 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Formulaire nouvelle alerte -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-4">Créer une Alerte</h3>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type d'alerte</label>
                            <select class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600">
                                <option>Besoin urgent</option>
                                <option>Maintenance prévue</option>
                                <option>Information générale</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 h-32"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Destinataires</label>
                            <select class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600">
                                <option>Tous les donneurs</option>
                                <option>Donneurs O-</option>
                                <option>Donneurs réguliers</option>
                            </select>
                        </div>
                        <button class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                            Envoyer l'alerte
                        </button>
                    </form>
                </div>

                <!-- Historique des notifications -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4">Historique des Notifications</h3>
                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium">Besoin urgent AB+</h4>
                                    <p class="text-sm text-gray-600">Envoyé à 150 donneurs</p>
                                </div>
                                <span class="text-sm text-gray-500">Il y a 2 jours</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Initialisation des graphiques
        document.addEventListener('DOMContentLoaded', function () {
            // Graphique des groupes sanguins
            const bloodTypeCtx = document.getElementById('bloodTypeChart').getContext('2d');
            new Chart(bloodTypeCtx, {
                type: 'doughnut',
                data: {
                    labels: ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
                    datasets: [{
                        data: [30, 15, 20, 10, 5, 5, 10, 5],
                        backgroundColor: [
                            '#ef4444', '#dc2626', '#b91c1c', '#991b1b',
                            '#7f1d1d', '#ef4444', '#dc2626', '#b91c1c'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });

            // Graphique de tendance
            const trendCtx = document.getElementById('donationTrendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                    datasets: [{
                        label: 'Dons mensuels',
                        data: [65, 59, 80, 81, 56, 55],
                        borderColor: '#ef4444',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Initialisation du calendrier
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    {
                        title: 'RDV - Jean D.',
                        start: '2024-03-15T10:00:00',
                        end: '2024-03-15T11:00:00',
                        backgroundColor: '#ef4444'
                    }
                ]
            });
            calendar.render();
        });

        // Gestion des sections
        function showSection(sectionId) {
            document.querySelectorAll('.section-content').forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById(sectionId).classList.remove('hidden');

            // Mise à jour du bouton actif
            document.querySelectorAll('nav button').forEach(button => {
                button.classList.remove('bg-red-50', 'text-red-600');
            });
            document.querySelector(`button[onclick="showSection('${sectionId}')"]`)
                .classList.add('bg-red-50', 'text-red-600');
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', () => {
            showSection('dashboard');
        });
    </script>
</body>

</html>