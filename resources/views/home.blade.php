<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonSang - Accueil</title>
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
                    <a href="/" class="text-red-600 text-2xl font-bold">DonSang</a>
                </div>

                <!-- Menu Mobile -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="home.html" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                    <a href="about.html" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                    <a href="contact.html" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                    <button class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition">
                        Connexion
                    </button>
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
                    <button class="bg-red-600 text-white px-8 py-3 rounded-full text-lg hover:bg-red-700 transition transform hover:scale-105">
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
                // ... (autres cartes) ...
            </div>
        </div>
    </section>

    <!-- Section Actualités -->
    <section id="actualites" class="py-16 bg-gray-50">
        // ... (section actualités existante) ...
    </section>

    <!-- Section Statistiques -->
    <section class="py-16 bg-red-600 text-white">
        // ... (contenu statistiques) ...
    </section>

    <!-- Section Newsletter -->
    <section class="py-16 bg-gray-50">
        // ... (contenu newsletter) ...
    </section>

    <!-- Section Partenaires -->
    <section class="py-16">
        // ... (partenaires existants) ...
    </section>

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
                        <li><a href="about.html" class="text-gray-400 hover:text-white">À propos</a></li>
                        <li><a href="contact.html" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                // ... (reste du footer) ...
            </div>
        </div>
    </footer>

    <script>
        // Menu mobile
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.querySelector('.md\\:flex');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Animation au défilement
        ScrollReveal().reveal('.container', {
            delay: 200,
            distance: '20px',
            origin: 'bottom',
            duration: 1000,
            easing: 'ease-in-out'
        });
    </script>
</body>
</html> 