<?php

namespace App\Repositories;

use App\Models\RecentBooking;
use App\Models\CarModel;

class CarRepository
{
    /**
     * Get recent cars with specifications
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentWithSpecifications($limit = 8)
    {
        return RecentBooking::with('model_specification')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Get car categories
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCategories()
    {
        return CarModel::all()->unique('category');
    }

    /**
     * Get car model by specification ID
     *
     * @param int $specificationId
     * @return \App\Models\CarModel|null
     */
    public function getBySpecificationId($specificationId)
    {
        return CarModel::where('model_specification_id', $specificationId)->first();
    }
}
