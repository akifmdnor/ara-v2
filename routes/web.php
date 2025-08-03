<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Affiliate\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Agent authentication routes (accessible without auth)
Route::prefix('affiliate')->name('affiliate.')->group(function () {
    Route::get('/login', function () {
        return view('affiliate.login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('affiliate/login-error', function () {
    return view('affiliate.login-error');
})->name('affiliate.login-error');

Route::get('affiliate/change-password', function () {
    return view('affiliate.change-password');
})->name('affiliate.change-password');

// Agent protected routes (require authentication)
Route::prefix('affiliate')->middleware(['auth:agent'])->name('affiliate.')->group(function () {
    // Redirect /affiliate to /affiliate/dashboard if authenticated
    Route::get('/', function () {
        return redirect()->route('affiliate.dashboard');
    });

    Route::get('/dashboard', [\App\Http\Controllers\Affiliate\DashboardController::class, 'index'])->name('dashboard');

    // Bookings module
    Route::get('/bookings', [\App\Http\Controllers\Affiliate\BookingController::class, 'index'])->name('bookings.index');

    // Car listing module
    Route::get('/car-listing', [\App\Http\Controllers\Affiliate\CarListingController::class, 'index'])->name('car-listing.index');
    Route::post('/car-listing/search', [\App\Http\Controllers\Affiliate\CarListingController::class, 'search'])->name('car-listing.search');
    Route::get('/car-listing/{carModel}/book', [\App\Http\Controllers\Affiliate\CarListingController::class, 'book'])->name('car-listing.book');

    // Restricted dates endpoint
    Route::get('/restricted-date', [\App\Http\Controllers\Affiliate\CarListingController::class, 'getRestrictedDates'])->name('restricted-dates');

    // Add more agent-specific routes here

});

Route::middleware(['auth:agent'])->group(function () {
    Route::get('/api/affiliate/bookings', [\App\Http\Controllers\Affiliate\BookingController::class, 'apiList']);
});
