<?php

namespace App\Services;

use App\Repositories\BookingRepository;

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
     */
    public function getAgentBookingsApi($agentId, $perPage = 10, $sort = 'created_at', $direction = 'desc', $filters = [])
    {
        return $this->bookingRepository->getAgentBookingsApi($agentId, $perPage, $sort, $direction, $filters);
    }

    /**
     * Get statistics for agent based on selected month period
     */
    public function getAgentStats($agentId, $month = 'all')
    {
        return $this->bookingRepository->getAgentStats($agentId, $month);
    }
}
