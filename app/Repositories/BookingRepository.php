<?php

namespace App\Repositories;

use App\Models\Booking;

class BookingRepository
{
    /**
     * Get bookings for a specific sales affiliate.
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
            $query->whereYear('pickup_datetime', $year)
                ->whereMonth('pickup_datetime', $month);
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
        // Get current period stats
        $currentQuery = Booking::where('sales_agent_id', $agentId);

        if ($month !== 'all') {
            $year = substr($month, 0, 4);
            $monthNum = substr($month, 5, 2);
            $currentQuery->whereYear('pickup_datetime', $year)
                ->whereMonth('pickup_datetime', $monthNum);
        } else {
            // For 'all' time, compare current month with previous month
            $currentQuery->whereYear('pickup_datetime', date('Y'))
                ->whereMonth('pickup_datetime', date('n'));
        }

        $currentBookings = $currentQuery->get();
        $currentTotalBookings = $currentBookings->count();
        $currentTotalSales = $currentBookings->sum('amount');
        $currentTotalCommission = $currentBookings->sum('commission');

        // Get previous period stats for comparison
        $previousQuery = Booking::where('sales_agent_id', $agentId);

        if ($month !== 'all') {
            $year = substr($month, 0, 4);
            $monthNum = substr($month, 5, 2);

            // Calculate previous month
            $previousDate = \Carbon\Carbon::createFromDate($year, $monthNum, 1)->subMonth();
            $previousQuery->whereYear('pickup_datetime', $previousDate->year)
                ->whereMonth('pickup_datetime', $previousDate->month);
        } else {
            // For 'all' time, compare current month with previous month
            $previousDate = \Carbon\Carbon::now()->subMonth();
            $previousQuery->whereYear('pickup_datetime', $previousDate->year)
                ->whereMonth('pickup_datetime', $previousDate->month);
        }

        $previousBookings = $previousQuery->get();
        $previousTotalBookings = $previousBookings->count();
        $previousTotalSales = $previousBookings->sum('amount');
        $previousTotalCommission = $previousBookings->sum('commission');

        // Calculate growth percentages
        $bookingsGrowth = $this->calculateGrowthPercentage($currentTotalBookings, $previousTotalBookings);
        $salesGrowth = $this->calculateGrowthPercentage($currentTotalSales, $previousTotalSales);
        $commissionGrowth = $this->calculateGrowthPercentage($currentTotalCommission, $previousTotalCommission);

        return [
            'total_bookings' => (string) $currentTotalBookings,
            'total_bookings_growth' => $bookingsGrowth,
            'total_sales' => number_format($currentTotalSales, 2),
            'total_sales_growth' => $salesGrowth,
            'total_commission' => number_format($currentTotalCommission, 2),
            'total_commission_growth' => $commissionGrowth,
        ];
    }

    /**
     * Calculate growth percentage between two values
     */
    private function calculateGrowthPercentage($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? '100%' : '0%';
        }

        $growth = (($current - $previous) / $previous) * 100;
        $sign = $growth >= 0 ? '+' : '';

        return $sign . number_format($growth, 1) . '%';
    }
}
