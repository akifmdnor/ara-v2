<?php

namespace App\Repositories;

use App\Models\CustomerReview;

class ReviewRepository
{
    /**
     * Get all customer reviews
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return CustomerReview::all();
    }


    /**
     * Get review by ID
     *
     * @param int $id
     * @return \App\Models\CustomerReview|null
     */
    public function find($id)
    {
        return CustomerReview::find($id);
    }
}
