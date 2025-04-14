<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\DonationCenterController;
use App\Http\Controllers\DonorController;

Route::get('/', function () {
    return view('home');
});

Route::get('/days', function () {
    return view('days');
})->name('days');

Route::get('/404', function () {
    return view('404');
})->name('404');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/admin', function () {
    return view('admin');
})->name('admin');

Route::get('/centre', function () {
    return view('centre');
})->name('centre');

Route::get('/donneur', function () {
    return view('donneur');
})->name('donneur');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/logout', function () {
    return view('logout');
})->name('logout');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');

Route::get('/home', function () {
    return view('home');
})->name('home');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/donor', [DonorController::class, 'index'])->name('donor.dashboard');
Route::get('/center', [DonationCenterController::class, 'index'])->name('donationCenter.dashboard');
Route::get('/center/appointment', [DonationCenterController::class, 'appointments'])->name('donationCenter.appointments');
Route::get('/center/profile', [DonationCenterController::class, 'profile'])->name('donationCenter.profile');
Route::get('/center/settings', [DonationCenterController::class, 'settings'])->name('donationCenter.settings');
Route::post('/center/profile/update', [DonationCenterController::class, 'updateProfile'])->name('donationCenter.profile.update');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/center/appointment', [DonationCenterController::class, 'appointments'])->name('donationCenter.appointments');

Route::middleware(['auth', 'role:donor'])->group(function () {
    // Route::get('/donor', [UserController::class, 'showDonorDashboard'])->name('donor.dashboard');

});
Route::middleware(['auth', 'role:donation_centre'])->group(function () {
    // Route::get('/donation-center', [UserController::class, 'showDonationCenterDashboard'])->name('donationCenter.dashboard');

});
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::get('/admin', [UserController::class, 'showAdminDashboard'])->name('admin.dashboard');

});


Route::get('/test', function () {
    return view('donor.test');
})->name('test');
Route::get('/test2', function () {
    return view('donationCenter.test');
})->name('test');
Route::get('/apts', function () {
    return view('donationCenter.apts');
})->name('apts');
