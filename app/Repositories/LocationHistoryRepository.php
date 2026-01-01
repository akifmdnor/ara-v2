<?php

namespace App\Repositories;

use App\Models\LocationHistory;

class LocationHistoryRepository
{
    /**
     * Get cached distances for a specific latitude and longitude combination
     * Only returns records where the associated branch still exists
     *
     * @param float $lat
     * @param float $long
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCachedDistances($lat, $long)
    {
        return LocationHistory::where('search_latitude', $lat)
            ->where('search_longitude', $long)
            ->whereHas('branch') // Only include records where branch still exists
            ->get()
            ->keyBy('branch_id');
    }

    /**
     * Create a new location history record
     *
     * @param array $data
     * @return \App\Models\LocationHistory
     */
    public function create(array $data)
    {
        return LocationHistory::create($data);
    }

    /**
     * Get location history by branch ID and search coordinates
     *
     * @param int $branchId
     * @param float $lat
     * @param float $long
     * @return \App\Models\LocationHistory|null
     */
    public function getByBranchAndCoordinates($branchId, $lat, $long)
    {
        return LocationHistory::where('branch_id', $branchId)
            ->where('search_latitude', $lat)
            ->where('search_longitude', $long)
            ->first();
    }

    /**
     * Delete location history records for branches that no longer exist
     *
     * @return int Number of deleted records
     */
    public function cleanOrphanedRecords()
    {
        return LocationHistory::whereDoesntHave('branch')->delete();
    }
}
