<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - DonSang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>

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

        .gradient-bg {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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
                        <i class="fas fa-shield-alt mr-2 text-3xl"></i>
                        Admin DonSang
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-2 bg-white rounded-full px-4 py-2 shadow-sm">
                        <i class="fas fa-user-shield text-red-600"></i>
                        <span class="text-gray-700">Super Admin</span>
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
                <div class="mb-8 text-center">
                    <div class="w-20 h-20 gradient-bg rounded-full mx-auto flex items-center justify-center">
                        <i class="fas fa-user-shield text-white text-3xl"></i>
                    </div>
                    <h2 class="mt-4 font-semibold text-lg">Panel Administrateur</h2>
                    <p class="text-gray-600 text-sm">Gestion Globale</p>
                </div>
                <nav>
                    <ul class="space-y-3">
                        <li>
                            <button onclick="showSection('dashboard')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-tachometer-alt text-xl"></i>
                                <span>Tableau de Bord</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('users')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-users text-xl"></i>
                                <span>Gestion Utilisateurs</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('centers')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-hospital-alt text-xl"></i>
                                <span>Centres de Don</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('data')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-database text-xl"></i>
                                <span>Supervision Données</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('security')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-lock text-xl"></i>
                                <span>Sécurité & RGPD</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('logs')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-history text-xl"></i>
                                <span>Logs Système</span>
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
                    <h2 class="text-3xl font-bold text-gray-800">Tableau de Bord Administrateur</h2>
                    <div class="flex space-x-4">
                        <button
                            class="flex items-center px-4 py-2 bg-white rounded-lg shadow-sm hover:shadow-md transition">
                            <i class="fas fa-download mr-2 text-red-600"></i>
                            <span class="text-gray-700">Exporter Rapport</span>
                        </button>
                    </div>
                </div>

                <!-- Statistiques Globales -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">1,234</span>
                        </div>
                        <p class="text-gray-600">Donneurs Actifs</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-hospital text-green-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">25</span>
                        </div>
                        <p class="text-gray-600">Centres Actifs</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-tint text-yellow-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">5,678</span>
                        </div>
                        <p class="text-gray-600">Dons ce mois</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">3</span>
                        </div>
                        <p class="text-gray-600">Alertes Système</p>
                    </div>
                </div>

                <!-- Graphiques -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Activité des Centres</h3>
                        <canvas id="centersActivityChart" height="200"></canvas>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Inscriptions Mensuelles</h3>
                        <canvas id="registrationsChart" height="200"></canvas>
                    </div>
                </div>
            </section>

            <!-- Gestion des Utilisateurs -->
            <section id="users" class="section-content hidden">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Gestion des Utilisateurs</h2>
                    <button class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                        + Nouvel Utilisateur
                    </button>
                </div>

                <!-- Tableau des utilisateurs -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <table id="usersTable" class="w-full">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Les données seront ajoutées dynamiquement -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Sécurité et RGPD -->
            <section id="security" class="section-content hidden">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Sécurité & Conformité RGPD</h2>
                </div>

                <!-- Paramètres de sécurité -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Paramètres de Sécurité</h3>
                        <form class="space-y-4">
                            <div>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" class="form-checkbox text-red-600 rounded">
                                    <span>Authentification à deux facteurs</span>
                                </label>
                            </div>
                            <div>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" class="form-checkbox text-red-600 rounded">
                                    <span>Journalisation des activités</span>
                                </label>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Durée de session (minutes)
                                </label>
                                <input type="number"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600"
                                    value="30">
                            </div>
                        </form>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Conformité RGPD</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                    <span>Politique de confidentialité à jour</span>
                                </div>
                                <button class="text-green-600 hover:text-green-700">Modifier</button>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                    <span>Consentements utilisateurs actifs</span>
                                </div>
                                <button class="text-green-600 hover:text-green-700">Voir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Centres de Don -->
            <section id="centers" class="section-content hidden">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Gestion des Centres de Don</h2>
                    <button class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                        + Nouveau Centre
                    </button>
                </div>

                <!-- Liste des centres -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Localisation</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Capacité
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4">Centre Saint-Louis</td>
                                    <td class="px-6 py-4">Paris, France</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-sm text-green-800 bg-green-100 rounded-full">
                                            Actif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">50 donneurs/jour</td>
                                    <td class="px-6 py-4 space-x-2">
                                        <button class="text-blue-600 hover:text-blue-700">
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

            <!-- Section Supervision des Données -->
            <section id="data" class="section-content hidden">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Supervision des Données</h2>
                    <div class="flex space-x-4">
                        <button
                            class="flex items-center px-4 py-2 bg-white rounded-lg shadow-sm hover:shadow-md transition">
                            <i class="fas fa-file-pdf mr-2 text-red-600"></i>
                            <span class="text-gray-700">Générer PDF</span>
                        </button>
                        <button
                            class="flex items-center px-4 py-2 bg-white rounded-lg shadow-sm hover:shadow-md transition">
                            <i class="fas fa-file-excel mr-2 text-green-600"></i>
                            <span class="text-gray-700">Export Excel</span>
                        </button>
                    </div>
                </div>

                <!-- Statistiques détaillées -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Distribution par Groupe Sanguin</h3>
                        <canvas id="bloodDistributionChart" height="200"></canvas>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Performance des Centres</h3>
                        <canvas id="centerPerformanceChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Tableau récapitulatif -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4">Récapitulatif Global</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Métrique
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valeur
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Évolution</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4">Total Dons</td>
                                    <td class="px-6 py-4">15,678</td>
                                    <td class="px-6 py-4 text-green-600">+12.5%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Section Logs Système -->
            <section id="logs" class="section-content hidden">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Logs Système</h2>
                    <div class="flex space-x-4">
                        <button
                            class="flex items-center px-4 py-2 bg-white rounded-lg shadow-sm hover:shadow-md transition">
                            <i class="fas fa-download mr-2 text-red-600"></i>
                            <span class="text-gray-700">Exporter Logs</span>
                        </button>
                    </div>
                </div>

                <!-- Filtres -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Niveau</label>
                            <select class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600">
                                <option>Tous</option>
                                <option>Error</option>
                                <option>Warning</option>
                                <option>Info</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date début</label>
                            <input type="date"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date fin</label>
                            <input type="date"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Source</label>
                            <select class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600">
                                <option>Toutes</option>
                                <option>Système</option>
                                <option>Utilisateur</option>
                                <option>Sécurité</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Liste des logs -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4 p-4 bg-red-50 rounded-lg">
                            <div class="text-red-600">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-red-800">Erreur d'authentification</p>
                                <p class="text-sm text-red-600">Tentative de connexion échouée - IP: 192.168.1.1</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                Il y a 5 minutes
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-4 bg-yellow-50 rounded-lg">
                            <div class="text-yellow-600">
                                <i class="fas fa-exclamation-triangle text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-yellow-800">Avertissement système</p>
                                <p class="text-sm text-yellow-600">Utilisation CPU élevée - 85%</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                Il y a 15 minutes
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
            // Graphique d'activité des centres
            const centersCtx = document.getElementById('centersActivityChart').getContext('2d');
            new Chart(centersCtx, {
                type: 'bar',
                data: {
                    labels: ['Centre 1', 'Centre 2', 'Centre 3', 'Centre 4', 'Centre 5'],
                    datasets: [{
                        label: 'Dons ce mois',
                        data: [150, 190, 170, 165, 205],
                        backgroundColor: '#ef4444'
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

            // Graphique des inscriptions
            const registrationsCtx = document.getElementById('registrationsChart').getContext('2d');
            new Chart(registrationsCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                    datasets: [{
                        label: 'Nouveaux donneurs',
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

            // Initialisation de la table des utilisateurs
            const usersTable = new simpleDatatables.DataTable("#usersTable", {
                searchable: true,
                fixedHeight: true,
                perPage: 10
            });

            // Graphique de distribution du sang
            const bloodDistCtx = document.getElementById('bloodDistributionChart').getContext('2d');
            new Chart(bloodDistCtx, {
                type: 'pie',
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
                            position: 'right'
                        }
                    }
                }
            });

            // Graphique de performance des centres
            const perfCtx = document.getElementById('centerPerformanceChart').getContext('2d');
            new Chart(perfCtx, {
                type: 'radar',
                data: {
                    labels: ['Dons', 'Satisfaction', 'Efficacité', 'Qualité', 'Disponibilité'],
                    datasets: [{
                        label: 'Performance',
                        data: [85, 90, 78, 95, 88],
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.2)'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        r: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
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