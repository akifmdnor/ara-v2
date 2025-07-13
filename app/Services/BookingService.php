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
}
