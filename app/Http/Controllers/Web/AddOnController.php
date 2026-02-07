<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarModel as CarModelModel;
use App\Models\ModelSpecification;
use App\Models\AddOnCars;
use App\Services\StorageHelper;
use App\Services\DistanceCalculationService;
use App\Services\PriceCalculationService;
use App\Services\DateTimeService;

class AddOnController extends Controller
{
    protected $distanceCalculationService;
    protected $priceCalculationService;
    protected $dateTimeService;

    public function __construct(
        DistanceCalculationService $distanceCalculationService,
        PriceCalculationService $priceCalculationService,
        DateTimeService $dateTimeService
    ) {
        $this->distanceCalculationService = $distanceCalculationService;
        $this->priceCalculationService = $priceCalculationService;
        $this->dateTimeService = $dateTimeService;
    }

    /**
     * Display the add-on selection page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $id = null)
    {
        // Use car_model_id from parameter or request
        $carModelId = $id ?? $request->car_model_id;

        // Validate required parameters
        $request->validate([
            'car_model_id' => 'sometimes|exists:car_models,id',
            'model_spec_id' => 'required|exists:model_specifications,id',
        ]);

        // If car_model_id is not in request but passed as parameter, add it
        if ($id && !$request->has('car_model_id')) {
            $request->merge(['car_model_id' => $id]);
        }

        // Get car model with addons (similar to checkout controller pattern)
        $carModel = CarModelModel::with(['pictures', 'branch', 'addoncars.addon'])->findOrFail($carModelId);
        $modelSpec = ModelSpecification::findOrFail($request->model_spec_id);

        // Get addons for this car model (similar to checkout controller)
        $addoncars = \App\Models\AddOnCars::with('addon.pictures')->where('car_model_id', $carModel->id)->get();

        // Get car image
        $carImageUrl = asset('images/ara-logo.png');
        if ($carModel->pictures && count($carModel->pictures) > 0) {
            $carImageUrl = StorageHelper::v1Url($carModel->pictures[0]->file_name);
        }

        // Get brand logo
        $brandLogoUrl = null;
        if ($modelSpec->brand_logo) {
            $brandLogoUrl = StorageHelper::v1Url($modelSpec->brand_logo);
        }

        // Build car name
        $carName = $modelSpec->brand . ' ' . $modelSpec->model_name . ' ' . $modelSpec->model_code;

        // Calculate rental days and hours
        // Convert date format from d-m-Y to d/m/Y (DateTimeService expects slashes)
        $pickupDate = str_replace('-', '/', $request->pickup_date) . ' ' . $request->pickup_time;
        $returnDate = str_replace('-', '/', $request->return_date) . ' ' . $request->return_time;
        $rentalDays = $this->dateTimeService->getDays($pickupDate, $returnDate);
        $rentalHours = $this->dateTimeService->getHours($pickupDate, $returnDate);

        // Calculate pricing using PriceCalculationService
        $totalPrice = $this->priceCalculationService->calculateCarModelPrice($carModel, $pickupDate, $returnDate);
        $pricePerDay = $rentalDays > 0 ? $totalPrice / $rentalDays : 0;

        // Check if pickup and return dates fall within a promo period
        $isPromo = $this->priceCalculationService->checkIsPickupAndReturnIsPromo($carModel, $pickupDate, $returnDate);
        $normalPricePerDay = $this->priceCalculationService->calculatePrice($carModel, $rentalDays, $rentalHours) / ($rentalDays ?: 1);

        // Calculate promo percentage if applicable
        $promoPercentage = 0;
        if ($isPromo && $normalPricePerDay > $pricePerDay) {
            $promoPercentage = (($normalPricePerDay - $pricePerDay) / $normalPricePerDay) * 100;
        } else {
            $isPromo = false;
        }

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

        // Calculate discount if promo is active
        $discount = 0.00;
        if ($isPromo && $normalPricePerDay > $pricePerDay) {
            $normalTotalPrice = $normalPricePerDay * $rentalDays;
            $discount = $normalTotalPrice - $totalPrice;
        }

        // Calculate total with delivery charges
        $doorToDoorTotal = $pickupCharge + $returnCharge;
        $grandTotal = $totalPrice + $doorToDoorTotal;

        // Calculate tax (6% SST)
        $taxAmount = $grandTotal * 0.06;

        // Get security deposit from car model
        $securityDeposit = $carModel->security_deposit ?? 300.00;

        // Build car details array
        $carDetails = [
            'id' => $carModel->id,
            'name' => $carName,
            'brand_logo' => $brandLogoUrl ?? asset('images/ara-logo.png'),
            'image' => $carImageUrl,
            'group' => $modelSpec->group ?? 'A',
            'category' => $carModel->category ?? 'Compact',
            'pickup_location' => $request->pickup_location,
            'return_location' => $request->return_location,
            'pickup_date' => $request->pickup_date . ', ' . $request->pickup_time,
            'return_date' => $request->return_date . ', ' . $request->return_time,
            'pickup_distance' => $pickupDistance,
            'pickup_charge' => $pickupCharge,
            'return_distance' => $returnDistance,
            'return_charge' => $returnCharge,
            'price_per_km' => $pricePerKm,
            'rental_days' => $rentalDays,
            'rental_price' => $totalPrice,
            'door_to_door_delivery' => $pickupCharge,
            'door_to_door_pickup' => $returnCharge,
            'discount' => $discount,
            'total_price' => $grandTotal,
            'tax_amount' => $taxAmount,
            'security_deposit' => $securityDeposit,
            'is_promo' => $isPromo,
            'promo_percentage' => round($promoPercentage),
        ];

        // Format add-ons for the view (similar processing as checkout controller)
        $addOns = $addoncars->map(function ($addonCar) {
            $addon = $addonCar->addon;

            // Get addon picture
            $pictureUrl = null;
            if ($addon->pictures && count($addon->pictures) > 0) {
                $pictureUrl = StorageHelper::v1Url($addon->pictures[0]->file_name);
            }

            return [
                'id' => $addon->id,
                'name' => $addon->title,
                'description' => $addon->description,
                'price' => $addonCar->addon_price,
                'type' => $addon->type === 'quantity' ? 'quantity' : 'checkbox',
                'icon' => $this->getAddonIcon($addon->title),
                'picture' => $pictureUrl,
            ];
        })->toArray();

        return view('web.addon.index', compact('carDetails', 'addOns'));
    }

    /**
     * Store selected addons and redirect to customer info with URL parameters
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Build URL parameters array with car and location details
        $params = [
            'car_model_id' => $request->car_model_id,
            'model_spec_id' => $request->model_spec_id,
            'pickup_location' => $request->pickup_location,
            'pickup_latitude' => $request->pickup_latitude,
            'pickup_longitude' => $request->pickup_longitude,
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'return_location' => $request->return_location,
            'return_latitude' => $request->return_latitude,
            'return_longitude' => $request->return_longitude,
            'return_date' => $request->return_date,
            'return_time' => $request->return_time,
        ];

        // Add selected addons to URL parameters
        // Expected format: addons[addon_id] = quantity
        if ($request->has('addons') && is_array($request->addons)) {
            foreach ($request->addons as $addonId => $quantity) {
                if ($quantity > 0) {
                    $params["addons[{$addonId}]"] = $quantity;
                }
            }
        }

        // Redirect to customer-info with all parameters
        return redirect()->route('web.customer-info.index', $params);
    }

    /**
     * Get icon name for add-on based on title
     *
     * @param string $title
     * @return string
     */
    private function getAddonIcon($title)
    {
        $iconMap = [
            'Child Seat' => 'child-seat',
            'Baby Seat' => 'baby-seat',
            'Extra Driver' => 'extra-driver',
            'Driver Under 23' => 'driver-under-23',
            'GPS Navigation' => 'gps',
            'Touch & Go Toll Card' => 'touch-go',
            'Smart TAG' => 'smart-tag',
            'Roofbox' => 'roofbox',
            'Collision Damage Waiver (CDW)' => 'cdw',
            'Super Collision Damage Waiver (SCDW)' => 'scdw',
            'Flood coverage' => 'flood',
            'Windshield Protection' => 'windshield',
        ];

        return $iconMap[$title] ?? 'addon'; // Default to 'addon' if not found
    }
}

