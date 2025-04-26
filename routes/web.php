<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DonationController; 
use App\Http\Controllers\DonationCenterController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::get('/', function () {
    return view('home');
})->name('home'); // Combined '/' and '/home'

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// --- Authentication Routes ---
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']); // Inherits name 'register'
Route::get('/login', [UserController::class, 'showLoginForm'])->name('showlogin');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

// --- Routes Requiring Authentication ---
Route::middleware(['auth'])->group(function () {

    // -- Profile Completion Routes --
    Route::get('/profile/complete/donor', [UserController::class, 'showCompleteProfileFormDonor'])->name('donor-profile.complete');
    Route::post('/profile/complete/donor', [UserController::class, 'completeProfile']); // Inherits name 'donor-profile.complete'
    Route::get('/profile/complete/center', [UserController::class, 'showCompleteProfileFormCenter'])->name('center-profile.complete');
    Route::post('/profile/complete/center', [UserController::class, 'completeProfile']); // Inherits name 'center-profile.complete'

    // -- Generic Profile Route (Consider if needed or use role-specific) --
    Route::get('/profile', function () {
        return view('profile.complete');
    })->name('profile');

    // -- Donor Routes --
    Route::middleware(['checkrole:donor','auth'])->prefix('donor')->name('donor.')->group(function () {
        Route::get('/', [DonorController::class, 'index'])->name('dashboard');
        Route::get('/centers', [DonorController::class, 'centers'])->name('centers');
        Route::get('/centers/nearest', [DonationCenterController::class, 'nearestCenters'])->name('centers.nearest'); // Note: Uses DonationCenterController

        // Calendar and reservation routes
        Route::get('/centers/{center}/available-days', [DonorController::class, 'availableDaysForCalendar'])->name('centers.available-days');
        // Note: The route below is functionally identical to the one above if {center} and {centerId} refer to the same thing. Kept both as requested.
        Route::get('/centers/{centerId}/available-days', [DonorController::class, 'availableDaysForCalendar'])->name('centers.availableDays');
        Route::get('/centers/{centerId}/available-hours/{date}', [DonorController::class, 'getAvailableTimeSlots'])->name('centers.availableHours');
        Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('cancel-reservation');

        // Static view routes for donor section
        Route::get('/appointments', [ReservationController::class, 'showReservations'])->name('appointments'); 

        // Donation history routes - updated to use DonationController
        Route::get('/history', [DonationController::class, 'donationHistory'])->name('history');
        Route::get('/donations/{donation}/results', [DonationController::class, 'viewDonationResults'])->name('donations.results');
        Route::get('/health-reports/{report}/download', [DonationController::class, 'downloadHealthReport'])->name('health-reports.download');
        Route::get('/certificates/{donation}/download', [DonationController::class, 'downloadCertificate'])->name('certificates.download');
        Route::get('/certificates/{donation}/share', [DonationController::class, 'shareCertificate'])->name('certificates.share');
        
        // For the analytics/statistics on the history page
        Route::get('/statistics', [DonationController::class, 'getDonationStatistics'])->name('statistics');
        Route::get('/reviews', function () {
            return view('donor.reviews');
        })->name('reviews');
    });

    // -- Donation Center Routes --
    // Note: Some routes were defined outside middleware, moved them inside for consistency if they require auth/role.
    Route::middleware(['checkrole:donation_centre'])->prefix('center')->name('donationCenter.')->group(function () {
        Route::get('/', [DonationCenterController::class, 'index'])->name('dashboard');
        Route::get('/appointments', [DonationCenterController::class, 'appointments'])->name('appointments'); // Duplicate definition removed from outside group
        Route::get('/profile', [DonationCenterController::class, 'profile'])->name('profile'); // Combined multiple profile gets
        Route::post('/profile/update', [DonationCenterController::class, 'updateProfile'])->name('profile.update');
        Route::get('/settings', [DonationCenterController::class, 'settings'])->name('settings');

        // Location Management
        Route::get('/location', [DonationCenterController::class, 'location'])->name('location');
        Route::post('/location', [DonationCenterController::class, 'saveLocation'])->name('saveLocation');

        // Slot and Hours Management (Assuming these require center role)
        Route::patch('/update', [DonationCenterController::class, 'updateCenter'])->name('update'); // Renamed from '/donation-center/update'
        Route::patch('/donation-slots/update', [DonationCenterController::class, 'updateSlots'])->name('donation-slots.update');
        Route::post('/special-hours/store', [DonationCenterController::class, 'storeSpecialHours'])->name('special-hours.store');
        Route::delete('/special-hours/delete', [DonationCenterController::class, 'deleteSpecialHours'])->name('special-hours.delete');
        Route::get('/donation-slots/available', [DonationCenterController::class, 'getAvailableSlots'])->name('donation-slots.available'); // Consider if this should be public/donor accessible
    });
    // Note: The following routes were outside the middleware group but seemed related. Moved them inside. Adjust if they don't require auth/center role.
    Route::get('/center/profile', [DonationCenterController::class, 'profile'])->name('donationCenter.profile'); // Already defined inside group
    Route::get('/center/location', [DonationCenterController::class, 'location'])->name('donationCenter.location'); // Already defined inside group
    Route::post('/center/location', [DonationCenterController::class, 'saveLocation'])->name('donationCenter.saveLocation'); // Already defined inside group
    Route::get('/donation-center/profile', [DonationCenterController::class, 'profile'])->name('donation-center.profile'); // Duplicate, uses hyphenated name
    Route::patch('/donation-center/update', [DonationCenterController::class, 'updateCenter'])->name('donation-center.update'); // Duplicate, uses hyphenated name
    Route::patch('/donation-slots/update', [DonationCenterController::class, 'updateSlots'])->name('donation-slots.update'); // Already defined inside group
    Route::post('/special-hours/store', [DonationCenterController::class, 'storeSpecialHours'])->name('special-hours.store'); // Already defined inside group
    Route::delete('/special-hours/delete', [DonationCenterController::class, 'deleteSpecialHours'])->name('special-hours.delete'); // Already defined inside group
    Route::get('/donation-slots/available', [DonationCenterController::class, 'getAvailableSlots'])->name('donation-slots.available'); // Already defined inside group

    // -- Admin Routes --
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        // Add other admin routes here
    });
});

// --- Other Miscellaneous Routes ---

// Example static view route (if needed)
Route::get('/days', function () {
    return view('days');
})->name('days');

// Note: This route seems misplaced, maybe intended for donor section?
Route::get('/nearby', function () {
    return view('donor.nearby-center');
})->name('nearby'); // This duplicates the root '/' route's view target. Consider removing or changing.

// --- Commented Out/Potentially Unused Routes ---
// Route::get('/donor/centers/{center}/available-slots/{date}', [DonorController::class, 'availableSlotsForDate'])->name('donor.centers.available-slots');
// Route::get('/donor/centers/available-slots', [DonorController::class, 'availableSlotsForDate']);
// Route::get('center/profile', [DonationCenterControl::class, 'showProfile'])->name('donationCenter.profile'); // Typo in Controller name? Duplicate route.
