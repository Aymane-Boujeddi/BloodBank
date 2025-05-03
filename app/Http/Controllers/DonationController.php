<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationCenter;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DonationController extends Controller
{
    public function index()
    {
        
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'donor_id' => 'required|exists:donors,id',
            'donation_center_id' => 'required|exists:donation_centers,id',
            'donation_date' => 'required|date',
        ]);

        $donation = Donation::create([
            'donor_id' => $request->donor_id,
            'donation_center_id' => $request->donation_center_id,
            'donation_date' => $request->donation_date,
        ]);

        return redirect()->back()->with('success', 'Don enregistré avec succès.');
    }

    public function show(Donation $donation)
    {
        $donation->load(['result', 'donor.user', 'donationCenter']);
        return view('donation.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        
    }

    public function update(Request $request, Donation $donation)
    {
        $request->validate([
            'donor_id' => 'sometimes|required|exists:donors,id',
            'donation_center_id' => 'sometimes|required|exists:donation_centers,id',
            'donation_date' => 'sometimes|required|date',
        ]);

        $donation->update($request->only([
            'donor_id',
            'donation_center_id',
            'donation_date',
        ]));

        return redirect()->back()->with('success', 'Don mis à jour avec succès.');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->back()->with('success', 'Don supprimé avec succès.');
    }

    public function storeResults(Request $request)
    {
        $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'blood_type' => 'nullable|string|max:5',
            'amount' => 'required|integer|min:100|max:1000',
            'hemoglobin' => 'nullable|numeric|min:0|max:25',
            'blood_pressure' => 'nullable|string|max:10',
            'pulse' => 'nullable|numeric|min:40|max:220',
            'has_medical_issues' => 'nullable|boolean',
            'medical_notes' => 'nullable|string',
            'next_eligible_donation_date' => 'nullable|date|after:today',
        ]);

        $existingResult = Result::where('donation_id', $request->donation_id)->first();

        if ($existingResult) {
            return redirect()->back()->with('error', 'Un résultat existe déjà pour ce don.');
        }

        if (!$request->next_eligible_donation_date) {
            $donation = Donation::findOrFail($request->donation_id);
            $nextEligibleDate = Carbon::parse($donation->donation_date)->addDays(56);
        } else {
            $nextEligibleDate = Carbon::parse($request->next_eligible_donation_date);
        }

        $result = Result::create([
            'donation_id' => $request->donation_id,
            'blood_type' => $request->blood_type,
            'hemoglobin' => $request->hemoglobin,
            'blood_pressure' => $request->blood_pressure,
            'pulse' => $request->pulse,
            'amount' => $request->amount,
            'has_medical_issues' => $request->has_medical_issues ? true : false,
            'medical_notes' => $request->medical_notes,
            'next_eligible_donation_date' => $nextEligibleDate,
        ]);

        return redirect()->back()->with('success', 'Résultat enregistré avec succès.');
    }

    public function updateResults(Request $request, Result $result)
    {
        $request->validate([
            'blood_type' => 'nullable|string|max:5',
            'amount' => 'required|integer|min:100|max:1000',
            'hemoglobin' => 'nullable|numeric|min:0|max:25',
            'blood_pressure' => 'nullable|string|max:10',
            'pulse' => 'nullable|numeric|min:40|max:220',
            'has_medical_issues' => 'nullable|boolean',
            'medical_notes' => 'nullable|string',
            'next_eligible_donation_date' => 'nullable|date|after:today',
        ]);

        $result->update([
            'blood_type' => $request->blood_type,
            'hemoglobin' => $request->hemoglobin,
            'blood_pressure' => $request->blood_pressure,
            'pulse' => $request->pulse,
            'amount' => $request->amount,
            'has_medical_issues' => $request->has_medical_issues ? true : false,
            'medical_notes' => $request->medical_notes,
            'next_eligible_donation_date' => $request->next_eligible_donation_date,
        ]);

        return redirect()->back()->with('success', 'Résultat mis à jour avec succès.');
    }

    public function donationHistory()
    {
        $user = Auth::user();
        $donor = $user->donor;

        $results = Result::whereHas('donation', function ($query) use ($donor) {
            $query->where('donor_id', $donor->id);
        })
            ->with(['donation.donationCenter', 'donation.donor.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $donations = Donation::where('donor_id', $donor->id)
            ->with(['donationCenter', 'donationCenter.city', 'result'])
            ->orderBy('donation_date', 'desc')
            ->paginate(10);

        $latestDonationWithResult = Donation::where('donor_id', $donor->id)
            ->whereHas('result')
            ->orderBy('donation_date', 'desc')
            ->with('result')
            ->first();

        $healthMetrics = null;

        if ($latestDonationWithResult && $latestDonationWithResult->result) {
            $healthMetrics = [
                'hemoglobin' => [
                    'value' => $latestDonationWithResult->result->hemoglobin,
                    'min' => 13.0,
                    'max' => 17.0,
                    'unit' => 'g/dL'
                ],
                'blood_pressure' => [
                    'value' => $latestDonationWithResult->result->blood_pressure,
                    'unit' => 'mmHg'
                ],
                'pulse' => [
                    'value' => $latestDonationWithResult->result->pulse,
                    'min' => 60,
                    'max' => 100,
                    'unit' => 'bpm'
                ],
            ];
        }

        $totalVolumeInLiters = $this->calculateTotalVolume($donor->id);

        $stats = [
            'total_donations' => $donations->total(),
            'total_volume' => $totalVolumeInLiters . ' L',
            'lives_saved' => $donations->count() * 3, 
            'centers_visited' => Donation::where('donor_id', $donor->id)
                ->distinct('donation_center_id')
                ->count('donation_center_id'),
        ];

        return view('donor.history', compact('results', 'donations', 'healthMetrics', 'stats'));
    }

    public function viewDonationResults($donationId)
    {
        $donation = Donation::where('id', $donationId)
            ->where('donor_id', Auth::user()->donor->id)
            ->with(['donationCenter', 'result'])
            ->firstOrFail();

        if (!$donation->result) {
            return redirect()->back()->with('error', 'Les résultats ne sont pas encore disponibles pour ce don.');
        }

        return view('donor.donation-results', compact('donation'));
    }

    public function downloadHealthReport($donationId)
    {
        $donation = Donation::where('id', $donationId)
            ->where('donor_id', Auth::user()->donor->id)
            ->with('result')
            ->firstOrFail();

        if (!$donation->result) {
            return redirect()->back()->with('error', 'Les résultats ne sont pas encore disponibles pour ce don.');
        }

        return redirect()->back()->with('success', 'Rapport téléchargé avec succès.');
    }

    public function downloadCertificate($donationId)
    {
        $donation = Donation::where('id', $donationId)
            ->where('donor_id', Auth::user()->donor->id)
            ->firstOrFail();

        return redirect()->back()->with('success', 'Certificat téléchargé avec succès.');
    }

    public function shareCertificate($donationId)
    {
        $donation = Donation::where('id', $donationId)
            ->where('donor_id', Auth::user()->donor->id)
            ->firstOrFail();

        return redirect()->back()->with('success', 'Lien de partage copié dans le presse-papier.');
    }

    public function getDonationStatistics()
    {
        $donor = Auth::user()->donor;

        $stats = [
            'total_donations' => Donation::where('donor_id', $donor->id)->count(),
            'last_donation' => Donation::where('donor_id', $donor->id)
                ->orderBy('donation_date', 'desc')
                ->first(),
            'most_visited_center' => DonationCenter::whereHas('donations', function ($query) use ($donor) {
                $query->where('donor_id', $donor->id);
            })
                ->withCount(['donations' => function ($query) use ($donor) {
                    $query->where('donor_id', $donor->id);
                }])
                ->orderBy('donations_count', 'desc')
                ->first()
        ];

        $latestDonationWithResult = Donation::where('donor_id', $donor->id)
            ->whereHas('result')
            ->orderBy('donation_date', 'desc')
            ->with('result')
            ->first();

        if ($latestDonationWithResult && $latestDonationWithResult->result) {
            $stats['blood_type'] = $latestDonationWithResult->result->blood_type;
        }

        return response()->json($stats);
    }

    private function calculateTotalVolume($donorId)
    {
        $totalMl = Result::whereHas('donation', function ($query) use ($donorId) {
            $query->where('donor_id', $donorId);
        })->sum('amount');

        return number_format($totalMl / 1000, 1);
    }
}
