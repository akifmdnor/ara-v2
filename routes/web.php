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
Route::name('web.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Web\IndexController::class, 'index']);
    //web.listing
    Route::get('/search', [\App\Http\Controllers\Web\SearchController::class, 'search']);
});




/*
|--------------------------------------------------------------------------
| Affiliate Routes
|--------------------------------------------------------------------------
|
| Routes for affiliate/agent functionality including authentication,
| dashboard, bookings, and car listings.
|
*/

Route::prefix('affiliate')->name('affiliate.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Public Affiliate Routes (No Authentication Required)
    |--------------------------------------------------------------------------
    */
    // Authentication routes
    Route::get('/login', function () {
        return view('affiliate.auth.login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    // Public informational routes
    Route::get('/login-error', function () {
        return view('affiliate.auth.login-error');
    })->name('login-error');

    /*
    |--------------------------------------------------------------------------
    | Protected Affiliate Routes (Authentication Required)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:agent')->group(function () {
        // Authentication
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        // Password management
        Route::get('/change-password', function () {
            return view('affiliate.auth.change-password');
        })->name('change-password');

        // Dashboard
        Route::get('/', function () {
            return redirect()->route('affiliate.dashboard');
        });

        Route::get('/dashboard', [\App\Http\Controllers\Affiliate\DashboardController::class, 'index'])
            ->name('dashboard');

        // Bookings Management
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Affiliate\BookingController::class, 'index'])
                ->name('index');
        });

        // Car Listings Management
        Route::prefix('car-listing')->name('car-listing.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Affiliate\CarListingController::class, 'index'])
                ->name('index');

            Route::post('/search', [\App\Http\Controllers\Affiliate\CarListingController::class, 'search'])
                ->name('search');

            Route::get('/{carModel}/book', [\App\Http\Controllers\Affiliate\CarListingController::class, 'book'])
                ->name('book');
        });

        // Utility endpoints
        Route::get('/restricted-dates', [\App\Http\Controllers\Affiliate\CarListingController::class, 'getRestrictedDates'])
            ->name('restricted-dates');
    });

});

/*
|--------------------------------------------------------------------------
| Affiliate API Routes
|--------------------------------------------------------------------------
|
| API endpoints for affiliate functionality that return JSON responses.
|
*/
Route::middleware('auth:agent')->prefix('api/affiliate')->name('api.affiliate.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\Affiliate\BookingController::class, 'apiList'])
        ->name('bookings');
});
