<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\DonationCenter;
use App\Models\User;
use App\Models\City;
use App\Models\BloodType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:donor,donation_centre',
            'city_id' => 'required|exists:cities,id',
        ]);
        // dd($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'city_id' => $request->city_id,
        ]);

        Auth::login($user);

        if ($user->role === 'donor') {
            return redirect()->route('donor-profile.complete');
        } elseif ($user->role === 'donation_centre') {
            return redirect()->route('center-profile.complete'); // FIXED: was redirecting to donor-profile.complete
        }
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            // dd($user);
            if ($user->role === 'donor') {
                // dd($user);
                if ($user->profile_status === 'incomplete') {
                    return redirect()->route('donor-profile.complete');
                }
                return redirect()->intended(route('donor.dashboard'));
            } elseif ($user->role === 'donation_centre') {
                if ($user->profile_status === 'incomplete') {
                    return redirect()->route('center-profile.complete');
                }
                return redirect()->intended(route('donationCenter.dashboard'));
            } elseif ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        $cities = City::all();
        $bloodTypes = BloodType::all();
        return view('register', compact('cities', 'bloodTypes'));
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));
    }

    public function showCompleteProfileFormDonor()
    {
        $bloodTypes = BloodType::all();
        return view('profile.complete-donor', compact('bloodTypes'));
    }
    public function showCompleteProfileFormCenter()
    {
        return view('profile.complete-center');
    }

    public function completeProfile(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'donor') {
            $request->validate([
                'phone_number' => 'required|string|max:20',
                'date_of_birth' => 'required|date|before:today',
                'has_donated' => 'required|boolean',
            ]);

            Donor::create([
                'user_id' => $user->id,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'blood_type_id' => $request->blood_type_id,
                'has_donated' => $request->has_donated,
            ]);
            $donor = User::where('id', $user->id)->first();
            $donor->profile_status = 'complete';
            $donor->save();

            return redirect()->route('donor.dashboard')->with('success', 'Your profile has been completed successfully.');
        } elseif ($user->role === 'donation_centre') {
            // dd($request->all());
            $request->validate([
                'center_name' => 'required|string|max:255',
                'address' => 'required|string|max:500',
                'phone_number' => 'required|string|max:20',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'opening_time' => 'required',
                'closing_time' => 'required',
            ]);
            // dd($request->longitude);
            $latitude = (float) $request->latitude;
            $longitude = (float) $request->longitude;

            DonationCenter::create([
                'user_id' => $user->id,
                'center_name' => $request->center_name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
            ]);
            $center = User::where('id', $user->id)->first();
            $center->profile_status = 'complete';
            $center->save();

            return redirect()->route('donationCenter.dashboard')->with('success', 'Your profile has been completed successfully.');
        }

        return redirect()->route('home')->with('error', 'Invalid user role.');
    }
}
