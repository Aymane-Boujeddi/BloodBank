<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class UserController extends Controller
{
    //

    public function index()
    {
        return view('users.index');
    }
    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required',
    //         'password' => 'required',
    //         'role' => 'required'
    //     ]);
    //     $hashedPassword = Hash::make($request->password);
    //     $request->merge([
    //         'password' => $hashedPassword
    //     ]);
    //     $user = User::create($request->all());
    //     return redirect()->route('users.index');
    // }
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required',  Rules\Password::defaults()],
         
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'last_logged' => now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('user', absolute: false));
    }
}
