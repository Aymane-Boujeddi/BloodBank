<!-- filepath: c:\Users\LENOVO\Herd\BloodBank\resources\views\donationCenter\center-profile.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Donation Center Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Center Information Card -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Center Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Update your donation center\'s information.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('donation-center.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="center_name" :value="__('Center Name')" />
                                <x-text-input id="center_name" name="center_name" type="text"
                                    class="mt-1 block w-full" :value="old('center_name', $center->center_name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('center_name')" />
                            </div>

                            <div>
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                    :value="old('address', $center->address)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('address')" />
                            </div>

                            <div>
                                <x-input-label for="phone_number" :value="__('Phone Number')" />
                                <x-text-input id="phone_number" name="phone_number" type="text"
                                    class="mt-1 block w-full" :value="old('phone_number', $center->phone_number)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                            </div>

                            <div class="flex space-x-4">
                                <div class="w-1/2">
                                    <x-input-label for="opening_time" :value="__('Opening Time')" />
                                    <x-text-input id="opening_time" name="opening_time" type="time"
                                        class="mt-1 block w-full" :value="old('opening_time', $center->opening_time)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('opening_time')" />
                                </div>
                                <div class="w-1/2">
                                    <x-input-label for="closing_time" :value="__('Closing Time')" />
                                    <x-text-input id="closing_time" name="closing_time" type="time"
                                        class="mt-1 block w-full" :value="old('closing_time', $center->closing_time)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('closing_time')" />
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <!-- Donation Slots Management Card -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Donation Slots Configuration') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Configure your donation slots, capacity, and availability.') }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('donation-slots.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <!-- Slot Duration and Capacity -->
                        <div class="flex space-x-4">
                            <div class="w-1/2">
                                <x-input-label for="slot_duration_minutes" :value="__('Appointment Duration (minutes)')" />
                                <x-text-input id="slot_duration_minutes" name="slot_duration_minutes" type="number"
                                    min="15" step="5" class="mt-1 block w-full" :value="old('slot_duration_minutes', $slot->slot_duration_minutes ?? 30)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('slot_duration_minutes')" />
                            </div>
                            <div class="w-1/2">
                                <x-input-label for="slots_per_hour" :value="__('Maximum Donors Per Hour')" />
                                <x-text-input id="slots_per_hour" name="slots_per_hour" type="number" min="1"
                                    class="mt-1 block w-full" :value="old('slots_per_hour', $slot->slots_per_hour ?? 2)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('slots_per_hour')" />
                            </div>
                        </div>

                        <!-- Closed Days of Week -->
                        <div>
                            <x-input-label :value="__('Regular Closed Days')" />
                            <div class="mt-2 grid grid-cols-7 gap-2">
                                @php
                                    $days = [
                                        'Sunday',
                                        'Monday',
                                        'Tuesday',
                                        'Wednesday',
                                        'Thursday',
                                        'Friday',
                                        'Saturday',
                                    ];
                                    $closedDays = $slot->closed_days ?? [];
                                @endphp

                                @foreach ($days as $index => $day)
                                    <label class="flex items-center">
                                        <input type="checkbox" class="rounded border-gray-300" name="closed_days[]"
                                            value="{{ $index }}"
                                            {{ in_array($index, $closedDays) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm">{{ $day }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('closed_days')" />
                        </div>

                        <!-- Unavailable Dates (Date Picker) -->
                        <div>
                            <x-input-label for="unavailable_dates" :value="__('Unavailable Dates')" />
                            <p class="text-xs text-gray-500 mb-2">Use comma to separate multiple dates (YYYY-MM-DD
                                format)</p>
                            <x-text-input id="unavailable_dates" name="unavailable_dates" type="text"
                                class="mt-1 block w-full" :value="old(
                                    'unavailable_dates',
                                    !empty($slot->unavailable_dates) ? implode(', ', $slot->unavailable_dates) : '',
                                )" />
                            <x-input-error class="mt-2" :messages="$errors->get('unavailable_dates')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save Configuration') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Special Hours Management -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Special Hours') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Add special operating hours for specific dates.') }}
                        </p>
                    </header>

                    <!-- Special Hours Table -->
                    <div class="mt-6">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Date</th>
                                    <th class="py-2 px-4 border-b">Opening Time</th>
                                    <th class="py-2 px-4 border-b">Closing Time</th>
                                    <th class="py-2 px-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($slot->special_hours))
                                    @foreach ($slot->special_hours as $date => $hours)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $date }}</td>
                                            <td class="py-2 px-4 border-b">{{ $hours['opening'] }}</td>
                                            <td class="py-2 px-4 border-b">{{ $hours['closing'] }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <form method="post" action="{{ route('special-hours.delete') }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="date"
                                                        value="{{ $date }}">
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Add Special Hours Form -->
                    <form method="post" action="{{ route('special-hours.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div class="flex space-x-4">
                            <div class="w-1/3">
                                <x-input-label for="special_date" :value="__('Date')" />
                                <x-text-input id="special_date" name="special_date" type="date"
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('special_date')" />
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="special_opening" :value="__('Opening Time')" />
                                <x-text-input id="special_opening" name="special_opening" type="time"
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('special_opening')" />
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="special_closing" :value="__('Closing Time')" />
                                <x-text-input id="special_closing" name="special_closing" type="time"
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('special_closing')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Add Special Hours') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Appointments Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Upcoming Appointments') }}
                        </h2>
                    </header>

                    <div class="mt-6">
                        @if ($appointments && count($appointments) > 0)
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">Date</th>
                                        <th class="py-2 px-4 border-b">Time</th>
                                        <th class="py-2 px-4 border-b">Donor</th>
                                        <th class="py-2 px-4 border-b">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $appointment->appointment_date }}</td>
                                            <td class="py-2 px-4 border-b">{{ $appointment->appointment_time }}</td>
                                            <td class="py-2 px-4 border-b">{{ $appointment->user->name }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <span
                                                    class="px-2 py-1 rounded text-xs 
                                                {{ $appointment->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $appointment->status === 'missed' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-gray-600">No upcoming appointments.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
