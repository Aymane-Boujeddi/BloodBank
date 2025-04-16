@extends('layouts.donor')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Centres de don de sang</h1>
            <p class="text-gray-600 mt-2">Trouvez un centre de don près de chez vous</p>
        </div>

        <!-- Search and Filter Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6">
            <div class="p-6">
                <form action="{{ route('donor.centers') }}" method="GET" id="centers-form">
                    <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-4">
                        <!-- Search Bar -->
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text" name="search" id="search-input"
                                    placeholder="Rechercher un centre par nom ou adresse..." value="{{ request('search') }}"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                                <div class="absolute left-3 top-3.5 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>

                        <!-- City Filter -->
                        <div class="md:w-1/3">
                            <select name="city" id="city-filter"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white transition-all appearance-none bg-no-repeat"
                                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%23a0aec0\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3e%3cpolyline points=\'6 9 12 15 18 9\'%3e%3c/polyline%3e%3c/svg%3e'); background-position: right 1rem center; background-size: 1em;">
                                <option value="">Toutes les villes</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="w-full md:w-auto px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all shadow-sm">
                                <i class="fas fa-filter mr-2"></i> Filtrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Centers Count -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6 px-6 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">Centres disponibles</h2>
                <div class="text-sm text-gray-500">
                    {{ count($centers) }} {{ count($centers) > 1 ? 'centres trouvés' : 'centre trouvé' }}
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Centers Grid -->
        @if (count($centers) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($centers as $center)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $center->center_name }}</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-500 mt-0.5">
                                        <i class="fas fa-map-marker-alt text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">Adresse</h4>
                                        <p class="text-sm text-gray-700">{{ $center->address }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 text-blue-500 mt-0.5">
                                        <i class="fas fa-city text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">Ville</h4>
                                        <p class="text-sm text-gray-700">{{ $center->city_name }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-green-50 text-green-500 mt-0.5">
                                        <i class="fas fa-phone text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">Téléphone</h4>
                                        <p class="text-sm text-gray-700">{{ $center->phone_number }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-yellow-50 text-yellow-500 mt-0.5">
                                        <i class="far fa-clock text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">Heures d'ouverture</h4>
                                        <p class="text-sm text-gray-700">8:00 - 17:00</p>
                                    </div>
                                </div>
                            </div>

                            @if ($center->latitude && $center->longitude)
                                <div class="mt-6 pt-5 border-t border-gray-100">
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $center->latitude }},{{ $center->longitude }}"
                                        target="_blank"
                                        class="inline-flex items-center justify-center w-full py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-300"
                                        title="Obtenir l'itinéraire via Google Maps">
                                        <i class="fas fa-directions mr-2"></i> Itinéraire via Google Maps
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="py-12 bg-white rounded-lg shadow-sm border border-gray-100 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <i class="fas fa-building text-gray-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun centre trouvé</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    Aucun centre de don de sang ne correspond à vos critères. Essayez de modifier vos filtres.
                </p>
                <a href="{{ route('donor.centers') }}" class="mt-4 inline-block text-red-600 hover:text-red-700">
                    <i class="fas fa-undo mr-2"></i> Réinitialiser les filtres
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup review buttons
            document.querySelectorAll('.center-review-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const card = this.closest('.center-card');
                    const reviewForm = card.querySelector('.review-form');
                    reviewForm.classList.toggle('hidden');
                });
            });

            // Setup rating stars
            document.querySelectorAll('.rating-input').forEach(container => {
                const stars = container.querySelectorAll('i');
                const ratingInput = container.closest('form').querySelector('.rating-value');

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const rating = parseInt(this.dataset.rating);
                        ratingInput.value = rating;

                        // Reset all stars
                        stars.forEach(s => s.classList.remove('text-yellow-400'));

                        // Highlight stars up to the clicked one
                        for (let i = 0; i < rating; i++) {
                            stars[i].classList.add('text-yellow-400');
                        }
                    });
                });
            });
        });
    </script>
@endpush
