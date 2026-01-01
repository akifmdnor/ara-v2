<?php

namespace App\Services;

use App\Models\Branch;
use App\Repositories\LocationHistoryRepository;

class DistanceCalculationService
{
    protected $locationHistoryRepository;

    public function __construct(LocationHistoryRepository $locationHistoryRepository)
    {
        $this->locationHistoryRepository = $locationHistoryRepository;
    }

    /**
     * Calculate distance charge based on distance and price per km
     *
     * @param string $distance
     * @param float $pricePerKm
     * @return float
     */
    public function calculateDistanceCharge(string $distance, float $pricePerKm): float
    {
        $arrDistance = explode(' ', trim($distance));
        $arrDistance[0] = str_replace(',', '', $arrDistance[0]);

        if ($arrDistance[1] == 'km') {
            return round($arrDistance[0] * $pricePerKm, 2);
        } else {
            return round($arrDistance[0] / 1000 * $pricePerKm, 2);
        }
    }

    /**
     * Calculate branch distance using cached data or MapBox API
     *
     * @param int $branchId
     * @param float $lat
     * @param float $long
     * @param string|null $locationName
     * @return string
     */
    public function calculateBranchDistance(int $branchId, float $lat, float $long, ?string $locationName = null): string
    {
        $branch = Branch::find($branchId);

        if ($lat == 0) {
            $lat = $branch->address_latitude;
        }

        if ($long == 0) {
            $long = $branch->address_longitude;
        }

        // Check if distance already exists in location_history
        $existingDistance = $this->locationHistoryRepository->getByBranchAndCoordinates($branchId, $lat, $long);

        if ($existingDistance) {
            return $existingDistance->distance_km . " km";
        }

        // If not found, query Mapbox
        $url = "https://api.mapbox.com/directions-matrix/v1/mapbox/driving/" . $long . "," . $lat . ";" . $branch->address_longitude . "," . $branch->address_latitude . "?annotations=distance&sources=0&destinations=all&access_token=" . env('MAPBOX_API_KEY');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result, true);

        $distanceKm = $response["distances"][0] ? ((int) $response["distances"][0][1] / 1000) : 9999;
        $distanceString = $distanceKm . " km";

        // Save to location_history for future use
        $branchName = Branch::find($branchId)->branch_name ?? 'Unknown Branch';

        $this->locationHistoryRepository->create([
            'branch_id' => $branchId,
            'branch_name' => $branchName,
            'search_latitude' => $lat,
            'search_longitude' => $long,
            'search_location_name' => $locationName,
            'distance_km' => $distanceKm
        ]);

        return $distanceString;
    }
}
