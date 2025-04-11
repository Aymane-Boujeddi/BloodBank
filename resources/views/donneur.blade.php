<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Donneur - DonSang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Animation library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-background {
            background: linear-gradient(135deg, #ff4b4b 0%, #ff6b6b 100%);
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
    </style>
</head>

<body class="bg-gray-50">
    <!-- Barre de Navigation -->
    <nav class="fixed w-full z-50 glass-effect">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-red-600 text-2xl font-bold flex items-center">
                        <i class="fas fa-heartbeat mr-2 text-3xl"></i>
                        DonSang
                    </a>
                    <div class="hidden md:flex space-x-6">
                        <a href="#" class="text-gray-700 hover:text-red-600 transition">Accueil</a>
                        <a href="#" class="text-gray-700 hover:text-red-600 transition">À propos</a>
                        <a href="#" class="text-gray-700 hover:text-red-600 transition">Contact</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-2 bg-white rounded-full px-4 py-2 shadow-sm">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=JeanDupont" alt="Avatar"
                            class="w-8 h-8 rounded-full border-2 border-red-600">
                        <span class="text-gray-700">Jean Dupont</span>
                    </div>
                    <button
                        class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition shadow-lg hover:shadow-xl">
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
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=JeanDupont" alt="Profile"
                        class="w-24 h-24 rounded-full mx-auto border-4 border-red-600">
                    <h2 class="mt-4 font-semibold text-lg">Jean Dupont</h2>
                    <p class="text-gray-600 text-sm">Donneur Régulier</p>
                </div>
                <nav>
                    <ul class="space-y-3">
                        <li>
                            <button onclick="showSection('profile')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span>Mon Profil</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('centres')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-hospital-alt text-xl"></i>
                                <span>Centres de Don</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('appointments')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-calendar-check text-xl"></i>
                                <span>Rendez-vous</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('reports')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-file-medical-alt text-xl"></i>
                                <span>Rapports d'Analyse</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('history')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-history text-xl"></i>
                                <span>Historique</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('reviews')"
                                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-3">
                                <i class="fas fa-star text-xl"></i>
                                <span>Avis</span>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Contenu Principal -->
        <main class="flex-1 ml-72 p-8 bg-gray-50">
            <!-- Section Profil -->
            <section id="profile" class="section-content">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Mon Profil</h2>
                    <div class="flex space-x-4">
                        <button
                            class="flex items-center px-4 py-2 bg-white rounded-lg shadow-sm hover:shadow-md transition">
                            <i class="fas fa-bell mr-2 text-red-600"></i>
                            <span class="text-gray-700">Notifications</span>
                        </button>
                        <button
                            class="flex items-center px-4 py-2 bg-white rounded-lg shadow-sm hover:shadow-md transition">
                            <i class="fas fa-cog mr-2 text-red-600"></i>
                            <span class="text-gray-700">Paramètres</span>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Carte d'information personnelle -->
                    <div class="col-span-2">
                        <div class="bg-white rounded-2xl shadow-lg p-6 hover-scale">
                            <div class="flex justify-between items-start mb-6">
                                <h3 class="text-xl font-semibold text-gray-800">Informations Personnelles</h3>
                                <button class="text-red-600 hover:text-red-700">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Nom</label>
                                    <input type="text" value="Dupont"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Prénom</label>
                                    <input type="text" value="Jean"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Email</label>
                                    <input type="email" value="jean.dupont@email.com"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Téléphone</label>
                                    <input type="tel" value="+33 6 12 34 56 78"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carte groupe sanguin -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover-scale">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6">Groupe Sanguin</h3>
                        <div class="text-center">
                            <div class="text-6xl font-bold text-red-600 mb-4">A+</div>
                            <p class="text-gray-600">Dernier don : 10 Mars 2024</p>
                            <p class="text-gray-600">Prochain don possible : 10 Juin 2024</p>
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mt-8">
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-tint text-red-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">12</span>
                        </div>
                        <p class="text-gray-600">Dons Totaux</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-heart text-green-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">36</span>
                        </div>
                        <p class="text-gray-600">Vies Sauvées</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">5</span>
                        </div>
                        <p class="text-gray-600">Rendez-vous Honorés</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover-scale">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-medal text-yellow-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-800">Gold</span>
                        </div>
                        <p class="text-gray-600">Statut Donneur</p>
                    </div>
                </div>
            </section>

            <!-- Section Centres -->
            <section id="centres" class="section-content hidden">
                <h2 class="text-2xl font-bold mb-6">Centres de Don</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <div id="map" class="h-96 bg-gray-200 rounded-lg shadow"></div>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="font-semibold">Centre Hospitalier Saint-Louis</h3>
                            <p class="text-gray-600">123 rue de la Santé, Paris</p>
                            <p class="text-sm text-gray-500 mt-2">
                                <i class="fas fa-clock mr-2"></i>
                                Lun-Ven: 9h-18h
                            </p>
                            <button class="mt-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                                Prendre RDV
                            </button>
                        </div>
                        <!-- Répéter pour d'autres centres -->
                    </div>
                </div>
            </section>

            <!-- Section Rendez-vous -->
            <section id="appointments" class="section-content hidden">
                <h2 class="text-2xl font-bold mb-6">Mes Rendez-vous</h2>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Centre</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4">15 Mai 2024 - 14h30</td>
                                <td class="px-6 py-4">Centre Saint-Louis</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-sm text-green-800 bg-green-100 rounded-full">
                                        Confirmé
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <button class="text-red-600 hover:text-red-700">Annuler</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Section Rapports d'Analyse -->
            <section id="reports" class="section-content hidden">
                <h2 class="text-2xl font-bold mb-6">Mes Rapports d'Analyse</h2>

                <!-- Liste des rapports -->
                <div class="space-y-4">
                    <!-- Rapport récent -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">Rapport du 10 Mars 2024</h3>
                                <p class="text-gray-600">Centre Saint-Louis</p>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Qualifié</span>
                        </div>
                        <div class="mt-4 flex gap-4">
                            <button class="flex items-center text-red-600 hover:text-red-700">
                                <i class="fas fa-eye mr-2"></i> Voir le détail
                            </button>
                            <button class="flex items-center text-red-600 hover:text-red-700">
                                <i class="fas fa-download mr-2"></i> Télécharger
                            </button>
                        </div>
                    </div>

                    <!-- Rapport plus ancien -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">Rapport du 15 Décembre 2023</h3>
                                <p class="text-gray-600">Centre Pasteur</p>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Qualifié</span>
                        </div>
                        <div class="mt-4 flex gap-4">
                            <button class="flex items-center text-red-600 hover:text-red-700">
                                <i class="fas fa-eye mr-2"></i> Voir le détail
                            </button>
                            <button class="flex items-center text-red-600 hover:text-red-700">
                                <i class="fas fa-download mr-2"></i> Télécharger
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Historique -->
            <section id="history" class="section-content hidden">
                <h2 class="text-2xl font-bold mb-6">Historique des Dons</h2>

                <!-- Nouvelle section Rapport d'Analyse -->
                <div class="mb-8 bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Dernier Rapport d'Analyse</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Informations générales -->
                        <div>
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-700 mb-2">Informations Générales</h4>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="mb-2"><span class="font-medium">Date du don :</span> 10 Mars 2024</p>
                                    <p class="mb-2"><span class="font-medium">Centre :</span> Centre Saint-Louis</p>
                                    <p class="mb-2"><span class="font-medium">Type de don :</span> Sang total</p>
                                    <p><span class="font-medium">Volume prélevé :</span> 450 ml</p>
                                </div>
                            </div>

                            <!-- Statut de qualification -->
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-700 mb-2">Statut</h4>
                                <div
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <span class="mr-2">●</span> Don qualifié
                                </div>
                            </div>
                        </div>

                        <!-- Résultats d'analyses -->
                        <div>
                            <h4 class="font-medium text-gray-700 mb-4">Paramètres Sanguins</h4>
                            <div class="space-y-4">
                                <!-- Hémogramme -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h5 class="font-medium mb-3">Hémogramme</h5>
                                    <table class="w-full">
                                        <tr class="border-b border-gray-200">
                                            <td class="py-2">Hémoglobine</td>
                                            <td class="py-2 text-right">14.5 g/dL</td>
                                            <td class="py-2 text-right text-green-600 text-sm">Normal</td>
                                        </tr>
                                        <tr class="border-b border-gray-200">
                                            <td class="py-2">Hématocrite</td>
                                            <td class="py-2 text-right">42%</td>
                                            <td class="py-2 text-right text-green-600 text-sm">Normal</td>
                                        </tr>
                                        <tr class="border-b border-gray-200">
                                            <td class="py-2">Plaquettes</td>
                                            <td class="py-2 text-right">250,000/µL</td>
                                            <td class="py-2 text-right text-green-600 text-sm">Normal</td>
                                        </tr>
                                    </table>
                                </div>

                                <!-- Tests de qualification -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h5 class="font-medium mb-3">Tests de Qualification</h5>
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center">
                                            <span>VIH</span>
                                            <span class="text-green-600">Négatif</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span>Hépatite B</span>
                                            <span class="text-green-600">Négatif</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span>Hépatite C</span>
                                            <span class="text-green-600">Négatif</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span>Syphilis</span>
                                            <span class="text-green-600">Négatif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recommandations -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-medium text-blue-800 mb-2">Recommandations</h4>
                        <ul class="list-disc list-inside text-blue-700 space-y-1">
                            <li>Prochain don possible à partir du 10 Juin 2024</li>
                            <li>Maintenir une bonne hydratation</li>
                            <li>Continuer une alimentation équilibrée riche en fer</li>
                        </ul>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="mt-6 flex gap-4">
                        <button
                            class="flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                            <i class="fas fa-download mr-2"></i>
                            Télécharger le rapport PDF
                        </button>
                        <button
                            class="flex items-center px-4 py-2 border border-red-600 text-red-600 rounded hover:bg-red-50 transition">
                            <i class="fas fa-envelope mr-2"></i>
                            Recevoir par email
                        </button>
                    </div>
                </div>

                <!-- Reste du contenu historique existant -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Graphique -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Statistiques</h3>
                        <canvas id="donationChart" class="w-full h-64"></canvas>
                    </div>
                    <!-- Liste des dons -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Derniers Dons</h3>
                        <div class="space-y-4">
                            <div class="border-b pb-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-semibold">Don de sang total</h4>
                                        <p class="text-sm text-gray-600">Centre Saint-Louis</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm text-gray-600">10 Mars 2024</span>
                                        <p class="text-sm font-semibold text-green-600">Résultats normaux</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Répéter pour d'autres dons -->
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Avis -->
            <section id="reviews" class="section-content hidden">
                <h2 class="text-2xl font-bold mb-6">Avis et Commentaires</h2>
                <!-- Formulaire d'avis -->
                <div class="bg-white p-6 rounded-lg shadow mb-6">
                    <h3 class="text-lg font-semibold mb-4">Donner votre avis</h3>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Centre</label>
                            <select class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-red-600">
                                <option>Centre Saint-Louis</option>
                                <option>Centre Pasteur</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Note</label>
                            <div class="flex space-x-2">
                                <i class="fas fa-star text-yellow-400 cursor-pointer"></i>
                                <i class="fas fa-star text-yellow-400 cursor-pointer"></i>
                                <i class="fas fa-star text-yellow-400 cursor-pointer"></i>
                                <i class="fas fa-star text-gray-300 cursor-pointer"></i>
                                <i class="fas fa-star text-gray-300 cursor-pointer"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Commentaire</label>
                            <textarea
                                class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-red-600 h-32"></textarea>
                        </div>
                        <button class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
                            Publier
                        </button>
                    </form>
                </div>
                <!-- Liste des avis -->
                <div class="space-y-4">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-semibold">Marie D.</h4>
                                <div class="flex text-yellow-400 mt-1">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <span class="text-sm text-gray-600">Il y a 2 jours</span>
                        </div>
                        <p class="text-gray-600">Excellent accueil, équipe très professionnelle. Je recommande vivement
                            ce
                            centre !</p>
                    </div>
                    <!-- Répéter pour d'autres avis -->
                </div>
            </section>
        </main>
    </div>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Gestion des sections avec animation
        function showSection(sectionId) {
            // Remove active class from all nav buttons
            document.querySelectorAll('nav button').forEach(button => {
                button.classList.remove('bg-red-50', 'text-red-600');
            });

            // Add active class to clicked button
            const activeButton = document.querySelector(`button[onclick="showSection('${sectionId}')"]`);
            if (activeButton) {
                activeButton.classList.add('bg-red-50', 'text-red-600');
            }

            // Hide all sections
            document.querySelectorAll('.section-content').forEach(section => {
                section.classList.add('hidden');
                section.classList.remove('fade-in');
            });

            // Show selected section with animation
            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.classList.remove('hidden');
                selectedSection.classList.add('fade-in');

                // Refresh AOS for new content
                setTimeout(() => {
                    AOS.refresh();
                }, 100);

                // Initialize map if showing centres section
                if (sectionId === 'centres' && document.getElementById('map')) {
                    setTimeout(() => {
                        initMap();
                    }, 100);
                }
            }
        }

        // Add fade-in animation style
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .fade-in {
                animation: fadeIn 0.5s ease-out forwards;
            }
        `;
        document.head.appendChild(style);

        // Initialisation de la carte
        function initMap() {
            if (!document.getElementById('map').__leaflet) {  // Check if map is not already initialized
                const map = L.map('map').setView([48.8566, 2.3522], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
            }
        }

        // Initialisation au chargement
        document.addEventListener('DOMContentLoaded', () => {
            // Show profile section by default
            showSection('profile');

            // Add click event listeners to all nav buttons
            document.querySelectorAll('nav button').forEach(button => {
                button.addEventListener('click', (e) => {
                    const sectionId = e.currentTarget.getAttribute('onclick').match(/'(.*?)'/)[1];
                    showSection(sectionId);
                });
            });
        });
    </script>
</body>

</html>