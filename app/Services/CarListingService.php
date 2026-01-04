<?php

namespace App\Services;

use App\Models\CarModel;
use App\Models\ModelSpecification;
use App\Repositories\CarModelRepository;
use App\Services\PriceCalculationService;
use App\Services\AvailabilityService;
use App\Services\DateTimeService;
use Illuminate\Support\Collection;

class CarListingService
{
    protected $carModelRepository;
    protected $priceCalculationService;
    protected $availabilityService;
    protected $dateTimeService;

    public function __construct(
        CarModelRepository $carModelRepository,
        PriceCalculationService $priceCalculationService,
        AvailabilityService $availabilityService,
        DateTimeService $dateTimeService
    ) {
        $this->carModelRepository = $carModelRepository;
        $this->priceCalculationService = $priceCalculationService;
        $this->availabilityService = $availabilityService;
        $this->dateTimeService = $dateTimeService;
    }

    public function getCarModels(array $filters = []): Collection
    {
        $carModels = $this->carModelRepository->getCarModelsWithFilters($filters);

        // Calculate additional properties
        $carModels->each(function ($carModel) {
            $carModel->total_price_perday = $carModel->price_day;
            $carModel->is_promo = $this->isPromo($carModel);
            $carModel->unavailable = $this->isUnavailable($carModel);
        });

        return $carModels;
    }

    public function getCategories(): Collection
    {
        return $this->carModelRepository->getCategories();
    }

    public function getCarModelById(int $id): ?CarModel
    {
        return $this->carModelRepository->getCarModelById($id);
    }

    public function getCarModelsByModelSpec(
        int $modelSpecId,
        array $branchIds,
        string $pickupDateTime,
        string $returnDateTime,
        array $pickupLocationData,
        array $returnLocationData
    ): Collection {
        $carModels = $this->carModelRepository->getCarModelsByModelSpecIdAndBranchIds(
            $modelSpecId,
            $branchIds
        );

        $days = $this->dateTimeService->getDays($pickupDateTime, $returnDateTime);
        $hours = $this->dateTimeService->getHours($pickupDateTime, $returnDateTime);

        foreach ($carModels as $carModel) {
            $this->processCarModelForDisplay(
                $carModel,
                $pickupDateTime,
                $returnDateTime,
                $days,
                $hours,
                $pickupLocationData,
                $returnLocationData
            );
        }

        return $carModels;
    }

    protected function processCarModelForDisplay(
        CarModel $carModel,
        string $pickupDateTime,
        string $returnDateTime,
        int $days,
        int $hours,
        array $pickupLocationData,
        array $returnLocationData
    ): void {
        $calculatedPrice = $this->priceCalculationService->calculateCarModelPrice(
            $carModel,
            $pickupDateTime,
            $returnDateTime
        );

        $carModel->total_price = $calculatedPrice;
        $carModel->price_per_day = $calculatedPrice / ($days ?: 1);
        $carModel->rent_duration = $this->dateTimeService->durationTitle($days, $hours);

        // Calculate pickup/return pricing (this might need to be moved to a separate service)
        $pickupReturnPrices = $this->calculatePickupReturnPrices(
            $carModel,
            $pickupLocationData,
            $returnLocationData
        );

        $carModel->pickup_price = $pickupReturnPrices['pickup_price'];
        $carModel->pickup_distance = $pickupReturnPrices['pickup_distance'];
        $carModel->return_price = $pickupReturnPrices['return_price'];
        $carModel->return_distance = $pickupReturnPrices['return_distance'];
        $carModel->price_per_kilo = $carModel->branch->price_per_km ?? 0;

        // Check for promo pricing
        $isPromo = $this->priceCalculationService->checkIsPickupAndReturnIsPromo(
            $carModel,
            $pickupDateTime,
            $returnDateTime
        );



        $carModel->normal_price_per_day = $this->priceCalculationService->calculatePrice(
            $carModel,
            $days,
            $hours
        ) / ($days ?: 1);

        if ($isPromo && $carModel->normal_price_per_day > $carModel->price_per_day) {
            $carModel->is_promo = $isPromo;
            //calculate promo percentage
            $promoPercentage = $isPromo ? ($carModel->normal_price_per_day - $carModel->price_per_day) / $carModel->normal_price_per_day * 100 : 0;
            $carModel->promo_percentage = $promoPercentage;
        }

        // Check availability
        $carModel->unavailable = $this->availabilityService->checkCarModelUnavailable(
            $carModel,
            $pickupDateTime,
            $returnDateTime
        );
    }

    protected function calculatePickupReturnPrices(CarModel $carModel, array $pickupLocationData, array $returnLocationData): array
    {
        // Calculate pickup distance and price
        $pickupDistance = $this->calculateDistance(
            $pickupLocationData['pickup_latitude'],
            $pickupLocationData['pickup_longitude'],
            $carModel->branch->address_latitude,
            $carModel->branch->address_longitude
        );

        $pickupPrice = $pickupDistance * ($carModel->branch->price_per_km ?? 0);

        // Calculate return distance and price
        $returnDistance = $this->calculateDistance(
            $returnLocationData['return_latitude'],
            $returnLocationData['return_longitude'],
            $carModel->branch->address_latitude,
            $carModel->branch->address_longitude
        );

        $returnPrice = $returnDistance * ($carModel->branch->price_per_km ?? 0);

        return [
            'pickup_price' => $pickupPrice,
            'pickup_distance' => $pickupDistance,
            'return_price' => $returnPrice,
            'return_distance' => $returnDistance,
        ];
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        // Simple distance calculation using Haversine formula
        // This is a basic implementation - you might want to use a more sophisticated service
        $earthRadius = 6371; // Earth's radius in kilometers

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    private function isPromo(CarModel $carModel): bool
    {
        // Add promo logic here
        // For example, check if there's a seasonal price or special offer
        return false;
    }

    private function isUnavailable(CarModel $carModel): bool
    {
        // Add availability logic here
        // For example, check if all cars of this model are booked for the requested dates
        return false;
    }

    public function searchCars(array $searchParams): array
    {
        $carModels = $this->getCarModels($searchParams);

        return [
            'success' => true,
            'data' => $carModels,
            'count' => $carModels->count(),
            'searchParams' => $searchParams
        ];
    }
}
