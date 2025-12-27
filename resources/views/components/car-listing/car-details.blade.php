<div x-show="selectedCar" class="mb-8">
    <template x-if="selectedCar">
        <div class="overflow-hidden bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="flex flex-col lg:flex-row">
                <!-- Car Image and Details -->
                <div class="flex-shrink-0 p-6 lg:w-1/3">
                    <!-- Car Image on Red Circular Base -->
                    <div class="flex justify-center mb-4">
                        <div class="relative">
                            <img :src="selectedCar.model_specification ? selectedCar.model_specification.picture_url ||
                                '/images/car-placeholder.jpg' : '/images/car-placeholder.jpg'"
                                :alt="selectedCar.model_specification ? selectedCar.model_specification.model_name || 'Car' :
                                    'Car'"
                                class="object-contain w-[400px] h-auto">

                            <div x-show="selectedCar.is_promo"
                                class="absolute -top-2 -right-2 px-2 py-1 text-xs font-bold text-white bg-yellow-500 rounded-full">
                                PROMO
                            </div>
                        </div>
                    </div>

                    <!-- Car Name -->
                    <h3 class="mb-4 text-xl font-bold text-center text-gray-900"
                        x-text="selectedCar.model_specification ? selectedCar.model_specification.model_name || 'Unknown Model' : 'Unknown Model'">
                    </h3>

                    <!-- Car Specifications Row -->
                    <div class="flex flex-wrap gap-4 justify-center text-sm text-gray-600">
                        <!-- Luggage -->
                        <div class="flex items-center space-x-1">
                            <img src="/icons/luggage.svg" alt="Luggage" class="w-4 h-4">
                            <span
                                x-text="(selectedCar.model_specification ? selectedCar.model_specification.luggage : 'N/A') + ' Luggage'"></span>
                        </div>

                        <!-- Transmission -->
                        <div class="flex items-center space-x-1">
                            <img src="/icons/transmission.svg" alt="Transmission" class="w-4 h-4">
                            <span
                                x-text="selectedCar.model_specification ? (selectedCar.model_specification.transmission_type || 'Auto') : 'Auto'"></span>
                        </div>

                        <!-- Seats -->
                        <div class="flex items-center space-x-1">
                            <img src="/icons/seat.svg" alt="Seats" class="w-4 h-4">
                            <span
                                x-text="(selectedCar.model_specification ? selectedCar.model_specification.seats : 'N/A') + ' Seats'"></span>
                        </div>

                        <!-- Engine -->
                        <div class="flex items-center space-x-1">
                            <img src="/icons/engine.svg" alt="Engine" class="w-4 h-4">
                            <span
                                x-text="(selectedCar.model_specification ? selectedCar.model_specification.fuel_tank : 'N/A') + ' L'"></span>
                        </div>

                        <!-- Doors -->
                        <div class="flex items-center space-x-1">
                            <img src="/icons/door.svg" alt="Doors" class="w-4 h-4">
                            <span
                                x-text="(selectedCar.model_specification ? selectedCar.model_specification.doors : 'N/A') + ' Doors'"></span>
                        </div>

                        <!-- Fuel Type -->
                        <div class="flex items-center space-x-1">
                            <img src="/icons/petrol.svg" alt="Fuel Type" class="w-4 h-4">
                            <span
                                x-text="selectedCar.model_specification ? selectedCar.model_specification.fuel_type || 'Petrol' : 'Petrol'"></span>
                        </div>
                    </div>
                </div>

                <!-- Location-based Pricing Table -->
                <div class="flex-1 p-6 bg-gray-50 lg:w-2/3">
                    <!-- Loading State -->
                    <div x-show="loadingAvailableCars" class="flex justify-center items-center py-8">
                        <div class="w-8 h-8 rounded-full border-b-2 border-red-600 animate-spin"></div>
                        <span class="ml-2 text-gray-600">Loading available cars...</span>
                    </div>

                    <!-- Desktop Table (hidden on mobile) -->
                    <div x-show="!loadingAvailableCars && availableCars.length > 0"
                        class="hidden overflow-hidden bg-white rounded-lg md:block">
                        <!-- Table Header -->
                        <div class="grid grid-cols-4 gap-4 px-4 py-3 bg-gray-100 border-b border-gray-200">
                            <div class="text-sm font-semibold tracking-wide text-gray-700 uppercase">LOCATION</div>
                            <div class="text-sm font-semibold tracking-wide text-center text-gray-700 uppercase">PRICE
                                PER DAY (RM)</div>
                            <div class="text-sm font-semibold tracking-wide text-center text-gray-700 uppercase">
                                DELIVERY & PICKUP (RM)</div>
                            <div></div>
                        </div>

                        <!-- Table Rows -->
                        <div>
                            <template x-for="car in availableCars" :key="car.id">
                                <div
                                    class="grid grid-cols-4 gap-4 items-center px-4 py-3 border-b border-gray-200 last:border-b-0">
                                    <div>
                                        <div class="font-medium text-gray-900"
                                            x-text="car.branch_name + ', ' + car.branch_city"></div>
                                        <span x-show="car.is_promo"
                                            class="inline-block px-2 py-1 mt-1 text-xs font-bold text-white bg-yellow-500 rounded">Discount
                                            Promo Rate</span>
                                    </div>
                                    <div class="text-center">
                                        <div x-show="car.is_promo" class="text-sm text-gray-400 line-through"
                                            x-text="'RM ' + car.price_per_day"></div>
                                        <div class="font-semibold"
                                            :class="car.is_promo ? 'text-red-600' : 'text-gray-900'"
                                            x-text="'RM ' + (car.is_promo ? car.promo_price : car.price_per_day)"></div>
                                    </div>
                                    <div class="text-center" x-text="'RM ' + car.delivery_cost"></div>
                                    <div class="text-center">
                                        <button x-show="car.is_available" @click="goToBooking(car)"
                                            class="px-6 py-2 text-sm font-semibold text-white bg-red-600 rounded-md transition duration-200 hover:bg-red-700">
                                            Select This Car
                                        </button>
                                        <button x-show="!car.is_available" disabled
                                            class="px-6 py-2 text-sm font-semibold text-white bg-gray-400 rounded-md cursor-not-allowed">
                                            Fully Booked
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Mobile Card Layout (shown only on mobile) -->
                    <div x-show="!loadingAvailableCars && availableCars.length > 0" class="block space-y-4 md:hidden">
                        <template x-for="car in availableCars" :key="car.id">
                            <div class="p-4 bg-white rounded-lg border border-gray-200">
                                <div class="space-y-3">
                                    <div>
                                        <div class="text-lg font-medium text-gray-900"
                                            x-text="car.branch_name + ', ' + car.branch_city"></div>
                                        <span x-show="car.is_promo"
                                            class="inline-block px-2 py-1 mt-1 text-xs font-bold text-white bg-yellow-500 rounded">Discount
                                            Promo Rate</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="text-sm text-gray-600">Price Per Day (RM)</div>
                                            <div x-show="car.is_promo" class="text-sm text-gray-400 line-through"
                                                x-text="car.price_per_day"></div>
                                            <div class="text-lg font-semibold"
                                                :class="car.is_promo ? 'text-red-600' : 'text-gray-900'"
                                                x-text="car.is_promo ? car.promo_price : car.price_per_day"></div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-600">Delivery & Pickup (RM)</div>
                                            <div class="text-lg font-semibold" x-text="car.delivery_cost"></div>
                                        </div>
                                    </div>
                                    <button x-show="car.is_available" @click="goToBooking(car)"
                                        class="py-3 w-full text-sm font-semibold text-white bg-red-600 rounded-md transition duration-200 hover:bg-red-700">
                                        Select This Car
                                    </button>
                                    <button x-show="!car.is_available" disabled
                                        class="py-3 w-full text-sm font-semibold text-white bg-gray-400 rounded-md cursor-not-allowed">
                                        Fully Booked
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- No Available Cars Message -->
                    <div x-show="!loadingAvailableCars && availableCars.length === 0" class="text-center py-8">
                        <svg class="mx-auto w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No cars available</h3>
                        <p class="mt-1 text-sm text-gray-500">This car model is not available at any branch for the
                            selected dates.</p>
                    </div>
                </div>

                <!-- Mobile Card Layout (shown only on mobile) -->
                <div class="block space-y-4 md:hidden">
                    <!-- Location Card 1 -->
                    <div class="p-4 bg-white rounded-lg border border-gray-200">
                        <div class="space-y-3">
                            <div>
                                <div class="text-lg font-medium text-gray-900">Bandar Puteri Puchong, Selangor</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-sm text-gray-600">Price Per Day (RM)</div>
                                    <div class="text-lg font-semibold">1,000.00</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Delivery & Pickup (RM)</div>
                                    <div class="text-lg font-semibold">20.00</div>
                                </div>
                            </div>
                            <button
                                class="py-3 w-full text-sm font-semibold text-white bg-red-600 rounded-md transition duration-200 hover:bg-red-700">
                                Select This Car
                            </button>
                        </div>
                    </div>

                    <!-- Location Card 2 (Promo) -->
                    <div class="p-4 bg-white rounded-lg border border-gray-200">
                        <div class="space-y-3">
                            <div>
                                <div class="text-lg font-medium text-gray-900">Shah Alam, Selangor</div>
                                <span
                                    class="inline-block px-2 py-1 mt-1 text-xs font-bold text-white bg-yellow-500 rounded">Discount
                                    Promo Rate</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-sm text-gray-600">Price Per Day (RM)</div>
                                    <div class="text-sm text-gray-400 line-through">1,099.00</div>
                                    <div class="text-lg font-semibold text-red-600">990.00</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Delivery & Pickup (RM)</div>
                                    <div class="text-lg font-semibold">20.00</div>
                                </div>
                            </div>
                            <button
                                class="py-3 w-full text-sm font-semibold text-white bg-red-600 rounded-md transition duration-200 hover:bg-red-700">
                                Select This Car
                            </button>
                        </div>
                    </div>

                    <!-- Location Card 3 -->
                    <div class="p-4 bg-white rounded-lg border border-gray-200">
                        <div class="space-y-3">
                            <div>
                                <div class="text-lg font-medium text-gray-900">Setapak, Kuala Lumpur</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-sm text-gray-600">Price Per Day (RM)</div>
                                    <div class="text-lg font-semibold">1,000.00</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Delivery & Pickup (RM)</div>
                                    <div class="text-lg font-semibold">20.00</div>
                                </div>
                            </div>
                            <button
                                class="py-3 w-full text-sm font-semibold text-white bg-red-600 rounded-md transition duration-200 hover:bg-red-700">
                                Select This Car
                            </button>
                        </div>
                    </div>

                    <!-- Location Card 4 (Fully Booked) -->
                    <div class="p-4 bg-white rounded-lg border border-gray-200">
                        <div class="space-y-3">
                            <div>
                                <div class="text-lg font-medium text-gray-900">Subang Jaya, Selangor</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-sm text-gray-600">Price Per Day (RM)</div>
                                    <div class="text-lg font-semibold">1,050.00</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Delivery & Pickup (RM)</div>
                                    <div class="text-lg font-semibold">15.00</div>
                                </div>
                            </div>
                            <button disabled
                                class="py-3 w-full text-sm font-semibold text-white bg-gray-400 rounded-md cursor-not-allowed">
                                Fully Booked
                            </button>
                        </div>
                    </div>

                    <!-- Location Card 5 (Promo) -->
                    <div class="p-4 bg-white rounded-lg border border-gray-200">
                        <div class="space-y-3">
                            <div>
                                <div class="text-lg font-medium text-gray-900">USJ 1, Selangor</div>
                                <span
                                    class="inline-block px-2 py-1 mt-1 text-xs font-bold text-white bg-yellow-500 rounded">Discount
                                    Promo Rate</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-sm text-gray-600">Price Per Day (RM)</div>
                                    <div class="text-sm text-gray-400 line-through">1,099.00</div>
                                    <div class="text-lg font-semibold text-red-600">980.00</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Delivery & Pickup (RM)</div>
                                    <div class="text-lg font-semibold">10.00</div>
                                </div>
                            </div>
                            <button
                                class="py-3 w-full text-sm font-semibold text-white bg-red-600 rounded-md transition duration-200 hover:bg-red-700">
                                Select This Car
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</template>

<!-- Close Button -->
<div class="mt-4 text-center">
    <button @click="selectedCar = null"
        class="px-6 py-2 font-semibold text-white bg-gray-500 rounded-md transition duration-200 hover:bg-gray-600">
        Close Details
    </button>
</div>
</div>
