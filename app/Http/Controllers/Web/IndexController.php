<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\RecentBooking;
use App\Models\CarModel;
use App\Models\HomepageManager;
use App\Models\CustomerReview;

class IndexController extends Controller
{
    /**
     * Display the web index page with homepage data.
     *
     * @return \Illuminate\View\View
     */
    public function xindex()
    {
        $branches = Branch::get();
        $recentCars = RecentBooking::with('model_specification')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        foreach ($recentCars as $recentCar) {
            $carModel = CarModel::where('model_specification_id', $recentCar->model_specification_id)->first();
            $recentCar->category = $carModel ? $carModel->category : 'Unknown';
        }
        $categories = CarModel::get()->unique('category');
        $desktopCover = HomepageManager::where('type', 'desktop_cover')->first();
        $mobileCover = HomepageManager::where('type', 'mobile_cover')->first();
        $timelessDeals = HomepageManager::where('type', 'timeless_deal')->get();
        $customerReviews = CustomerReview::all();

        return view('web.index', compact('branches', 'recentCars', 'categories', 'desktopCover', 'mobileCover', 'timelessDeals', 'customerReviews'));
    }
}
