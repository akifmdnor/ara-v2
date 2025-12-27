<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CarListingService;
use App\Services\DistanceService;
use Illuminate\Support\Facades\Log;

class CarListingController extends Controller
{
    protected $carListingService;
    protected $distanceService;

    public function __construct(CarListingService $carListingService, DistanceService $distanceService)
    {
        $this->carListingService = $carListingService;
        $this->distanceService = $distanceService;
    }

    public function index(Request $request)
    {
        // Get search parameters
        $searchParams = [
            'pickup_location' => $request->input('pickup_location', ''),
            'return_location' => $request->input('return_location', ''),
            'pickup_latitude' => $request->input('pickup_latitude', ''),
            'pickup_longitude' => $request->input('pickup_longitude', ''),
            'return_latitude' => $request->input('return_latitude', ''),
            'return_longitude' => $request->input('return_longitude', ''),
            'pickup_date' => $request->input('pickup_date', ''),
            'return_date' => $request->input('return_date', ''),
            'pickup_time' => $request->input('pickup_time', '9:00 AM'),
            'return_time' => $request->input('return_time', '9:00 AM'),
            'min_price' => $request->input('min_price', 0),
            'max_price' => $request->input('max_price', 1500),
            'category' => $request->input('category', ['All']),
            'sort_by' => $request->input('sort_by', 'ASC'),
        ];

        // Get car models and categories using service
        $carModels = $this->carListingService->getCarModels($searchParams);
        $categories = $this->carListingService->getCategories();

        return view('affiliate.car-listing.index', [
            'carModels' => $carModels,
            'categories' => $categories,
            'searchParams' => $searchParams
        ]);
    }

    public function search(Request $request)
    {
        // Get search parameters from request
        $searchParams = [
            'pickup_location' => $request->input('pickup_location', ''),
            'return_location' => $request->input('return_location', ''),
            'pickup_latitude' => $request->input('pickup_latitude', ''),
            'pickup_longitude' => $request->input('pickup_longitude', ''),
            'return_latitude' => $request->input('return_latitude', ''),
            'return_longitude' => $request->input('return_longitude', ''),
            'pickup_date' => $request->input('pickup_date', ''),
            'return_date' => $request->input('return_date', ''),
            'pickup_time' => $request->input('pickup_time', '9:00 AM'),
            'return_time' => $request->input('return_time', '9:00 AM'),
            'min_price' => $request->input('min_price', 0),
            'max_price' => $request->input('max_price', 1500),
            'category' => $request->input('category', ['All']),
            'sort_by' => $request->input('sort_by', 'ASC'),
        ];

        Log::info('Search request received:', $searchParams);

        // Use service to search cars
        $result = $this->carListingService->searchCars($searchParams);

        // Filter cars by distance if pickup coordinates are provided
        if (!empty($searchParams['pickup_latitude']) && !empty($searchParams['pickup_longitude'])) {
            $pickupLat = (float) $searchParams['pickup_latitude'];
            $pickupLong = (float) $searchParams['pickup_longitude'];

            Log::info('Filtering cars by distance from pickup location', [
                'pickup_lat' => $pickupLat,
                'pickup_long' => $pickupLong,
                'max_distance' => 10
            ]);

            $filteredCars = $this->distanceService->filterCarModelsByDistance(
                $result['data'],
                $pickupLat,
                $pickupLong,
                10 // 10km max distance
            );

            $result['data'] = $filteredCars->toArray();
        }

        Log::info('Search result count after distance filtering:', ['count' => count($result['data'])]);

        return response()->json($result);
    }

    public function book(Request $request, $carModelId)
    {
        // Get the car model using service
        $carModel = $this->carListingService->getCarModelById($carModelId);

        if (!$carModel) {
            abort(404, 'Car model not found');
        }

        // Get search parameters
        $searchParams = [
            'pickup_location' => $request->input('pickup_location', ''),
            'return_location' => $request->input('return_location', ''),
            'pickup_date' => $request->input('pickup_date', ''),
            'return_date' => $request->input('return_date', ''),
            'pickup_time' => $request->input('pickup_time', '9:00 AM'),
            'return_time' => $request->input('return_time', '9:00 AM'),
        ];

        return view('affiliate.car-listing.book', [
            'carModel' => $carModel,
            'searchParams' => $searchParams
        ]);
    }

    /**
     * Get restricted dates for date picker
     */
    public function getRestrictedDates()
    {
        // Get restricted dates from database or configuration
        // This could be from a RestrictedDateTime model or configuration
        $restrictedDates = [];

        // Example: Get dates from RestrictedDateTime model if it exists
        if (class_exists('App\Models\RestrictedDateTime')) {
            $restrictedDates = \App\Models\RestrictedDateTime::pluck('date')
                ->map(function ($date) {
                    return $date->format('d-m-Y');
                })
                ->toArray();
        }

        // You can also add hardcoded restricted dates here
        // $restrictedDates = array_merge($restrictedDates, [
        //     '25-12-2024', // Christmas
        //     '01-01-2025', // New Year
        // ]);

        return response()->json($restrictedDates);
    }
}
