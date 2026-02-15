<?php

namespace App\Services;

use App\Models\CarModel;
use App\Models\ModelSpecification;
use App\Models\AddOnCars;
use Illuminate\Http\Request;

class BookingCalculationService
{
    protected $priceCalculationService;
    protected $distanceCalculationService;
    protected $dateTimeService;

    public function __construct(
        PriceCalculationService $priceCalculationService,
        DistanceCalculationService $distanceCalculationService,
        DateTimeService $dateTimeService
    ) {
        $this->priceCalculationService = $priceCalculationService;
        $this->distanceCalculationService = $distanceCalculationService;
        $this->dateTimeService = $dateTimeService;
    }

    /**
     * Calculate rental pricing details
     *
     * @param CarModel $carModel
     * @param Request $request
     * @return array
     */
    public function calculateRentalPricing(CarModel $carModel, Request $request): array
    {
        // Calculate rental days and hours
        $pickupDate = str_replace('-', '/', $request->pickup_date) . ' ' . $request->pickup_time;
        $returnDate = str_replace('-', '/', $request->return_date) . ' ' . $request->return_time;
        $rentalDays = $this->dateTimeService->getDays($pickupDate, $returnDate);
        $rentalHours = $this->dateTimeService->getHours($pickupDate, $returnDate);

        // Calculate pricing
        $totalPrice = $this->priceCalculationService->calculateCarModelPrice($carModel, $pickupDate, $returnDate);
        $pricePerDay = $rentalDays > 0 ? $totalPrice / $rentalDays : 0;

        return [
            'totalPrice' => $totalPrice,
            'pricePerDay' => $pricePerDay,
            'rentalDays' => $rentalDays,
            'rentalHours' => $rentalHours,
            'pickupDate' => $pickupDate,
            'returnDate' => $returnDate,
        ];
    }

    /**
     * Calculate delivery charges
     *
     * @param CarModel $carModel
     * @param Request $request
     * @return array
     */
    public function calculateDeliveryCharges(CarModel $carModel, Request $request): array
    {
        $pricePerKm = $carModel->branch->price_per_km ?? 1.80;

        // Calculate pickup distance and charge
        $pickupDistance = $this->distanceCalculationService->calculateBranchDistance(
            $carModel->branch_id,
            $request->pickup_latitude,
            $request->pickup_longitude,
            $request->pickup_location
        );
        $pickupCharge = $this->distanceCalculationService->calculateDistanceCharge(
            $pickupDistance,
            $pricePerKm
        );

        // Calculate return distance and charge
        $returnDistance = $this->distanceCalculationService->calculateBranchDistance(
            $carModel->branch_id,
            $request->return_latitude,
            $request->return_longitude,
            $request->return_location
        );
        $returnCharge = $this->distanceCalculationService->calculateDistanceCharge(
            $returnDistance,
            $pricePerKm
        );

        return [
            'pickupDistance' => $pickupDistance,
            'pickupCharge' => $pickupCharge,
            'returnDistance' => $returnDistance,
            'returnCharge' => $returnCharge,
            'doorToDoorTotal' => $pickupCharge + $returnCharge,
            'pricePerKm' => $pricePerKm,
        ];
    }

    /**
     * Calculate addon total
     *
     * @param CarModel $carModel
     * @param Request $request
     * @return float
     */
    public function calculateAddonTotal(CarModel $carModel, Request $request): float
    {
        $addonTotal = 0;

        if ($request->has('addons') && is_array($request->addons)) {
            foreach ($request->addons as $addonId => $quantity) {
                if ($quantity > 0) {
                    $addonCar = AddOnCars::where('car_model_id', $carModel->id)
                        ->where('addon_id', $addonId)
                        ->first();

                    if ($addonCar) {
                        $addonTotal += $addonCar->addon_price * $quantity;
                    }
                }
            }
        }

        return $addonTotal;
    }

