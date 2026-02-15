<?php

namespace App\Repositories;

use App\Models\Booking;

class BookingRepository
{
    /**
     * Find booking by ID with full details
     *
     * @param int $id
     * @return Booking
     */
    public function findWithDetails($id)
    {
        return Booking::with([
            'car_model.pictures',
            'car_model.model_specification',
            'addonbookings.addon',
            'user',
            'branch'
        ])->findOrFail($id);
    }

    /**
     * Find booking by ID
     *
     * @param int $id
     * @return Booking
     */
    public function find($id)
    {
        return Booking::findOrFail($id);
    }

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
     *
     * @param int $agentId
     * @param int $perPage
     * @param string $sort
     * @param string $direction
     * @param array $filters
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAgentBookingsApi($agentId, $perPage = 10, $sort = 'created_at', $direction = 'desc', $filters = []): \Illuminate\Pagination\LengthAwarePaginator
    {
        try {
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
        } catch (\Exception $e) {
            // Return empty paginator in case of error
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Get statistics for agent based on selected month period
     *
     * @param int $agentId
     * @param string $month
     * @return array
     */
    public function getAgentStats($agentId, $month = 'all'): array
    {
        try {
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
        } catch (\Exception $e) {
            // Return default stats in case of error
            return [
                'total_bookings' => '0',
                'total_bookings_growth' => '0%',
                'total_sales' => '0.00',
                'total_sales_growth' => '0%',
                'total_commission' => '0.00',
                'total_commission_growth' => '0%',
            ];
        }
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

    /**
     * Create a new booking with all related data
     *
     * @param array $bookingData
     * @return Booking
     */
    public function createBooking(array $bookingData): Booking
    {
        return Booking::create($bookingData);
    }

    /**
     * Save addon bookings for a booking
     *
     * @param int $bookingId
     * @param array $addons
     * @return void
     */
    public function saveAddons(int $bookingId, array $addons): void
    {
        foreach ($addons as $addonId => $amount) {
            if ($amount > 0) {
                \App\Models\AddOnBookings::create([
                    'booking_id' => $bookingId,
                    'addon_id' => $addonId,
                    'amount' => $amount,
                ]);
            }
        }
    }

    /**
     * Save pictures for a booking
     *
     * @param int $bookingId
     * @param string $fileName
     * @return void
     */
    public function savePicture(int $bookingId, string $fileName): void
    {
        \App\Models\Picture::create([
            'model_id' => $bookingId,
            'model_name' => 'booking',
            'file_name' => $fileName
        ]);
    }
}
