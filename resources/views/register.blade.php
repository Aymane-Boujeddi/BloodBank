<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodBank - Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/scrollreveal"></script>
</head>

<body class="font-sans">
    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="text-red-600 text-2xl font-bold">BloodBank</a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}"
                            class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition">
                            Inscription
                        </a>
                    </div>
                </div>

                <div class="hidden md:hidden absolute top-full left-0 right-0 bg-white shadow-md p-6" id="mobile-menu">
                    <div class="flex flex-col space-y-4">
                        <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                        <a href="{{ route('about') }}" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                        <a href="{{ route('contact') }}" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-red-600 transition">Connexion</a>
                        <a href="{{ route('register') }}"
                            class="text-gray-600 hover:text-red-600 transition">Inscription</a>
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
                        <i class="fas fa-heart text-red-600 text-4xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">Inscription</h2>
                    <p class="text-gray-600 mt-2">Rejoignez la communauté des donneurs et sauvez des vies</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8">
                    <form action="{{ route('register') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom
                                complet</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('name') border-red-500 @enderror"
                                    placeholder="Votre nom complet">
                            </div>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('email') border-red-500 @enderror"
                                    placeholder="votre@email.com">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Je suis un...</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label for="role_donor"
                                    class="flex flex-col items-center p-3 border rounded-lg cursor-pointer transition-colors hover:bg-red-50 peer-checked:bg-red-50 peer-checked:border-red-500 @if (old('role', 'donor') == 'donor') bg-red-50 border-red-500 @else border-gray-300 @endif">
                                    <input type="radio" id="role_donor" name="role" value="donor"
                                        class="sr-only peer" {{ old('role', 'donor') == 'donor' ? 'checked' : '' }}>
                                    <i
                                        class="fas fa-user-alt text-xl mb-2 @if (old('role', 'donor') == 'donor') text-red-600 @else text-gray-500 @endif"></i>
                                    <span
                                        class="text-sm font-medium @if (old('role', 'donor') == 'donor') text-red-600 @else text-gray-700 @endif">Donneur</span>
                                </label>

                                <label for="role_donation_centre"
                                    class="flex flex-col items-center p-3 border rounded-lg cursor-pointer transition-colors hover:bg-red-50 peer-checked:bg-red-50 peer-checked:border-red-500 @if (old('role') == 'donation_centre') bg-red-50 border-red-500 @else border-gray-300 @endif">
                                    <input type="radio" id="role_donation_centre" name="role"
                                        value="donation_centre" class="sr-only peer"
                                        {{ old('role') == 'donation_centre' ? 'checked' : '' }}>
                                    <i
                                        class="fas fa-hospital text-xl mb-2 @if (old('role') == 'donation_centre') text-red-600 @else text-gray-500 @endif"></i>
                                    <span
                                        class="text-sm font-medium @if (old('role') == 'donation_centre') text-red-600 @else text-gray-700 @endif">Centre
                                        de don</span>
                                </label>
                            </div>
                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city_id" class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                                <select id="city_id" name="city_id"
                                    class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent appearance-none @error('city_id') border-red-500 @enderror">
                                    <option value="">Sélectionnez votre ville</option>
                                    @foreach ($cities ?? [] as $city)
                                        <option value="{{ $city->id }}"
                                            {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            @error('city_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de
                                passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password"
                                    class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="terms" name="terms"
                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-700">J'accepte les <a href="#"
                                    class="text-red-600 hover:text-red-800 font-medium">conditions
                                    d'utilisation</a></label>
                        </div>

                        <div class="bg-blue-50 text-blue-700 p-3 rounded-md text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            Après votre inscription, vous pourrez compléter votre profil avec des informations
                            supplémentaires.
                        </div>

                        <button type="submit"
                            class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition transform hover:scale-105">
                            Créer mon compte
                        </button>
                    </form>

                    <p class="text-center mt-6 text-gray-600">
                        Déjà un compte ?
                        <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 font-semibold">Se
                            connecter</a>
                    </p>
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
                        <li><a href="{{ route('legal') }}" class="text-gray-400 hover:text-white">Mentions
                                légales</a></li>
                        <li><a href="{{ route('privacy') }}"
                                class="text-gray-400 hover:text-white">Confidentialité</a></li>
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

            const donorRadio = document.getElementById('role_donor');
            const centerRadio = document.getElementById('role_donation_centre');

            if (donorRadio && centerRadio) {
                function updateRadioStyles() {
                    const donorLabel = donorRadio.closest('label');
                    const donorIcon = donorLabel.querySelector('i');
                    const donorText = donorLabel.querySelector('span');

                    const centerLabel = centerRadio.closest('label');
                    const centerIcon = centerLabel.querySelector('i');
                    const centerText = centerLabel.querySelector('span');

                    if (donorRadio.checked) {
                        donorLabel.classList.add('bg-red-50', 'border-red-500');
                        donorIcon.classList.add('text-red-600');
                        donorIcon.classList.remove('text-gray-500');
                        donorText.classList.add('text-red-600');
                        donorText.classList.remove('text-gray-700');

                        centerLabel.classList.remove('bg-red-50', 'border-red-500');
                        centerIcon.classList.remove('text-red-600');
                        centerIcon.classList.add('text-gray-500');
                        centerText.classList.remove('text-red-600');
                        centerText.classList.add('text-gray-700');
                    } else if (centerRadio.checked) {
                        centerLabel.classList.add('bg-red-50', 'border-red-500');
                        centerIcon.classList.add('text-red-600');
                        centerIcon.classList.remove('text-gray-500');
                        centerText.classList.add('text-red-600');
                        centerText.classList.remove('text-gray-700');

                        donorLabel.classList.remove('bg-red-50', 'border-red-500');
                        donorIcon.classList.remove('text-red-600');
                        donorIcon.classList.add('text-gray-500');
                        donorText.classList.remove('text-red-600');
                        donorText.classList.add('text-gray-700');
                    }
                }

                updateRadioStyles();

                donorRadio.addEventListener('change', updateRadioStyles);
                centerRadio.addEventListener('change', updateRadioStyles);
            }
        });
    </script>
</body>

</html>
