@extends('layouts.donor')

@section('content')
    <!-- Health History Section -->
    <section id="history" class="mb-8">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-lg font-medium text-gray-800">Historique et résultats</h2>
            </div>
            <div class="p-5">
                <div class="space-y-4">
                    <!-- Donation History Item -->
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium text-gray-900">Don de sang total</h3>
                                <p class="text-sm text-gray-500">15 Mars 2024 - Centre Hospitalier Universitaire</p>
                                <div class="mt-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Résultats disponibles
                                    </span>
                                </div>
                            </div>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fas fa-file-medical mr-1"></i> Voir résultats
                            </button>
                        </div>
                    </div>
                    <!-- Add more history items here -->
                </div>
            </div>
        </div>
    </section>
@endsection
