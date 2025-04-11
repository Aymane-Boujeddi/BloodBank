<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonSang - Connexion</title>
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
                        <a href="login.html"
                            class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition">
                            Connexion
                        </a>
                        <a href="register.html"
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
                        <a href="login.html" class="text-gray-600 hover:text-red-600 transition">Connexion</a>
                        <a href="register.html" class="text-gray-600 hover:text-red-600 transition">Inscription</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <section class="min-h-screen pt-24 bg-gradient-to-br from-red-50 via-red-100 to-white flex items-center">
        <div class="container mx-auto px-6">
            <div class="max-w-md mx-auto">
                <!-- Logo et Titre -->
                <div class="text-center mb-8">
                    <div class="inline-block p-4 bg-red-100 rounded-full mb-4">
                        <i class="fas fa-heart text-red-600 text-4xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">Connexion</h2>
                    <p class="text-gray-600 mt-2">Accédez à votre espace personnel</p>
                </div>

                <!-- Formulaire de Connexion -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <form class="space-y-6">
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email"
                                    class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent"
                                    placeholder="votre@email.com">
                            </div>
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password"
                                    class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Options -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-700">Se souvenir de moi</label>
                            </div>
                            <a href="#" class="text-sm text-red-600 hover:text-red-700">Mot de passe oublié ?</a>
                        </div>

                        <!-- Bouton de connexion -->
                        <button type="submit"
                            class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition transform hover:scale-105">
                            Se connecter
                        </button>
                    </form>

                    <!-- Séparateur -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Ou continuez avec</span>
                        </div>
                    </div>

                    <!-- Boutons sociaux -->
                    <div class="grid grid-cols-2 gap-4">
                        <button
                            class="flex items-center justify-center px-4 py-2 border rounded-lg hover:bg-gray-50 transition">
                            <i class="fab fa-google text-red-600 mr-2"></i>
                            Google
                        </button>
                        <button
                            class="flex items-center justify-center px-4 py-2 border rounded-lg hover:bg-gray-50 transition">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>
                            Facebook
                        </button>
                    </div>

                    <!-- Lien d'inscription -->
                    <p class="text-center mt-6 text-gray-600">
                        Pas encore de compte ?
                        <a href="register.html" class="text-red-600 hover:text-red-700 font-semibold">S'inscrire</a>
                    </p>
                </div>
            </div>
        </div>
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
                <div>
                    <h4 class="text-lg font-semibold mb-4">Légal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Mentions légales</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Confidentialité</a></li>
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

    <!-- <script>
    //     // Menu mobile
    //     const mobileMenuButton = document.getElementById('mobile-menu-button');
    //     const mobileMenu = document.getElementById('mobile-menu');

    //     mobileMenuButton.addEventListener('click', () => {
    //         mobileMenu.classList.toggle('hidden');
    //     });

    //     // Close mobile menu when clicking outside
    //     document.addEventListener('click', (e) => {
    //         if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
    //             mobileMenu.classList.add('hidden');
    //         }
    //     });
    // </script> -->
</body>

</html>