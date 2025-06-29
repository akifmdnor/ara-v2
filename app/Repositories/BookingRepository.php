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
            ->orderByDesc('created_at')
            ->get();
    }
}
