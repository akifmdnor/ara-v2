<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Services\CarListingService;
use App\Services\PaymentService;
use App\Services\NotificationService;
use App\Services\BookingCalculationService;
use App\Repositories\BookingRepository;
use App\Models\CarModel as CarModelModel;
use App\Models\ModelSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected $bookingService;
    protected $carListingService;
    protected $paymentService;
    protected $notificationService;
    protected $calculationService;
    protected $bookingRepository;

    public function __construct(
        BookingService $bookingService,
        CarListingService $carListingService,
        PaymentService $paymentService,
        NotificationService $notificationService,
        BookingCalculationService $calculationService,
        BookingRepository $bookingRepository
    ) {
        $this->bookingService = $bookingService;
        $this->carListingService = $carListingService;
        $this->paymentService = $paymentService;
        $this->notificationService = $notificationService;
        $this->calculationService = $calculationService;
        $this->bookingRepository = $bookingRepository;
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

            // Calculate all pricing components
            $pricing = $this->calculationService->calculateRentalPricing($carModel, $request);
            $delivery = $this->calculationService->calculateDeliveryCharges($carModel, $request);
            $addonTotal = $this->calculationService->calculateAddonTotal($carModel, $request);
            $amounts = $this->calculationService->calculateTotalAmounts($pricing, $delivery, $addonTotal);

            // Debug logging
            \Log::info('Booking calculation results', [
                'pricing' => $pricing,
                'delivery' => $delivery,
                'addonTotal' => $addonTotal,
                'amounts' => $amounts,
            ]);

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

            // Create booking using service
            $booking = $this->bookingService->createWebBooking(
                $carModel,
                $request,
                $amounts,
                $user,
                $pricing['rentalDays'],
                $pricing['rentalHours'],
                $delivery['pickupDistance'],
                $delivery['returnDistance'],
                $delivery['pickupCharge'],
                $delivery['returnCharge'],
                $pricing['pricePerDay'],
                $pricing['totalPrice']
            );

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
    public function index($bookingId)
    {
        $booking = $this->bookingRepository->findWithDetails($bookingId);

        // If payment is already partial or paid, redirect to success page
        if ($booking->payment_status === 'Partial' || $booking->payment_status === 'Paid') {
            return redirect()->route('web.booking.success', ['booking' => $booking->id]);
        }

        // If pending payment, show the first payment page
        $carDetails = $this->calculationService->buildCarDetails($booking);
        $addons = $this->calculationService->buildAddonsArray($booking);
        $totalAmount = $booking->amount;

        return view('web.booking.index', compact('carDetails', 'addons', 'totalAmount', 'booking'));
    }

    /**
     * Show second payment page
     *
     * @param int $bookingId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function secondPayment($bookingId)
    {
        $booking = $this->bookingRepository->findWithDetails($bookingId);

        // Only show second payment if deposit is paid
        if ($booking->payment_status !== 'Partial') {
            return redirect()->route('web.booking.index', ['booking' => $booking->id]);
        }

        $carDetails = $this->calculationService->buildCarDetails($booking);
        $addons = $this->calculationService->buildAddonsArray($booking);

        $paymentAmounts = $this->calculationService->calculateRemainingPayment($booking);
        $viewData = array_merge(compact('carDetails', 'addons', 'booking'), $paymentAmounts);

        return view('web.booking.second-payment', $viewData);
    }

    /**
     * Update booking payment method and redirect to confirmation
     * NOTE: This method is currently unused in the embedded payment flow.
     * Payment processing happens directly via the payment buttons.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // This method is not used in the current embedded payment implementation
        // Payment processing happens directly when users click payment buttons
        return redirect()->route('web.booking.index', ['booking' => $request->booking_id ?? null])
            ->with('info', 'Please select a payment method to complete your booking.');
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

    /**
     * Display payment success page
     *
     * @param int $bookingId
     * @return \Illuminate\View\View
     */
    public function success(Request $request, $bookingId)
    {
        $booking = \App\Models\Booking::with([
            'car_model.model_specification',
            'car_model.pictures',
            'branch',
            'user',
            'addonbookings.addon'
        ])->findOrFail($bookingId);

        // Check if this is a redirect from Stripe payment (like completed method)
        $redirectStatus = $request->get('redirect_status');
        $paymentIntentId = $request->get('payment_intent');

        if ($redirectStatus === 'succeeded' && $paymentIntentId) {
            // Handle Stripe redirect-based confirmation
            $payment_status_before = $booking->payment_status;

            // Determine if this is a second payment
            $isSecondPayment = $booking->payment_status === 'Partial';
            $amount = $isSecondPayment
                ? ($booking->amount - $booking->amount_paid)
                : $booking->amount_secd;

            $booking->amount_paid += $amount;
            $booking->payment_status = $isSecondPayment ? 'Paid' : 'Partial';
            $booking->save();

            \Log::info("Stripe redirect payment processed (success page)", [
                'booking_id' => $bookingId,
                'payment_intent' => $paymentIntentId,
                'amount' => $amount,
                'new_status' => $booking->payment_status,
                'is_second_payment' => $isSecondPayment,
            ]);

            // Send confirmation emails
            if (!$isSecondPayment) {
                $this->notificationService->sendDepositConfirmationEmails($booking, $amount);
            } else {
                $this->notificationService->sendFullPaymentConfirmationEmails($booking);
            }
        }


        // Prepare car details
        $firstPicture = $booking->car_model->pictures->first();
        $carImage = $firstPicture ? asset('storage/' . str_replace('public/', '', $firstPicture->file_name)) : asset('images/ara-logo.png');

        $carDetails = [
            'name' => $booking->car_model->model_specification->model_name ?? 'Car',
            'brand_logo' => $booking->car_model->model_specification->brand_logo ?? null,
            'brand' => $booking->car_model->model_specification->brand ?? 'Brand',
            'price_per_day' => $booking->amount_rent_per_day ?? 0,
            'duration' => $booking->duration_days ?? 1,
            'total_price' => $booking->amount_rent ?? 0,
            'security_deposit' => $booking->amount_secd ?? 0,
            'image' => $carImage,
            'transmission' => $booking->car_model->model_specification->transmission_type ?? 'Manual',
            'fuel' => $booking->car_model->model_specification->fuel_type ?? 'Petrol',
            'seats' => $booking->car_model->model_specification->seats ?? 5,
            'luggage' => $booking->car_model->model_specification->luggage ?? 2,
            'doors' => $booking->car_model->model_specification->doors ?? 4,
            'is_promo' => $booking->car_model->is_promo ?? false,
            'discount' => 0,
            'promo_percentage' => 0,
            // Additional fields for sidebar
            'rental_price' => $booking->amount_rent ?? 0,
            'rental_days' => $booking->duration_days ?? 1,
            'door_to_door_delivery' => $booking->amount_delivery ?? 0,
            'door_to_door_pickup' => $booking->amount_dropoff ?? 0,
            'pickup_location' => $booking->pickup_location ?? 'Location',
            'return_location' => $booking->dropoff_location ?? 'Location',
            'pickup_date' => $booking->pickup_datetime ? \Carbon\Carbon::parse($booking->pickup_datetime)->format('d-m-Y, g:i A') : now()->format('d-m-Y, g:i A'),
            'pickup_time' => $booking->pickup_datetime ? \Carbon\Carbon::parse($booking->pickup_datetime)->format('g:i A') : '9:00 AM',
            'return_date' => $booking->dropoff_datetime ? \Carbon\Carbon::parse($booking->dropoff_datetime)->format('d-m-Y, g:i A') : now()->addDays(1)->format('d-m-Y, g:i A'),
            'return_time' => $booking->dropoff_datetime ? \Carbon\Carbon::parse($booking->dropoff_datetime)->format('g:i A') : '9:00 AM',
            'group' => $booking->car_model->model_specification->group ?? 'A',
            'category' => $booking->car_model->category ?? 'Compact',
            'tax_amount' => $booking->amount_sst ?? 0,
        ];

        // Calculate discount if promo
        if ($carDetails['is_promo']) {
            $carDetails['promo_percentage'] = $booking->car_model->promo_percentage ?? 10;
            $originalPrice = $carDetails['total_price'] / (1 - ($carDetails['promo_percentage'] / 100));
            $carDetails['discount'] = $originalPrice - $carDetails['total_price'];
        }

        // Prepare addons
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

        // Calculate subtotal (before SST and security deposit)
        $subtotal = $booking->amount_rent + $booking->amount_delivery + $booking->amount_dropoff + $booking->amount_addon - ($carDetails['discount'] ?? 0);

        // Determine payment display based on booking status
        $paymentDisplay = [];
        if ($booking->payment_status === 'Partial') {
            // Deposit paid, show remaining balance
            $paymentDisplay = [
                'amountPaid' => $booking->amount_paid,
                'remainingBalance' => $booking->amount - $booking->amount_paid,
                'showRemaining' => true,
            ];
        } elseif ($booking->payment_status === 'Paid') {
            // Full payment completed
            $paymentDisplay = [
                'amountPaid' => $booking->amount_paid,
                'remainingBalance' => 0,
                'showRemaining' => false,
            ];
        }

        return view('web.booking.success', compact('booking', 'carDetails', 'addons', 'subtotal', 'paymentDisplay'));
    }

    /**
     * Display payment failed page
     *
     * @param int $bookingId
     * @return \Illuminate\View\View
     */
    public function failed($bookingId)
    {
        $booking = \App\Models\Booking::with([
            'car_model.model_specification',
            'car_model.pictures',
            'branch',
            'user',
            'addonbookings.addon'
        ])->findOrFail($bookingId);

        // Prepare car details
        $firstPicture = $booking->car_model->pictures->first();
        $carImage = $firstPicture ? asset('storage/' . str_replace('public/', '', $firstPicture->file_name)) : asset('images/ara-logo.png');

        $carDetails = [
            'name' => $booking->car_model->model_specification->model_name ?? 'Car',
            'brand_logo' => $booking->car_model->model_specification->brand_logo ?? null,
            'brand' => $booking->car_model->model_specification->brand ?? 'Brand',
            'price_per_day' => $booking->amount_rent_per_day ?? 0,
            'duration' => $booking->duration_days ?? 1,
            'total_price' => $booking->amount_rent ?? 0,
            'security_deposit' => $booking->amount_secd ?? 0,
            'image' => $carImage,
            'transmission' => $booking->car_model->model_specification->transmission_type ?? 'Manual',
            'fuel' => $booking->car_model->model_specification->fuel_type ?? 'Petrol',
            'seats' => $booking->car_model->model_specification->seats ?? 5,
            'luggage' => $booking->car_model->model_specification->luggage ?? 2,
            'doors' => $booking->car_model->model_specification->doors ?? 4,
            'is_promo' => $booking->car_model->is_promo ?? false,
            'discount' => 0,
            'promo_percentage' => 0,
            // Additional fields for sidebar
            'rental_price' => $booking->amount_rent ?? 0,
            'rental_days' => $booking->duration_days ?? 1,
            'door_to_door_delivery' => $booking->amount_delivery ?? 0,
            'door_to_door_pickup' => $booking->amount_dropoff ?? 0,
            'pickup_location' => $booking->pickup_location ?? 'Location',
            'return_location' => $booking->dropoff_location ?? 'Location',
            'pickup_date' => $booking->pickup_datetime ? \Carbon\Carbon::parse($booking->pickup_datetime)->format('d-m-Y, g:i A') : now()->format('d-m-Y, g:i A'),
            'pickup_time' => $booking->pickup_datetime ? \Carbon\Carbon::parse($booking->pickup_datetime)->format('g:i A') : '9:00 AM',
            'return_date' => $booking->dropoff_datetime ? \Carbon\Carbon::parse($booking->dropoff_datetime)->format('d-m-Y, g:i A') : now()->addDays(1)->format('d-m-Y, g:i A'),
            'return_time' => $booking->dropoff_datetime ? \Carbon\Carbon::parse($booking->dropoff_datetime)->format('g:i A') : '9:00 AM',
            'group' => $booking->car_model->model_specification->group ?? 'A',
            'category' => $booking->car_model->category ?? 'Compact',
            'tax_amount' => $booking->amount_sst ?? 0,
        ];

        // Calculate discount if promo
        if ($carDetails['is_promo']) {
            $carDetails['promo_percentage'] = $booking->car_model->promo_percentage ?? 10;
            $originalPrice = $carDetails['total_price'] / (1 - ($carDetails['promo_percentage'] / 100));
            $carDetails['discount'] = $originalPrice - $carDetails['total_price'];
        }

        // Prepare addons
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

        // Calculate subtotal (before SST and security deposit)
        $subtotal = $booking->amount_rent + $booking->amount_delivery + $booking->amount_dropoff + $booking->amount_addon - ($carDetails['discount'] ?? 0);

        return view('web.booking.failed', compact('booking', 'carDetails', 'addons', 'subtotal'));
    }


    /**
     * Process Stripe payment
     *
     * @param int $bookingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function stripeProcess($bookingId)
    {
        // This route is now handled via AJAX in the booking index view
        // Return the booking data for potential future use
        $booking = $this->bookingRepository->findWithDetails($bookingId);

        return response()->json([
            'booking_id' => $booking->id,
            'amount' => $booking->amount_secd,
        ]);
    }

    /**
     * Process Stripe payment intent creation
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processStripePayment(Request $request)
    {
        try {
            $bookingId = $request->items[0]['id'];
            $booking = $this->bookingRepository->find($bookingId);

            $result = $this->paymentService->processStripePayment($booking);

            return response()->json(['clientSecret' => $result['client_secret']]);

        } catch (\Exception $e) {
            Log::error('Stripe payment intent creation failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Process Billplz payment
     *
     * @param int $bookingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function billplzProcess($bookingId)
    {
        try {
            $booking = $this->bookingRepository->find($bookingId);
            $url = $this->paymentService->processBillplzPayment($booking);

            return redirect($url);

        } catch (\Exception $e) {
            Log::error('Billplz payment failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Payment processing failed. Please try again.']);
        }
    }

    /**
     * Handle Stripe payment return after payment attempt
     *
     * @param Request $request
     * @param int $bookingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stripeReturn(Request $request, $bookingId)
    {
        try {
            $booking = $this->bookingRepository->findWithDetails($bookingId);
            
            // Get payment intent from Stripe
            $paymentIntentId = $request->input('payment_intent');
            
            if (!$paymentIntentId) {
                Log::warning('No payment intent ID provided for booking ' . $bookingId);
                return redirect()->route('web.booking.failed', ['booking' => $bookingId]);
            }
            
            // Retrieve payment intent status from Stripe
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId);
            
            // Check if payment succeeded
            if ($paymentIntent->status === 'succeeded') {
                Log::info('Stripe payment succeeded for booking ' . $bookingId);
                return redirect()->route('web.booking.success', ['booking' => $bookingId]);
            } else {
                Log::info('Stripe payment failed with status: ' . $paymentIntent->status . ' for booking ' . $bookingId);
                return redirect()->route('web.booking.failed', ['booking' => $bookingId]);
            }
            
        } catch (\Exception $e) {
            Log::error('Error processing Stripe return: ' . $e->getMessage());
            return redirect()->route('web.booking.failed', ['booking' => $bookingId]);
        }
    }

    /**
     * Handle Billplz payment success redirect
     *
     * @param Request $request
     * @param int $bookingId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function billplzSuccess(Request $request, $bookingId)
    {
        $booking = $this->bookingRepository->findWithDetails($bookingId);
        
        // Check if payment was successful from Billplz response
        $billplzPaid = $request->input('billplz.paid', 'false');
        $isPaid = $billplzPaid === 'true' || $billplzPaid === true;
        
        // If payment failed, redirect to failed page
        if (!$isPaid) {
            Log::info('Billplz payment failed for booking ' . $bookingId);
            return redirect()->route('web.booking.failed', ['booking' => $bookingId]);
        }
        
        // Check booking payment status
        $success = $booking->payment_status === 'Partial' || $booking->payment_status === 'Paid';
        
        // If booking status indicates failure, redirect to failed page
        if (!$success) {
            Log::info('Booking payment status indicates failure for booking ' . $bookingId);
            return redirect()->route('web.booking.failed', ['booking' => $bookingId]);
        }
        
        $paymentType = $booking->payment_status === 'Paid' ? 'Full' : 'Booking Deposit';
        $carDetails = $this->calculationService->buildCarDetails($booking);

        return view('web.booking.completed', compact('booking', 'carDetails', 'success', 'paymentType'));
    }

    /**
     * Handle Billplz callback for payment confirmation
     *
     * @param Request $request
     * @param string $paymentType
     * @param int $bookingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function billplzCallback(Request $request, string $paymentType, string $bookingId)
    {
        Log::debug('Billplz callback triggered at ' . date("Y-m-d h:i:sa") . '. Request: ' . implode(" ", $request->all()));

        $paymentStatus = [
            'first-payment' => 'Partial',
            'second-payment' => 'Paid'
        ];

        $callbackResult = $this->paymentService->handleBillplzCallback($request->all(), $paymentType, $bookingId);

        if ($callbackResult) {
            // Send appropriate emails
            if ($callbackResult['payment_type'] === 'first-payment') {
                $this->notificationService->sendDepositConfirmationEmails(
                    $callbackResult['booking'],
                    $callbackResult['amount_paid']
                );
            } elseif ($callbackResult['payment_type'] === 'second-payment') {
                $this->notificationService->sendFullPaymentConfirmationEmails(
                    $callbackResult['booking']
                );
            }

            return response()->json([
                [
                    'payment_status' => $callbackResult['booking']->payment_status,
                    'amount' => $request->input('amount'),
                    'booking_id' => $bookingId,
                    'success' => true,
                ]
            ], 200);
        }

        return response()->json([
            'error' => 'Payment update failed',
        ], 500);
    }

    /**
     * Handle Billplz callback (v1 style for compatibility)
     *
     * @param Request $request
     * @param int $bookingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function billplzCallbackV1(Request $request, int $bookingId)
    {
        Log::debug('Billplz callback v1 triggered at ' . date("Y-m-d h:i:sa") . '. Request: ' . implode(" ", $request->all()));

        // Determine payment type from the route
        $routeName = request()->route()->getName();
        $paymentType = str_contains($routeName, 'second-payment') ? 'second-payment' : 'first-payment';

        $callbackResult = $this->paymentService->handleBillplzCallback($request->all(), $paymentType, $bookingId);

        if ($callbackResult) {
            // Send appropriate confirmation emails
            if ($paymentType === 'first-payment') {
                $this->notificationService->sendDepositConfirmationEmails(
                    $callbackResult['booking'],
                    $callbackResult['amount_paid']
                );
            } else {
                // Send full payment confirmation emails
                $this->notificationService->sendFullPaymentConfirmationEmails(
                    $callbackResult['booking']
                );
            }

            return response()->json([
                [
                    'payment_status' => $callbackResult['booking']->payment_status,
                    'amount' => $request->input('amount'),
                    'booking_id' => $bookingId,
                    'success' => true,
                ]
            ], 200);
        }

        return response()->json([
            'error' => 'Payment update failed',
        ], 500);
    }

    /**
     * Handle booking completed page (alias for success)
     *
     * @param int $bookingId
     * @return \Illuminate\View\View
     */

    /**
     * Handle Stripe webhook for payment confirmation
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stripeWebhook(Request $request)
    {
        // Debug logging
        Log::info('Stripe webhook received', [
            'headers' => $request->headers->all(),
            'content_length' => strlen($request->getContent()),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            $webhookResult = $this->paymentService->handleStripeWebhook(
                $request->getContent(),
                $request->header('stripe-signature')
            );

            if ($webhookResult) {
                Log::info('Stripe webhook processed successfully', [
                    'booking_id' => $webhookResult['booking']->id,
                    'payment_status' => $webhookResult['booking']->payment_status,
                    'amount_paid' => $webhookResult['booking']->amount_paid,
                ]);

                // Send deposit confirmation emails
                $this->notificationService->sendDepositConfirmationEmails(
                    $webhookResult['booking'],
                    $webhookResult['amount_paid']
                );
            }

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::error('Stripe webhook failed: ' . $e->getMessage(), [
                'request_content' => $request->getContent(),
                'signature' => $request->header('stripe-signature'),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }
}
