<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodBank - À Propos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/scrollreveal"></script>
</head>

<body class="font-sans">
    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-red-600 text-2xl font-bold">BloodBank</a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                    <a href="{{ route('login') }}" class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition">
                        Connexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-24 bg-gradient-to-br from-red-50 via-red-100 to-white">
        <div class="container mx-auto px-6 py-16">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl font-bold text-gray-800 mb-6">Notre Histoire</h1>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Depuis notre création, nous nous engageons à faciliter et à promouvoir le don de sang pour sauver des vies. 
                    Notre plateforme connecte les donneurs aux centres de don, rendant le processus simple et accessible.
                </p>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="bg-white rounded-xl shadow-lg p-8 transform hover:-translate-y-2 transition duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-heart text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Notre Mission</h3>
                    <p class="text-gray-600">
                        Faciliter l'accès au don de sang et sauver plus de vies en connectant donneurs et centres de don.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 transform hover:-translate-y-2 transition duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Notre Vision</h3>
                    <p class="text-gray-600">
                        Créer un réseau national efficace où chaque personne peut facilement contribuer à sauver des vies.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 transform hover:-translate-y-2 transition duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-star text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Nos Valeurs</h3>
                    <p class="text-gray-600">
                        Engagement, transparence et innovation au service de la santé publique.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-red-600 text-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold mb-2">50K+</div>
                    <p class="text-red-100">Donneurs Actifs</p>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">100+</</div>
                    <p class="text-red-100">Centres Partenaires</p>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">150K+</div>
                    <p class="text-red-100">Vies Sauvées</p>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">98%</div>
                    <p class="text-red-100">Satisfaction</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Notre Équipe</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="w-32 h-32 rounded-full overflow-hidden mx-auto mb-6">
                        <img src="https://placehold.co/200x200" alt="Team member" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Dr. Sophie Martin</h3>
                    <p class="text-gray-600">Directrice Médicale</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">BloodBank</h3>
                    <p class="text-gray-400">Ensemble, sauvons des vies</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liens utiles</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">À propos</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contact</a></li>
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
</body>
</html>