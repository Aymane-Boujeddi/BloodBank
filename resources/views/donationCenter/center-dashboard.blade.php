@extends('layouts.donation-center')

@section('title', 'Tableau de bord')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
            <p class="text-gray-600">Bienvenue, {{ auth()->user()->donationCenter->center_name ?? 'Centre de don' }}</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-2">
            <a href=""
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center text-sm">
                <i class="fas fa-calendar-alt mr-2"></i>
                Gérer les créneaux
            </a>
            <a href="{{ route('donationCenter.results') }}"
                class="bg-white border border-red-600 text-red-600 hover:bg-red-50 px-4 py-2 rounded-lg flex items-center text-sm">
                <i class="fas fa-file-medical-alt mr-2"></i>
                Gérer les résultats
            </a>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="space-y-6">
        <!-- Key Performance Indicators -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Today's Appointments -->
            <div class="bg-white rounded-lg p-4 border-l-4 border-blue-500 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-calendar-check text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">RDV aujourd'hui</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $todayAppointments ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Completed Donations -->
            <div class="bg-white rounded-lg p-4 border-l-4 border-green-500 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-hand-holding-heart text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Dons terminés</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $completedDonations ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Results -->
            <div class="bg-white rounded-lg p-4 border-l-4 border-yellow-500 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-file-medical-alt text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Résultats en attente</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $pendingResults ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Monthly Donations -->
            <div class="bg-white rounded-lg p-4 border-l-4 border-purple-500 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Dons ce mois</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $monthlyDonations ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Appointments -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-800">Rendez-vous d'aujourd'hui</h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $todayAppointmentsCount ?? 0 }} total
                </span>
            </div>
            <div class="p-5">
                @if (isset($todayAppointments) && count($todayAppointments) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($todayAppointments as $appointment)
                            <div class="border border-gray-200 rounded-lg hover:bg-gray-50 p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-{{ $appointment->status_color }}-100 flex items-center justify-center">
                                            <i class="fas fa-{{ $appointment->status_icon }} text-{{ $appointment->status_color }}-500"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-grow">
                                        <div class="flex justify-between items-center">
                                            <p class="text-sm font-medium text-gray-900">{{ $appointment->donor_name }}</p>
                                            <span class="text-xs text-gray-500">{{ $appointment->time }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $appointment->blood_type }} • {{ $appointment->phone }}</p>
                                        <div class="mt-3 flex space-x-2">
                                            <form action="{{ route('donationCenter.markArrived', $appointment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-1 rounded bg-blue-50 text-blue-600 hover:bg-blue-100">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('donationCenter.markCompleted', $appointment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-1 rounded bg-green-50 text-green-600 hover:bg-green-100">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('donationCenter.cancelReservation', $appointment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-1 rounded bg-red-50 text-red-600 hover:bg-red-100">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="far fa-calendar-check text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500">Aucun rendez-vous pour aujourd'hui</p>
                    </div>
                @endif
            </div>
            <div class="px-5 py-3 border-t border-gray-100">
                <a href="{{ route('donationCenter.appointments') }}"
                    class="flex items-center justify-center text-sm font-medium text-red-600 hover:text-red-800">
                    <span>Gérer tous les rendez-vous</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Pending Appointments Management -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Demandes de rendez-vous</h2>
                <a href="{{ route('donationCenter.appointments') }}" class="text-sm text-red-600 hover:text-red-800">
                    Tout voir
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Donneur
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Date & Heure
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Groupe sanguin
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if (isset($pendingAppointments) && count($pendingAppointments) > 0)
                            @foreach ($pendingAppointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $appointment->donor_name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $appointment->date }}</div>
                                        <div class="text-xs text-gray-500">{{ $appointment->time }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                            {{ $appointment->blood_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('donationCenter.confirmReservation') }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="id" value="{{ $appointment->id }}">
                                            <button type="submit" class="text-green-600 hover:text-green-900 mr-3">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('donationCenter.rejectReservation') }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="id" value="{{ $appointment->id }}">
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Aucune demande de rendez-vous en attente.
                                </td>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pending Results Management -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Résultats à traiter</h2>
                    <a href="{{ route('donationCenter.results') }}" class="text-sm text-red-600 hover:text-red-800">
                        Tout voir
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Donneur
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Date du don
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Groupe sanguin
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if (isset($pendingResults) && count($pendingResults) > 0)
                                @foreach ($pendingResults as $result)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">{{ $result->donor_name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $result->donation_date }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                                {{ $result->blood_type ?? 'À déterminer' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('donationCenter.results.edit', $result->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Aucun résultat en attente.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Center Performance -->
            <div class="bg-white rounded-lg shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Performance du centre</h2>
                    <select class="text-sm border rounded p-1">
                        <option selected>30 derniers jours</option>
                        <option>Cette année</option>
                        <option>Dernière année</option>
                    </select>
                </div>
                <div class="h-80 bg-gray-50 rounded-lg mb-4">
                    <!-- Placeholder for chart -->
                    <div class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-chart-line text-4xl text-gray-300 mb-2"></i>
                            <p class="text-gray-500">Graphique de performance</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 p-3 rounded-lg">
                        <div class="text-sm font-medium text-gray-700">Taux de réussite</div>
                        <div class="text-xl font-semibold text-green-700">94%</div>
                        <div class="text-xs text-gray-500">+2% vs précédent</div>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <div class="text-sm font-medium text-gray-700">Taux de présence</div>
                        <div class="text-xl font-semibold text-blue-700">87%</div>
                        <div class="text-xs text-gray-500">+5% vs précédent</div>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">
                        <div class="text-sm font-medium text-gray-700">Nouveaux donneurs</div>
                        <div class="text-xl font-semibold text-purple-700">24</div>
                        <div class="text-xs text-gray-500">+18% vs précédent</div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

