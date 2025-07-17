<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\BookingService;

class DashboardController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $agent = Auth::guard('agent')->user();
        $bookings = $this->bookingService->getDashboardBookings($agent->id);

        return view('affiliate.dashboard', [
            'pendingBookings' => $bookings['pending'],
            'processedBookings' => $bookings['processed'],
        ]);
    }
}
