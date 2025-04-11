<?php

namespace App\Http\Controllers;

use App\Models\DonationCenter;
use App\Http\Requests\StoreDonationCenterRequest;
use App\Http\Requests\UpdateDonationCenterRequest;

class DonationCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    }
}
