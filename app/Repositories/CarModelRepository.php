<?php

namespace App\Repositories;

use App\Models\CarModel;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class CarModelRepository
{
    public function getActiveCarModels(): Builder
    {
        return CarModel::with(['model_specification', 'pictures', 'branch'])
            ->where('is_deactive', 0)
            ->whereHas('cars', function ($q) {
                $q->where('is_deactive', 0);
            });
    }

    public function getCarModelsWithFilters(array $filters = []): Collection
    {
        $query = $this->getActiveCarModels();

        // Apply price filter
        if (isset($filters['min_price']) && isset($filters['max_price'])) {
            $minPrice = $filters['min_price'] ?? 0;
            $maxPrice = $filters['max_price'] ?? 1500;

            if ($minPrice > 0 || $maxPrice < 1500) {
                $query->whereBetween('price_day', [$minPrice, $maxPrice]);
            }
        }

        // Apply category filter
        if (isset($filters['category']) && !empty($filters['category'])) {
            // If "All" is selected, don't apply category filter
            if (in_array('All', $filters['category'])) {
                Log::info('"All" category selected - no filter applied');
            } else {
                Log::info('Applying category filter:', $filters['category']);
            $query->whereIn('category', $filters['category']);
            }
        } else {
            Log::info('No category filter applied - empty or not set');
        }

        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'ASC';
        $query->orderBy('price_day', $sortBy);

        return $query->get();
    }

    public function getCarModelById(int $id): ?CarModel
    {
        return CarModel::with(['model_specification', 'pictures', 'branch'])
            ->find($id);
    }

    public function getCategories(): Collection
    {
        return CarModel::distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->filter()
            ->values();
    }

    public function getCarModelsByCategory(string $category): Collection
    {
        return $this->getActiveCarModels()
            ->where('category', $category)
            ->get();
    }

    public function getCarModelsByPriceRange(float $minPrice, float $maxPrice): Collection
    {
        return $this->getActiveCarModels()
            ->whereBetween('price_day', [$minPrice, $maxPrice])
            ->get();
    }

    public function searchCarModels(string $searchTerm): Collection
    {
        return $this->getActiveCarModels()
            ->whereHas('model_specification', function ($query) use ($searchTerm) {
                $query->where('model_name', 'like', "%{$searchTerm}%");
            })
            ->get();
    }
}
