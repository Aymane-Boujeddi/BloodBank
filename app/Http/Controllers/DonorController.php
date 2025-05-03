<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Http\Requests\StoreDonorRequest;
use App\Http\Requests\UpdateDonorRequest;
use Illuminate\Http\Request;
use App\Models\DonationCenter;
use App\Models\City;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\BloodType;
use App\Models\Donation  ;
use Illuminate\Support\Facades\Auth;

class DonorController extends Controller
{
    public function index()
    {
        $donor = Donor::with('bloodType', 'user.city')
            ->where('user_id', Auth::id())
            ->first();
        
        if (!$donor) {
            return redirect()->route('login');
        }

        $donations = Donation::with(['donationCenter', 'results'])
            ->where('donor_id', $donor->id)
            ->get();
        
        $stats = [
            'totalDonations' => $donations->count(),
            'monthlyDonations' => $donations->filter(function($donation) {
                return Carbon::parse($donation->donation_date)->isCurrentMonth();
            })->count(),
        ];
        
        $nextAppointment = Reservation::with(['donationCenter.user.city'])
            ->where('donor_id', $donor->id)
            ->where('reservation_date', '>=', now()->format('Y-m-d'))
            ->where('status', '!=', 'cancelled')
            ->orderBy('reservation_date')
            ->orderBy('reservation_time')
            ->first();
        
        
        return view('donor.donor-dashboard', compact(
            'donor',
            'stats',
            'nextAppointment',
           
        ));
    }
    
    /**
     * Calculate donor's eligibility for different donation types
     * based on their donation history and results
     */
  
    
    /**
     * Get notifications for the donor dashboard
     */
   

    public function create() {}

    public function store(StoreDonorRequest $request) {}

    public function show(Donor $donor) {}

    public function edit(Donor $donor) {}

    public function update(UpdateDonorRequest $request, Donor $donor) {}

    public function destroy(Donor $donor)
    {
        $donor->delete();
        return redirect()->route('donor.dashboard')->with('success', 'Donneur supprimé avec succès');
    }

    public function centers(Request $request)
    {
        $query = DonationCenter::query()
            ->join('users', 'donation_centers.user_id', '=', 'users.id')
            ->join('cities', 'users.city_id', '=', 'cities.id')
            ->select('donation_centers.*', 'cities.name as city_name');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('donation_centers.center_name', 'like', "%{$search}%")
                ->orWhere('donation_centers.address', 'like', "%{$search}%");
        }

        if ($request->filled('city')) {
            $query->where('cities.name', $request->city);
        }

        $centers = $query->get();

        foreach ($centers as $center) {
            $center->availability_message = "Open from {$center->opening_time} to {$center->closing_time}";

            $center->available_days = $center->availableDays()->pluck('day')->toArray();

            $upcoming_dates_array = [];
            $today = now()->startOfDay();

            for ($i = 0; $i < 30; $i++) {
                $checkDate = $today->copy()->addDays($i);
                $dayName = $checkDate->format('l');

                if (in_array($dayName, $center->available_days)) {
                    $formattedDate = $checkDate->format('Y-m-d');
                    $upcoming_dates_array[] = [
                        'date' => $formattedDate,
                        'day_name' => $dayName,
                        'formatted' => $checkDate->format('d/m/Y'),
                    ];
                }
            }

            $center->upcoming_available_dates = $upcoming_dates_array;
        }

        $cities = City::orderBy('name')->pluck('name')->toArray();