    /**
     * Calculate total amounts for booking
     *
     * @param array $pricing
     * @param array $delivery
     * @param float $addonTotal
     * @return array
     */
    public function calculateTotalAmounts(array $pricing, array $delivery, float $addonTotal): array
    {
        $subtotal = $pricing['totalPrice'] + $delivery['doorToDoorTotal'] + $addonTotal;
        $taxAmount = $subtotal * 0.06; // 6% SST
        $grandTotal = $subtotal + $taxAmount;

        return [
            'subtotal' => $subtotal,
            'taxAmount' => $taxAmount,
            'grandTotal' => $grandTotal,
            'totalAddon' => $addonTotal,
            'totalAddonBranchOnly' => 0, // Can be extended if needed
        ];
    }

    /**
     * Build car details array for views
     *
     * @param mixed $booking
     * @return array
     */
    public function buildCarDetails($booking): array
    {
        $modelSpec = $booking->car_model->model_specification;

        // Get car image
        $firstPicture = $booking->car_model->pictures->first();
        $carImage = $firstPicture
            ? asset('storage/' . str_replace('public/', '', $firstPicture->file_name))
            : asset('images/ara-logo.png');

        return [
            'id' => $booking->car_model->id,
            'name' => $modelSpec->brand . ' ' . $modelSpec->model_name . ' ' . $modelSpec->model_code,
            'brand_logo' => $modelSpec->brand_logo ? \App\Services\StorageHelper::v1Url($modelSpec->brand_logo) : asset('images/ara-logo.png'),
            'image' => $carImage,
            'pickup_location' => $booking->pickup_location,
            'return_location' => $booking->dropoff_location,
            'pickup_date' => \Carbon\Carbon::parse($booking->pickup_datetime)->format('d-m-Y, g:i A'),
            'return_date' => \Carbon\Carbon::parse($booking->dropoff_datetime)->format('d-m-Y, g:i A'),
            'rental_days' => $booking->duration_days,
            'rental_price' => $booking->amount_rent,
            'door_to_door_delivery' => $booking->amount_delivery,
            'door_to_door_pickup' => $booking->amount_dropoff,
            'discount' => 0.00,
            'tax_amount' => $booking->amount_sst,
            'security_deposit' => $booking->amount_secd,
            'is_promo' => $booking->car_model->is_promo ?? false,
            'promo_percentage' => 0,
            // Additional fields for sidebar
            'pickup_time' => \Carbon\Carbon::parse($booking->pickup_datetime)->format('g:i A'),
            'return_time' => \Carbon\Carbon::parse($booking->dropoff_datetime)->format('g:i A'),
            'group' => $modelSpec->group ?? 'A',
            'category' => $booking->car_model->category ?? 'Compact',
        ];
    }

    /**
     * Build addons array for views
     *
     * @param mixed $booking
     * @return array
     */
    public function buildAddonsArray($booking): array
    {
        $addons = [];

        if ($booking->addonbookings) {
            foreach ($booking->addonbookings as $addonBooking) {
                $addons[] = [
                    'id' => $addonBooking->addon->id ?? 0,
                    'name' => $addonBooking->addon->name ?? 'Addon',
                    'price' => $addonBooking->addon->price ?? 0,
                    'unit' => $addonBooking->addon->unit ?? 'pcs',
                    'quantity' => $addonBooking->amount ?? 1,
                    'total_price' => ($addonBooking->addon->price ?? 0) * ($addonBooking->amount ?? 1) * ($booking->duration_days ?? 1),
                ];
            }
        }

        return $addons;
    }

    /**
     * Calculate remaining payment amounts for second payment
     *
     * @param \App\Models\Booking $booking
     * @return array
     */
    public function calculateRemainingPayment($booking): array
    {
        $totalAmount = $booking->amount;
        $amountPaid = $booking->amount_paid;
        $remainingAmount = $totalAmount - $amountPaid;

        return [
            'totalAmount' => $totalAmount,
            'amountPaid' => $amountPaid,
            'remainingAmount' => $remainingAmount,
        ];
    }

    /**
     * Determine which booking view to show based on payment status
     *
     * @param \App\Models\Booking $booking
     * @return string
     */
    public function getBookingView($booking): string
    {
        return $booking->payment_status === 'Partial'
            ? 'web.booking.second-payment'
            : 'web.booking.index';
    }
}