<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agent\Auth\LoginController;

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
Route::prefix('agent')->name('agent.')->group(function () {
    Route::get('/login', function () {
        return view('agent.login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('agent/login-error', function () {
    return view('agent.login-error');
})->name('agent.login-error');

Route::get('agent/change-password', function () {
    return view('agent.change-password');
})->name('agent.change-password');

// Agent protected routes (require authentication)
Route::prefix('agent')->middleware(['auth:agent'])->name('agent.')->group(function () {
    // Redirect /agent to /agent/dashboard if authenticated
    Route::get('/', function () {
        return redirect()->route('agent.dashboard');
    });

    Route::get('/dashboard', [\App\Http\Controllers\Agent\DashboardController::class, 'index'])->name('dashboard');

    // Bookings module
    Route::get('/bookings', [\App\Http\Controllers\Agent\BookingController::class, 'index'])->name('bookings.index');

    // Add more agent-specific routes here
});
