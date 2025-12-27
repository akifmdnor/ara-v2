<?php

namespace App\Services\Affiliate;

use App\Models\Branch;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DistanceService
{
    private $mapboxApiKey;

    public function __construct()
    {
        $this->mapboxApiKey = config('mapbox.api_key');
    }

    /**
     * Calculate distance between pickup location and branch
     * Uses caching to reduce API calls
     */
    public function calculateBranchDistance($branch_id, $lat, $long)
    {
        $branch = Branch::find($branch_id);

        if (!$branch) {
            return 9999; // Return high distance if branch not found
        }

        // Use branch coordinates if pickup coordinates are not provided
        if ($lat == 0) {
            $lat = $branch->address_latitude;
        }
        if ($long == 0) {
            $long = $branch->address_longitude;
        }

        // Create cache key based on coordinates and branch
        $cacheKey = "distance_{$branch_id}_{$lat}_{$long}";

        // Check if distance is cached
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Calculate distance using Mapbox API
        $distance = $this->calculateDistanceFromMapbox($branch, $lat, $long);

        // Cache the result for 24 hours to reduce API calls
        Cache::put($cacheKey, $distance, now()->addHours(24));

        return $distance;
    }

    /**
     * Calculate distance using Mapbox Directions Matrix API
     */
    private function calculateDistanceFromMapbox($branch, $lat, $long)
    {
        try {
            $url = "https://api.mapbox.com/directions-matrix/v1/mapbox/driving/" .
                $long . "," . $lat . ";" .
                $branch->address_longitude . "," . $branch->address_latitude .
                "?annotations=distance&sources=0&destinations=all&access_token=" . $this->mapboxApiKey;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200 || !$result) {
                Log::warning("Mapbox API error for branch {$branch->id}: HTTP {$httpCode}");
                return 9999; // Return high distance on API error
            }

            $response = json_decode($result, true);

            if (isset($response["distances"][0][1])) {
                $distanceKm = (int) $response["distances"][0][1] / 1000;
                Log::info("Distance calculated for branch {$branch->id}: {$distanceKm} km");
                return $distanceKm;
            }

            Log::warning("Invalid Mapbox response for branch {$branch->id}");
            return 9999;

        } catch (\Exception $e) {
            Log::error("Error calculating distance for branch {$branch->id}: " . $e->getMessage());
            return 9999;
        }
    }

    /**
     * Filter car models by distance from pickup location
     */
    public function filterCarModelsByDistance($carModels, $pickupLat, $pickupLong, $maxDistance = 10)
    {
        if (empty($carModels)) {
            return collect();
        }

        $filteredModels = collect();

        foreach ($carModels as $carModel) {
            $distance = $this->calculateBranchDistance(
                $carModel->branch_id,
                $pickupLat,
                $pickupLong
            );

            if ($distance <= $maxDistance) {
                // Add distance to car model for display
                $carModel->distance_from_pickup = $distance;
                $filteredModels->push($carModel);
            }
        }

        Log::info("Filtered cars by distance: {$filteredModels->count()} out of " . count($carModels) . " within {$maxDistance}km");

        return $filteredModels;
    }

    /**
     * Get distance in formatted string
     */
    public function formatDistance($distance)
    {
        if ($distance >= 9999) {
            return 'Distance unavailable';
        }
        return number_format($distance, 1) . ' km';
    }

    /**
     * Clear all cached distances
     */
    public function clearDistanceCache()
    {
        $keys = Cache::get('distance_*');
        foreach ($keys as $key) {
            Cache::forget($key);
        }
        Log::info('Distance cache cleared');
    }

    /**
     * Get cache statistics
     */
    public function getCacheStats()
    {
        $keys = Cache::get('distance_*');
        return [
            'total_cached_distances' => count($keys),
            'cache_keys' => $keys
        ];
    }
}
