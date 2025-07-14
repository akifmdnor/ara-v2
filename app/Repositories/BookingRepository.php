<?php

namespace App\Repositories;

use App\Models\Booking;

class BookingRepository
{
    /**
     * Get bookings for a specific sales agent.
     */
    public function getBookingsForAgent($agentId)
    {
        return Booking::where('sales_agent_id', $agentId)
            ->with('car_model', 'car_model.branch')
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Get paginated, filterable, and sortable bookings for a specific sales agent (for API)
     */
    public function getAgentBookingsApi($agentId, $perPage = 10, $sort = 'created_at', $direction = 'desc', $filters = [])
    {
        $query = Booking::where('sales_agent_id', $agentId)
            ->with(['car_model', 'car_model.branch', 'car_model.model_specification', 'user', 'branch', 'staff', 'sales_agent', 'car.car_model.model_specification']);

        // Month filtering
        if (!empty($filters['month']) && $filters['month'] !== 'all') {
            $year = substr($filters['month'], 0, 4);
            $month = substr($filters['month'], 5, 2);
            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);
        }

        // Filtering
        if (!empty($filters['customer_status']) && $filters['customer_status'] !== 'All') {
            $query->where('payment_status', $filters['customer_status']);
        }
        if (!empty($filters['booking_number'])) {
            $query->whereRaw("CONCAT('BK', LPAD(id, 4, '0')) LIKE ?", ['%' . $filters['booking_number'] . '%']);
        }
        if (!empty($filters['customer_name'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['customer_name'] . '%');
            });
        }

        // Sorting
        $query->orderBy($sort, $direction);

        // Pagination
        return $query->paginate($perPage);
    }

    /**
     * Get statistics for agent based on selected month period
     */
    public function getAgentStats($agentId, $month = 'all')
    {
        $query = Booking::where('sales_agent_id', $agentId)
            ->with('sales_agent');

        // Month filtering
        if ($month !== 'all') {
            $year = substr($month, 0, 4);
            $monthNum = substr($month, 5, 2);
            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $monthNum);
        }

        $bookings = $query->get();

        $totalBookings = $bookings->count();
        $totalSales = $bookings->sum('amount');
        $totalCommission = $bookings->sum('commission'); // Uses the accessor

        return [
            'total_bookings' => (string) $totalBookings,
            'total_bookings_growth' => '36%', // Placeholder - could calculate from previous period
            'total_sales' => number_format($totalSales, 2),
            'total_sales_growth' => '36%', // Placeholder - could calculate from previous period
            'total_commission' => number_format($totalCommission, 2),
            'total_commission_growth' => '36%', // Placeholder - could calculate from previous period
        ];
    }
}
