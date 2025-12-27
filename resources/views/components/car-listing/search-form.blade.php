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
                                <select id="InputStartTime" name="pickup_time" x-model="searchParams.pickup_time"
                                    class="py-3 pr-10 pl-10 w-full rounded-lg border border-gray-300 appearance-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <template x-for="time in timeOptions" :key="time">
                                        <option :value="time" x-text="time"></option>
                                    </template>
                                </select>
                                <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
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
                            <input type="hidden" id="return_latitude" x-model="searchParams.return_latitude">
                            <input type="hidden" id="return_longitude" x-model="searchParams.return_longitude">
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
                                <select id="InputReturnTime" name="return_time" x-model="searchParams.return_time"
                                    class="py-3 pr-10 pl-10 w-full rounded-lg border border-gray-300 appearance-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <template x-for="time in timeOptions" :key="time">
                                        <option :value="time" x-text="time"></option>
                                    </template>
                                </select>
                                <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
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
