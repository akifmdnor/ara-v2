<?php

namespace App\Services;

use App\Repositories\SearchRepository;
use App\Services\PriceCalculationService;
use App\Services\AvailabilityService;
use App\Services\DateTimeService;
use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    protected $searchRepository;
    protected $priceCalculationService;
    protected $availabilityService;
    protected $dateTimeService;

    public function __construct(
        SearchRepository $searchRepository,
        PriceCalculationService $priceCalculationService,
        AvailabilityService $availabilityService,
        DateTimeService $dateTimeService
    ) {
        $this->searchRepository = $searchRepository;
        $this->priceCalculationService = $priceCalculationService;
        $this->availabilityService = $availabilityService;
        $this->dateTimeService = $dateTimeService;
    }

    /**
     * Process car search with all filtering and calculations
     *
     * @param array $branchIds
     * @param string $pickupDateTime
     * @param string $dropoffDateTime
     * @param float $minPrice
     * @param float $maxPrice
     * @param string $sortBy
     * @param array|null $categories
     * @return Collection
     */
    public function processCarSearch(
        array $branchIds,
        string $pickupDateTime,
        string $dropoffDateTime,
        float $minPrice = 0,
        float $maxPrice = 1500,
        string $sortBy = 'DESC',
        array $categories = null
    ): Collection {
        $modelSpecs = $this->searchRepository->getModelSpecificationsWithCarModels($branchIds, $sortBy, $categories);

        return $this->processModelSpecifications($modelSpecs, $pickupDateTime, $dropoffDateTime, $minPrice, $maxPrice, $branchIds);
    }

    /**
     * Process model specifications with pricing and availability calculations
     *
     * @param Collection $modelSpecs
     * @param string $pickupDateTime
     * @param string $dropoffDateTime
     * @param float $minPrice
     * @param float $maxPrice
     * @param array $branchIds
     * @return Collection
     */
    private function processModelSpecifications(
        Collection $modelSpecs,
        string $pickupDateTime,
        string $dropoffDateTime,
        float $minPrice,
        float $maxPrice,
        array $branchIds
    ): Collection {
        foreach ($modelSpecs as $key => $modelSpec) {
            $modelSpec->days = $this->dateTimeService->getDays($pickupDateTime, $dropoffDateTime);
            $modelSpec->hours = $this->dateTimeService->getHours($pickupDateTime, $dropoffDateTime);

            // Skip if car_model is null
            if (!$modelSpec->car_model) {
                unset($modelSpecs[$key]);
                continue;
            }

            // Remove duplicate model specs based on pricing
            foreach ($modelSpecs as $modelSpecCheck) {
                if ($modelSpec->id == $modelSpecCheck->id) {
                    if (
                        $this->priceCalculationService->calculateCarModelPrice($modelSpec->car_model, $pickupDateTime, $dropoffDateTime) >
                        $this->priceCalculationService->calculateCarModelPrice($modelSpecCheck->car_model, $pickupDateTime, $dropoffDateTime)
                    ) {
                        unset($modelSpecs[$key]);
                        continue 2;
                    }
                }
            }

            $carModel = $modelSpec->car_model;
            $carModelId = $modelSpec->car_model_id;

            $calculatedPrice = $this->priceCalculationService->calculateCarModelPrice($modelSpec->car_model, $pickupDateTime, $dropoffDateTime);
            $modelSpec->total_price = $calculatedPrice;

            $getDays = $this->dateTimeService->getDays($pickupDateTime, $dropoffDateTime);
            $days = $getDays == 0 ? 1 : $getDays;

            if ($calculatedPrice == 0) {
                unset($modelSpecs[$key]);
                continue;
            }

            $modelSpec->total_price_perday = $calculatedPrice / $days;
            $isPromo = $this->priceCalculationService->checkIsPickupAndReturnIsPromo($modelSpec->car_model, $pickupDateTime, $dropoffDateTime);
            $modelSpec->normal_price_perday = $this->priceCalculationService->calculatePrice($modelSpec->car_model, $modelSpec->days, $modelSpec->hours) / $modelSpec->days;

            if ($isPromo && $modelSpec->normal_price_perday >= $modelSpec->total_price_perday) {
                $modelSpec->is_promo = $isPromo;
            }

            if ($modelSpec->total_price_perday == 0) {
                unset($modelSpecs[$key]);
                continue;
            }

            if ($modelSpec->total_price_perday < $minPrice || $modelSpec->total_price_perday > $maxPrice) {
                unset($modelSpecs[$key]);
                continue;
            }

            $modelSpec->unavailable = $this->availabilityService->checkModelSpecUnavailable($modelSpec, $pickupDateTime, $dropoffDateTime, $branchIds);
        }

        return $modelSpecs;
    }

    /**
     * Get unique categories
     *
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->searchRepository->getCategories();
    }
}