        return view('donor.centers', [
            'centers' => $centers,
            'cities' => $cities
        ]);
    }

    

   

    public function availableDays($id)
    {
        $center = DonationCenter::findOrFail($id);
        $availableDays = $center->availableDays()->pluck('day')->toArray();

        return response()->json([
            'available_days' => $availableDays
        ]);
    }

    public function availableSlotsForDate($centerId, $date)
    {
        try {
            $center = DonationCenter::findOrFail($centerId);

            $parsedDate = \Carbon\Carbon::parse($date);
            $dayName = $parsedDate->format('l');

            $availableDays = $center->availableDays()->pluck('day')->toArray();

            if (!in_array($dayName, $availableDays)) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'available_slots' => [],
                        'status' => 'closed',
                        'message' => "Center is not open on {$dayName}"
                    ]);
                }

                return view('donor.centers', compact('center', 'date', 'dayName'))
                    ->with('status', 'closed')
                    ->with('message', "Center is not open on {$dayName}")
                    ->with('available_slots', []);
            }

            $openingTime = $center->opening_time;
            $closingTime = $center->closing_time;

            if (!$openingTime || !$closingTime) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'available_slots' => [],
                        'status' => 'error',
                        'message' => "Center has invalid operating hours"
                    ], 500);
                }

                return view('donor.centers', compact('center', 'date'))
                    ->with('status', 'error')
                    ->with('message', "Center has invalid operating hours")
                    ->with('available_slots', []);
            }

            $allTimeSlots = [];
            for ($time = strtotime($openingTime); $time < strtotime($closingTime); $time += 3600) {
                $allTimeSlots[] = date('H:i', $time);
            }

            $reservations = Reservation::where('donation_center_id', $centerId)
                ->where('reservation_date', $date)
                ->get(['reservation_time']);

            $reservationCounts = [];
            foreach ($reservations as $reservation) {
                $time = $reservation->reservation_time;
                if (!isset($reservationCounts[$time])) {
                    $reservationCounts[$time] = 1;
                } else {
                    $reservationCounts[$time]++;
                }
            }

            $availableSlots = [];
            foreach ($allTimeSlots as $slot) {
                $count = $reservationCounts[$slot] ?? 0;
                if ($count < $center->hourly_rate) {
                    $availableSlots[] = $slot;
                }
            }

            $morningSlots = array_filter($availableSlots, function ($slot) {
                return (int)substr($slot, 0, 2) < 12;
            });

            $afternoonSlots = array_filter($availableSlots, function ($slot) {
                return (int)substr($slot, 0, 2) >= 12;
            });

            $status = count($availableSlots) > 0 ? 'available' : 'full';

            if (request()->expectsJson()) {
                return response()->json([
                    'available_slots' => $availableSlots,
                    'morning_slots' => array_values($morningSlots),
                    'afternoon_slots' => array_values($afternoonSlots),
                    'status' => $status,
                    'hourly_capacity' => $center->hourly_rate,
                    'total_slots' => count($allTimeSlots),
                    'reserved_slots' => count($reservations)
                ]);
            }

            return view('donor.centers', compact(
                'center',
                'date',
                'availableSlots',
                'morningSlots',
                'afternoonSlots',
                'allTimeSlots',
                'status'
            ));
        } catch (\Exception $e) {
            Log::error("Error in availableSlotsForDate: " . $e->getMessage());

            if (request()->expectsJson()) {
                return response()->json([
                    'available_slots' => [],
                    'status' => 'error',
                    'message' => "An unexpected error occurred"
                ], 500);
            }

            return view('donor.centers')
                ->with('status', 'error')
                ->with('message', "An unexpected error occurred")
                ->with('available_slots', []);
        }
    }

    public function availableDaysForCalendar($centerId)
    {
        try {
            $center = DonationCenter::findOrFail($centerId);

            $openDays = $center->availableDays()->pluck('day')->toArray();

            if (empty($openDays)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le centre n\'a pas configuré de jours disponibles'
                ]);
            }

            $availableDates = [];
            $today = now()->startOfDay();

            for ($i = 0; $i < 60; $i++) {
                $date = $today->copy()->addDays($i);
                $dayName = $date->format('l');

                if (in_array($dayName, $openDays)) {
                    $availableDates[] = [
                        'date' => $date->format('Y-m-d'),
                        'day_name' => $this->translateDayToFrench($dayName),
                        'availability' => 'available'
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'available_dates' => $availableDates,
                'center_hours' => [
                    'opening' => $center->opening_time,
                    'closing' => $center->closing_time
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in availableDaysForCalendar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Une erreur s'est produite lors du chargement des dates disponibles"
            ], 500);
        }
    }

    public function getAvailableTimeSlots($centerId, $date)
    {
        try {
            $center = DonationCenter::with('availableDays')->findOrFail($centerId);
            $parsedDate = Carbon::parse($date);
            $dayName = $parsedDate->format('l');
            $openDays = $center->availableDays->pluck('day')->toArray();
            if (!in_array($dayName, $openDays)) {
                return response()->json([
                    'success' => false,
                    'message' => "Le centre n'est pas ouvert le " . $this->translateDayToFrench($dayName) . "."
                ]);
            }

            $openingTimeStr = $center->opening_time;
            $closingTimeStr = $center->closing_time;

            if (empty($openingTimeStr) || empty($closingTimeStr)) {
                return response()->json(['success' => false, 'message' => "Horaires manquants ou invalides."]);
            }

            $openingTs = strtotime($openingTimeStr);
            $closingTs = strtotime($closingTimeStr);

            if ($openingTs === false || $closingTs === false || $openingTs >= $closingTs) {
                return response()->json(['success' => false, 'message' => "Horaires mal configurés."]);
            }

            $reservationCounts = Reservation::where('donation_center_id', $centerId)
                ->where('reservation_date', $parsedDate->format('Y-m-d'))
                ->selectRaw("DATE_FORMAT(reservation_time, '%H:%i') as time_slot, COUNT(*) as count")
                ->groupBy('time_slot')
                ->pluck('count', 'time_slot')
                ->toArray();

            $availableHours = [];
            $hourlyRate = max(1, (int)($center->hourly_rate ?? 1));

            for ($time = $openingTs; $time < $closingTs; $time += 3600) {
                $slot = date('H:i', $time);
                $count = $reservationCounts[$slot] ?? 0;
                if ($count < $hourlyRate) {
                    $availableHours[] = $slot;
                }
            }

            return response()->json([
                'success' => true,
                'available_hours' => $availableHours
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Centre de donation non trouvé.'], 404);
        } catch (\Exception $e) {
            Log::error("General Exception in getAvailableTimeSlots: " . $e->getMessage() . " on line " . $e->getLine());
            return response()->json(['success' => false, 'message' => "Une erreur serveur s'est produite."], 500);
        }
    }

    private function translateDayToFrench($dayName)
    {
        $days = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        ];

        return $days[$dayName] ?? $dayName;
    }

 
}
