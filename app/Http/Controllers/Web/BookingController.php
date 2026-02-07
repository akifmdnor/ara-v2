<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Services\CarListingService;
use App\Services\DistanceCalculationService;
use App\Services\PriceCalculationService;
use App\Services\DateTimeService;
use App\Models\CarModel as CarModelModel;
use App\Models\ModelSpecification;
use App\Models\AddOnCars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected $bookingService;
    protected $carListingService;
    protected $distanceCalculationService;
    protected $priceCalculationService;
    protected $dateTimeService;

    public function __construct(
        BookingService $bookingService,
        CarListingService $carListingService,
        DistanceCalculationService $distanceCalculationService,
        PriceCalculationService $priceCalculationService,
        DateTimeService $dateTimeService
    ) {
        $this->bookingService = $bookingService;
        $this->carListingService = $carListingService;
        $this->distanceCalculationService = $distanceCalculationService;
        $this->priceCalculationService = $priceCalculationService;
        $this->dateTimeService = $dateTimeService;
    }

    /**
     * Create booking from customer info and redirect to payment page
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createBooking(Request $request)
    {
        try {
            // Get car model
            $carModel = CarModelModel::with(['branch', 'pictures'])->findOrFail($request->car_model_id);
            $modelSpec = ModelSpecification::findOrFail($request->model_spec_id);

            // Calculate rental days and hours
            $pickupDate = str_replace('-', '/', $request->pickup_date) . ' ' . $request->pickup_time;
            $returnDate = str_replace('-', '/', $request->return_date) . ' ' . $request->return_time;
            $rentalDays = $this->dateTimeService->getDays($pickupDate, $returnDate);
            $rentalHours = $this->dateTimeService->getHours($pickupDate, $returnDate);

            // Calculate pricing
            $totalPrice = $this->priceCalculationService->calculateCarModelPrice($carModel, $pickupDate, $returnDate);
            $pricePerDay = $rentalDays > 0 ? $totalPrice / $rentalDays : 0;

            // Get price per km from branch
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

            // Calculate addon total
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

            // Calculate total amounts
            $doorToDoorTotal = $pickupCharge + $returnCharge;
            $grandTotal = $totalPrice + $doorToDoorTotal + $addonTotal;

            $amount = [
                'totalAddon' => $addonTotal,
                'totalAddonBranchOnly' => 0,
                'subtotal' => $grandTotal,
                'sst' => 0,
                'total' => $grandTotal,
            ];

            // Get or create user
            $user = $this->getOrCreateUser([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->country_code . $request->phone,
                'country' => $request->country,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
            ]);

            // Create booking using service - with PENDING PAYMENT status
            $booking = $this->bookingService->createWebBooking(
                $carModel,
                $request,
                $amount,
                $user,
                $rentalDays,
                $rentalHours,
                $pickupDistance,
                $returnDistance,
                $pickupCharge,
                $returnCharge,
                $pricePerDay,
                $totalPrice
            );

            // Redirect to payment page with booking ID
            return redirect()->route('web.booking.index', ['booking' => $booking->id])
                ->with('success', 'Booking created. Please complete payment.');

        } catch (\Exception $e) {
            Log::error('Booking creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create booking: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show the payment page for existing booking
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get booking by ID
        $bookingId = $request->booking;
        $booking = \App\Models\Booking::with(['car_model.pictures', 'car_model.model_specification', 'addonbookings.addon'])
            ->findOrFail($bookingId);

        $modelSpec = $booking->car_model->model_specification;

        // Build car details array from booking
        $carDetails = [
            'id' => $booking->car_model->id,
            'name' => $modelSpec->brand . ' ' . $modelSpec->model_name . ' ' . $modelSpec->model_code,
            'brand_logo' => $modelSpec->brand_logo ? \App\Services\StorageHelper::v1Url($modelSpec->brand_logo) : asset('images/ara-logo.png'),
            'image' => ($booking->car_model->pictures && count($booking->car_model->pictures) > 0)
                ? \App\Services\StorageHelper::v1Url($booking->car_model->pictures[0]->file_name)
                : asset('images/ara-logo.png'),
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
        ];

        // Get addons from booking
        $addons = [];
        foreach ($booking->addonbookings as $addonBooking) {
            $addons[] = [
                'name' => $addonBooking->addon->title,
                'quantity' => $addonBooking->amount,
                'price' => $addonBooking->amount,
                'total_price' => $addonBooking->amount,
            ];
        }

        $totalAmount = $booking->amount;

        return view('web.booking.index', compact('carDetails', 'addons', 'totalAmount', 'booking'));
    }

    /**
     * Update booking payment method and redirect to confirmation
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate payment form
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|in:online,counter',
            'agree_terms' => 'required|accepted',
        ]);

        try {
            // Get booking
            $booking = \App\Models\Booking::findOrFail($request->booking_id);

            // Update payment method
            $booking->payment_method = $request->payment_method;

            // If counter payment, keep as pending
            // If online payment, TODO: redirect to payment gateway
            if ($request->payment_method === 'counter') {
                $booking->payment_status = 'Pending';
            }

            $booking->save();

            // Redirect based on payment method
            if ($request->payment_method === 'online') {
                // TODO: Redirect to payment gateway
                return redirect()->route('web.booking.confirmation', ['booking' => $booking->id])
                    ->with('success', 'Redirecting to payment gateway...');
            } else {
                // Counter payment - show confirmation
                return redirect()->route('web.booking.confirmation', ['booking' => $booking->id])
                    ->with('success', 'Booking created successfully. Please pay at the counter.');
            }
        } catch (\Exception $e) {
            Log::error('Booking payment update failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update booking: ' . $e->getMessage()]);
        }
    }

    /**
     * Calculate total amounts
     *
     * @param array $carDetails
     * @param array $addons
     * @return array
     */
    private function calculateAmounts(array $carDetails, array $addons): array
    {
        $totalAddon = 0;
        $totalAddonBranchOnly = 0;

        foreach ($addons as $addon) {
            $totalAddon += $addon['total_price'] ?? 0;
            if ($addon['branch_only'] ?? false) {
                $totalAddonBranchOnly += $addon['total_price'] ?? 0;
            }
        }

        $subtotal = ($carDetails['total_price'] ?? 0) + $totalAddon;
        $sst = 0; // Calculate SST if applicable
        $total = $subtotal + $sst;

        return [
            'totalAddon' => $totalAddon,
            'totalAddonBranchOnly' => $totalAddonBranchOnly,
            'subtotal' => $subtotal,
            'sst' => $sst,
            'total' => $total,
        ];
    }

    /**
     * Calculate total for display
     *
     * @param array $carDetails
     * @param array $addons
     * @return float
     */
    private function calculateTotal(array $carDetails, array $addons): float
    {
        $amounts = $this->calculateAmounts($carDetails, $addons);
        return $amounts['total'];
    }

    /**
     * Get or create user from customer info
     *
     * @param array $customerInfo
     * @return \App\Models\User
     */
    private function getOrCreateUser(array $customerInfo)
    {
        $user = \App\Models\User::where('email', $customerInfo['email'])->first();

        if (!$user) {
            $user = \App\Models\User::create([
                'name' => $customerInfo['name'],
                'email' => $customerInfo['email'],
                'phone' => $customerInfo['phone'],
                'country' => $customerInfo['country'] ?? null,
                'address' => $customerInfo['address'] ?? null,
                'city' => $customerInfo['city'] ?? null,
                'state' => $customerInfo['state'] ?? null,
                'postal_code' => $customerInfo['postal_code'] ?? null,
            ]);
        }

        return $user;
    }

    /**
     * Show booking confirmation
     *
     * @param int $bookingId
     * @return \Illuminate\View\View
     */
    public function confirmation($bookingId)
    {
        $booking = \App\Models\Booking::with(['car_model', 'branch', 'user', 'addonbookings'])
            ->findOrFail($bookingId);

        return view('web.booking.confirmation', compact('booking'));
    }
}
