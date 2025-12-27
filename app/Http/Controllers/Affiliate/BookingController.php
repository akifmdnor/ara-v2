<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Affiliate\BookingService;

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
        // Get stats from service or calculate separately
        $stats = [
            'total_bookings' => 0, // Will be calculated by API
            'total_bookings_growth' => '36%',
            'total_sales' => 0, // Will be calculated by API
            'total_sales_growth' => '36%',
            'total_commission' => 1270,
            'total_commission_growth' => '36%',
        ];
        return view('affiliate.bookings.index', [
            'stats' => $stats,
        ]);
    }


    /**
     * API endpoint: Get bookings for the authenticated agent (paginated, filterable, sortable, JSON)
     */
    public function apiList()
    {
        $agent = Auth::guard('agent')->user();
        $perPage = request('per_page', 10);
        $page = request('page', 1);
        $sort = request('sort', 'created_at');
        $direction = request('direction', 'desc');
        $filters = [
            'month' => request('month', 'all'),
            'customer_status' => request('customer_status', 'All'),
            'booking_number' => request('booking_number', ''),
            'customer_name' => request('customer_name', ''),
        ];

        // Get filtered bookings
        $bookings = $this->bookingService->getAgentBookingsApi($agent->id, $perPage, $sort, $direction, $filters);

        // Get stats for the selected period
        $stats = $this->bookingService->getAgentStats($agent->id, $filters['month']);

        return response()->json([
            'data' => $bookings->items(),
            'meta' => [
                'current_page' => $bookings->currentPage(),
                'last_page' => $bookings->lastPage(),
                'per_page' => $bookings->perPage(),
                'total' => $bookings->total(),
            ],
            'stats' => $stats,
        ]);
    }
}
