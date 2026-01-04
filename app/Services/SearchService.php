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
    ) {
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
    ) {
        $processedModelSpecs = collect();
        $processedModelSpecIds = [];

        foreach ($modelSpecs as $key => $modelSpec) {
            // Skip if already processed this model spec
            if (in_array($modelSpec->id, $processedModelSpecIds)) {
                continue;
            }

            $modelSpec->days = $this->dateTimeService->getDays($pickupDateTime, $dropoffDateTime);
            $modelSpec->hours = $this->dateTimeService->getHours($pickupDateTime, $dropoffDateTime);
            $getDays = $this->dateTimeService->getDays($pickupDateTime, $dropoffDateTime);
            $days = $getDays == 0 ? 1 : $getDays;

            // Get all car models for this model spec within the branches
            $carModels = \App\Models\CarModel::with('branch')
                ->where('model_specification_id', $modelSpec->id)
                ->whereIn('branch_id', $branchIds)
                ->where('is_deactive', false)
                ->get();

            if ($carModels->isEmpty()) {
                continue;
            }

            // Process each car model
            $processedCarModels = collect();
            $minPricePerDay = null;

            foreach ($carModels as $carModel) {
                $calculatedPrice = $this->priceCalculationService->calculateCarModelPrice($carModel, $pickupDateTime, $dropoffDateTime);

                if ($calculatedPrice == 0) {
                    continue;
                }

                $pricePerDay = $calculatedPrice / $days;

                // Track minimum price for filtering
                if ($minPricePerDay === null || $pricePerDay < $minPricePerDay) {
                    $minPricePerDay = $pricePerDay;
                }

                // Add calculated values to car model
                $carModel->total_price = $calculatedPrice;
                $carModel->price_per_day = $pricePerDay;
                $carModel->rent_duration = $this->dateTimeService->durationTitle($modelSpec->days, $modelSpec->hours);

                // Check if promo
                $isPromo = $this->priceCalculationService->checkIsPickupAndReturnIsPromo($carModel, $pickupDateTime, $dropoffDateTime);

                $carModel->normal_price_per_day = $this->priceCalculationService->calculatePrice($carModel, $modelSpec->days, $modelSpec->hours) / $modelSpec->days;

                if ($isPromo && $carModel->normal_price_per_day > $carModel->price_per_day) {
                    $carModel->is_promo = true;
                    //calculate promo percentage
                    $promoPercentage = $isPromo ? ($carModel->normal_price_per_day - $carModel->price_per_day) / $carModel->normal_price_per_day * 100 : 0;
                    $carModel->promo_percentage = $promoPercentage;
                } else {
                    $carModel->is_promo = false;
                }



                // Check availability
                $carModel->unavailable = $this->availabilityService->checkCarModelUnavailable($carModel, $pickupDateTime, $dropoffDateTime);

                $processedCarModels->push($carModel);
            }

            // Skip if no valid car models
            if ($processedCarModels->isEmpty() || $minPricePerDay === null) {
                continue;
            }

            // Apply price filtering based on minimum price
            if ($minPricePerDay < $minPrice || $minPricePerDay > $maxPrice) {
                continue;
            }

            // Set model spec pricing based on cheapest car model
            $modelSpec->total_price_perday = $minPricePerDay;
            $modelSpec->total_price = $minPricePerDay * $days;

            // Check if ANY car model is promo
            $modelSpec->is_promo = $processedCarModels->contains('is_promo', true);

            // Check if ALL car models are unavailable
            $modelSpec->unavailable = $processedCarModels->every('unavailable', true);

            // Attach processed car models to model spec
            $modelSpec->car_models = $processedCarModels;

            // Process included field (add-ons) into array
            $modelSpec->includedArray = [];
            if (!empty($modelSpec->included)) {
                $modelSpec->includedArray = preg_split('/<br[^>]*>/i', $modelSpec->included);
                // Filter out empty values
                $modelSpec->includedArray = array_filter($modelSpec->includedArray, function ($value) {
                    return !empty(trim($value));
                });
            }

            $processedModelSpecs->push($modelSpec);
            $processedModelSpecIds[] = $modelSpec->id;
        }

        return $processedModelSpecs->reverse();
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
