<?php

namespace App\Http\Controllers;

use App\Models\DonationCenter;
use App\Http\Requests\StoreDonationCenterRequest;
use App\Http\Requests\UpdateDonationCenterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\Rdv;
class DonationCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('donationCenter.dashboard');
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
}
