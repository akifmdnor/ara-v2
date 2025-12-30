{{-- Main Content Area - Matches Figma Design --}}
<div class="flex flex-col gap-6">
    {{-- Results Header Callout --}}
    <div class="flex items-center justify-center px-5 py-5 rounded-lg" style="background-color: #eff6ff; height: 68px;">
        <p class="text-base" style="color: #18181b;">
            We've found 5 cars of all categories near Subang Jaya
        </p>
    </div>

    {{-- Cars List --}}
    <div class="flex flex-col gap-8">
        @php
            $sampleCars = [
                [
                    'name' => 'Perodua Myvi',
                    'price' => '180.00',
                    'total_price' => '360.00',
                    'original_price' => '200.00',
                    'image' => asset('images/ara-logo.png'),
                    'transmission' => 'Auto',
                    'seats' => '4',
                    'doors' => '4',
                    'luggage' => '2',
                    'engine' => '1.5 L',
                    'fuel' => 'Petrol',
                    'location' => 'Bandar Puteri, Puchong, Selangor',
                    'hours' => 'Opening Hours: 09:00 AM - 05:00 PM',
                    'tags' => ['Group A', 'Compact', '10 Branch/es'],
                    'features' => ['ABS', 'EBD', 'Radar Cruise', 'Lane Assist', 'Bluetooth', 'Apple Car Play'],
                    'sale_tags' => [
                        ['text' => 'SALE', 'bg' => '#fff4ed', 'border' => '#ff9960', 'color' => '#fe7439'],
                        ['text' => '10% OFF TODAY', 'bg' => '#fe7439', 'border' => '#fe7439', 'color' => '#fff4ed'],
                    ],
                    'limited_offer' => true,
                    'variants' => [
                        [
                            'name' => 'Myvi 1.5H (M800)',
                            'location' => 'Bandar Puteri, Puchong, Selangor',
                            'price' => '200.00',
                            'total_price' => '400.00',
                            'features' => ['ABS', 'EBD', 'Radar Cruise', 'Lane Assist', 'Bluetooth', 'Apple Car Play'],
                        ],
                        [
                            'name' => 'Myvi 1.5H (M800)',
                            'location' => 'Puchong Perdana, Puchong, Selangor',
                            'price' => '180.00',
                            'total_price' => '360.00',
                            'original_price' => '200.00',
                            'sale' => true,
                            'features' => ['ABS', 'EBD', 'Radar Cruise', 'Lane Assist', 'Bluetooth', 'Apple Car Play'],
                        ],
                    ],
                ],
                [
                    'name' => 'Proton Saga',
                    'price' => '150.00',
                    'total_price' => '300.00',
                    'image' => asset('images/ara-logo.png'),
                    'transmission' => 'Manual',
                    'seats' => '5',
                    'doors' => '4',
                    'luggage' => '3',
                    'engine' => '1.3 L',
                    'fuel' => 'Petrol',
                    'location' => 'Puchong Perdana, Puchong, Selangor',
                    'hours' => 'Opening Hours: 09:00 AM - 05:00 PM',
                    'tags' => ['Group B', 'Sedan', '8 Branch/es'],
                    'features' => ['ABS', 'EBD', 'Bluetooth'],
                    'variants' => [],
                ],
                [
                    'name' => 'Honda City',
                    'price' => '250.00',
                    'total_price' => '500.00',
                    'image' => asset('images/ara-logo.png'),
                    'transmission' => 'Auto',
                    'seats' => '5',
                    'doors' => '4',
                    'luggage' => '3',
                    'engine' => '1.5 L',
                    'fuel' => 'Petrol',
                    'location' => 'Seksyen 13 Shah Alam, Shah Alam, Selangor',
                    'hours' => 'Opening Hours: 09:00 AM - 05:00 PM',
                    'tags' => ['Group C', 'Sedan', '6 Branch/es'],
                    'features' => ['ABS', 'EBD', 'Radar Cruise', 'Lane Assist', 'Bluetooth', 'Apple Car Play'],
                    'variants' => [],
                ],
            ];
        @endphp

        @foreach ($sampleCars as $index => $car)
            @include('web.search.components.car-card', ['car' => $car, 'index' => $index])
        @endforeach
    </div>

    {{-- Load More Button --}}
    <div class="flex items-center mt-8 h-5">
        <div class="flex-1 h-0 border-t" style="border-color: #e4e4e7;"></div>
        <button class="mx-4 " style="color: #18181b;">
            Load More
        </button>
        <div class="flex-1 h-0 border-t" style="border-color: #e4e4e7;"></div>
    </div>
</div>
