<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\DonationCenter;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    public function index() {}

    public function create() {}

    public function store(Request $request)
    {
        try {
            $request->validate([
                'center_id' => 'required|exists:donation_centers,id',
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required|date_format:H:i',
            ]);
            // dd($request->all());

            $user = Auth::user();

            $donor = $user->donor;

            

            $existingAppointment = Reservation::where('donor_id', $donor->id)
                ->first() ? true : false;
                

            if ($existingAppointment) {
                // dd('hello');
                return redirect()->back()->with('error', 'Vous avez déjà un rendez-vous .');
            }

            $reservation = Reservation::create([
                'donor_id' => $donor->id,
                'donation_center_id' => $request->center_id,
                'reservation_date' => $request->date,
                'reservation_time' => $request->time,
                'status' => 'pending'
            ]);
            if ($reservation) {
                return redirect()->back()->with('success', 'Rendez-vous créé avec succès');
            } else {
                return redirect()->back()->with('error', 'Une erreur est survenue lors de la création du rendez-vous.');
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création du rendez-vous.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Reservation $reservation) {}

    public function edit(Reservation $reservation)
    {
        return view('donor.editReservation', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'donor_id' => 'required|exists:donors,id',
            'donation_center_id' => 'required|exists:donation_centers,id',
        ]);
        $reservation->update($request->all());
        return redirect()->route('donor.dashboard')->with('success', 'Rendez-vous mis à jour avec succès');
    }

    public function destroy(Reservation $reservation)
    {
        if ($reservation->donor_id !== Auth::user()->donor->id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à annuler ce rendez-vous.');
        }

        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Seuls les rendez-vous en attente peuvent être annulés.');
        }

        $reservation->delete();
        return redirect()->route('donor.appointments')->with('success', 'Rendez-vous supprimé avec succès');
    }

    public function recordDonation(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:reservations,id',
        ]);

        $reservation = Reservation::find($request->id);

        Donation::create([
            'donor_id' => $reservation->donor_id,
            'donation_center_id' => $reservation->donation_center_id,
            'donation_date' => now(),
        ]);

        $reservation->delete();

        return redirect()->back()->with('success', 'Don complété avec succès');
    }

    public function showReservations()
    {
        $user = Auth::user();
        $donor = $user->donor;

        $reservations = Reservation::where('donor_id', $donor->id)
            ->with([
                'donationCenter',
                'donationCenter.city',
                'donationCenter.user'
            ])
            ->orderBy('reservation_date', 'desc')
            ->get();

        return view('donor.appointments', compact('reservations'));
    }

    public function showReservationsForCenter()
    {
        $user = Auth::user();
        $center = $user->donationCenter;

        $pendingReservations = Reservation::where('donation_center_id', $center->id)
            ->where('status', 'pending')
            ->with([
                'donor',
                'donor.user'
            ])
            ->orderBy('reservation_date', 'asc')
            ->get();

        $confirmedReservations = Reservation::where('donation_center_id', $center->id)
            ->where('status', 'confirmed')
            ->with([
                'donor',
                'donor.user'
            ])
            ->orderBy('reservation_date', 'asc')
            ->get();

        $todayReservationsCount = Reservation::where('donation_center_id', $center->id)
            ->whereDate('reservation_date', Carbon::today())
            ->count();

        $thisWeekReservationsCount = Reservation::where('donation_center_id', $center->id)
            ->whereBetween('reservation_date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->count();

        return view('donationCenter.appointments', compact(
            'pendingReservations',
            'confirmedReservations',
            'todayReservationsCount',
            'thisWeekReservationsCount'
        ));
    }

    public function confirmReservation(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:reservations,id',
        ]);

        $reservation = Reservation::find($request->id);
        $reservation->status = 'confirmed';
        $reservation->save();

        return redirect()->route('donationCenter.appointments')->with('success', 'RDV confirmé avec succès.');
    }

    public function rejectReservation(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:reservations,id',
        ]);

        $id = $request->id;
        $reservation = Reservation::find($id);
        $reservation->status = 'rejected';
        $reservation->save();
        return redirect()->route('donationCenter.appointments')->with('success', 'RDV rejeté avec succès.');
    }

    public function toPendingReservation(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:reservations,id',
        ]);
        $id = $request->id;
        $reservation = Reservation::find($id);
        if ($reservation) {
            $reservation->status = 'pending';
            $reservation->save();
            return redirect()->route('donationCenter.appointments')->with('success', 'RDV remis à l\'état "en attente" avec succès.');
        } else {
            return redirect()->route('donationCenter.appointments')->with('error', 'RDV non trouvé.');
        }
    }
}
