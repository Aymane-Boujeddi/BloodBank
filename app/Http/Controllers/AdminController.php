<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\BloodType;
use App\Models\City;
use App\Models\DonationCenter;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Reservation;
use App\Models\User;
use Faker\Core\Blood;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    // public function approveCenter($id)
    // {
    //     $center = DonationCenter::findOrFail($id);
    //     $center->status = 'approved';
    //     $center->save();

    //     return redirect()->route('admin.centers.index')->with('success', 'Donation center approved successfully.');
    // }
    
    // public function rejectCenter($id)
    // {
    //     $center = DonationCenter::findOrFail($id);
    //     $center->status = 'rejected';
    //     $center->save();

    //     return redirect()->route('admin.centers.index')->with('success', 'Donation center rejected successfully.');
    // }


    
    // public function addCity(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //     ]);

    //     City::create([
    //         'name' => $request->name,
    //     ]);

    //     return redirect()->back()->with('success', 'City added successfully.');
    // }
    
    // public function deleteCity($id)
    // {
    //     $city = City::findOrFail($id);
    //     $city->delete();

    //     return redirect()->back()->with('success', 'City deleted successfully.');
    // }
    
    public function approveDonationCenter($id)
    {
        $center = DonationCenter::findOrFail($id);
        $center->status = 'approved';
        $center->save();

        return redirect()->back()->with('success', 'Donation center approved successfully.');
    }
    
    public function rejectDonationCenter($id)
    {
        $center = DonationCenter::findOrFail($id);
        $center->status = 'rejected';
        $center->save();

        return redirect()->back()->with('success', 'Donation center rejected successfully.');
    }

    public function deleteDonationCenter($id)
    {
        $center = DonationCenter::findOrFail($id);
        $center->delete();

        return redirect()->back()->with('success', 'Donation center deleted successfully.');
    }
    
    public function deleteAllRejectedCenters()
    {
        DonationCenter::where('status', 'rejected')->delete();

        return redirect()->back()->with('success', 'All rejected donation centers deleted successfully.');
    }

    public function dashboard()
    {
        $pendingCenters = DonationCenter::where('status', 'pending')->get();
        $approvedCenters = DonationCenter::where('status', 'approved')->get();

        $stats = [
            'total_centers' => DonationCenter::count(),
            'pending_centers' => $pendingCenters->count(),
            'approved_centers' => $approvedCenters->count(),
            'total_reservations' => Reservation::count(),
            'total_donors' => Donor::count(),
            'total_donations' => Donation::count(),
            'total_cities' => City::count(),
        ];

        return view('admin.dashboard', compact('stats', 'pendingCenters'));
    }

    public function users()
    {
        $inactiveDate = now()->subDays(30);
        
        $donors = User::where('role', 'donor')
            ->with('donor', 'city')
            ->get();
            
        $centers = DonationCenter::with('user', 'city')
            ->where('status', 'approved')
            ->orderBy('center_name')
            ->get();
            
        $inactiveUsers = User::where('last_login', '<', $inactiveDate)
            ->with('city')
            ->with('donor', 'donationCenter')
            ->get();

        $stats = [
            'total_users' => User::count(),
            'total_donors' => User::where('role', 'donor')->count(),
            'total_centers' => User::where('role', 'donation_centre')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'inactive_users' => $inactiveUsers->count()
        ];
        
        return view('admin.users', compact('donors', 'centers', 'inactiveUsers', 'stats'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->isDonor() && $user->donor) {
            $user->donor->delete();
        } elseif ($user->isDonationCenter() && $user->donationCenter) {
            $user->donationCenter->delete();
        } elseif ($user->isAdmin() && $user->admin) {
            $user->admin->delete();
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function centers()
    {
        $pendingCenters = DonationCenter::where('status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $approvedCenters = DonationCenter::where('status', 'approved')
            ->with('user')
            ->orderBy('center_name')
            ->get();

        $rejectedCenters = DonationCenter::where('status', 'rejected')
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->get();

        $cities = City::orderBy('name')->get();
        $cityCount = $cities->count();
        // dd($cityCount);
        $stats = [
            'total_centers' => DonationCenter::count(),
            'pending_centers' => $pendingCenters->count(),
            'approved_centers' => $approvedCenters->count(),
            'rejected_centers' => $rejectedCenters->count(),
            'total_cities' => City::count()
        ];

        return view('admin.centers', compact(
            'stats',
            'pendingCenters',
            'approvedCenters',
            'rejectedCenters',
            'cities'
        ));
    }

    public function getCenterDetails($id)
    {
        $center = DonationCenter::with(['city'])
            ->withCount(['reservations', 'donations'])
            ->findOrFail($id);

        $lastReservation = $center->reservations()->latest()->first();
        $lastDonation = $center->donations()->latest()->first();

        $lastActivity = null;
        if ($lastReservation && $lastDonation) {
            $lastActivity = $lastReservation->created_at->gt($lastDonation->created_at)
                ? 'Rendez-vous le ' . $lastReservation->created_at->format('d/m/Y')
                : 'Don le ' . $lastDonation->created_at->format('d/m/Y');
        } elseif ($lastReservation) {
            $lastActivity = 'Rendez-vous le ' . $lastReservation->created_at->format('d/m/Y');
        } elseif ($lastDonation) {
            $lastActivity = 'Don le ' . $lastDonation->created_at->format('d/m/Y');
        }

        $center->last_activity = $lastActivity;

        return response()->json($center);
    }

    public function data()
    {
        $cities = City::all();
        $bloodTypes = BloodType::all();

        return view('admin.data', compact(
            'cities',
            'bloodTypes'
        ));
    }
}
