<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonSang - Inscription</title>
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
                    <a href="/" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                    <a href="/about" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                    <a href="/contact" class="text-gray-600 hover:text-red-600 transition">Contact</a>
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

                <!-- Menu Mobile Content -->
                <div class="hidden md:hidden absolute top-full left-0 right-0 bg-white shadow-md p-6" id="mobile-menu">
                    <div class="flex flex-col space-y-4">
                        <a href="/" class="text-gray-600 hover:text-red-600 transition">Accueil</a>
                        <a href="/about" class="text-gray-600 hover:text-red-600 transition">À propos</a>
                        <a href="/contact" class="text-gray-600 hover:text-red-600 transition">Contact</a>
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-red-600 transition">Connexion</a>
                        <a href="{{ route('register') }}"
                            class="text-gray-600 hover:text-red-600 transition">Inscription</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Registration Section -->
    <section class="min-h-screen pt-24 pb-12 bg-gradient-to-br from-red-50 via-red-100 to-white flex items-center">
        <div class="container mx-auto px-6 my-8">
            <div class="max-w-2xl mx-auto">
                <!-- Logo et Titre -->
                <div class="text-center mb-8">
                    <div class="inline-block p-4 bg-red-100 rounded-full mb-4">
                        <i class="fas fa-heart text-red-600 text-4xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">Inscription</h2>
                    <p class="text-gray-600 mt-2">Rejoignez la communauté des donneurs et sauvez des vies</p>
                </div>

                <!-- Formulaire d'Inscription -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <form action="{{ route('register') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nom -->
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

                        <!-- Email -->
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

                        <!-- Type d'utilisateur (improved design) -->
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

                        <!-- Conditional Fields -->
                        <div id="donor-fields" class="space-y-6 @if (old('role') == 'donation_centre') hidden @endif">
                            <!-- Téléphone (pour les donneurs) -->
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Numéro
                                    de téléphone</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="tel" id="phone_number" name="phone_number"
                                        value="{{ old('phone_number') }}"
                                        class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('phone_number') border-red-500 @enderror"
                                        placeholder="Votre numéro de téléphone">
                                </div>
                                @error('phone_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date de naissance (pour les donneurs) -->
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date
                                    de naissance</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input type="date" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth') }}"
                                        class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('date_of_birth') border-red-500 @enderror">
                                </div>
                                @error('date_of_birth')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="center-fields" class="space-y-6 @if (old('role', 'donor') == 'donor') hidden @endif">
                            <!-- Nom du centre -->
                            <div>
                                <label for="center_name" class="block text-sm font-medium text-gray-700 mb-2">Nom du
                                    centre</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-hospital text-gray-400"></i>
                                    </div>
                                    <input type="text" id="center_name" name="center_name"
                                        value="{{ old('center_name') }}"
                                        class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('center_name') border-red-500 @enderror"
                                        placeholder="Nom du centre de don">
                                </div>
                                @error('center_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Adresse -->
                            <div>
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                <div class="relative">
                                    <div class="absolute top-3 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                    <textarea id="address" name="address" rows="2"
                                        class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('address') border-red-500 @enderror"
                                        placeholder="Adresse complète du centre">{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Téléphone (pour le centre) -->
                            <div>
                                <label for="center_phone"
                                    class="block text-sm font-medium text-gray-700 mb-2">Téléphone du centre</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="tel" id="center_phone" name="center_phone"
                                        value="{{ old('center_phone') }}"
                                        class="w-full pl-10 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent @error('center_phone') border-red-500 @enderror"
                                        placeholder="Numéro de téléphone du centre">
                                </div>
                                @error('center_phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Ville -->
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

                        <!-- Mot de passe -->
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

                        <!-- Confirmer mot de passe -->
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

                        <!-- Options -->
                        <div class="flex items-center">
                            <input type="checkbox" id="terms" name="terms"
                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-700">J'accepte les <a href="#"
                                    class="text-red-600 hover:text-red-800 font-medium">conditions
                                    d'utilisation</a></label>
                        </div>

                        <!-- Bouton de connexion -->
                        <button type="submit"
                            class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition transform hover:scale-105">
                            Créer mon compte
                        </button>
                    </form>

                    <!-- Séparateur -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Ou inscrivez-vous avec</span>
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
                        Déjà un compte ?
                        <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 font-semibold">Se
                            connecter</a>
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
        // Menu mobile
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', (e) => {
                    if (mobileMenu && !mobileMenu.classList.contains('hidden') &&
                        !mobileMenuButton.contains(e.target) &&
                        !mobileMenu.contains(e.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }

            // Toggle form fields based on user type
            const donorRadio = document.getElementById('role_donor');
            const centerRadio = document.getElementById('role_donation_centre');
            const donorFields = document.getElementById('donor-fields');
            const centerFields = document.getElementById('center-fields');

            if (donorRadio && centerRadio && donorFields && centerFields) {
                // Initial state setup - ensure form is in correct state on page load
                function updateFieldVisibility() {
                    if (donorRadio.checked) {
                        donorFields.classList.remove('hidden');
                        centerFields.classList.add('hidden');

                        // Update styles for user type selection
                        donorRadio.closest('label').classList.add('bg-red-50', 'border-red-500');
                        centerRadio.closest('label').classList.remove('bg-red-50', 'border-red-500');

                        centerRadio.closest('label').querySelector('i').classList.remove('text-red-600');
                        centerRadio.closest('label').querySelector('i').classList.add('text-gray-500');

                        donorRadio.closest('label').querySelector('i').classList.add('text-red-600');
                        donorRadio.closest('label').querySelector('i').classList.remove('text-gray-500');

                        // Also update text colors
                        donorRadio.closest('label').querySelector('span').classList.add('text-red-600');
                        donorRadio.closest('label').querySelector('span').classList.remove('text-gray-700');

                        centerRadio.closest('label').querySelector('span').classList.remove('text-red-600');
                        centerRadio.closest('label').querySelector('span').classList.add('text-gray-700');
                    } else {
                        donorFields.classList.add('hidden');
                        centerFields.classList.remove('hidden');

                        // Update styles for user type selection
                        donorRadio.closest('label').classList.remove('bg-red-50', 'border-red-500');
                        centerRadio.closest('label').classList.add('bg-red-50', 'border-red-500');

                        donorRadio.closest('label').querySelector('i').classList.remove('text-red-600');
                        donorRadio.closest('label').querySelector('i').classList.add('text-gray-500');

                        centerRadio.closest('label').querySelector('i').classList.add('text-red-600');
                        centerRadio.closest('label').querySelector('i').classList.remove('text-gray-500');

                        // Also update text colors
                        centerRadio.closest('label').querySelector('span').classList.add('text-red-600');
                        centerRadio.closest('label').querySelector('span').classList.remove('text-gray-700');

                        donorRadio.closest('label').querySelector('span').classList.remove('text-red-600');
                        donorRadio.closest('label').querySelector('span').classList.add('text-gray-700');
                    }
                }

                // Set up initial state
                updateFieldVisibility();

                // Add event listeners
                donorRadio.addEventListener('change', updateFieldVisibility);
                centerRadio.addEventListener('change', updateFieldVisibility);
            }
        });
    </script>
</body>

</html>
