<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationCenterController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('home');
});

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');

Route::get('/home', function () {
    return view('home');
})->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/profile', function () {
    return view('profile.complete');
})->name('profile');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('showlogin');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/center', [DonationCenterController::class, 'index'])->name('donationCenter.dashboard');
Route::get('/center/appointment', [DonationCenterController::class, 'appointments'])->name('donationCenter.appointments');
Route::get('/center/profile', [DonationCenterController::class, 'profile'])->name('donationCenter.profile');
Route::get('/center/settings', [DonationCenterController::class, 'settings'])->name('donationCenter.settings');
Route::post('/center/profile/update', [DonationCenterController::class, 'updateProfile'])->name('donationCenter.profile.update');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/center/appointment', [DonationCenterController::class, 'appointments'])->name('donationCenter.appointments');

Route::middleware(['auth', 'CheckRole:donor'])->group(function () {
    // Route::get('/donor', [UserController::class, 'showDonorDashboard'])->name('donor.dashboard');
Route::get('/donor', [DonorController::class, 'index'])->name('donor.dashboard');

});
Route::get('/donor/centers', [DonorController::class, 'centers'])->name('donor.centers');
Route::get('/donor/centers/nearest', [DonationCenterController::class, 'nearestCenters'])->name('donor.centers.nearest');

Route::middleware(['auth', 'checkrole:donation_centre'])->group(function () {
    // Route::get('/donation-center', [UserController::class, 'showDonationCenterDashboard'])->name('donationCenter.dashboard');

    // Location management
});
Route::get('/center/location', [DonationCenterController::class, 'location'])->name('donationCenter.location');
Route::post('/center/location', [DonationCenterController::class, 'saveLocation'])->name('donationCenter.saveLocation');

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::get('/admin', [UserController::class, 'showAdminDashboard'])->name('admin.dashboard');
});

Route::get('/days', function () {
    return view('days');
})->name('days');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Profile completion routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/complete/donor', [UserController::class, 'showCompleteProfileFormDonor'])->name('donor-profile.complete');
    Route::post('/profile/complete/donor', [UserController::class, 'completeProfile'])->name('donor-profile.complete');
    Route::get('/profile/complete/center', [UserController::class, 'showCompleteProfileFormCenter'])->name('center-profile.complete');
    Route::post('/profile/complete/center', [UserController::class, 'completeProfile'])->name('center-profile.complete');
});
Route::get('/', function () {
    return view('donor.nearby-center');
})->name('nearby');
Route::get('/donor/appointments', function () {
    return view('donor.appointments');
})->name('donor.appointments');
Route::get('/center/location', function () {
    return view('donationCenter.location');
})->name('donationCenter.location');

Route::get('/donor/history', function () {
    return view('donor.history');
})->name('donor.history');

Route::get('/donor/reviews', function () {
    return view('donor.reviews');
})->name('donor.reviews');

Route::get('center/profile', function () {
    return view('donationCenter.center-profile');
})->name('donationCenter.profile');

Route::post('/donor/reservations/store', [ReservationController::class, 'store'])->name('donor.reservations.store')->middleware('auth');
Route::get('/donation-center/profile', [DonationCenterController::class, 'profile'])->name('donation-center.profile');
Route::patch('/donation-center/update', [DonationCenterController::class, 'updateCenter'])->name('donation-center.update');
Route::patch('/donation-slots/update', [DonationCenterController::class, 'updateSlots'])->name('donation-slots.update');
Route::post('/special-hours/store', [DonationCenterController::class, 'storeSpecialHours'])->name('special-hours.store');
Route::delete('/special-hours/delete', [DonationCenterController::class, 'deleteSpecialHours'])->name('special-hours.delete');
Route::get('/donation-slots/available', [DonationCenterController::class, 'getAvailableSlots'])->name('donation-slots.available');
