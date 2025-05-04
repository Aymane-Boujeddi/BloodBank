<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Donation;
use App\Models\DonationCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ResultController extends Controller
{
    public function index()
    {
        $donationCenter = Auth::user()->donationCenter;

        $donations = Donation::where('donation_center_id', $donationCenter->id)
            ->with(['donor.user', 'result'])
            ->orderBy('donation_date', 'desc')
            ->paginate(10);

        return view('donationCenter.results', compact('donations', 'donationCenter'));
    }

    public function create(Request $request)
    {
        $donation = Donation::findOrFail($request->donation_id);
        return view('donationCenter.results.create', compact('donation'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'blood_type_id' => 'required|string|exists:blood_types,id',
            'hemoglobin' => 'nullable|numeric',
            'blood_pressure' => 'nullable|string',
            'pulse' => 'nullable|numeric',
            'amount' => 'required|integer|min:100|max:1000',
            'has_medical_issues' => 'boolean',
            'medical_notes' => 'nullable|string',
            'next_eligible_donation_date' => 'nullable|date',
        ]);

        $existingResult = Result::where('donation_id', $request->donation_id)->first();

        if ($existingResult) {
            return redirect()->back()->with('error', 'Un résultat existe déjà pour ce don.');
        }

       Result::create([
            'donation_id' => $request->donation_id,
            'blood_type_id' => $request->blood_type_id,
            'hemoglobin' => $request->hemoglobin,
            'blood_pressure' => $request->blood_pressure,
            'pulse' => $request->pulse,
            'amount' => $request->amount,
            'has_medical_issues' => $request->has_medical_issues ?? false,
            'medical_notes' => $request->medical_notes,
            'next_eligible_donation_date' => $request->next_eligible_donation_date,
        ]);

        return redirect()->route('donationCenter.centerResultsPage')->with('success', 'Résultat ajouté avec succès.');
    }

    public function show(Result $result)
    {
        $donationCenter = Auth::user()->donationCenter;
        if ($result->donation->donation_center_id !== $donationCenter->id) {
            abort(403, 'Vous n\'avez pas la permission de voir ce résultat.');
        }

        return view('donationCenter.results.show', compact('result'));
    }

  

    public function update(Request $request, Result $result)
    {
        $donationCenter = Auth::user()->donationCenter;
        if ($result->donation->donation_center_id !== $donationCenter->id) {
            abort(403, 'Vous n\'avez pas la permission de modifier ce résultat.');
        }

        $request->validate([
            'blood_type' => 'nullable|string',
            'hemoglobin' => 'nullable|numeric',
            'blood_pressure' => 'nullable|string',
            'pulse' => 'nullable|numeric',
            'amount' => 'required|integer|min:100|max:1000',
            'has_medical_issues' => 'boolean',
            'medical_notes' => 'nullable|string',
            'next_eligible_donation_date' => 'nullable|date',
        ]);

        $result->blood_type = $request->blood_type;
        $result->hemoglobin = $request->hemoglobin;
        $result->blood_pressure = $request->blood_pressure;
        $result->pulse = $request->pulse;
        $result->amount = $request->amount;
        $result->has_medical_issues = $request->has_medical_issues ?? false;
        $result->medical_notes = $request->medical_notes;
        $result->next_eligible_donation_date = $request->next_eligible_donation_date;
        $result->save();

        return redirect()->back()->with('success', 'Résultat mis à jour avec succès.');
    }

    public function destroy(Result $result)
    {
        $donationCenter = Auth::user()->donationCenter;
        if ($result->donation->donation_center_id !== $donationCenter->id) {
            abort(403, 'Vous n\'avez pas la permission de supprimer ce résultat.');
        }

        $result->delete();

        return redirect()->back()->with('success', 'Résultat supprimé avec succès.');
    }

    public function donorResults()
    {
        $donor = Auth::user()->donor;

        $results = Result::whereHas('donation', function ($query) use ($donor) {
            $query->where('donor_id', $donor->id);
        })
            ->with(['donation.donationCenter'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('donor.results', compact('results'));
    }

   
}
