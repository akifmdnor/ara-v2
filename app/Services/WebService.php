<?php

namespace App\Services;

use App\Services\BranchService;
use App\Services\CarService;
use App\Services\HomepageService;
use App\Services\ReviewService;
class WebService
{
    protected $branchService;
    protected $carService;
    protected $homepageService;
    protected $reviewService;

    public function __construct(
        BranchService $branchService,
        CarService $carService,
        HomepageService $homepageService,
        ReviewService $reviewService
    ) {
        $this->branchService = $branchService;
        $this->carService = $carService;
        $this->homepageService = $homepageService;
        $this->reviewService = $reviewService;
    }

    /**
     * Get all homepage data by orchestrating specialized services
     *
     * @return array
     */
    public function getHomepageData(): array
    {
        return [
            'branches' => $this->branchService->getBranchesForDisplay(),
            'recentCars' => $this->carService->getRecentCarsForDisplay(),
            'categories' => $this->carService->getCategories(),
            'desktopCover' => $this->homepageService->getDesktopCover(),
            'mobileCover' => $this->homepageService->getMobileCover(),
            'timelessDeals' => $this->homepageService->getTimelessDeals(),
            'customerReviews' => $this->reviewService->getReviewsForDisplay(),
        ];
    }
}
