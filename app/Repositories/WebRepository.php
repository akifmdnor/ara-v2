<?php

namespace App\Repositories;

use App\Models\Branch;
use App\Models\RecentBooking;
use App\Models\CarModel;
use App\Models\HomepageManager;
use App\Models\CustomerReview;

class WebRepository
{
    /**
     * Get all branches
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBranches()
    {
        return Branch::all();
    }

    /**
     * Get recent cars with their specifications and categories
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentCars($limit = 8)
    {
        $recentCars = RecentBooking::with('model_specification')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();

        // Add category information
        foreach ($recentCars as $recentCar) {
            $carModel = CarModel::where('model_specification_id', $recentCar->model_specification_id)->first();
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
        return CarModel::all()->unique('category');
    }

    /**
     * Get desktop cover from homepage manager
     *
     * @return \App\Models\HomepageManager|null
     */
    public function getDesktopCover()
    {
        return HomepageManager::where('type', 'desktop_cover')->first();
    }

    /**
     * Get mobile cover from homepage manager
     *
     * @return \App\Models\HomepageManager|null
     */
    public function getMobileCover()
    {
        return HomepageManager::where('type', 'mobile_cover')->first();
    }

    /**
     * Get timeless deals from homepage manager
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTimelessDeals()
    {
        return HomepageManager::where('type', 'timeless_deal')->get();
    }

    /**
     * Get all customer reviews
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCustomerReviews()
    {
        return CustomerReview::all();
    }
}
