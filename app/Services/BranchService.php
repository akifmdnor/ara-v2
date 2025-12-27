<?php

namespace App\Services;

use App\Repositories\BranchRepository;

class BranchService
{
    protected $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    /**
     * Get all branches
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBranches()
    {
        return $this->branchRepository->getAll();
    }

    /**
     * Get branches for display
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBranchesForDisplay()
    {
        return $this->getAllBranches();
    }
}
