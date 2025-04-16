<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Http\Requests\StoreDonorRequest;
use App\Http\Requests\UpdateDonorRequest;
use App\Models\Rdv;
use Illuminate\Http\Request;
use App\Models\DonationCenter;
use App\Models\City;
class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('donor.donor-dashboard');
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
    public function store(StoreDonorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Donor $donor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donor $donor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDonorRequest $request, Donor $donor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donor $donor)
    {
        //
        $donor->delete();
        return redirect()->route('donor.dashboard')->with('success', 'Donneur supprimé avec succès');
    }

    /**
     * Display donation centers with optional filtering by name/address and city
     */
    public function centers(Request $request)
    {
        // Start with a base query that joins the necessary tables
        $query = DonationCenter::query()
            ->join('users', 'donation_centers.user_id', '=', 'users.id')
            ->join('cities', 'users.city_id', '=', 'cities.id')
            ->select('donation_centers.*', 'cities.name as city_name');
        
            // dd($query->get());
        // Apply search filter for center name or address
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('donation_centers.center_name', 'like', "%{$search}%")
                  ->orWhere('donation_centers.address', 'like', "%{$search}%");
            });
        }
        
        // Apply city filter
        if ($request->has('city') && $request->city != '') {
            $city = $request->city;
            $query->where('cities.name', $city);
        }
        
        // Get centers
        $centers = $query->get();
        
        // Load opening hours relationship for each center
        $centers->load('openingHours');
        
        // Get unique cities for filter dropdown
        $cities = City::orderBy('name')->pluck('name')->toArray();
        
        return view('donor.centers', [
            'centers' => $centers,
            'cities' => $cities
        ]);
    }

    /**
     * Process a center review submission
     */
    public function reviewCenter(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);
        
        $center = DonationCenter::findOrFail($id);
        
        // Create a new review
        // $center->reviews()->create([
        //     'user_id' => auth()->id(),
        //     'rating' => $request->rating,
        //     'comment' => $request->comment
        // ]);
        
        return redirect()->route('donor.centers')->with('success', 'Merci pour votre avis!');
    }
}
