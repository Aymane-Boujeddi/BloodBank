@extends('layouts.donor')

@section('content')
    <!-- Reviews Section -->
    <section id="reviews" class="mb-8">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-lg font-medium text-gray-800">Avis et commentaires</h2>
            </div>
            <div class="p-5">
                <!-- Add Review Form -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-800 mb-2">Donnez votre avis</h3>
                    <div class="space-y-3">
                        <div class="rating text-2xl">
                            <i class="far fa-star cursor-pointer hover:text-yellow-400"></i>
                            <i class="far fa-star cursor-pointer hover:text-yellow-400"></i>
                            <i class="far fa-star cursor-pointer hover:text-yellow-400"></i>
                            <i class="far fa-star cursor-pointer hover:text-yellow-400"></i>
                            <i class="far fa-star cursor-pointer hover:text-yellow-400"></i>
                        </div>
                        <textarea class="w-full p-3 border rounded-lg" rows="3" placeholder="Partagez votre expérience..."></textarea>
                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                            Publier
                        </button>
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="space-y-4">
                    <div class="border-b pb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="rating text-sm mb-1">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="text-sm text-gray-800 mb-1">Personnel très accueillant et professionnel.</p>
                                <div class="flex items-center text-xs text-gray-500">
                                    <span>Marie D.</span>
                                    <span class="mx-1">•</span>
                                    <span>Il y a 2 jours</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Star rating functionality
            const stars = document.querySelectorAll('.rating .fa-star');
            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.classList.remove('far');
                            s.classList.add('fas');
                        } else {
                            s.classList.remove('fas');
                            s.classList.add('far');
                        }
                    });
                });
            });
        });
    </script>
@endpush
