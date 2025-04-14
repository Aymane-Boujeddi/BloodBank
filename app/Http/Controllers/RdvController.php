<?php

namespace App\Http\Controllers;

use App\Models\Rdv;
use Illuminate\Http\Request;
use App\Models\Donation;

class RdvController extends Controller
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
    public function store(Request $request)
    {
        //
        $request->validate([
            'date' => 'required|date',
            'donor_id' => 'required|exists:donors,id',
            'center_id' => 'required|exists:donation_centers,id',
        ]);

        Rdv::create($request->all());
        return redirect()->route('donor.dashboard')->with('success', 'RDV créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rdv $rdv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rdv $rdv)
    {
        //
        return view('donor.editReservation', compact('rdv'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rdv $rdv)
    {
        //
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'donor_id' => 'required|exists:donors,id',
            'center_id' => 'required|exists:donation_centers,id',
        ]);
        $rdv->update($request->all());
        return redirect()->route('donor.dashboard')->with('success', 'RDV mis à jour avec succès'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rdv $rdv)
    {
        //  
        $rdv->delete();
        return redirect()->route('donor.dashboard')->with('success', 'RDV supprimé avec succès');
    }

     public function confirmRdv(Request $request)
    {   
        $request->validate([
            'id' => 'required|exists:rdvs,id',
            'time' => 'required|date_format:H:i',
        ]);
        $rdv = Rdv::find($request->id);
        $rdv->status = 'confirmed';
        $rdv->time = $request->time;
        $rdv->save();
        return redirect()->route('donor.dashboard')->with('success', 'RDV confirmé avec succès');
    }
    public function rejectRdv($id)
    {
        $rdv = Rdv::find($id);
        $rdv->status = 'rejected';
        
        $rdv->save();
        return redirect()->route('donor.dashboard')->with('success', 'RDV rejeté avec succès');
    }
    public function doneRdv($id)
    {
        $rdv = Rdv::find($id);
        Donation::create([
            'donor_id' => $rdv->donor_id,
            'donation_center_id' => $rdv->center_id,
            'donation_date' => now(),
        ]);
        $rdv->delete();
        $rdv->save();
        return redirect()->route('donor.dashboard')->with('success', 'RDV terminé avec succès');
    }
}
