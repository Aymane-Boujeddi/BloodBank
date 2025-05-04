<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodBank - Donnez votre sang, sauvez des vies</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .blood-wave {
            position: relative;
            overflow: hidden;
        }

        .blood-wave::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 20px;
            background: rgb(239, 68, 68);
            border-radius: 50% 50% 0 0;
        }
    </style>
</head>

<body class="font-sans bg-gray-50">
    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="." class="flex items-center">
                        <i class="fas fa-tint text-red-600 text-2xl mr-2"></i>
                        <span class="text-red-600 text-2xl font-bold">BloodBank</span>
                    </a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" id="home-link"
                        class="text-gray-600 hover:text-red-600 transition font-medium">Accueil</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}"
                            class="text-red-600 border border-red-600 px-6 py-2 rounded-full hover:bg-red-50 transition">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition shadow-md">
                            Inscription
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden md:hidden bg-white shadow-md" id="mobile-menu">
            <div class="container mx-auto px-6 py-4 flex flex-col space-y-4">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                <a href="{{ route('about') }}" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                <a href="{{ route('contact') }}" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-red-600 transition">Connexion</a>
                <a href="{{ route('register') }}" class="text-gray-600 hover:text-red-600 transition">Inscription</a>
            </div>
        </div>
    </nav>

    <section class="pt-24 bg-gradient-to-br from-red-50 via-white to-red-100">
        <div class="container mx-auto px-6 py-16">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4 leading-tight">
                        Donnez votre sang, <br><span class="text-red-600">Sauvez des vies</span>
                    </h1>
                    <p class="text-gray-600 text-lg mb-8">
                        Un don de sang peut sauver jusqu'à 3 vies. Rejoignez notre communauté de donneurs et participez
                        à cette noble cause.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}?role=donor"
                            class="bg-red-600 text-white px-8 py-3 rounded-full text-lg hover:bg-red-700 transition shadow-lg flex items-center justify-center">
                            <i class="fas fa-heart mr-2"></i> Devenir donneur
                        </a>
                        <a href="#find-center"
                            class="bg-white text-red-600 border-2 border-red-600 px-8 py-3 rounded-full text-lg hover:bg-red-50 transition flex items-center justify-center">
                            <i class="fas fa-map-marker-alt mr-2"></i> Trouver un centre
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 relative">
                    <div class="absolute -top-6 -left-6 w-20 h-20 bg-red-200 rounded-full opacity-70"></div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-red-200 rounded-full opacity-70"></div>
                    <img src="https://images.unsplash.com/photo-1615461066841-6116e61058f4?q=80&w=1000&auto=format"
                        alt="Don de sang" class="rounded-lg shadow-xl relative z-10 object-cover w-full h-[400px]">
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Nos services</h2>
                <p class="text-gray-600 mt-2">Comment notre plateforme vous aide à sauver des vies</p>
                <div class="w-20 h-1 bg-red-600 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition group">
                    <div class="text-red-600 text-3xl mb-4 transition-transform">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Recherche de centres</h3>
                    <p class="text-gray-600 mb-4">Trouvez facilement le centre de don le plus proche de chez vous grâce
                        à notre système de géolocalisation avancé.</p>
                    <a href="#" class="text-red-600 hover:text-red-700 font-medium inline-flex items-center">
                        Découvrir <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition group">
                    <div class="text-red-600 text-3xl mb-4 transition-transform">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Rendez-vous en ligne</h3>
                    <p class="text-gray-600 mb-4">Planifiez votre prochain don de sang en quelques clics et recevez des
                        rappels personnalisés.</p>
                    <a href="#" class="text-red-600 hover:text-red-700 font-medium inline-flex items-center">
                        Prendre rendez-vous <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition group">
                    <div class="text-red-600 text-3xl mb-4 transition-transform">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Suivi de vos dons</h3>
                    <p class="text-gray-600 mb-4">Suivez votre historique de dons, visualisez votre impact et recevez
                        des badges de reconnaissance.</p>
                    <a href="#" class="text-red-600 hover:text-red-700 font-medium inline-flex items-center">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-red-600 text-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-20 blood-wave opacity-10"></div>
        <div class="absolute bottom-0 left-0 w-full h-20 blood-wave opacity-10" style="transform: rotate(180deg);">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Notre impact</h2>
                <p class="mt-2 text-red-100">Ensemble, nous faisons la différence</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">12,580</div>
                    <div class="text-red-100">Donneurs actifs</div>
                </div>

                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">8,392</div>
                    <div class="text-red-100">Vies sauvées</div>
                </div>

                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">156</div>
                    <div class="text-red-100">Centres partenaires</div>
                </div>

                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">25,746</div>
                    <div class="text-red-100">Dons de sang</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gradient-to-r from-red-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Compatibilité des groupes sanguins</h2>
                <p class="text-gray-600 mt-2">Comprendre qui peut recevoir votre don</p>
                <div class="w-20 h-1 bg-red-600 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-xl font-semibold mb-6 text-gray-800">Tableau de compatibilité</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th
                                        class="py-3 px-4 bg-red-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                                        Groupe sanguin
                                    </th>
                                    <th
                                        class="py-3 px-4 bg-red-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                                        Peut donner à
                                    </th>
                                    <th
                                        class="py-3 px-4 bg-red-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                                        Peut recevoir de
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <span
                                                class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mr-3">A+</span>
                                            <span class="font-medium text-gray-900">A positif</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-700">A+, AB+</td>
                                    <td class="py-4 px-4 text-center text-gray-700">A+, A-, O+, O-</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <span
                                                class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mr-3">A-</span>
                                            <span class="font-medium text-gray-900">A négatif</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-700">A+, A-, AB+, AB-</td>
                                    <td class="py-4 px-4 text-center text-gray-700">A-, O-</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <span
                                                class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mr-3">B+</span>
                                            <span class="font-medium text-gray-900">B positif</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-700">B+, AB+</td>
                                    <td class="py-4 px-4 text-center text-gray-700">B+, B-, O+, O-</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <span
                                                class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mr-3">B-</span>
                                            <span class="font-medium text-gray-900">B négatif</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-700">B+, B-, AB+, AB-</td>
                                    <td class="py-4 px-4 text-center text-gray-700">B-, O-</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <span
                                                class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mr-3">AB+</span>
                                            <span class="font-medium text-gray-900">AB positif</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-700">AB+ seulement</td>
                                    <td class="py-4 px-4 text-center text-gray-700">Tous les groupes</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <span
                                                class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mr-3">AB-</span>
                                            <span class="font-medium text-gray-900">AB négatif</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-700">AB+, AB-</td>
                                    <td class="py-4 px-4 text-center text-gray-700">A-, B-, AB-, O-</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <span
                                                class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mr-3">O+</span>
                                            <span class="font-medium text-gray-900">O positif</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-700">A+, B+, AB+, O+</td>
                                    <td class="py-4 px-4 text-center text-gray-700">O+, O-</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <span
                                                class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mr-3">O-</span>
                                            <span class="font-medium text-gray-900">O négatif</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-700">Tous les groupes</td>
                                    <td class="py-4 px-4 text-center text-gray-700">O- seulement</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex flex-col justify-between">
                    <div class="bg-white p-6 rounded-xl shadow-lg mb-6">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Le saviez-vous ?</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div
                                    class="flex-shrink-0 h-5 w-5 rounded-full bg-red-100 flex items-center justify-center mr-3 mt-0.5">
                                    <i class="fas fa-tint text-red-600 text-xs"></i>
                                </div>
                                <p class="text-gray-700">Le groupe O négatif est considéré comme le "donneur universel"
                                    car il peut être transfusé à n'importe quel patient.</p>
                            </li>
                            <li class="flex items-start">
                                <div
                                    class="flex-shrink-0 h-5 w-5 rounded-full bg-red-100 flex items-center justify-center mr-3 mt-0.5">
                                    <i class="fas fa-tint text-red-600 text-xs"></i>
                                </div>
                                <p class="text-gray-700">Le groupe AB+ est le "receveur universel" et peut recevoir du
                                    sang de tous les autres groupes.</p>
                            </li>
                            <li class="flex items-start">
                                <div
                                    class="flex-shrink-0 h-5 w-5 rounded-full bg-red-100 flex items-center justify-center mr-3 mt-0.5">
                                    <i class="fas fa-tint text-red-600 text-xs"></i>
                                </div>
                                <p class="text-gray-700">Seulement 7% de la population a un groupe sanguin O négatif,
                                    pourtant il est utilisé dans les situations d'urgence.</p>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-gradient-to-r from-red-600 to-red-700 p-6 rounded-xl shadow-lg text-white">
                        <h3 class="text-xl font-semibold mb-4">Demande actuelle</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold">O-</span>
                                    <span class="text-sm">Critique</span>
                                </div>
                                <div class="w-full bg-white bg-opacity-30 rounded-full h-2.5">
                                    <div class="bg-white h-2.5 rounded-full" style="width: 15%"></div>
                                </div>
                            </div>
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold">A+</span>
                                    <span class="text-sm">Modérée</span>
                                </div>
                                <div class="w-full bg-white bg-opacity-30 rounded-full h-2.5">
                                    <div class="bg-white h-2.5 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold">B-</span>
                                    <span class="text-sm">Faible</span>
                                </div>
                                <div class="w-full bg-white bg-opacity-30 rounded-full h-2.5">
                                    <div class="bg-white h-2.5 rounded-full" style="width: 25%"></div>
                                </div>
                            </div>
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold">AB+</span>
                                    <span class="text-sm">Stable</span>
                                </div>
                                <div class="w-full bg-white bg-opacity-30 rounded-full h-2.5">
                                    <div class="bg-white h-2.5 rounded-full" style="width: 75%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <a href="{{ route('register') }}?role=donor"
                                class="inline-flex items-center justify-center w-full px-5 py-3 mt-3 bg-white text-red-600 font-medium rounded-lg hover:bg-gray-100 transition-colors duration-300">
                                <i class="fas fa-heart mr-2"></i> Donner maintenant
                            </a>
                        </div>
                    </div>
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
                        <li><a href="." class="text-gray-400 hover:text-white">Mentions
                                légales</a></li>
                        <li><a href="" class="text-gray-400 hover:text-white">Confidentialité</a></li>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
