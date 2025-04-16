<?php

namespace App\Http\Controllers;

use App\Models\DonationCenter;
use App\Http\Requests\StoreDonationCenterRequest;
use App\Http\Requests\UpdateDonationCenterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Rdv;
use Carbon\Carbon;

class DonationCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('donor.center-dashboard');
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
        $user = Auth::user();
        $donationCenter = DonationCenter::where('user_id', $user->id)->first();

        return view('donationCenter.profile', compact('user', 'donationCenter'));
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
        $rdv = Rdv::find($id);
        $rdv->status = 'approved';
        $rdv->save();
        return redirect()->route('donationCenter.appointments')->with('success', 'RDV approuvé avec succès.');
    }
    public function rejectRdv($id)
    {
        $rdv = Rdv::find($id);
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
}
