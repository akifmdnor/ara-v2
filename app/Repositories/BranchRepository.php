<?php

namespace App\Repositories;

use App\Models\Branch;

class BranchRepository
{
    /**
     * Get all branches
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Branch::all();
    }

}
