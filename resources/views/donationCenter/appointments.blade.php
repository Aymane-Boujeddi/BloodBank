@extends('layouts.donation-center')

@section('title', 'Rendez-vous')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="stats-card bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">En attente</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pendingReservations->count() }}</p>
                </div>
            </div>
        </div>
        <div class="stats-card bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Confirmés</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $confirmedReservations->count() }}</p>
                </div>
            </div>
        </div>
        <div class="stats-card bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Aujourd'hui</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $todayReservationsCount }}
                    </p>
                </div>
            </div>
        </div>
        <div class="stats-card bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-user-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Cette semaine</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $thisWeekReservationsCount }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex space-x-4 mb-6">
        <button type="button" data-tab="pending"
            class="tab-btn pending-tab active flex-1 py-4 px-6 rounded-lg font-medium text-center transition-all bg-white shadow-sm ">
            <div class="flex items-center justify-center">
                <i class="fas fa-clock mr-2"></i>
                <span>Rendez-vous en attente</span>
                <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $pendingReservations->count() }}
                </span>
            </div>
        </button>
        <button type="button" data-tab="confirmed"
            class="tab-btn confirmed-tab flex-1 py-4 px-6 rounded-lg font-medium text-center transition-all bg-white shadow-sm ">
            <div class="flex items-center justify-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Rendez-vous confirmés</span>
                <span class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $confirmedReservations->count() }}
                </span>
            </div>
        </button>
    </div>

    <div class="tabs-content">
        <div id="pending-tab" class="tab-panel space-y-6 hidden">
            <div class="bg-white rounded-lg shadow-sm divide-y divide-gray-200">
                @if ($pendingReservations->count() > 0)
                    @foreach ($pendingReservations as $reservation)
                        <div class="appointment-card pending p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-16 text-center">
                                    <div class="text-sm font-medium text-yellow-600">
                                        {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ substr($reservation->reservation_time, 0, 5) }}</div>
                                </div>
                                <div class="ml-4 flex-grow">
                                    <div class="flex items-center">
                                        <div class="font-medium">
                                            {{ $reservation->donor->user->name ?? 'Donneur inconnu' }}</div>
                                        <span class="ml-2 px-2 py-0.5 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                            En attente
                                        </span>
                                        <span class="ml-2 text-xs text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $reservation->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1 flex items-center">
                                        <span class="inline-block w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                        <span
                                            class="mr-4">{{ $reservation->donor->blood_type ?? 'Groupe sanguin inconnu' }}</span>
                                        <span class="flex items-center">
                                            <i class="fas fa-phone-alt mr-1"></i>
                                            {{ $reservation->donor->phone ?? 'Non disponible' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-auto flex items-center space-x-2">
                                    <form action="{{ route('donationCenter.confirmReservation') }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="id" value="{{ $reservation->id }}">
                                        <button type="submit"
                                            class="flex items-center px-3 py-1.5 text-green-600 hover:bg-green-50 rounded-md border border-green-200 transition-colors"
                                            title="Confirmer">
                                            <i class="fas fa-check mr-1.5"></i>
                                            <span>Confirmer</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('donationCenter.rejectReservation') }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="id" value="{{ $reservation->id }}">
                                        <button type="submit"
                                            class="flex items-center px-3 py-1.5 text-red-600 hover:bg-red-50 rounded-md border border-red-200 transition-colors"
                                            title="Refuser">
                                            <i class="fas fa-times mr-1.5"></i>
                                            <span>Refuser</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-8 text-center">
                        <div class="text-gray-400 mb-3">
                            <i class="fas fa-calendar-times text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-800 mb-1">Aucun rendez-vous en attente</h3>
                        <p class="text-gray-600">Vous n'avez pas de rendez-vous à confirmer pour le moment</p>
                    </div>
                @endif
            </div>
        </div>

        <div id="confirmed-tab" class="tab-panel space-y-6 hidden">
            <div class="bg-white rounded-lg shadow-sm divide-y divide-gray-200">
                @if ($confirmedReservations->count() > 0)
                    @foreach ($confirmedReservations as $reservation)
                        <div class="appointment-card confirmed p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-16 text-center">
                                    <div class="text-sm font-medium text-green-600">
                                        {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ substr($reservation->reservation_time, 0, 5) }}</div>
                                </div>
                                <div class="ml-4 flex-grow">
                                    <div class="flex items-center">
                                        <div class="font-medium">
                                            {{ $reservation->donor->user->name ?? 'Donneur inconnu' }}</div>
                                        <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded-full">
                                            Confirmé
                                        </span>
                                        <span class="ml-2 text-xs text-gray-500">
                                            <i class="fas fa-check mr-1"></i> Confirmé
                                            {{ $reservation->updated_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1 flex items-center">
                                        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                        <span
                                            class="mr-4">{{ $reservation->donor->blood_type ?? 'Groupe sanguin inconnu' }}</span>
                                        <span class="flex items-center">
                                            <i class="fas fa-phone-alt mr-1"></i>
                                            {{ $reservation->donor->phone ?? 'Non disponible' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-auto flex items-center space-x-2">
                                    <form action="{{ route('donationCenter.toPendingReservation') }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="id" value="{{ $reservation->id }}">
                                        <button type="submit"
                                            class="flex items-center px-3 py-1.5 text-red-600 hover:bg-red-50 rounded-md border border-red-200 transition-colors"
                                            title="Annuler">
                                            <i class="fas fa-times mr-1.5"></i>
                                            <span>Annuler</span>
                                        </button>
                                    </form>
                                    {{-- {{$reservation->id}} --}}
                                    <form action="{{ route('donationCenter.recordDonation') }}"
                                        method="POST" class="inline ml-2">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="id" value="{{ $reservation->id }}">
                                        <button type="submit"
                                            class="flex items-center px-3 py-1.5 text-blue-600 hover:bg-blue-50 rounded-md border border-blue-200 transition-colors"
                                            title="Enregistrer un don">
                                            <i class="fas fa-tint mr-1.5"></i>
                                            <span>Enregistrer don</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-8 text-center">
                        <div class="text-gray-400 mb-3">
                            <i class="fas fa-calendar-times text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-800 mb-1">Aucun rendez-vous confirmé</h3>
                        <p class="text-gray-600">Vous n'avez pas encore confirmé de rendez-vous</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    var tabButtons = document.querySelectorAll('.tab-btn');
    var tabPanels = document.querySelectorAll('.tab-panel');

    tabButtons.forEach(function(button) {
    button.addEventListener('click', function() {
    var tabId = this.getAttribute('data-tab');

    tabPanels.forEach(function(panel) {
    panel.classList.add('hidden');
    });

    tabButtons.forEach(function(btn) {
    btn.classList.remove('active');
    btn.style.backgroundColor = 'white';
    btn.style.color = 'black';
    btn.style.border = 'none';
    });

    var selectedPanel = document.getElementById(tabId + '-tab');
    if (selectedPanel) {
    selectedPanel.classList.remove('hidden');
    }

    this.classList.add('active');

    if (tabId === 'pending') {
    this.style.backgroundColor = '#FEF3C7';
    this.style.color = '#92400E';
    this.style.border = 'none';
    } else if (tabId === 'confirmed') {
    this.style.backgroundColor = '#D1FAE5';
    this.style.color = '#065F46';
    this.style.border = 'none';
    }
    });
    });

    document.getElementById('pending-tab').classList.remove('hidden');
    var defaultButton = document.querySelector('.pending-tab');
    defaultButton.classList.add('active');
    defaultButton.style.backgroundColor = '#FEF3C7';
    defaultButton.style.color = '#92400E';
    defaultButton.style.border = 'none';
@endsection
