<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodBank - Donnez votre sang, sauvez des vies</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/scrollreveal"></script>
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

        .stats-item {
            transition: transform 0.3s ease;
        }

        .stats-item:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body class="font-sans bg-gray-50">
    <!-- Barre de Navigation -->
    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <i class="fas fa-tint text-red-600 text-2xl mr-2"></i>
                        <span class="text-red-600 text-2xl font-bold">BloodBank</span>
                    </a>
                </div>

                <!-- Menu Mobile -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-600 hover:text-red-600 transition font-medium">Accueil</a>
                    <a href="/about" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                    <a href="/contact" class="text-gray-600 hover:text-red-600 transition">Contact</a>
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

        <!-- Menu Mobile Dropdown -->
        <div class="hidden md:hidden bg-white shadow-md" id="mobile-menu">
            <div class="container mx-auto px-6 py-4 flex flex-col space-y-4">
                <a href="/" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                <a href="/about" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                <a href="/contact" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-red-600 transition">Connexion</a>
                <a href="{{ route('register') }}" class="text-gray-600 hover:text-red-600 transition">Inscription</a>
            </div>
        </div>
    </nav>

    <!-- Section Héros -->
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
                            class="bg-red-600 text-white px-8 py-3 rounded-full text-lg hover:bg-red-700 transition transform hover:scale-105 shadow-lg flex items-center justify-center">
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

    <!-- Fonctionnalités Principales -->
    <section id="services" class="py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Nos services</h2>
                <p class="text-gray-600 mt-2">Comment notre plateforme vous aide à sauver des vies</p>
                <div class="w-20 h-1 bg-red-600 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Carte 1 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition group">
                    <div class="text-red-600 text-3xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Recherche de centres</h3>
                    <p class="text-gray-600 mb-4">Trouvez facilement le centre de don le plus proche de chez vous grâce
                        à notre système de géolocalisation avancé.</p>
                    <a href="#" class="text-red-600 hover:text-red-700 font-medium inline-flex items-center">
                        Découvrir <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Carte 2 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition group">
                    <div class="text-red-600 text-3xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Rendez-vous en ligne</h3>
                    <p class="text-gray-600 mb-4">Planifiez votre prochain don de sang en quelques clics et recevez des
                        rappels personnalisés.</p>
                    <a href="#" class="text-red-600 hover:text-red-700 font-medium inline-flex items-center">
                        Prendre rendez-vous <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Carte 3 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition group">
                    <div class="text-red-600 text-3xl mb-4 group-hover:scale-110 transition-transform">
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

    <!-- Section Actualités -->
    {{-- <section id="actualites" class="py-16 bg-gradient-to-tr from-gray-100 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Actualités</h2>
                <p class="text-gray-600 mt-2">Restez informé des dernières nouvelles</p>
                <div class="w-20 h-1 bg-red-600 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Actualité 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1579154204601-01588f351e67?q=80&w=1000&auto=format"
                        alt="Journée mondiale du don de sang" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-sm text-red-600 font-semibold">14 Juin 2025</span>
                        <h3 class="text-xl font-bold mt-2 mb-3">Journée mondiale du don de sang</h3>
                        <p class="text-gray-600">Participez à nos événements spéciaux organisés à travers le pays pour
                            célébrer cette journée importante.</p>
                        <a href="#" class="inline-block mt-4 text-red-600 hover:underline">Lire plus</a>
                    </div>
                </div>

                <!-- Actualité 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1631815587646-b85a1bb027e1?q=80&w=1000&auto=format"
                        alt="Besoin urgent de sang" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-sm text-red-600 font-semibold">5 Avril 2025</span>
                        <h3 class="text-xl font-bold mt-2 mb-3">Besoin urgent de sang type O-</h3>
                        <p class="text-gray-600">Les réserves de sang de type O- sont au plus bas. Votre don est
                            crucial pour les patients en attente.</p>
                        <a href="#" class="inline-block mt-4 text-red-600 hover:underline">Lire plus</a>
                    </div>
                </div>

                <!-- Actualité 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1579684453423-f84349ef60b0?q=80&w=1000&auto=format"
                        alt="Nouvelle technologie" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-sm text-red-600 font-semibold">20 Mars 2025</span>
                        <h3 class="text-xl font-bold mt-2 mb-3">Nouvelles technologies dans le domaine du don du sang
                        </h3>
                        <p class="text-gray-600">Découvrez les avancées technologiques qui révolutionnent le processus
                            de collecte et de stockage du sang.</p>
                        <a href="#" class="inline-block mt-4 text-red-600 hover:underline">Lire plus</a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="#"
                    class="inline-block bg-red-600 text-white px-8 py-3 rounded-full hover:bg-red-700 transition shadow-md">
                    Toutes les actualités
                </a>
            </div>
        </div>
    </section> --}}

    <!-- Section Statistiques -->
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
                <!-- Stat 1 -->
                <div class="text-center stats-item">
                    <div class="text-4xl font-bold mb-2">12,580</div>
                    <div class="text-red-100">Donneurs actifs</div>
                </div>

                <!-- Stat 2 -->
                <div class="text-center stats-item">
                    <div class="text-4xl font-bold mb-2">8,392</div>
                    <div class="text-red-100">Vies sauvées</div>
                </div>

                <!-- Stat 3 -->
                <div class="text-center stats-item">
                    <div class="text-4xl font-bold mb-2">156</div>
                    <div class="text-red-100">Centres partenaires</div>
                </div>

                <!-- Stat 4 -->
                <div class="text-center stats-item">
                    <div class="text-4xl font-bold mb-2">25,746</div>
                    <div class="text-red-100">Dons de sang</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Témoignages -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Témoignages</h2>
                <p class="text-gray-600 mt-2">Ce que disent nos donneurs et bénéficiaires</p>
                <div class="w-20 h-1 bg-red-600 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Témoignage 1 -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-sm">
                    <div class="text-red-500 text-3xl mb-4">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="text-gray-600 italic mb-6">
                        "Grâce aux donneurs de sang, j'ai pu surmonter ma leucémie. Vous ne savez pas à quel point votre
                        geste est précieux pour des personnes comme moi."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-300 rounded-full overflow-hidden mr-4">
                            <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Sophie Martin">
                        </div>
                        <div>
                            <h4 class="font-semibold">Sophie Martin</h4>
                            <p class="text-sm text-gray-500">Bénéficiaire</p>
                        </div>
                    </div>
                </div>

                <!-- Témoignage 2 -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-sm">
                    <div class="text-red-500 text-3xl mb-4">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="text-gray-600 italic mb-6">
                        "Je donne mon sang régulièrement depuis 5 ans. C'est un petit geste qui prend peu de temps mais
                        qui a un impact énorme sur la vie des autres."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-300 rounded-full overflow-hidden mr-4">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Thomas Dubois">
                        </div>
                        <div>
                            <h4 class="font-semibold">Thomas Dubois</h4>
                            <p class="text-sm text-gray-500">Donneur régulier</p>
                        </div>
                    </div>
                </div>

                <!-- Témoignage 3 -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-sm">
                    <div class="text-red-500 text-3xl mb-4">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="text-gray-600 italic mb-6">
                        "En tant que médecin urgentiste, je vois chaque jour l'importance des dons de sang. Les donneurs
                        sont des héros anonymes qui sauvent des vies."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-300 rounded-full overflow-hidden mr-4">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Dr. Sarah Benali">
                        </div>
                        <div>
                            <h4 class="font-semibold">Dr. Sarah Benali</h4>
                            <p class="text-sm text-gray-500">Médecin urgentiste</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Newsletter -->
    {{-- <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 bg-red-600 text-white p-8 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-5xl mb-4">
                                <i class="far fa-envelope"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-2">Restez informé</h3>
                            <p class="text-red-100">Recevez nos actualités</p>
                        </div>
                    </div>
                    <div class="md:w-2/3 p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Inscrivez-vous à notre newsletter</h3>
                        <p class="text-gray-600 mb-6">
                            Recevez des informations sur les campagnes de don, les besoins urgents et les actualités
                            importantes.
                        </p>
                        <form class="flex flex-col sm:flex-row gap-4">
                            <input type="email" placeholder="Votre adresse email"
                                class="flex-grow px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
                            <button type="submit"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition whitespace-nowrap">
                                S'abonner
                            </button>
                        </form>
                        <p class="text-xs text-gray-500 mt-4">
                            En vous inscrivant, vous acceptez notre politique de confidentialité. Vous pourrez vous
                            désabonner à tout moment.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Section Partenaires -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Nos partenaires</h2>
                <p class="text-gray-600 mt-2">Ils nous font confiance et nous soutiennent</p>
                <div class="w-20 h-1 bg-red-600 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 items-center">
                <div class="flex items-center justify-center grayscale hover:grayscale-0 transition">
                    <img src="https://placehold.co/150x80?text=Partenaire+1" alt="Partenaire 1" class="max-h-16">
                </div>
                <div class="flex items-center justify-center grayscale hover:grayscale-0 transition">
                    <img src="https://placehold.co/150x80?text=Partenaire+2" alt="Partenaire 2" class="max-h-16">
                </div>
                <div class="flex items-center justify-center grayscale hover:grayscale-0 transition">
                    <img src="https://placehold.co/150x80?text=Partenaire+3" alt="Partenaire 3" class="max-h-16">
                </div>
                <div class="flex items-center justify-center grayscale hover:grayscale-0 transition">
                    <img src="https://placehold.co/150x80?text=Partenaire+4" alt="Partenaire 4" class="max-h-16">
                </div>
                <div class="flex items-center justify-center grayscale hover:grayscale-0 transition">
                    <img src="https://placehold.co/150x80?text=Partenaire+5" alt="Partenaire 5" class="max-h-16">
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- Find Center -->
    <section id="find-center" class="py-16 bg-gradient-to-br from-red-50 to-white relative overflow-hidden">
        <!-- Decorative blood drops -->
        <div class="absolute top-10 left-10 w-16 h-16 bg-red-100 rounded-full opacity-50"></div>
        <div class="absolute bottom-20 right-20 w-24 h-24 bg-red-100 rounded-full opacity-50"></div>
        <div class="absolute top-40 right-40 w-12 h-12 bg-red-100 rounded-full opacity-30"></div>
        
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">Trouvez où donner</h2>
                    <p class="text-gray-600 mt-2">Votre don est précieux, trouvez le centre qui vous attend</p>
                    <div class="w-20 h-1 bg-red-600 mx-auto mt-4"></div>
                </div>
                
                <div class="bg-white rounded-xl shadow-xl p-6 md:p-8 backdrop-blur-sm bg-opacity-80">
                    <!-- Search bar -->
                    <div class="mb-6">
                        <div class="flex items-center p-2 bg-gray-50 rounded-full shadow-inner">
                            <i class="fas fa-search text-gray-400 mx-3"></i>
                            <input type="text" placeholder="Entrez votre adresse ou code postal" class="bg-transparent border-none w-full focus:outline-none py-2">
                            <button class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition transform hover:scale-105 ml-2 flex-shrink-0">
                                Rechercher
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="md:w-1/2">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-semibold">Centres à proximité</h3>
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="mr-2">Trier par:</span>
                                    <select class="text-sm border-b border-gray-300 focus:outline-none focus:border-red-600 bg-transparent">
                                        <option>Distance</option>
                                        <option>Disponibilité</option>
                                        <option>Horaires</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="space-y-4 max-h-96 overflow-y-auto pr-2 styled-scrollbar">
                                <!-- Centre 1 -->
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-red-50 transition cursor-pointer transform hover:-translate-y-1 hover:shadow-md">
                                    <div class="flex justify-between">
                                        <h4 class="font-semibold text-red-600">Centre Hospitalier Universitaire</h4>
                                        <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full flex items-center">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> Ouvert
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1"><i class="fas fa-map-marker-alt mr-1 text-red-400"></i> 123 Avenue de la République, Paris</p>
                                    <div class="flex justify-between items-center mt-3">
                                        <div class="flex items-center">
                                            <i class="far fa-clock text-gray-400 mr-1"></i>
                                            <span class="text-xs text-gray-500">9h - 18h</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-sm text-red-600 font-medium mr-2">2.3 km</span>
                                            <i class="fas fa-chevron-right text-gray-400"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex items-center text-sm text-red-500">
                                        <i class="fas fa-tint mr-1"></i> 
                                        <span>Besoin urgent: A+ et O-</span>
                                    </div>
                                </div>
                                
                                <!-- Centre 2 -->
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-red-50 transition cursor-pointer transform hover:-translate-y-1 hover:shadow-md">
                                    <div class="flex justify-between">
                                        <h4 class="font-semibold text-red-600">Clinique Saint Michel</h4>
                                        <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full flex items-center">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> Ouvert
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1"><i class="fas fa-map-marker-alt mr-1 text-red-400"></i> 45 Rue des Lilas, Paris</p>
                                    <div class="flex justify-between items-center mt-3">
                                        <div class="flex items-center">
                                            <i class="far fa-clock text-gray-400 mr-1"></i>
                                            <span class="text-xs text-gray-500">8h - 19h30</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-sm text-red-600 font-medium mr-2">3.7 km</span>
                                            <i class="fas fa-chevron-right text-gray-400"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-sm text-gray-500">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs">Parking gratuit</span>
                                        <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs ml-1">Sans RDV</span>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="#" class="mt-4 text-red-600 hover:text-red-700 inline-flex items-center font-medium group">
                                Voir tous les centres 
                                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition"></i>
                            </a>
                        </div>
                        
                        <div class="md:w-1/2">
                            <div class="relative h-96 rounded-lg overflow-hidden bg-gray-100 shadow-md border border-gray-200">
                                <!-- Interactive map placeholder -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center bg-gray-50">
                                    <div class="relative w-full h-full">
                                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-100"></div>
                                        <img src="https://api.mapbox.com/styles/v1/mapbox/light-v10/static/2.3488,48.8534,12,0/600x400?access_token=pk.placeholder" 
                                             alt="Carte des centres" class="w-full h-full object-cover opacity-90">
                                        
                                        <!-- Map pins -->
                                        <div class="absolute top-1/3 left-1/3 transform -translate-x-1/2 -translate-y-1/2">
                                            <div class="animate-pulse">
                                                <div class="w-4 h-4 bg-red-600 rounded-full"></div>
                                                <div class="w-4 h-4 bg-red-600 rounded-full animate-ping absolute inset-0 opacity-75"></div>
                                            </div>
                                        </div>
                                        <div class="absolute top-1/2 left-2/3 transform -translate-x-1/2 -translate-y-1/2">
                                            <div class="w-4 h-4 bg-red-600 rounded-full"></div>
                                        </div>
                                        <div class="absolute top-2/3 left-1/5 transform -translate-x-1/2 -translate-y-1/2">
                                            <div class="w-4 h-4 bg-red-600 rounded-full"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="absolute bottom-0 left-0 right-0 bg-white bg-opacity-95 p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium">Utilisez votre localisation</p>
                                            <p class="text-xs text-gray-500">Pour trouver les centres les plus proches</p>
                                        </div>
                                        <button class="bg-red-600 text-white px-4 py-2 rounded-full text-sm hover:bg-red-700 transform hover:scale-105 transition flex items-center">
                                            <i class="fas fa-location-arrow mr-1"></i> Me localiser
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Blood type selector -->
                            <div class="mt-4 p-3 bg-red-50 rounded-lg">
                                <p class="text-sm font-medium text-red-800 mb-2">Filtrer par groupe sanguin demandé:</p>
                                <div class="flex flex-wrap gap-2">
                                    <button class="px-3 py-1 bg-white border border-red-200 rounded-full text-sm hover:bg-red-600 hover:text-white transition">A+</button>
                                    <button class="px-3 py-1 bg-white border border-red-200 rounded-full text-sm hover:bg-red-600 hover:text-white transition">A-</button>
                                    <button class="px-3 py-1 bg-white border border-red-200 rounded-full text-sm hover:bg-red-600 hover:text-white transition">B+</button>
                                    <button class="px-3 py-1 bg-white border border-red-200 rounded-full text-sm hover:bg-red-600 hover:text-white transition">B-</button>
                                    <button class="px-3 py-1 bg-white border border-red-200 rounded-full text-sm hover:bg-red-600 hover:text-white transition">AB+</button>
                                    <button class="px-3 py-1 bg-white border border-red-200 rounded-full text-sm hover:bg-red-600 hover:text-white transition">AB-</button>
                                    <button class="px-3 py-1 bg-white border border-red-200 rounded-full text-sm hover:bg-red-600 hover:text-white transition">O+</button>
                                    <button class="px-3 py-1 bg-red-600 text-white border border-red-600 rounded-full text-sm">O-</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Call to action -->
                    <div class="mt-8 bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-4 text-white text-center">
                        <div class="flex items-center justify-center">
                            <div class="mr-3">
                                <i class="fas fa-calendar-alt text-2xl"></i>
                            </div>
                            <div class="text-left">
                                <h4 class="font-bold">Pas le temps aujourd'hui?</h4>
                                <p class="text-sm text-red-100">Planifiez votre prochain don et recevez un rappel</p>
                            </div>
                            <button class="ml-auto bg-white text-red-600 px-4 py-2 rounded-full font-medium hover:bg-red-100 transition">
                                Planifier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .styled-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .styled-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(239, 68, 68, 0.5);
            border-radius: 3px;
        }
        .styled-scrollbar::-webkit-scrollbar-track {
            background-color: rgba(0, 0, 0, 0.05);
        }
        </style>
    </section> --}}

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

    {{-- <script>
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
    </script> --}}
</body>

</html>
