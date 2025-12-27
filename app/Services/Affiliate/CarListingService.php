<?php

namespace App\Services\Affiliate;

use App\Models\CarModel;
use App\Repositories\Affiliate\CarModelRepository;
use Illuminate\Support\Collection;

class CarListingService
{
    protected $carModelRepository;

    public function __construct(CarModelRepository $carModelRepository)
    {
        $this->carModelRepository = $carModelRepository;
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
