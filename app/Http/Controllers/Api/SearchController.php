<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle search API request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Get search parameters from request
        $pickupLocation = $request->get('pickup_location');
        $pickupDate = $request->get('pickup_date');
        $pickupTime = $request->get('pickup_time');
        $returnLocation = $request->get('return_location');
        $returnDate = $request->get('return_date');
        $returnTime = $request->get('return_time');

        // Mock data - in real implementation, this would query the database
        $mockData = [
            'success' => true,
            'message' => 'Search completed successfully',
            'data' => [
                'total_cars' => 48,
                'location' => $pickupLocation ?: 'Bandar Puteri, Puchong, Selangor',
                'cars' => [
                    [
                        'name' => 'Perodua Myvi',
                        'price' => '180.00',
                        'total_price' => '360.00',
                        'original_price' => '200.00',
                        'image' => '/images/ara-logo.png',
                        'transmission' => 'Auto',
                        'seats' => '4',
                        'doors' => '4',
                        'luggage' => '2',
                        'engine' => '1.5 L',
                        'fuel' => 'Petrol',
                        'tags' => ['Group A', 'Compact', '10 Branch/es'],
                        'sale_tags' => [
                            ['text' => 'SALE', 'bg' => '#fff4ed', 'border' => '#ff9960', 'color' => '#fe7439'],
                            ['text' => '10% OFF TODAY', 'bg' => '#fe7439', 'border' => '#fe7439', 'color' => '#fff4ed'],
                        ],
                        'limited_offer' => true,
                        'variants' => [
                            [
                                'name' => 'Myvi 1.5H (M800)',
                                'location' => 'Bandar Puteri, Puchong, Selangor',
                                'price' => '180.00',
                                'total_price' => '360.00',
                                'original_price' => '200.00',
                                'sale' => true,
                                'features' => [
                                    '1,000km mileage/day',
                                    'CDW insurance coverage (Excess RM5,000)',
                                    'Additional driver',
                                    'Free delivery and pick up within 5km',
                                    'Baby/booster seat (free)',
                                    'Pet friendly',
                                ],
                            ],
                            [
                                'name' => 'Myvi 1.5H (M801)',
                                'location' => 'Puchong Perdana, Puchong, Selangor',
                                'price' => '210.00',
                                'total_price' => '420.00',
                                'fully_booked' => true,
                                'features' => [
                                    '1,200km mileage/day',
                                    'Full insurance coverage',
                                    'Additional driver',
                                    'Free delivery and pick up within 10km',
                                    'Baby/booster seat (free)',
                                    'GPS navigation',
                                ],
                            ],
                        ],
                    ],
                    [
                        'name' => 'Proton Saga',
                        'price' => '150.00',
                        'total_price' => '300.00',
                        'image' => '/images/ara-logo.png',
                        'transmission' => 'Manual',
                        'seats' => '5',
                        'doors' => '4',
                        'luggage' => '3',
                        'engine' => '1.3 L',
                        'fuel' => 'Petrol',
                        'tags' => ['Group B', 'Sedan', '8 Branch/es'],
                        'variants' => [
                            [
                                'name' => 'Saga 1.3 Premium (S100)',
                                'location' => 'Puchong Perdana, Puchong, Selangor',
                                'price' => '150.00',
                                'total_price' => '300.00',
                                'features' => [
                                    '800km mileage/day',
                                    'CDW insurance coverage (Excess RM4,000)',
                                    'Additional driver',
                                    'Free delivery within 5km',
                                    'Baby/booster seat (free)',
                                    'USB charging',
                                ],
                            ],
                        ],
                    ],
                    [
                        'name' => 'Honda City',
                        'price' => '250.00',
                        'total_price' => '500.00',
                        'image' => '/images/ara-logo.png',
                        'transmission' => 'Auto',
                        'seats' => '5',
                        'doors' => '4',
                        'luggage' => '3',
                        'engine' => '1.5 L',
                        'fuel' => 'Petrol',
                        'tags' => ['Group C', 'Sedan', '6 Branch/es'],
                        'variants' => [
                            [
                                'name' => 'City 1.5V (C100)',
                                'location' => 'Seksyen 13 Shah Alam, Shah Alam, Selangor',
                                'price' => '250.00',
                                'total_price' => '500.00',
                                'features' => [
                                    '1,500km mileage/day',
                                    'CDW insurance coverage (Excess RM7,000)',
                                    'Additional driver',
                                    'Free delivery within 8km',
                                    'Baby/booster seat (free)',
                                    'GPS navigation',
                                ],
                            ],
                        ],
                    ],
                ]
            ],
            'search_params' => [
                'pickup_location' => $pickupLocation,
                'pickup_date' => $pickupDate,
                'pickup_time' => $pickupTime,
                'return_location' => $returnLocation,
                'return_date' => $returnDate,
                'return_time' => $returnTime,
            ]
        ];

        return response()->json($mockData);
    }
}
