@props(['car', 'searchParams'])

<div
    class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
    <!-- Car Image -->
    <div class="relative">
        <img src="{{ $car->model_specification->picture_url ?? '/images/car-placeholder.jpg' }}"
            alt="{{ $car->model_specification->model_name ?? 'Car' }}" class="w-full h-48 object-cover">

        <!-- Promo Badge -->
        @if ($car->is_promo)
            <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                PROMO
            </div>
        @endif

        <!-- Unavailable Overlay -->
        @if ($car->unavailable)
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="text-white text-center">
                    <div class="text-lg font-bold">LIMITED STOCK</div>
                </div>
            </div>
        @endif
    </div>

    <!-- Car Details -->
    <div class="p-4">
        <!-- Car Name -->
        <h3 class="text-lg font-semibold text-gray-900 mb-3 text-center">
            {{ Str::limit($car->model_specification->model_name ?? 'Unknown Model', 30) }}
        </h3>

        <!-- Car Specifications Grid -->
        <div class="grid grid-cols-3 gap-2 mb-4">
            <!-- Doors -->
            <div class="flex flex-col items-center text-center">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mb-1">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v4m8-4v4" />
                    </svg>
                </div>
                <span class="text-xs text-gray-600">{{ $car->model_specification->doors ?? 'N/A' }} Doors</span>
            </div>

            <!-- Seats -->
            <div class="flex flex-col items-center text-center">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mb-1">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <span class="text-xs text-gray-600">{{ $car->model_specification->seats ?? 'N/A' }} Seats</span>
            </div>

            <!-- Luggage -->
            <div class="flex flex-col items-center text-center">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mb-1">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-xs text-gray-600">{{ $car->model_specification->luggage ?? 'N/A' }} Bags</span>
            </div>

            <!-- Fuel Type -->
            <div class="flex flex-col items-center text-center">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mb-1">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-xs text-gray-600">{{ $car->model_specification->fuel_type ?? 'N/A' }}</span>
            </div>

            <!-- Engine -->
            <div class="flex flex-col items-center text-center">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mb-1">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <span class="text-xs text-gray-600">{{ $car->model_specification->fuel_tank ?? 'N/A' }} L</span>
            </div>

            <!-- Transmission -->
            <div class="flex flex-col items-center text-center">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mb-1">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="text-xs text-gray-600">{{ $car->model_specification->transmission_type ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Action Button -->
        <div class="mt-4">
            @if ($car->unavailable)
                <button class="w-full py-3 px-4 bg-gray-100 text-gray-500 rounded-lg font-semibold cursor-not-allowed">
                    Fully Booked
                </button>
            @else
                <form method="GET" action="{{ route('affiliate.car-listing.book', $car->id) }}" class="w-full">
                    <!-- Hidden inputs for search parameters -->
                    <input type="hidden" name="pickup_location" value="{{ $searchParams['pickup_location'] ?? '' }}">
                    <input type="hidden" name="return_location" value="{{ $searchParams['return_location'] ?? '' }}">
                    <input type="hidden" name="pickup_date" value="{{ $searchParams['pickup_date'] ?? '' }}">
                    <input type="hidden" name="return_date" value="{{ $searchParams['return_date'] ?? '' }}">
                    <input type="hidden" name="pickup_time" value="{{ $searchParams['pickup_time'] ?? '9:00 AM' }}">
                    <input type="hidden" name="return_time" value="{{ $searchParams['return_time'] ?? '9:00 AM' }}">

                    <button type="submit"
                        class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition duration-200 flex items-center justify-center">
                        <div class="flex items-baseline">
                            <span class="text-sm mr-1">RM</span>
                            <span class="text-lg font-bold">{{ number_format($car->total_price_perday) }}</span>
                            <span class="text-sm ml-1">/day</span>
                        </div>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
