<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\BookingService;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $agent = Auth::guard('agent')->user();
        $bookings = $this->bookingService->getAllBookingsForAgent($agent->id);
        // Dummy stats for UI
        $stats = [
            'total_bookings' => $bookings->count(),
            'total_bookings_growth' => '36%',
            'total_sales' => $bookings->sum('amount'),
            'total_sales_growth' => '36%',
            'total_commission' => $bookings->sum('commission'),
            'total_commission_growth' => '36%',
        ];
        return view('agent.bookings.index', [
            'bookings' => $bookings,
            'stats' => $stats,
        ]);
    }
}
