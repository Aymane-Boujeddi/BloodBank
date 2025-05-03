<?php

namespace App\Http\Controllers;

use App\Models\DonationCenter;
use App\Http\Requests\StoreDonationCenterRequest;
use App\Http\Requests\UpdateDonationCenterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Donation;
use App\Models\Reservation;
use App\Models\BloodType;
use Carbon\Carbon;

class DonationCenterController extends Controller
{
    public function index()
    {
        return view('donationCenter.center-dashboard');
    }

    public function create() {}

    public function store(StoreDonationCenterRequest $request)
    {
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

    public function show(DonationCenter $donationCenter) {}

    public function edit(DonationCenter $donationCenter) {}

    public function update(UpdateDonationCenterRequest $request, DonationCenter $donationCenter) {}

    public function destroy(DonationCenter $donationCenter)
    {
        $donationCenter->delete();
        return redirect()->route('donationCenter.dashboard')->with('success', 'Centre de don supprimé avec succès.');
    }

    public function profile()
    {
        $user = Auth::user();


        $donationCenter = DonationCenter::where('user_id', $user->id)->first();

        if (!$donationCenter) {
            return redirect()->route('donationCenter.dashboard')
                ->with('error', 'You need to create a donation center first.');
        }



        return view('donationCenter.center-profile', compact('user', 'donationCenter'));
    }
    public function showProfile()
    {
        $user = Auth::user();
        $center = DonationCenter::where('user_id', $user->id)->first();
        
        if (!$center) {
            return redirect()->route('donationCenter.dashboard')
                ->with('error', 'Vous devez d\'abord créer un centre de don.');
        }
        
        $availableDays = $center->availableDays()->pluck('day')->toArray();
        
        return view('donationCenter.center-profile', compact('user', 'center', 'availableDays'));
    }

 

    public function updateProfile(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $donationCenter = DonationCenter::where('user_id', $authUser->id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'center_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string|max:500',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $donationCenter->center_name = $request->center_name;
        $donationCenter->address = $request->address;
        $donationCenter->phone = $request->phone;
        $donationCenter->description = $request->description;
        $donationCenter->save();

        return redirect()->route('donationCenter.profile')->with('success', 'Profil mis à jour avec succès.');
    }

 
    public function nearestCenters(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255',
        ]);

        $city = $request->city;

        $centersQuery = DonationCenter::select('donation_centers.*')
            ->join('users', 'donation_centers.user_id', '=', 'users.id')
            ->join('cities', 'users.city_id', '=', 'cities.id')
            ->join('center_opening_hours', 'donation_centers.id', '=', 'center_opening_hours.donation_center_id')
            ->where('cities.name', 'like', '%' . $city . '%');

        $centers = $centersQuery->orderBy('center_name')->get();

        $now = now();
        $currentDay = strtolower($now->format('l'));
        $currentTime = $now->format('H:i:s');


        return response()->json($centers);
    }

    public function saveLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        
        $user = Auth::user();
        $center = DonationCenter::where('user_id', $user->id)->first();

        if (!$center) {
            return redirect()->back()->with('error', 'Centre de don introuvable');
        }

        $center->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('donationCenter.profile')->with('success', 'Emplacement mis à jour avec succès');
    }

    public function updateCenter(Request $request)
    {
        $user = Auth::user();
        $donationCenter = DonationCenter::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'center_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'opening_time' => ['required', 'date_format:H:i'],
            'closing_time' => ['required', 'date_format:H:i', 'after:opening_time'],
            'available_days' => ['nullable', 'array'],
            'available_days.*' => ['string', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday']
        ]);

        $donationCenter->update([
            'center_name' => $validated['center_name'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'opening_time' => $validated['opening_time'],
            'closing_time' => $validated['closing_time'],
        ]);

        if (isset($validated['available_days'])) {
            $donationCenter->availableDays()->delete();
            
            foreach ($validated['available_days'] as $day) {
                $donationCenter->availableDays()->create(['day' => $day]);
            }
        }

        if ($request->has('name') || $request->has('email')) {
            $userValidated = $request->validate([
                'name' => ['sometimes', 'string', 'max:255'],
                'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            ]);
            $userSave = User::find($user->id);
            $userSave->update($userValidated);
        }

        return back()->with('success', 'Information du centre mise à jour avec succès.');
    }
    public function showResultsPage()
    {
        $user = Auth::user();
        $donationCenter = DonationCenter::where('user_id', $user->id)->first();
        $bloodTypes = BloodType::all();

        $donations = Donation::where('donation_center_id', $donationCenter->id)
            ->with(['donor', 'donationCenter'])
            ->orderBy('created_at', 'desc')
            ->get();


        return view('donationCenter.results', compact('user', 'donationCenter', 'donations','bloodTypes'));
    }
}
