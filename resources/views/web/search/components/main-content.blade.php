{{-- Main Content Area - Matches Figma Design --}}
<div class="flex flex-col gap-6">
    {{-- Results Header Callout --}}
    <div class="flex gap-2 items-start px-3 py-3 rounded-lg" style="background-color: #f0fdf4;">
        {{-- Success Icon --}}
        <div class="flex justify-center items-start shrink-0">
            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M10 18.75C5.16797 18.75 1.25 14.832 1.25 10C1.25 5.16797 5.16797 1.25 10 1.25C14.832 1.25 18.75 5.16797 18.75 10C18.75 14.832 14.832 18.75 10 18.75ZM9.0625 13.75L15.6445 7.16797L14.4023 5.92578L9.0625 11.2656L6.39258 8.59375L5.15039 9.83594L9.0625 13.75Z"
                    fill="#15803d" stroke="#15803d" stroke-width="0.5" />
            </svg>
        </div>

        {{-- Text Content --}}
        <div class="flex flex-col flex-1 gap-1">
            <p class="text-sm font-semibold leading-[20px]" style="color: #15803d;">
                Success!
            </p>
            <p class="text-sm leading-[20px]" style="color: #18181b;">
                We've found 48 cars of all categories near Bandar Puteri, Puchong, Selangor
            </p>
        </div>
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
        <button class="mx-4" style="color: #18181b;">
            Load More
        </button>
        <div class="flex-1 h-0 border-t" style="border-color: #e4e4e7;"></div>
    </div>
</div>
