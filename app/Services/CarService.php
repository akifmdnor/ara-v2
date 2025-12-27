<?php

namespace App\Services;

use App\Repositories\CarRepository;

class CarService
{
    protected $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    /**
     * Get recent cars with category information
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentCarsWithCategories($limit = 8)
    {
        $recentCars = $this->carRepository->getRecentWithSpecifications($limit);

        // Add category information
        foreach ($recentCars as $recentCar) {
            $carModel = $this->carRepository->getBySpecificationId($recentCar->model_specification_id);
            $recentCar->category = $carModel ? $carModel->category : 'Unknown';
        }

        return $recentCars;
    }

    /**
     * Get unique car categories
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCategories()
    {
        return $this->carRepository->getCategories();
    }

    /**
     * Get recent cars for display
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentCarsForDisplay($limit = 8)
    {
        return $this->getRecentCarsWithCategories($limit);
    }
}
