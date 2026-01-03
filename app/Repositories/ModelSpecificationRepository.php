<?php

namespace App\Repositories;

use App\Models\ModelSpecification;
use Illuminate\Database\Eloquent\Collection;

class ModelSpecificationRepository
{
    /**
     * Get model specification by ID
     *
     * @param int $id
     * @return ModelSpecification|null
     */
    public function getModelSpecificationById(int $id): ?ModelSpecification
    {
        return ModelSpecification::find($id);
    }

    /**
     * Get model specification by ID with pictures
     *
     * @param int $id
     * @return ModelSpecification|null
     */
    public function getModelSpecificationWithPictures(int $id): ?ModelSpecification
    {
        return ModelSpecification::with('pictures')->find($id);
    }
}
