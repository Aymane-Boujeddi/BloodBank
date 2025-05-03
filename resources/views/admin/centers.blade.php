@extends('layouts.admin')

@section('title', 'Gestion des Centres de Don')

@section('content')
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-red-50 to-white p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des Centres de Don</h1>
                    <p class="text-gray-600 mt-1">Gérer les demandes d'inscription et les centres existants</p>
                </div>
            </div>
        </div>

        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">En attente</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_centers'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Approuvés</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['approved_centers'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-times-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Rejetés</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['rejected_centers'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Régions</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_cities'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border-b border-gray-200">
            <nav class="px-6" x-data="{ activeTab: '{{ request('tab', 'pending') }}' }">
                <div class="flex justify-around space-x-4 -mb-px">
                    <button @click="activeTab = 'pending'"
                        :class="activeTab === 'pending' ? 'border-b-2 border-red-500 text-red-600' :
                            'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent'"
                        class="py-4 px-1 font-medium text-sm focus:outline-none transition duration-200 ease-in-out">
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>En attente</span>
                            <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $stats['pending_centers'] }}
                            </span>
                        </div>
                    </button>

                    <button @click="activeTab = 'approved'"
                        :class="activeTab === 'approved' ? 'border-b-2 border-red-500 text-red-600' :
                            'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent'"
                        class="py-4 px-1 font-medium text-sm focus:outline-none transition duration-200 ease-in-out">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Approuvés</span>
                            <span class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $stats['approved_centers'] }}
                            </span>
                        </div>
                    </button>

                    <button @click="activeTab = 'rejected'"
                        :class="activeTab === 'rejected' ? 'border-b-2 border-red-500 text-red-600' :
                            'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent'"
                        class="py-4 px-1 font-medium text-sm focus:outline-none transition duration-200 ease-in-out">
                        <div class="flex items-center">
                            <i class="fas fa-times-circle mr-2"></i>
                            <span>Rejetés</span>
                            <span class="ml-2 bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $stats['rejected_centers'] }}
                            </span>
                        </div>
                    </button>
                </div>

                <!-- Tab: Pending Centers -->
                <div x-show="activeTab === 'pending'" x-transition class="py-6">
                    <div class="mb-6 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Centres en attente d'approbation</h3>
                        <div class="relative">
                            <input type="text" placeholder="Rechercher un centre..." class="search-input pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>

                    @if ($pendingCenters->count() > 0)
                        <div class="space-y-4">
                            @foreach ($pendingCenters as $center)
                                <div
                                    class="center-item bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                                    <div class="p-5 border-l-4 border-yellow-500">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div class="md:col-span-3">
                                                <div class="flex">
                                                    <div
                                                        class="flex-shrink-0 h-14 w-14 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-hospital text-xl"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <h4 class="text-lg font-medium text-gray-900">{{ $center->name }}</h4>

                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-1 mt-2">
                                                            <div class="flex items-center">
                                                                <i class="fas fa-map-marker-alt text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2">
                                                                    {{ $center->user->city->name ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <i class="fas fa-calendar-alt text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2">
                                                                    {{ $center->created_at->format('d/m/Y') }}</p>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <i class="fas fa-envelope text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2 truncate">
                                                                    {{ $center->user->email }}</p>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <i class="fas fa-phone text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2">
                                                                    {{ $center->phone_number ?? 'Non spécifié' }}</p>
                                                            </div>
                                                            <div class="flex items-center sm:col-span-2">
                                                                <i class="fas fa-location-arrow text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2">
                                                                    {{ $center->address }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="mt-3">
                                                            <span
                                                                class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                                <i class="fas fa-clock mr-1"></i> En attente depuis
                                                                {{ $center->created_at->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="md:flex md:flex-col md:justify-center md:items-end space-y-2">
                                                <div class="grid grid-cols-2 md:grid-cols-1 gap-2 w-full">
                                                    <form action="{{ route('admin.centers.approve', $center->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="w-full px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 flex items-center justify-center">
                                                            <i class="fas fa-check mr-2"></i> Approuver
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.centers.reject', $center->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 flex items-center justify-center">
                                                            <i class="fas fa-times mr-2"></i> Rejeter
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-message text-center py-12 bg-gray-50 rounded-lg">
                            <div class="mx-auto h-20 w-20 bg-gray-100 rounded-full flex items-center justify-center mb-4 shadow-inner">
                                <i class="far fa-check-circle text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-500">Aucun centre en attente d'approbation pour le moment.</p>
                        </div>
                    @endif
                </div>

                <!-- Tab: Approved Centers -->
                <div x-show="activeTab === 'approved'" x-transition class="py-6">
                    <div class="mb-6 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Centres approuvés</h3>
                        <div class="relative">
                            <input type="text" placeholder="Rechercher un centre..." class="search-input pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>

                    @if ($approvedCenters->count() > 0)
                        <div class="space-y-4">
                            @foreach ($approvedCenters as $center)
                                <div class="center-item bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                                    <div class="p-5 border-l-4 border-green-500">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div class="md:col-span-3">
                                                <div class="flex">
                                                    <div class="flex-shrink-0 h-14 w-14 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-hospital text-xl"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <h4 class="text-lg font-medium text-gray-900">{{ $center->name }}</h4>

                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-1 mt-2">
                                                            <div class="flex items-center">
                                                                <i class="fas fa-map-marker-alt text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2">
                                                                    {{ $center->user->city->name ?? ($center->city->name ?? 'N/A') }}
                                                                </p>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <i class="fas fa-calendar-alt text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2">
                                                                    {{ $center->updated_at->format('d/m/Y') }}</p>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <i class="fas fa-envelope text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2 truncate">
                                                                    {{ $center->email }}</p>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <i class="fas fa-phone text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2">
                                                                    {{ $center->phone ?? 'Non spécifié' }}</p>
                                                            </div>
                                                            <div class="flex items-center sm:col-span-2">
                                                                <i class="fas fa-location-arrow text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2">
                                                                    {{ $center->address }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="mt-3">
                                                            <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                                <i class="fas fa-check-circle mr-1"></i> Approuvé le
                                                                {{ $center->updated_at->format('d/m/Y') }}
                                                            </span>
                                                            @if (isset($center->reservations_count) && $center->reservations_count > 0)
                                                                <span class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full ml-2">
                                                                    <i class="fas fa-calendar-check mr-1"></i>
                                                                    {{ $center->reservations_count }} rendez-vous
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="md:col-span-1 flex items-center justify-center">
                                                <form action="{{ route('admin.centers.reject', $center->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-full px-4 py-2.5 border border-red-300 text-red-700 bg-white hover:bg-red-50 rounded-lg transition-colors flex items-center justify-center shadow-sm">
                                                        <i class="fas fa-times-circle mr-2"></i> Rejeter
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-message text-center py-12 bg-gray-50 rounded-lg">
                            <div class="mx-auto h-20 w-20 bg-gray-100 rounded-full flex items-center justify-center mb-4 shadow-inner">
                                <i class="far fa-hospital text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-500">Aucun centre approuvé pour le moment.</p>
                        </div>
                    @endif
                </div>

                <!-- Tab: Rejected Centers -->
                <div x-show="activeTab === 'rejected'" x-transition class="py-6">
                    <div class="mb-6 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Centres rejetés</h3>
                        <div class="relative">
                            <input type="text" placeholder="Rechercher un centre..." class="search-input pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>

                    @if ($rejectedCenters->count() > 0)
                        <div class="space-y-4">
                            @foreach ($rejectedCenters as $center)
                                <div class="center-item bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                                    <div class="p-5 border-l-4 border-red-500">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div class="md:col-span-3">
                                                <div class="flex">
                                                    <div class="flex-shrink-0 h-14 w-14 bg-red-100 text-red-600 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-hospital-alt text-xl"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <h4 class="text-lg font-medium text-gray-900">{{ $center->name }}</h4>

                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-1 mt-2">
                                                            <div class="flex items-center">
                                                                <i class="fas fa-map-marker-alt text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2">
                                                                    {{ $center->user->city->name ?? ($center->city->name ?? 'N/A') }}
                                                                </p>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <i class="fas fa-calendar-alt text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2">
                                                                    {{ $center->updated_at->format('d/m/Y') }}</p>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <i class="fas fa-envelope text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2 truncate">
                                                                    {{ $center->email }}</p>
                                                            </div>
                                                            <div class="flex items-center sm:col-span-2">
                                                                <i class="fas fa-location-arrow text-gray-400 w-5 text-center"></i>
                                                                <p class="text-sm text-gray-500 ml-2">
                                                                    {{ $center->address }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="mt-3">
                                                            <span class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                                <i class="fas fa-times-circle mr-1"></i> Rejeté le
                                                                {{ $center->updated_at->format('d/m/Y') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="md:flex md:flex-col md:justify-center md:items-end space-y-2">
                                                <div class="grid grid-cols-2 md:grid-cols-1 gap-2 w-full">
                                                    <form action="{{ route('admin.centers.approve', $center->id) }}" method="POST" class="w-full">
                                                        @csrf
                                                        <button type="submit" class="w-full px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 flex items-center justify-center">
                                                            <i class="fas fa-redo-alt mr-2"></i> Reconsidérer
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.centers.delete', $center->id) }}" method="POST" class="w-full"
                                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce centre ? Cette action est irréversible.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 flex items-center justify-center">
                                                            <i class="fas fa-trash-alt mr-2"></i> Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-message text-center py-12 bg-gray-50 rounded-lg">
                            <div class="mx-auto h-20 w-20 bg-gray-100 rounded-full flex items-center justify-center mb-4 shadow-inner">
                                <i class="far fa-times-circle text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-500">Aucun centre rejeté pour le moment.</p>
                        </div>
                    @endif
                </div>
            </nav>
        </div>

        <!-- Modal for center details -->
        <div id="centerDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-medium text-gray-900">Détails du centre</h3>
                        <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div id="centerDetails" class="space-y-6">
                        <div class="text-center py-4">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-600 mx-auto"></div>
                            <p class="mt-2 text-gray-500">Chargement des détails...</p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button id="close-modal-btn-footer" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInputs = document.querySelectorAll('.search-input');

            searchInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const searchText = this.value.toLowerCase();
                    const tabContent = this.closest('[x-show]');
                    if (!tabContent) return;

                    const centerItems = tabContent.querySelectorAll('.center-item');
                    const emptyMessage = tabContent.querySelector('.empty-message');
                    let anyVisible = false;

                    centerItems.forEach(item => {
                        const text = item.textContent.toLowerCase();
                        const shouldShow = text.includes(searchText);
                        item.style.display = shouldShow ? '' : 'none';
                        if (shouldShow) anyVisible = true;
                    });

                    if (emptyMessage) {
                        if (!anyVisible && centerItems.length > 0) {
                            emptyMessage.style.display = 'block';
                            const messageParagraph = emptyMessage.querySelector('p');
                            if (messageParagraph) {
                                messageParagraph.textContent =
                                    `Aucun centre trouvé pour "${searchText}"`;
                            }
                        } else {
                            emptyMessage.style.display = 'none';
                        }
                    }
                });
            });

            const modal = document.getElementById('centerDetailsModal');
            if (modal) {
                const closeButtons = modal.querySelectorAll('#close-modal-btn, #close-modal-btn-footer');

                closeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        modal.classList.add('hidden');
                    });
                });

                window.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        modal.classList.add('hidden');
                    }
                });

                window.openCenterModal = function(centerId) {
                    modal.classList.remove('hidden');
                };
            }
        });
    </script>
@endpush
