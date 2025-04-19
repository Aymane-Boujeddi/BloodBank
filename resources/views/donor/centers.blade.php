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
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $center->center_name }}</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-500 mt-0.5">
                                        <i class="fas fa-map-marker-alt text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">Adresse
                                        </h4>
                                        <p class="text-sm text-gray-700">{{ $center->address }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 text-blue-500 mt-0.5">
                                        <i class="fas fa-city text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">Ville
                                        </h4>
                                        <p class="text-sm text-gray-700">{{ $center->city_name }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-green-50 text-green-500 mt-0.5">
                                        <i class="fas fa-phone text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">
                                            Téléphone</h4>
                                        <p class="text-sm text-gray-700">{{ $center->phone_number }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-yellow-50 text-yellow-500 mt-0.5">
                                        <i class="far fa-clock text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">
                                            Disponibilité</h4>
                                        <p class="text-sm text-gray-700">{{ $center->availability_message }}</p>

                                        @if (isset($center->available_slots) && isset($center->reserved_slots))
                                            <div class="mt-1">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    @php
                                                        $percentage =
                                                            $center->available_slots > 0
                                                                ? max(
                                                                    0,
                                                                    min(
                                                                        100,
                                                                        ($center->reserved_slots /
                                                                            $center->available_slots) *
                                                                            100,
                                                                    ),
                                                                )
                                                                : 100;
                                                    @endphp
                                                    <div class="bg-red-600 h-2 rounded-full"
                                                        style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ $center->available_slots - $center->reserved_slots }} places
                                                    disponibles sur {{ $center->available_slots }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-3">
                                @if ($center->latitude && $center->longitude)
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $center->latitude }},{{ $center->longitude }}"
                                        target="_blank"
                                        class="inline-flex items-center justify-center py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-300"
                                        title="Obtenir l'itinéraire via Google Maps">
                                        <i class="fas fa-directions mr-2"></i> Itinéraire
                                    </a>
                                @endif

                                <!-- Reservation Button -->
                                <button type="button"
                                    class="inline-flex items-center justify-center py-2.5 px-4 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-300 reservation-btn"
                                    data-center-id="{{ $center->id }}" data-center-name="{{ $center->center_name }}">
                                    <i class="fas fa-calendar-plus mr-2"></i> Prendre RDV
                                </button>
                            </div>
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

<!-- Reservation Modal -->
<div id="reservation-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Prendre rendez-vous</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500" id="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('donor.reservations.store') }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="donation_center_id" id="modal-center-id">
            <input type="hidden" name="donor_id" value="{{ auth()->user()->donor->id }}">

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" id="modal-center-name-label">Centre de
                        don</label>
                    <p class="text-base font-semibold text-gray-900" id="modal-center-name"></p>
                </div>

                <div>
                    <label for="reservation_date" class="block text-sm font-medium text-gray-700 mb-1">Date du
                        rendez-vous</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" id="reservation_date" name="reservation_date"
                            class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            min="{{ date('Y-m-d') }}" required>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Choisissez une date à partir d'aujourd'hui</p>
                </div>

                <div>
                    <label for="reservation_time" class="block text-sm font-medium text-gray-700 mb-1">Heure du
                        rendez-vous</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-clock text-gray-400"></i>
                        </div>
                        <select id="reservation_time" name="reservation_time"
                            class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 appearance-none"
                            required>
                            <option value="">Sélectionner une heure</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-5 flex items-center">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Choisissez un créneau disponible</p>
                </div>

                <div class="bg-yellow-50 p-3 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Veuillez noter que votre rendez-vous devra être confirmé par le centre de don.
                                Vous recevrez une notification dès que votre demande aura été traitée.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <button type="button"
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    id="cancel-reservation">
                    Annuler
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Confirmer le rendez-vous
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Reservation Modal Functionality
            const reservationModal = document.getElementById('reservation-modal');
            const closeModal = document.getElementById('close-modal');
            const cancelReservation = document.getElementById('cancel-reservation');
            const modalCenterId = document.getElementById('modal-center-id');
            const modalCenterName = document.getElementById('modal-center-name');
            const reservationDate = document.getElementById('reservation_date');
            const reservationTime = document.getElementById('reservation_time');

            // Open modal when clicking reservation buttons
            document.querySelectorAll('.reservation-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const centerId = this.dataset.centerId;
                    const centerName = this.dataset.centerName;

                    modalCenterId.value = centerId;
                    modalCenterName.textContent = centerName;

                    // Reset time options
                    reservationTime.innerHTML = '<option value="">Sélectionner une heure</option>';

                    // Open modal
                    reservationModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Prevent scrolling
                });
            });

            // Fetch available time slots when date changes
            reservationDate.addEventListener('change', function() {
                const date = this.value;
                const centerId = modalCenterId.value;

                if (date && centerId) {
                    // Clear current options
                    reservationTime.innerHTML = '<option value="">Chargement des horaires...</option>';

                    // Fetch available slots from API
                    fetch(`/donation-slots/available?date=${date}&center_id=${centerId}`)
                        .then(response => response.json())
                        .then(data => {
                            reservationTime.innerHTML =
                                '<option value="">Sélectionner une heure</option>';

                            if (data.slots && data.slots.length > 0) {
                                data.slots.forEach(slot => {
                                    const option = document.createElement('option');
                                    option.value = slot.time + ':00';
                                    option.textContent =
                                        `${slot.time} (${slot.available} place${slot.available > 1 ? 's' : ''} disponible${slot.available > 1 ? 's' : ''})`;
                                    reservationTime.appendChild(option);
                                });
                            } else {
                                const option = document.createElement('option');
                                option.value = "";
                                option.textContent = data.message || "Aucun créneau disponible";
                                option.disabled = true;
                                reservationTime.appendChild(option);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching time slots:', error);
                            reservationTime.innerHTML =
                            '<option value="">Erreur de chargement</option>';
                        });
                }
            });

            // Close modal functions
            const closeModalFunction = () => {
                reservationModal.classList.add('hidden');
                document.body.style.overflow = '';
            };

            closeModal.addEventListener('click', closeModalFunction);
            cancelReservation.addEventListener('click', closeModalFunction);

            // Close modal when clicking outside
            reservationModal.addEventListener('click', function(e) {
                if (e.target === reservationModal) {
                    closeModalFunction();
                }
            });

            // Prevent closing when clicking inside the modal content
            reservationModal.querySelector('.bg-white').addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
@endpush
