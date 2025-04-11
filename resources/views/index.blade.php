<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonSang - Plateforme de Don de Sang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/scrollreveal"></script>
</head>

<body class="font-sans">
    <!-- Barre de Navigation -->
    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="index.html" class="text-red-600 text-2xl font-bold">DonSang</a>
                </div>

                <!-- Menu Mobile -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.html" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                    <a href="about.html" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                    <a href="contact.html" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                    <div class="flex space-x-4">
                        <a href="donneur.html"
                            class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition">
                            Connexion
                        </a>
                        <a href="centre.html"
                            class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition">
                            Inscription
                        </a>
                    </div>
                </div>

                <!-- Menu Mobile Content -->
                <div class="hidden md:hidden absolute top-full left-0 right-0 bg-white shadow-md p-6" id="mobile-menu">
                    <div class="flex flex-col space-y-4">
                        <a href="index.html" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                        <a href="about.html" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                        <a href="contact.html" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                        <a href="donneur.html" class="text-gray-600 hover:text-red-600 transition">Espace Donneur</a>
                        <a href="centre.html" class="text-gray-600 hover:text-red-600 transition">Espace Centre</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Section Héros -->
    <section class="pt-24 bg-gradient-to-r from-red-50 to-red-100">
        <div class="container mx-auto px-6 py-16">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                        Donnez votre sang, <br>Sauvez des vies
                    </h1>
                    <p class="text-gray-600 text-lg mb-8">
                        Chaque don compte. Rejoignez notre communauté de donneurs et participez à sauver des vies.
                    </p>
                    <button
                        class="bg-red-600 text-white px-8 py-3 rounded-full text-lg hover:bg-red-700 transition transform hover:scale-105">
                        Donner maintenant
                    </button>
                </div>
                <div class="md:w-1/2">
                    <img src="https://placehold.co/600x400" alt="Don de sang" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités Principales -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Carte 1 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div class="text-red-600 text-3xl mb-4">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Recherche de centres</h3>
                    <p class="text-gray-600">Trouvez facilement le centre de don le plus proche de chez vous.</p>
                </div>
                <!-- Carte 2 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div class="text-red-600 text-3xl mb-4">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Prise de rendez-vous</h3>
                    <p class="text-gray-600">Planifiez votre prochain don en quelques clics.</p>
                </div>
                <!-- Carte 3 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div class="text-red-600 text-3xl mb-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Suivi des dons</h3>
                    <p class="text-gray-600">Gardez une trace de vos dons et de leur impact.</p>
                </div>
            </div>
        </div>
    </section>



    <!-- Section Centres de Don -->
    <section id="centres" class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Centres à proximité</h2>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div id="map" class="h-96 w-full bg-gray-200">
                    <!-- Intégration de carte ici -->
                </div>
            </div>
        </div>
    </section>




    <!-- Page d'Erreur 404 -->
    <!-- <section id="error-404" class="min-h-screen flex items-center justify-center bg-gray-50 ">
        <div class="text-center px-6">
            <div class="mb-8">
                <i class="fas fa-exclamation-circle text-red-600 text-6xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Page Non Trouvée</h1>
            <p class="text-gray-600 mb-8">Désolé, la page que vous recherchez n'existe pas ou a été déplacée.</p>
            <div class="space-x-4">
                <a href="/" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition inline-block">
                    Retour à l'accueil
                </a>
                <a href="#contact" class="text-red-600 hover:text-red-700 px-6 py-3 inline-block">
                    Nous contacter
                </a>
            </div>
        </div>
    </section> -->



    <!-- Pied de Page -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">DonSang</h3>
                    <p class="text-gray-400">Ensemble, sauvons des vies</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liens utiles</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">À propos</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Centres</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Légal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Mentions légales</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">CGU</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Suivez-nous</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>


</body>

</html>