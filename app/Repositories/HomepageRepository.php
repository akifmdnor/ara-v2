<?php

namespace App\Repositories;

use App\Models\HomepageManager;

class HomepageRepository
{
    /**
     * Get content by type
     *
     * @param string $type
     * @return \App\Models\HomepageManager|null
     */
    public function getByType($type)
    {
        return HomepageManager::where('type', $type)->first();
    }

    /**
     * Get all content by type
     *
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllByType($type)
    {
        return HomepageManager::where('type', $type)->get();
    }

    /**
     * Get desktop cover
     *
     * @return \App\Models\HomepageManager|null
     */
    public function getDesktopCover()
    {
        return $this->getByType('desktop_cover');
    }

    /**
     * Get mobile cover
     *
     * @return \App\Models\HomepageManager|null
     */
    public function getMobileCover()
    {
        return $this->getByType('mobile_cover');
    }

    /**
     * Get timeless deals
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTimelessDeals()
    {
        return $this->getAllByType('timeless_deal');
    }
}
