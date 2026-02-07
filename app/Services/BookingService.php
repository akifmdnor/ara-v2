<?php

namespace App\Services;

use App\Repositories\BookingRepository;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Create a new booking from web request
     *
     * @param $carModel
     * @param $request
     * @param array $amount
     * @param $user
     * @return \App\Models\Booking
     */
    public function createWebBooking($carModel, $request, array $amount, $user, $rentalDays = 0, $rentalHours = 0, $pickupDistance = 0, $returnDistance = 0, $pickupCharge = 0, $returnCharge = 0, $pricePerDay = 0, $totalPrice = 0)
    {
        // Format pickup and return datetimes
        $pickupDatetime = $this->formatDatetime($request->pickup_date, $request->pickup_time);
        $dropoffDatetime = $this->formatDatetime($request->return_date, $request->return_time);

        // Prepare booking data
        $bookingData = [
            'car_model_id' => $carModel->id,
            'branch_id' => $carModel->branch->id,
            'pickup_datetime' => $pickupDatetime,
            'dropoff_datetime' => $dropoffDatetime,
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->return_location,
            'user_id' => $user->id,
            'duration_days' => $rentalDays,
            'duration_hours' => $rentalHours,
            'amount' => $amount['total'],
            'notes' => $request->notes,
            'driver_IC' => $request->get('driver_id_number'),
            'driver_name' => $request->get('name'),
            'driver_mobile_number' => $request->get('country_code') . $request->get('phone'),
            'driver_age' => $request->get('age'),
            'pickup_latitude' => $request->get('pickup_latitude'),
            'pickup_longitude' => $request->get('pickup_longitude'),
            'dropoff_latitude' => $request->get('return_latitude'),
            'dropoff_longitude' => $request->get('return_longitude'),
            'pickup_distance' => $pickupDistance,
            'dropoff_distance' => $returnDistance,
            'amount_distance' => $pickupCharge + $returnCharge,
            'amount_dropoff' => $returnCharge,
            'amount_delivery' => $pickupCharge,
            'amount_addon' => $amount['totalAddon'] ?? 0,
            'amount_addon_branch' => $amount['totalAddonBranchOnly'] ?? 0,
            'amount_rent' => $totalPrice,
            'amount_secd' => $carModel->security_deposit ?? 0,
            'amount_rent_per_day' => $pricePerDay,
            'duration_days_real' => $rentalDays,
            'duration_hours_real' => $rentalHours,
            'amount_sst' => $amount['sst'] ?? 0,
            'booking_status' => 'Pending',
            'payment_status' => 'Pending',
        ];

        // Create booking
        $booking = $this->bookingRepository->createBooking($bookingData);

        // Handle IC/Passport images
        if ($request->hasFile('ic_passport')) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            foreach ($request->file('ic_passport') as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                if (in_array($extension, $allowedExtensions)) {
                    $filename = $file->store('public');
                    $this->bookingRepository->savePicture($booking->id, $filename);
                }
            }
        }

        // Handle License images
        if ($request->hasFile('license')) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            foreach ($request->file('license') as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                if (in_array($extension, $allowedExtensions)) {
                    $filename = $file->store('public');
                    $this->bookingRepository->savePicture($booking->id, $filename);
                }
            }
        }

        // Save addons if any
        if ($request->has('addons') && is_array($request->addons)) {
            $this->bookingRepository->saveAddons($booking->id, $request->addons);
        }

        return $booking;
    }

    /**
     * Validate if file is a valid image
     *
     * @param $file
     * @return bool
     */
    private function isValidImage($file): bool
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        $extension = strtolower($file->getClientOriginalExtension());
        return in_array($extension, $allowedExtensions);
    }

    /**
     * Format date and time to datetime string
     *
     * @param string $date Format: d-m-Y (e.g., 23-01-2026)
     * @param string $time Format: h:i A (e.g., 5:30 PM)
     * @return string Format: Y-m-d H:i:s
     */
    private function formatDatetime($date, $time): string
    {
        // Convert date from d-m-Y to d/m/Y format
        $dateFormatted = str_replace('-', '/', $date);

        // Combine date and time
        $datetime = \DateTime::createFromFormat('d/m/Y g:i A', $dateFormatted . ' ' . $time);

        // Return in Y-m-d H:i:s format
        return $datetime ? $datetime->format('Y-m-d H:i:s') : '';
    }
}
