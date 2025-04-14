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

    public function register(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:donor,donation_centre'],
            'city_id' => ['required', 'exists:cities,id'],
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'role.required' => 'Veuillez sélectionner un type de compte.',
            'role.in' => 'Le type de compte sélectionné n\'est pas valide.',
            'city_id.required' => 'Veuillez sélectionner une ville.',
            'city_id.exists' => 'La ville sélectionnée n\'existe pas.',
        ]);

        if ($request->role === 'donor') {
            $request->validate([
                'phone_number' => ['required', 'string'],
                'date_of_birth' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
                'blood_type_id' => ['required', 'exists:blood_types,id'],
                'has_donated' => ['required', 'boolean'],
            ], [
                'phone_number.required' => 'Le numéro de téléphone est obligatoire.',
                'date_of_birth.required' => 'La date de naissance est obligatoire.',
                'date_of_birth.before_or_equal' => 'Vous devez avoir au moins 18 ans pour donner du sang.',
                'blood_type_id.required' => 'Veuillez sélectionner votre groupe sanguin.',
                'blood_type_id.exists' => 'Le groupe sanguin sélectionné n\'est pas valide.',
                'has_donated.required' => 'Veuillez indiquer si vous avez déjà donné du sang.',
            ]);
        } elseif ($request->role === 'donation_centre') {
            $request->validate([
                'center_name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string'],
                'centre_phone' => ['required', 'string'],
            ], [
                'center_name.required' => 'Le nom du centre est obligatoire.',
                'address.required' => 'L\'adresse du centre est obligatoire.',
                'centre_phone.required' => 'Le numéro de téléphone du centre est obligatoire.',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'city_id' => $request->city_id,
        ]);

        if ($request->role === 'donor') {
            $donor = new Donor([
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'blood_type_id' => $request->blood_type_id,
                'has_donated' => $request->has_donated,
            ]);
            $user->donor()->save($donor);
        } elseif ($request->role === 'donation_centre') {
            $center = new DonationCenter([
                'center_name' => $request->center_name,
                'address' => $request->address,
                'centre_phone' => $request->phone_number,
                'user_id' => $user->id,
            ]);
            $user->donationCenter()->save($center);
        }

        event(new Registered($user));
        Auth::login($user);

        if ($request->role === 'donor') {
            return redirect(route('donor.dashboard', absolute: false));
        } elseif ($request->role === 'donation_centre') {
            return redirect(route('donationCenter.dashboard', absolute: false));
        } elseif ($request->role === 'admin') {
            return redirect(route('admin.dashboard', absolute: false));
        }

        return redirect(route('home', absolute: false));
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

            if ($user->role === 'donor') {
                return redirect()->intended(route('donor.dashboard'));
            } elseif ($user->role === 'donation_centre') {
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
}
