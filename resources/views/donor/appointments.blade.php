@extends('layouts.donor')

@section('content')
    <!-- Appointments Section -->
    <section id="appointments" class="mb-8">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-lg font-medium text-gray-800">Mes rendez-vous</h2>
            </div>
            <div class="p-5">
                <!-- Upcoming Appointment -->
                <div class="mb-6 p-4 border border-green-200 rounded-lg bg-green-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-green-600 text-sm font-medium">Prochain rendez-vous</span>
                            <h3 class="font-medium text-gray-900 mt-1">Centre Hospitalier Universitaire</h3>
                            <p class="text-sm text-gray-600 mt-1">Mercredi 20 Avril 2024 - 14:30</p>
                            <div class="mt-2 space-x-2">
                                <button class="text-sm text-red-600 hover:text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> Annuler
                                </button>
                                <button class="text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-calendar-alt mr-1"></i> Reprogrammer
                                </button>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="#" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-map-marker-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Available Slots -->
                <div class="border rounded-lg">
                    <div class="px-4 py-3 bg-gray-50 border-b">
                        <h3 class="font-medium text-gray-800">Créneaux disponibles</h3>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center p-3 border rounded-lg hover:border-red-500 cursor-pointer">
                                <div class="font-medium">Lun</div>
                                <div class="text-sm text-gray-500">24 Avr</div>
                            </div>
                            <!-- Add more date slots -->
                        </div>
                        <div class="mt-4 space-y-2">
                            <button class="w-full p-2 text-left rounded-lg hover:bg-red-50">
                                <span class="text-sm font-medium">09:00</span>
                                <span class="text-sm text-gray-500 ml-2">Disponible</span>
                            </button>
                            <!-- Add more time slots -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
