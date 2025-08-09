@extends('layouts.app')

@section('title', 'Car Listing - Book Your Car')
@section('description', 'Browse and book cars for your rental needs')

@section('content')
    <x-affiliate-navbar :user="auth()->user()" headerText="Car Listing">
        <div x-data="carListing()" x-init="initCarListing()">
            <!-- Search Form -->
            <div class="p-6 mb-6 bg-white rounded-lg border border-gray-200 shadow-sm">
                <form @submit.prevent="searchCars" class="space-y-4">
                    <!-- Main Row: Start Block | Chevron | Return Block | Search Button -->
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start">
                        <!-- Start Block (Location + Date + Time) -->
                        <div class="flex-1">
                            <div class="space-y-4">
                                <!-- Start Location -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Start Location</label>
                                    <div class="relative">
                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="pickup_location" x-model="searchParams.pickup_location"
                                            class="py-3 pr-4 pl-10 w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                            placeholder="Enter pickup location">
                                        <input type="hidden" id="pickup_latitude" x-model="searchParams.pickup_latitude">
                                        <input type="hidden" id="pickup_longitude" x-model="searchParams.pickup_longitude">
                                    </div>
                                </div>

                                <!-- Start Date & Time -->
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Start Date -->
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Start Date</label>
                                        <div class="relative">
                                            <div class="flex absolute inset-y-0 left-0 items-center pl-3">
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="InputStartDate" name="pickup_date"
                                                x-model="searchParams.pickup_date"
                                                class="py-3 pr-4 pl-10 w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                                placeholder="dd-mm-yyyy" readonly>
                                            <button type="button" onclick="$('#InputStartDate').datepicker('show')"
                                                class="absolute right-2 top-1/2 text-gray-400 transform -translate-y-1/2 hover:text-gray-600">
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Start Time -->
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Start Time</label>
                                        <div class="relative">
                                            <div class="flex absolute inset-y-0 left-0 items-center pl-3">
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <select id="InputStartTime" name="pickup_time"
                                                x-model="searchParams.pickup_time"
                                                class="py-3 pr-10 pl-10 w-full rounded-lg border border-gray-300 appearance-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                                <template x-for="time in timeOptions" :key="time">
                                                    <option :value="time" x-text="time"></option>
                                                </template>
                                            </select>
                                            <div
                                                class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chevron Icon -->
                        <div class="hidden justify-center items-center pt-10 md:flex">
                            <svg class="w-8 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 32 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 5l7 7-7 7" />
                            </svg>
                        </div>

                        <!-- Return Block (Location + Date + Time) -->
                        <div class="flex-1">
                            <div class="space-y-4">
                                <!-- Return Location -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">Return Location</label>
                                    <div class="relative">
                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="return_location" x-model="searchParams.return_location"
                                            class="py-3 pr-4 pl-10 w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                            placeholder="Enter return location">
                                        <input type="hidden" id="return_latitude"
                                            x-model="searchParams.return_latitude">
                                        <input type="hidden" id="return_longitude"
                                            x-model="searchParams.return_longitude">
                                    </div>
                                </div>

                                <!-- Return Date & Time -->
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Return Date -->
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Return Date</label>
                                        <div class="relative">
                                            <div class="flex absolute inset-y-0 left-0 items-center pl-3">
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="InputReturnDate" name="return_date"
                                                x-model="searchParams.return_date"
                                                class="py-3 pr-4 pl-10 w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                                placeholder="dd-mm-yyyy" readonly>
                                            <button type="button" onclick="$('#InputReturnDate').datepicker('show')"
                                                class="absolute right-2 top-1/2 text-gray-400 transform -translate-y-1/2 hover:text-gray-600">
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Return Time -->
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Return Time</label>
                                        <div class="relative">
                                            <div class="flex absolute inset-y-0 left-0 items-center pl-3">
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <select id="InputReturnTime" name="return_time"
                                                x-model="searchParams.return_time"
                                                class="py-3 pr-10 pl-10 w-full rounded-lg border border-gray-300 appearance-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                                <template x-for="time in timeOptions" :key="time">
                                                    <option :value="time" x-text="time"></option>
                                                </template>
                                            </select>
                                            <div
                                                class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search Button Block -->
                        <div class="flex justify-start items-start pt-7">
                            <button type="submit"
                                class="flex items-start px-8 min-w-[200px] py-3 space-x-2 font-semibold text-white bg-orange-500 rounded-lg transition duration-200 hover:bg-orange-600 text-center">

                                <span class="m-auto text-center">Search</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Filters and Results -->
            <div x-show="hasSearched" class="p-6 bg-white rounded-t-lg border border-gray-200 shadow-sm">
                <!-- Category Filters -->
                <div class="flex flex-wrap mb-4">
                    <button @click="setCategory('All')"
                        :class="searchParams.category.includes('All') ? 'bg-red-600 text-white shadow-md' :
                            'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'"
                        class="px-3 py-3 font-medium rounded-tl-lg shadow-sm transition duration-200">
                        All
                    </button>
                    <template x-for="(category, index) in categories" :key="category">
                        <button @click="toggleCategory(category)"
                            :class="[
                                searchParams.category.includes(category) ? 'bg-red-600 text-white shadow-md' :
                                'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50',
                                index === categories.length - 1 ? 'rounded-tr-lg' : ''
                            ]"
                            class="px-3 py-3 font-medium shadow-sm transition duration-200" x-text="category">
                        </button>
                    </template>
                </div>

                <!-- Results Count -->
                <div class="mb-6">
                    <p class="text-lg text-gray-700">
                        We've found <span class="font-bold text-red-600" x-text="carModels.length"></span> cars available

                    </p>
                </div>

                <!-- Loading State -->
                <div x-show="loading" class="flex justify-center items-center py-12">
                    <div class="w-12 h-12 rounded-full border-b-2 border-red-600 animate-spin"></div>
                </div>

                <!-- Selected Car Detail Section -->
                <div x-show="selectedCar" class="mb-8">
                    <template x-if="selectedCar">
                        <div class="overflow-hidden bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex flex-col lg:flex-row">
                                <!-- Car Image and Details -->
                                <div class="p-6 lg:w-1/2">
                                    <!-- Car Image on Red Circular Base -->
                                    <div class="flex justify-center mb-4">
                                        <div class="relative">

                                            <img :src="selectedCar.model_specification ? selectedCar.model_specification
                                                .picture_url || '/images/car-placeholder.jpg' :
                                                '/images/car-placeholder.jpg'"
                                                :alt="selectedCar.model_specification ? selectedCar.model_specification
                                                    .model_name || 'Car' : 'Car'"
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
                                <div class="p-6 bg-gray-50 lg:w-1/2">
                                    <!-- Desktop Table (hidden on mobile) -->
                                    <div class="hidden overflow-hidden bg-white rounded-lg md:block">
                                        <!-- Table Header -->
                                        <div class="grid grid-cols-4 gap-4 px-4 py-3 bg-gray-100 border-b border-gray-200">
                                            <div class="text-sm font-semibold tracking-wide text-gray-700 uppercase">
                                                LOCATION</div>
                                            <div
                                                class="text-sm font-semibold tracking-wide text-center text-gray-700 uppercase">
                                                PRICE PER DAY (RM)</div>
                                            <div
                                                class="text-sm font-semibold tracking-wide text-center text-gray-700 uppercase">
                                                DELIVERY & PICKUP (RM)</div>
                                            <div></div>
                                        </div>

                                        <!-- Table Rows -->
                                        <div>
                                            <!-- Row 1 -->
                                            <div
                                                class="grid grid-cols-4 gap-4 items-center px-4 py-3 border-b border-gray-200">
                                                <div class="font-medium text-gray-900">Bandar Puteri Puchong, Sel...</div>
                                                <div class="font-semibold text-center">1,000.00</div>
                                                <div class="text-center">20.00</div>
                                                <div class="text-center">
                                                    <button
                                                        class="px-6 py-2 text-sm font-semibold text-white bg-red-600 rounded-md transition duration-200 hover:bg-red-700">
                                                        Select This Car
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Row 2 (Promo) -->
                                            <div
                                                class="grid grid-cols-4 gap-4 items-center px-4 py-3 border-b border-gray-200">
                                                <div>
                                                    <div class="font-medium text-gray-900">Shah Alam, Selangor</div>
                                                    <span
                                                        class="inline-block px-2 py-1 mt-1 text-xs font-bold text-white bg-yellow-500 rounded">Discount
                                                        Promo Rate</span>
                                                </div>
                                                <div class="text-center">
                                                    <div class="text-sm text-gray-400 line-through">1,099</div>
                                                    <div class="font-semibold text-red-600">990.00</div>
                                                </div>
                                                <div class="text-center">20.00</div>
                                                <div class="text-center">
                                                    <button
                                                        class="px-6 py-2 text-sm font-semibold text-white bg-red-600 rounded-md transition duration-200 hover:bg-red-700">
                                                        Select This Car
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Row 3 -->
                                            <div
                                                class="grid grid-cols-4 gap-4 items-center px-4 py-3 border-b border-gray-200">
                                                <div class="font-medium text-gray-900">Setapak, Kuala Lumpur</div>
                                                <div class="font-semibold text-center">1,000.00</div>
                                                <div class="text-center">20.00</div>
                                                <div class="text-center">
                                                    <button
                                                        class="px-6 py-2 text-sm font-semibold text-white bg-red-600 rounded-md transition duration-200 hover:bg-red-700">
                                                        Select This Car
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Row 4 (Fully Booked) -->
                                            <div
                                                class="grid grid-cols-4 gap-4 items-center px-4 py-3 border-b border-gray-200">
                                                <div class="font-medium text-gray-900">Subang Jaya, Selangor</div>
                                                <div class="font-semibold text-center">1,050.00</div>
                                                <div class="text-center">15.00</div>
                                                <div class="text-center">
                                                    <button disabled
                                                        class="px-6 py-2 text-sm font-semibold text-white bg-gray-400 rounded-md cursor-not-allowed">
                                                        Fully Booked
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Row 5 (Promo) -->
                                            <div class="grid grid-cols-4 gap-4 items-center px-4 py-3">
                                                <div>
                                                    <div class="font-medium text-gray-900">USJ 1, Selangor</div>
                                                    <span
                                                        class="inline-block px-2 py-1 mt-1 text-xs font-bold text-white bg-yellow-500 rounded">Discount
                                                        Promo Rate</span>
                                                </div>
                                                <div class="text-center">
                                                    <div class="text-sm text-gray-400 line-through">1,099</div>
                                                    <div class="font-semibold text-red-600">980.00</div>
                                                </div>
                                                <div class="text-center">10.00</div>
                                                <div class="text-center">
                                                    <button
                                                        class="px-6 py-2 text-sm font-semibold text-white bg-red-600 rounded-md transition duration-200 hover:bg-red-700">
                                                        Select This Car
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mobile Card Layout (shown only on mobile) -->
                                    <div class="block space-y-4 md:hidden">
                                        <!-- Location Card 1 -->
                                        <div class="p-4 bg-white rounded-lg border border-gray-200">
                                            <div class="space-y-3">
                                                <div>
                                                    <div class="text-lg font-medium text-gray-900">Bandar Puteri Puchong,
                                                        Selangor</div>
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
                                                    <div class="text-lg font-medium text-gray-900">Shah Alam, Selangor
                                                    </div>
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
                                                    <div class="text-lg font-medium text-gray-900">Setapak, Kuala Lumpur
                                                    </div>
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
                                                    <div class="text-lg font-medium text-gray-900">Subang Jaya, Selangor
                                                    </div>
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

                <!-- Car Grid -->
                <div x-show="!loading" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <template x-for="car in carModels" :key="car.id">
                        <div class="overflow-hidden bg-white rounded-lg border border-gray-200 shadow-sm transition-shadow duration-200 hover:shadow-md  md:min-w-[250px]"
                            @click="selectCar(car)">
                            <!-- Car Image -->
                            <div class="flex relative justify-center items-center  aspect-square md:m-w-[250px]">

                                <img :src="car.model_specification ? car.model_specification.picture_url ||
                                    '/images/car-placeholder.jpg' : '/images/car-placeholder.jpg'"
                                    :alt="car.model_specification ? car.model_specification.model_name || 'Car' : 'Car'"
                                    class="object-contain w-full h-auto">

                                <!-- Promo Badge -->
                                <div x-show="car.is_promo"
                                    class="absolute top-2 right-2 px-2 py-1 text-xs font-bold text-white bg-yellow-500 rounded-full">
                                    PROMO
                                </div>
                            </div>

                            <!-- Car Details -->
                            <div>
                                <!-- Car Name -->
                                <h3 class="mb-4 text-lg font-bold text-center text-gray-900"
                                    x-text="car.model_specification ? car.model_specification.model_name || 'Unknown Model' : 'Unknown Model'">
                                </h3>

                                <!-- Car Specifications Grid -->
                                <div class="grid grid-cols-3 gap-3 mx-3 mb-4">
                                    <!-- Luggage -->
                                    <div class="flex items-center space-x-2">
                                        <img src="/icons/luggage.svg" alt="Luggage" class="w-4 h-4 text-gray-500">
                                        <span class="text-xs text-gray-500"
                                            x-text="(car.model_specification ? car.model_specification.luggage : 'N/A') + ' Luggage'"></span>
                                    </div>

                                    <!-- Seats -->
                                    <div class="flex items-center space-x-2">
                                        <img src="/icons/seat.svg" alt="Seats" class="w-4 h-4 text-gray-500">
                                        <span class="text-xs text-gray-500"
                                            x-text="(car.model_specification ? car.model_specification.seats : 'N/A') + ' Seats'"></span>
                                    </div>

                                    <!-- Doors -->
                                    <div class="flex items-center space-x-2">
                                        <img src="/icons/door.svg" alt="Doors" class="w-4 h-4 text-gray-500">
                                        <span class="text-xs text-gray-500"
                                            x-text="(car.model_specification ? car.model_specification.doors : 'N/A') + ' Doors'"></span>
                                    </div>

                                    <!-- Transmission -->
                                    <div class="flex items-center space-x-2">
                                        <img src="/icons/transmission.svg" alt="Transmission"
                                            class="w-4 h-4 text-gray-500">
                                        <span class="text-xs text-gray-500"
                                            x-text="car.model_specification ? (car.model_specification.transmission_type || 'Auto') : 'Auto'"></span>
                                    </div>

                                    <!-- Engine -->
                                    <div class="flex items-center space-x-2">
                                        <img src="/icons/engine.svg" alt="Engine" class="w-4 h-4 text-gray-500">
                                        <span class="text-xs text-gray-500"
                                            x-text="(car.model_specification ? car.model_specification.fuel_tank : 'N/A') + ' L'"></span>
                                    </div>

                                    <!-- Fuel Type -->
                                    <div class="flex items-center space-x-2">
                                        <img src="/icons/petrol.svg" alt="Fuel Type" class="w-4 h-4 text-gray-500">
                                        <span class="text-xs text-gray-500"
                                            x-text="car.model_specification ? car.model_specification.fuel_type || 'Petrol' : 'Petrol'"></span>
                                    </div>
                                </div>

                                <!-- Action Section -->
                                <div class="mt-4">
                                    <!-- Unavailable Car -->
                                    <div x-show="car.unavailable"
                                        class="px-4 py-3 w-full font-semibold text-gray-700 bg-gray-200 rounded-b-lg">
                                        Fully Booked
                                    </div>

                                    <!-- Available Car (Clickable) -->
                                    <div x-show="!car.unavailable"
                                        class="block px-4 py-3 w-full font-semibold text-center text-white bg-red-600 rounded-b-lg transition duration-200 hover:bg-red-700">
                                        View More
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- No Results -->
                <div x-show="!loading && carModels.length === 0" class="py-12 text-center">
                    <svg class="mx-auto w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No cars found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria.</p>
                </div>

                <!-- Load More Button -->
                <div x-show="!loading && carModels.length > 0" class="mt-8 text-center">
                    <button class="font-medium text-gray-600 transition duration-200 hover:text-gray-800">
                        Load More
                    </button>
                </div>
            </div>

            <!-- Initial State - Before Search -->
            <div x-show="!hasSearched" class="p-12 text-center bg-white rounded-lg border border-gray-200 shadow-sm">
                <svg class="mx-auto mb-4 w-16 h-16 text-gray-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="mb-2 text-lg font-medium text-gray-900">Search for Available Cars</h3>
                <p class="mb-6 text-gray-500">Enter your pickup and return details to find available cars</p>

            </div>
        </div>
    </x-affiliate-navbar>

    <script src="{{ asset('js/date-time-picker.js') }}"></script>
    <script>
        // Direct date picker initialization
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing date pickers directly...');

            function initDatePickers() {
                if (typeof $ !== 'undefined' && $.fn.datepicker) {
                    console.log('jQuery and datepicker available, initializing...');

                    // Initialize Start Date Picker
                    if ($('#InputStartDate').length) {
                        $('#InputStartDate').datepicker({
                            format: 'dd-mm-yyyy',
                            autoclose: true,
                            startDate: '+1d',
                            endDate: '+1y',
                            todayHighlight: false,
                            clearBtn: true,
                            orientation: 'bottom auto',
                            beforeShowDay: function(date) {
                                // Disable today and past dates
                                var today = new Date();
                                today.setHours(0, 0, 0, 0);
                                return [date >= today, ''];
                            }
                        });
                        console.log('Start date picker initialized');
                    }

                    // Initialize Return Date Picker
                    if ($('#InputReturnDate').length) {
                        $('#InputReturnDate').datepicker({
                            format: 'dd-mm-yyyy',
                            autoclose: true,
                            startDate: '+0d',
                            todayHighlight: true,
                            clearBtn: true,
                            orientation: 'bottom auto'
                        });
                        console.log('Return date picker initialized');
                    }
                } else {
                    console.log('jQuery or datepicker not available, retrying...');
                    setTimeout(initDatePickers, 500);
                }
            }

            initDatePickers();
        });
    </script>
    <script>
        function carListing() {
            return {
                loading: false,
                hasSearched: false,
                carModels: [],
                selectedCar: null,
                categories: @json($categories),
                searchParams: {
                    pickup_location: '{{ $searchParams['pickup_location'] ?? '' }}',
                    return_location: '{{ $searchParams['return_location'] ?? '' }}',
                    pickup_latitude: '{{ $searchParams['pickup_latitude'] ?? '' }}',
                    pickup_longitude: '{{ $searchParams['pickup_longitude'] ?? '' }}',
                    return_latitude: '{{ $searchParams['return_latitude'] ?? '' }}',
                    return_longitude: '{{ $searchParams['return_longitude'] ?? '' }}',
                    pickup_date: '{{ $searchParams['pickup_date'] ?? '' }}',
                    return_date: '{{ $searchParams['return_date'] ?? '' }}',
                    pickup_time: '{{ $searchParams['pickup_time'] ?? '9:00 AM' }}',
                    return_time: '{{ $searchParams['return_time'] ?? '9:00 AM' }}',
                    min_price: {{ $searchParams['min_price'] ?? 0 }},
                    max_price: {{ $searchParams['max_price'] ?? 1500 }},
                    category: @json($searchParams['category'] ?? ['All']),
                    sort_by: '{{ $searchParams['sort_by'] ?? 'ASC' }}'
                },
                timeOptions: [
                    '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM',
                    '12:00 PM', '12:30 PM', '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM',
                    '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM', '5:00 PM', '5:30 PM',
                    '6:00 PM', '6:30 PM', '7:00 PM', '7:30 PM', '8:00 PM', '8:30 PM',
                    '9:00 PM', '9:30 PM', '10:00 PM', '10:30 PM', '11:00 PM'
                ],

                initCarListing() {
                    // Initialize with current search params
                    console.log('Available categories:', this.categories);
                    console.log('Initial search params:', this.searchParams);

                    // Check if there are search parameters in URL to determine if search has been performed
                    const urlParams = new URLSearchParams(window.location.search);
                    const hasSearchParams = urlParams.has('pickup_location') || urlParams.has('return_location') ||
                        urlParams.has('pickup_date') || urlParams.has('return_date');

                    console.log('Has search params:', hasSearchParams);
                    console.log('URL params:', Object.fromEntries(urlParams.entries()));

                    if (hasSearchParams) {
                        this.hasSearched = true;
                        // Load initial cars if search params exist
                        this.loadInitialCars();
                    }

                    this.updateUrl();
                    this.initializeDateTimePicker();
                    this.initializeGooglePlaces();
                },

                async loadInitialCars() {
                    // Load cars based on URL parameters on page load
                    if (this.hasSearched) {
                        await this.searchCars();
                    }
                },

                initializeDateTimePicker() {
                    // Initialize date picker after Alpine.js is ready
                    this.$nextTick(() => {
                        // Wait for dateTimePicker to be available
                        const checkDateTimePicker = () => {
                            if (window.dateTimePicker) {
                                this.syncDateTimeWithPicker();
                            } else {
                                setTimeout(checkDateTimePicker, 100);
                            }
                        };
                        checkDateTimePicker();
                    });
                },

                syncDateTimeWithPicker() {
                    // Update Alpine.js data when date picker changes
                    $('#InputStartDate').on('changeDate', (e) => {
                        this.searchParams.pickup_date = this.formatDateForAlpine(e.date);
                        this.updateUrl();
                    });

                    $('#InputReturnDate').on('changeDate', (e) => {
                        this.searchParams.return_date = this.formatDateForAlpine(e.date);
                        this.updateUrl();
                    });

                    // Update time selections
                    $('select[name="pickup_time"]').on('change', (e) => {
                        this.searchParams.pickup_time = e.target.value;
                        this.updateUrl();
                    });

                    $('select[name="return_time"]').on('change', (e) => {
                        this.searchParams.return_time = e.target.value;
                        this.updateUrl();
                    });
                },

                formatDateForAlpine(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${day}-${month}-${year}`;
                },

                async searchCars() {
                    console.log('Searching cars with params:', this.searchParams);
                    this.loading = true;
                    this.hasSearched = true;
                    try {
                        const response = await fetch('{{ route('affiliate.car-listing.search') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify(this.searchParams)
                        });

                        const data = await response.json();
                        console.log('Search response:', data);
                        if (data.success) {
                            this.carModels = data.data;
                            console.log('Updated carModels count:', this.carModels.length);
                            console.log('Car models:', this.carModels);
                            this.updateUrl();
                        } else {
                            console.error('Search failed:', data.message || 'Unknown error');
                        }
                    } catch (error) {
                        console.error('Error searching cars:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                setCategory(category) {
                    console.log('Setting category to:', category);
                    if (category === 'All') {
                        this.searchParams.category = ['All'];
                    } else {
                        this.searchParams.category = [category];
                    }
                    console.log('Updated searchParams.category:', this.searchParams.category);
                    this.hasSearched = true;
                    this.searchCars();
                },

                toggleCategory(category) {
                    console.log('Toggling category:', category);
                    console.log('Current categories:', this.searchParams.category);

                    if (this.searchParams.category.includes(category)) {
                        // Remove the category
                        this.searchParams.category = this.searchParams.category.filter(c => c !== category);
                        // If no categories left, default to "All"
                        if (this.searchParams.category.length === 0) {
                            this.searchParams.category = ['All'];
                        }
                        console.log('Removed category, new list:', this.searchParams.category);
                    } else {
                        // Remove "All" if it's currently selected
                        this.searchParams.category = this.searchParams.category.filter(c => c !== 'All');
                        // Add the new category
                        this.searchParams.category.push(category);
                        console.log('Added category, new list:', this.searchParams.category);
                    }
                    this.hasSearched = true;
                    this.searchCars();
                },

                toggleSort() {
                    this.searchParams.sort_by = this.searchParams.sort_by === 'ASC' ? 'DESC' : 'ASC';
                    this.hasSearched = true;
                    this.searchCars();
                },

                updateUrl() {
                    const params = new URLSearchParams();
                    Object.keys(this.searchParams).forEach(key => {
                        if (this.searchParams[key] !== '' && this.searchParams[key] !== null) {
                            if (Array.isArray(this.searchParams[key])) {
                                this.searchParams[key].forEach(value => {
                                    params.append(key + '[]', value);
                                });
                            } else {
                                params.set(key, this.searchParams[key]);
                            }
                        }
                    });

                    const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
                    window.history.pushState({}, '', newUrl);
                },

                initializeGooglePlaces() {
                    // Wait for Google Maps API to be loaded
                    if (typeof google !== 'undefined' && google.maps && google.maps.places) {
                        this.setupPickupLocationAutocomplete();
                        this.setupReturnLocationAutocomplete();
                    } else {
                        // Retry after a short delay
                        setTimeout(() => this.initializeGooglePlaces(), 1000);
                    }
                },

                setupPickupLocationAutocomplete() {
                    const options = {
                        componentRestrictions: {
                            country: "my"
                        }
                    };

                    const input = document.getElementById('pickup_location');
                    if (input) {
                        const autocomplete = new google.maps.places.Autocomplete(input, options);
                        google.maps.event.addListener(autocomplete, 'place_changed', () => {
                            const place = autocomplete.getPlace();
                            this.searchParams.pickup_location = place.name;
                            this.searchParams.pickup_latitude = place.geometry.location.lat();
                            this.searchParams.pickup_longitude = place.geometry.location.lng();
                            this.updateUrl();
                        });
                    }
                },

                setupReturnLocationAutocomplete() {
                    const options = {
                        componentRestrictions: {
                            country: "my"
                        }
                    };

                    const input = document.getElementById('return_location');
                    if (input) {
                        const autocomplete = new google.maps.places.Autocomplete(input, options);
                        google.maps.event.addListener(autocomplete, 'place_changed', () => {
                            const place = autocomplete.getPlace();
                            this.searchParams.return_location = place.name;
                            this.searchParams.return_latitude = place.geometry.location.lat();
                            this.searchParams.return_longitude = place.geometry.location.lng();
                            this.updateUrl();
                        });
                    }
                },

                selectCar(car) {
                    console.log('Selected car:', car);
                    this.selectedCar = car;
                    // Scroll to the selected car section
                    this.$nextTick(() => {
                        const selectedSection = document.querySelector('[x-show="selectedCar"]');
                        if (selectedSection) {
                            selectedSection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                }
            }
        }
    </script>

    <!-- Google Maps API -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('google.maps.api_key') }}&libraries=places&callback=Function.prototype"
        async defer></script>
@endsection
