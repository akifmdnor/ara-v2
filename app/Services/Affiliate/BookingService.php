<?php

namespace App\Services\Affiliate;

use App\Repositories\Affiliate\BookingRepository;

class BookingService
{
    protected $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Get bookings for dashboard, separated by status.
     */
    public function getDashboardBookings($agentId)
    {
        $bookings = $this->bookingRepository->getBookingsForAgent($agentId);

        $pending = $bookings->where('booking_status', 'Pending');
        $processed = $bookings->where('booking_status', '!=', 'Pending');

        return [
            'pending' => $pending,
            'processed' => $processed,
        ];
    }

    public function getAllBookingsForAgent($agentId)
    {
        return $this->bookingRepository->getBookingsForAgent($agentId);
    }

    /**
     * Get paginated, filterable, and sortable bookings for agent (for API)
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
        return $this->bookingRepository->getAgentBookingsApi($agentId, $perPage, $sort, $direction, $filters);
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
        return $this->bookingRepository->getAgentStats($agentId, $month);
    }
}
