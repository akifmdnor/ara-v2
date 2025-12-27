<?php

namespace App\Services;

use App\Repositories\HomepageRepository;

class HomepageService
{
    protected $homepageRepository;

    public function __construct(HomepageRepository $homepageRepository)
    {
        $this->homepageRepository = $homepageRepository;
    }

    /**
     * Get content by type
     *
     * @param string $type
     * @return \App\Models\HomepageManager|null
     */
    public function getContentByType($type)
    {
        return $this->homepageRepository->getByType($type);
    }

    /**
     * Get all content by type
     *
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllContentByType($type)
    {
        return $this->homepageRepository->getAllByType($type);
    }

    /**
     * Get desktop cover
     *
     * @return \App\Models\HomepageManager|null
     */
    public function getDesktopCover()
    {
        return $this->getContentByType('desktop_cover');
    }

    /**
     * Get mobile cover
     *
     * @return \App\Models\HomepageManager|null
     */
    public function getMobileCover()
    {
        return $this->getContentByType('mobile_cover');
    }

    /**
     * Get timeless deals
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTimelessDeals()
    {
        return $this->getAllContentByType('timeless_deal');
    }
}
