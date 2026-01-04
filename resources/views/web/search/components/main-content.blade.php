{{-- Main Content Area - Matches Figma Design --}}
<div class="flex flex-col gap-6" x-data="carListing()">
    {{-- Results Header Callout --}}
    <div class="flex gap-2 items-start px-2 py-2.5 rounded-lg" style="background-color: #f0fdf4;">
        {{-- Success Icon --}}
        <div class="flex justify-center items-start shrink-0">
            <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7 11.2143L8.12645 12.5116C8.55869 13.0095 9.34594 12.9601 9.71261 12.4122L13 7.5M17.25 10C17.25 14.0041 14.0041 17.25 10 17.25C5.99594 17.25 2.75 14.0041 2.75 10C2.75 5.99594 5.99594 2.75 10 2.75C14.0041 2.75 17.25 5.99594 17.25 10Z"
                    stroke="#15803D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

        {{-- Text Content --}}
        <div class="flex flex-col flex-1 ">
            <div class="flex items-center ">
                <p class="text-base font-medium leading-[20px]" style="color: #15803d;">
                    Success!
                </p>

            </div>
            <p class="text-base leading-[1px] font-light" style="color: #18181b;">
                We've found 48 cars of all categories near Bandar Puteri, Puchong, Selangor
            </p>

        </div>
    </div>

    {{-- Cars List --}}
    <div class="flex flex-col gap-8">
        @foreach($modelSpecs ?? [] as $modelSpec)
            @include('web.search.components.car-card', ['modelSpec' => $modelSpec])
        @endforeach
    </div>

    {{-- Old Sample Cars (Commented out) --}}
    {{-- @php
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
