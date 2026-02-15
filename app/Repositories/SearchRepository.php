<?php

namespace App\Repositories;

use App\Models\ModelSpecification;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\Collection;

class SearchRepository
{
    /**
     * Get model specifications with car models joined, filtered by branch IDs
     *
     * @param array $branchIds
     * @param string $sortBy
     * @param array|null $categories
     * @return Collection
     */
    public function getModelSpecificationsWithCarModels(array $branchIds, string $sortBy = 'ASC', array $categories = null, array $brands = null)
    {
        $query = ModelSpecification::join('car_models', 'model_specifications.id', '=', 'car_models.model_specification_id')
            ->select('model_specifications.*', 'car_models.id as car_model_id', 'car_models.price_day')
            ->whereIn('branch_id', $branchIds)
            ->where('car_models.is_deactive', false)
            ->orderBy('price_day', $sortBy);

        if ($categories !== null) {
            $query->whereIn('category', $categories);
        }

        if ($brands !== null) {
            $query->whereIn('model_specifications.brand', $brands);
        }

        return $query->with(['car_model.cars', 'pictures'])->get();
    }
    public function getCategories()
    {
        return CarModel::distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->filter()
            ->values();
    }

    public function getBrands()
    {
        return ModelSpecification::distinct()
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->pluck('brand')
            ->filter()
            ->values();
    }
}
