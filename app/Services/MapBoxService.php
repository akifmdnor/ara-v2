<?php

namespace App\Services;

use App\Models\Branch;
use App\Repositories\LocationHistoryRepository;

class MapBoxService
{
    protected $locationHistoryRepository;

    public function __construct(LocationHistoryRepository $locationHistoryRepository)
    {
        $this->locationHistoryRepository = $locationHistoryRepository;
    }

    function getBranchDistanceMapbox($branchs, $lat, $long, $location_name = null)
    {
        // Check if we have cached results for this lat/long combination (only for existing branches)
        $existingDistances = $this->locationHistoryRepository->getCachedDistances($lat, $long);

        // Check if we have all branches cached
        $all_cached = true;
        $cached_distances = [];

        foreach ($branchs as $index => $branch) {
            if (isset($existing_distances[$branch->id])) {
                $cached_distances[$index] = $existingDistances[$branch->id]->distance_km;
            } else {
                $all_cached = false;
                break;
            }
        }

        // If all distances are cached and we have branches, return them
        if ($all_cached && !empty($branchs)) {
            return $cached_distances;
        }

        // Original Mapbox logic
        $origin = '';
        $origin2 = '';
        $counter = 0;
        // if ($lat == 0)
        //     $lat = $branch->address_latitude ;

        // if ($long == 0)
        //     $long = $branch->address_longitude;


        foreach ($branchs as $branch) {
            // print item

            if ($counter < 23)
                $origin .= $branch->address_longitude . "," . $branch->address_latitude . ";";
            else
                $origin2 .= $branch->address_longitude . "," . $branch->address_latitude . ";";

            $counter++;

        }


        $origin = rtrim($origin, ";");
        $origin2 = rtrim($origin2, ";");
        $url = "https://api.mapbox.com/directions-matrix/v1/mapbox/driving/" . $long . "," . $lat . ";" . $origin . "?annotations=distance&sources=0&destinations=all&access_token=" . env('MAPBOX_API_KEY');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result, true);
        unset($response["distances"][0][0]);

        if ($origin2 != '') {
            $url2 = "https://api.mapbox.com/directions-matrix/v1/mapbox/driving/" . $long . "," . $lat . ";" . $origin2 . "?annotations=distance&sources=0&destinations=all&access_token=" . env('MAPBOX_API_KEY');
            $ch2 = curl_init();
            curl_setopt($ch2, CURLOPT_URL, $url2);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch2, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
            $result2 = curl_exec($ch2);
            curl_close($ch2);
            $response2 = json_decode($result2, true);
            unset($response2["distances"][0][0]);


        }

        $finalResponse = array_merge($response["distances"][0], $response2["distances"][0]);
        // Save all distances to location_history
        foreach ($finalResponse as $index => $distance_km) {
            if (isset($branchs[$index])) {
                $branch = $branchs[$index];
                $branch_name = Branch::find($branch->id)->branch_name ?? 'Unknown Branch';

                $this->locationHistoryRepository->create([
                    'branch_id' => $branch->id,
                    'branch_name' => $branch_name,
                    'search_latitude' => $lat,
                    'search_longitude' => $long,
                    'search_location_name' => $location_name,
                    'distance_km' => $distance_km / 1000
                ]);
            }
        }
        $finalResponse = array_map(function ($distance) {
            return $distance / 1000;
        }, $finalResponse);
        return $finalResponse;

    }


}
