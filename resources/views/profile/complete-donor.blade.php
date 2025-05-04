<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodBank - Complétez votre profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/scrollreveal"></script>
</head>

<body class="font-sans">
    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{route('home')}}" class="text-red-600 text-2xl font-bold">BloodBank</a>
                </div>

               
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>

             
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                    <a href="/about" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                    <a href="/contact" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-600">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-red-600 transition">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>

               
                <div class="hidden md:hidden absolute top-full left-0 right-0 bg-white shadow-md p-6" id="mobile-menu">
                    <div class="flex flex-col space-y-4">
                        <a href="/" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                        <a href="/about" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                        <a href="/contact" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                        @auth
                            <span class="text-gray-600">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-red-600 transition">
                                    Déconnexion
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <section class="min-h-screen pt-24 pb-12 bg-gradient-to-br from-red-50 via-red-100 to-white flex items-center">
        <div class="container mx-auto px-6 my-8">
            <div class="max-w-2xl mx-auto">
               
                <div class="text-center mb-8">
                    <div class="inline-block p-4 bg-red-100 rounded-full mb-4">
                        <i class="fas fa-user-edit text-red-600 text-4xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">Complétez votre profil</h2>
                    <p class="text-gray-600 mt-2">Ajoutez vos informations spécifiques pour une meilleure expérience</p>
                </div>

               
                <div class="flex items-center justify-center mb-8">
                    <div class="flex items-center">
                        <div class="rounded-full h-8 w-8 flex items-center justify-center bg-green-500 text-white">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="h-1 w-16 bg-green-500"></div>
                    </div>
                    <div class="flex items-center">
                        <div class="rounded-full h-8 w-8 flex items-center justify-center bg-red-600 text-white">
                            2
                        </div>
                    </div>
                </div>

               
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <form action="{{ route('completeProfile') }}" method="POST" class="space-y-6">
                        @csrf

                           
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations du donneur</h3>

                          
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Numéro
                                    de téléphone</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="tel" id="phone_number" name="phone_number"
                                        value="{{ old('phone_number', auth()->user()->donor->phone_number ?? '') }}"
                                        class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('phone_number') border-red-500 @enderror"
                                        placeholder="Votre numéro de téléphone">
                                </div>
                                @error('phone_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date
                                    de naissance</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input type="date" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', auth()->user()->donor->date_of_birth ?? '') }}"
                                        class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('date_of_birth') border-red-500 @enderror">
                                </div>
                                @error('date_of_birth')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                          
                            <div>
                                <label for="blood_type_id" class="block text-sm font-medium text-gray-700 mb-2">Groupe
                                    sanguin</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-tint text-gray-400"></i>
                                    </div>
                                    <select id="blood_type_id" name="blood_type_id"
                                        class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent appearance-none @error('blood_type_id') border-red-500 @enderror">
                                        <option value="">Sélectionnez votre groupe sanguin</option>
                                        @foreach ($bloodTypes ?? [] as $bloodType)
                                            <option value="{{ $bloodType->id }}"
                                                {{ old('blood_type_id', auth()->user()->donor->blood_type_id ?? '') == $bloodType->id ? 'selected' : '' }}>
                                                {{ $bloodType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                @error('blood_type_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                         
                            <div>
                                <label for="has_donated"
                                    class="block text-sm font-medium text-gray-700 mb-2">Avez-vous déjà donné du
                                    sang?</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-history text-gray-400"></i>
                                    </div>
                                    <select id="has_donated" name="has_donated"
                                        class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent appearance-none @error('has_donated') border-red-500 @enderror">
                                        <option value="" disabled
                                            {{ old('has_donated', auth()->user()->donor->has_donated ?? null) === null ? 'selected' : '' }}>
                                            Sélectionnez une option</option>
                                        <option value="1"
                                            {{ old('has_donated', auth()->user()->donor->has_donated ?? null) === 1 ? 'selected' : '' }}>
                                            Oui, j'ai déjà fait un don de sang</option>
                                        <option value="0"
                                            {{ old('has_donated', auth()->user()->donor->has_donated ?? null) === 0 ? 'selected' : '' }}>
                                            Non, ce sera ma première fois</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                @error('has_donated')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        

                    
                        <div class="flex items-center justify-between pt-4">
                            <button type="submit"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition transform hover:scale-105">
                                Compléter mon profil
                            </button>
                        </div>
                    </form>
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
                        <li><a href="/about" class="text-gray-400 hover:text-white">À propos</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-white">Contact</a></li>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (mobileMenu && !mobileMenu.classList.contains('hidden') &&
                        !mobileMenuButton.contains(e.target) &&
                        !mobileMenu.contains(e.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>
