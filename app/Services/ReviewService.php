<?php

namespace App\Services;

use App\Repositories\ReviewRepository;

class ReviewService
{
    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Get all customer reviews
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllReviews()
    {
        return $this->reviewRepository->getAll();
    }

    /**
     * Get customer reviews for display
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReviewsForDisplay()
    {
        return $this->getAllReviews();
    }
}
