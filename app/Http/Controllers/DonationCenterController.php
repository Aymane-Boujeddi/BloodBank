<?php

namespace App\Http\Controllers;

use App\Models\DonationCenter;
use App\Http\Requests\StoreDonationCenterRequest;
use App\Http\Requests\UpdateDonationCenterRequest;
use App\Models\DonationSlot;
use App\Models\DonationBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Rdv;
use App\Models\Reservation;
use Carbon\Carbon;

class DonationCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('donationCenter.center-dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDonationCenterRequest $request)
    {
        //
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city_id' => ['required', 'integer'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $donationCenter = DonationCenter::create($request->all());

        return redirect()->route('donation-centers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DonationCenter $donationCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DonationCenter $donationCenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDonationCenterRequest $request, DonationCenter $donationCenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DonationCenter $donationCenter)
    {
        //
        $donationCenter->delete();
        return redirect()->route('donationCenter.dashboard')->with('success', 'Centre de don supprimé avec succès.');
    }

    public function appointments()
    {
        // Here you could load any data needed for the appointments page
        // For example, upcoming appointments, blood type statistics, etc.

        return view('donationCenter.appointments');
    }

    /**
     * Show the user profile page.
     */
    public function profile()
    {
        $user = Auth::user();

        // Ensure $user is an instance of the User model
        if (!$user instanceof \App\Models\User) {
            abort(500, 'Authenticated user is not valid.');
        }

        $donationCenter = DonationCenter::where('user_id', $user->id)->first();

        if (!$donationCenter) {
            return redirect()->route('donationCenter.dashboard')
                ->with('error', 'You need to create a donation center first.');
        }

        // Get donation slots configuration
        $slot = DonationSlot::where('donation_center_id', $donationCenter->id)->first();

        // Get upcoming appointments/bookings
        $appointments = DonationBooking::where('donation_center_id', $donationCenter->id)
            ->where('appointment_date', '>=', now()->format('Y-m-d'))
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->with('user')
            ->get();

        return view('donationCenter.center-profile', compact('user', 'donationCenter', 'slot', 'appointments'));
    }

    /**
     * Show the settings page.
     */
    public function settings()
    {
        $user = Auth::user();
        $donationCenter = DonationCenter::where('user_id', $user->id)->first();

        return view('donationCenter.settings', compact('user', 'donationCenter'));
    }

    /**
     * Update the user profile information.
     */
    public function updateProfile(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $donationCenter = DonationCenter::where('user_id', $authUser->id)->first();

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'center_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string|max:500',
        ]);

        // Update authUser information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Update donation center information
        $donationCenter->center_name = $request->center_name;
        $donationCenter->address = $request->address;
        $donationCenter->phone = $request->phone;
        $donationCenter->description = $request->description;
        $donationCenter->save();

        return redirect()->route('donationCenter.profile')->with('success', 'Profil mis à jour avec succès.');
    }
    public function approveRdv($id)
    {
        $rdv = Reservation::find($id);
        $rdv->status = 'approved';
        $rdv->save();
        return redirect()->route('donationCenter.appointments')->with('success', 'RDV approuvé avec succès.');
    }
    public function rejectRdv($id)
    {
        $rdv = Reservation::find($id);
        $rdv->status = 'rejected';
        $rdv->save();
        return redirect()->route('donationCenter.appointments')->with('success', 'RDV rejeté avec succès.');
    }
    public function nearestCenterss(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|numeric|min:1|max:100',
        ]);

        $userLat = $request->latitude;
        $userLng = $request->longitude;
        $radius = $request->radius ?? 25; // Default 25km radius

        // Query centers within radius using Haversine formula
        $centers = DonationCenter::select('donation_centers.*')
            ->selectRaw("(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$userLat, $userLng, $userLat])
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();

        // Add additional fields like status based on opening hours
        foreach ($centers as $center) {
            $center->status = $this->calculateStatus($center);
            // You could add additional data like estimated waiting time, etc.
        }

        return response()->json($centers);
    }

    private function calculateStatus($center)
    {
        // Get current time
        $now = Carbon::now();
        $openingTime = Carbon::parse($center->opening_time);
        $closingTime = Carbon::parse($center->closing_time);

        // Logic to determine if open, closing soon, or closed
        if (!$center->is_active) {
            return 'closed';
        } elseif ($now->lt($openingTime) || $now->gt($closingTime)) {
            return 'closed';
        } elseif ($now->diffInMinutes($closingTime) <= 60) {
            return 'closing-soon';
        } else {
            return 'open';
        }
    }
    public function nearestCenters(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255', // City is now required
        ]);

        $city = $request->city; // Get the city from request

        // Query centers in the specified city
        $centersQuery = DonationCenter::select('donation_centers.*')
            ->join('users', 'donation_centers.user_id', '=', 'users.id')
            ->join('cities', 'users.city_id', '=', 'cities.id')
            ->join('center_opening_hours', 'donation_centers.id', '=', 'center_opening_hours.donation_center_id')
            ->where('cities.name', 'like', '%' . $city . '%');

        $centers = $centersQuery->orderBy('center_name')->get();
        // dd($centers);
        // Get current day and time
        $now = now();
        $currentDay = strtolower($now->format('l')); // 'monday', 'tuesday', etc.
        $currentTime = $now->format('H:i:s');

        // Process centers to add necessary data for the view
        foreach ($centers as $center) {
            // Get opening hours for today
            $todayHours = $center->openingHours()
                ->where('day', $currentDay)
                ->first();

            // Check if the center is open, closed, or closing soon
            if (!$todayHours || $todayHours->is_closed) {
                $center->status = 'closed';
                $center->hours = 'Fermé aujourd\'hui';
            } else {
                $openingTime = $todayHours->opening_time;
                $closingTime = $todayHours->closing_time;

                // Format for display
                $center->hours = substr($openingTime, 0, 5) . ' - ' . substr($closingTime, 0, 5);

                // Determine if open, closed, or closing soon
                if ($currentTime < $openingTime) {
                    $center->status = 'closed';
                } elseif ($currentTime > $closingTime) {
                    $center->status = 'closed';
                } else {
                    // Calculate if closing within 1 hour
                    $closingDateTime = \Carbon\Carbon::createFromFormat('H:i:s', $closingTime);
                    $currentDateTime = \Carbon\Carbon::createFromFormat('H:i:s', $currentTime);

                    if ($closingDateTime->diffInMinutes($currentDateTime) <= 60) {
                        $center->status = 'closing-soon';
                    } else {
                        $center->status = 'open';
                    }
                }
            }

            // Mock rating data
            $center->rating = rand(35, 50) / 10;
            $center->reviews = rand(10, 150);

            // Add city name
            $center->city_name = $center->city ? $center->city->name : '';
        }

        return response()->json($centers);
    }

    /**
     * Save the donation center's location
     */
    public function saveLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        dd($request->all());

        // Get current user's donation center
        // $center = auth()->user()->donationCenter;

        if (!$center) {
            return redirect()->back()->with('error', 'Centre de don introuvable');
        }

        // Update location
        $center->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('donationCenter.profile')->with('success', 'Emplacement mis à jour avec succès');
    }

    /**
     * Update the donation center profile information.
     */
    public function updateCenter(Request $request)
    {
        $user = Auth::user();
        $donationCenter = DonationCenter::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'center_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'opening_time' => ['required'],
            'closing_time' => ['required'],
        ]);

        $donationCenter->update([
            'center_name' => $validated['center_name'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'opening_time' => $validated['opening_time'],
            'closing_time' => $validated['closing_time'],
        ]);

        return back()->with('success', 'Center information updated successfully.');
    }

    /**
     * Update or create donation slots configuration.
     */
    public function updateSlots(Request $request)
    {
        $user = Auth::user();
        $donationCenter = DonationCenter::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'slot_duration_minutes' => ['required', 'integer', 'min:15'],
            'slots_per_hour' => ['required', 'integer', 'min:1'],
            'closed_days' => ['nullable', 'array'],
            'unavailable_dates' => ['nullable', 'string'],
        ]);

        // Process unavailable dates from comma-separated string to array
        $unavailableDates = [];
        if (!empty($validated['unavailable_dates'])) {
            $dates = explode(',', $validated['unavailable_dates']);
            foreach ($dates as $date) {
                $trimmedDate = trim($date);
                if (!empty($trimmedDate) && strtotime($trimmedDate)) {
                    $unavailableDates[] = $trimmedDate;
                }
            }
        }

        $slot = DonationSlot::updateOrCreate(
            ['donation_center_id' => $donationCenter->id],
            [
                'slot_duration_minutes' => $validated['slot_duration_minutes'],
                'slots_per_hour' => $validated['slots_per_hour'],
                'closed_days' => $validated['closed_days'] ?? [],
                'unavailable_dates' => $unavailableDates,
            ]
        );

        return back()->with('success', 'Donation slots updated successfully.');
    }

    /**
     * Add special hours for specific dates.
     */
    public function storeSpecialHours(Request $request)
    {
        $user = Auth::user();
        $donationCenter = DonationCenter::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'special_date' => ['required', 'date'],
            'special_opening' => ['required'],
            'special_closing' => ['required'],
        ]);

        $slot = DonationSlot::where('donation_center_id', $donationCenter->id)->first();

        if (!$slot) {
            $slot = DonationSlot::create([
                'donation_center_id' => $donationCenter->id,
                'special_hours' => [],
                'slot_duration_minutes' => 30,
                'slots_per_hour' => 2,
            ]);
        }

        $specialHours = $slot->special_hours ?? [];
        $specialHours[$validated['special_date']] = [
            'opening' => $validated['special_opening'],
            'closing' => $validated['special_closing']
        ];

        $slot->special_hours = $specialHours;
        $slot->save();

        return back()->with('success', 'Special hours added successfully.');
    }

    /**
     * Delete special hours for a specific date.
     */
    public function deleteSpecialHours(Request $request)
    {
        $user = Auth::user();
        $donationCenter = DonationCenter::where('user_id', $user->id)->firstOrFail();
        $slot = DonationSlot::where('donation_center_id', $donationCenter->id)->first();

        if ($slot && isset($slot->special_hours[$request->date])) {
            $specialHours = $slot->special_hours;
            unset($specialHours[$request->date]);

            $slot->special_hours = $specialHours;
            $slot->save();
        }

        return back()->with('success', 'Special hours removed successfully.');
    }

    /**
     * Get available time slots for a specific date.
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'center_id' => 'required|exists:donation_centers,id'
        ]);

        $date = $request->date;
        $centerId = $request->center_id;

        $center = DonationCenter::findOrFail($centerId);
        $slotConfig = DonationSlot::where('donation_center_id', $centerId)->first();

        if (!$slotConfig) {
            return response()->json(['error' => 'Slot configuration not found'], 404);
        }

        // Check if date is unavailable
        if (in_array($date, $slotConfig->unavailable_dates ?? [])) {
            return response()->json(['slots' => [], 'message' => 'This date is unavailable for donations']);
        }

        // Check if day of week is closed
        $dayOfWeek = Carbon::parse($date)->dayOfWeek; // 0 (Sun) to 6 (Sat)
        if (in_array($dayOfWeek, $slotConfig->closed_days ?? [])) {
            return response()->json(['slots' => [], 'message' => 'The center is closed on this day']);
        }

        // Get opening/closing times (check special hours first)
        $openingTime = $center->opening_time;
        $closingTime = $center->closing_time;

        if (!empty($slotConfig->special_hours) && isset($slotConfig->special_hours[$date])) {
            $openingTime = $slotConfig->special_hours[$date]['opening'];
            $closingTime = $slotConfig->special_hours[$date]['closing'];
        }

        // Generate time slots
        $slots = $this->generateTimeSlots(
            $date,
            $openingTime,
            $closingTime,
            $slotConfig->slot_duration_minutes,
            $slotConfig->slots_per_hour,
            $centerId
        );

        return response()->json(['slots' => $slots]);
    }

    /**
     * Generate available time slots.
     */
    private function generateTimeSlots($date, $openingTime, $closingTime, $duration, $slotsPerHour, $centerId)
    {
        $start = Carbon::parse("$date $openingTime");
        $end = Carbon::parse("$date $closingTime");
        $slots = [];

        // Find existing bookings for this date and center
        $bookings = DonationBooking::where('donation_center_id', $centerId)
            ->where('appointment_date', $date)
            ->get()
            ->pluck('appointment_time')
            ->toArray();

        while ($start < $end) {
            $slotEnd = (clone $start)->addMinutes($duration);

            if ($slotEnd <= $end) {
                $timeStr = $start->format('H:i');
                $bookedCount = 0;

                // Count how many bookings exist for this time
                foreach ($bookings as $booking) {
                    if (substr($booking, 0, 5) === $timeStr) {
                        $bookedCount++;
                    }
                }

                // Add slot if there's capacity available
                if ($bookedCount < $slotsPerHour) {
                    $slots[] = [
                        'time' => $timeStr,
                        'available' => $slotsPerHour - $bookedCount,
                        'total' => $slotsPerHour
                    ];
                }
            }

            // Move to next slot
            $start->addMinutes($duration);
        }

        return $slots;
    }
}
