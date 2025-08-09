@extends('layouts.app')

@section('title', 'Book Car - ' . ($carModel->model_specification->model_name ?? 'Car'))
@section('description', 'Confirm your car booking')

@section('content')
    <x-affiliate-navbar :user="auth()->user()" headerText="Book Car">
        <div x-data="carListing()" x-init="initCarListing()">
            <!-- Search Form -->
            <x-car-search-form />

            <!-- Booking Details -->
            <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Book Your Car</h1>
                    <a href="{{ route('affiliate.car-listing.index') }}" class="font-medium text-red-600 hover:text-red-700">
                        ← Back to Car Listing
                    </a>
                </div>

                <!-- Featured Car Section (Main Car) -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden mb-8">
                    <div class="flex flex-col lg:flex-row">
                        <!-- Car Image and Details -->
                        <div class="lg:w-1/3 p-6">
                            <!-- Car Image on Red Circular Base -->
                            <div class="flex justify-center mb-4">
                                <div class="relative">
                                    <div class="w-48 h-48 bg-red-600 rounded-full flex items-center justify-center">
                                        <img src="{{ $carModel->model_specification->picture_url ?? '/images/car-placeholder.jpg' }}"
                                            alt="{{ $carModel->model_specification->model_name ?? 'Car' }}"
                                            class="w-40 h-40 object-contain">
                                    </div>
                                    @if ($carModel->is_promo ?? false)
                                        <div
                                            class="absolute -top-2 -right-2 px-2 py-1 text-xs font-bold text-white bg-yellow-500 rounded-full">
                                            PROMO
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Car Name -->
                            <h3 class="text-xl font-bold text-center text-gray-900 mb-4">
                                {{ $carModel->model_specification->model_name ?? 'Unknown Model' }}
                            </h3>

                            <!-- Car Specifications Row -->
                            <div class="flex flex-wrap justify-center gap-4 text-sm text-gray-600">
                                <!-- Luggage -->
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/luggage.svg" alt="Luggage" class="w-4 h-4">
                                    <span>{{ $carModel->model_specification->luggage ?? 'N/A' }} Luggage</span>
                                </div>

                                <!-- Transmission -->
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/transmission.svg" alt="Transmission" class="w-4 h-4">
                                    <span>{{ $carModel->model_specification->transmission_type ?? 'Auto' }}</span>
                                </div>

                                <!-- Seats -->
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/seat.svg" alt="Seats" class="w-4 h-4">
                                    <span>{{ $carModel->model_specification->seats ?? 'N/A' }} Seats</span>
                                </div>

                                <!-- Engine -->
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/engine.svg" alt="Engine" class="w-4 h-4">
                                    <span>{{ $carModel->model_specification->fuel_tank ?? 'N/A' }} L</span>
                                </div>

                                <!-- Doors -->
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/door.svg" alt="Doors" class="w-4 h-4">
                                    <span>{{ $carModel->model_specification->doors ?? 'N/A' }} Doors</span>
                                </div>

                                <!-- Fuel Type -->
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/petrol.svg" alt="Fuel Type" class="w-4 h-4">
                                    <span>{{ $carModel->model_specification->fuel_type ?? 'Petrol' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Location-based Pricing Table -->
                        <div class="lg:w-2/3 bg-gray-50 p-6">
                            <!-- Table -->
                            <div class="bg-white rounded-lg overflow-hidden">
                                <!-- Table Header -->
                                <div class="grid grid-cols-4 gap-4 py-3 px-4 bg-gray-100 border-b border-gray-200">
                                    <div class="text-sm font-semibold text-gray-700 uppercase tracking-wide">LOCATION</div>
                                    <div class="text-sm font-semibold text-gray-700 uppercase tracking-wide text-center">
                                        PRICE PER DAY (RM)</div>
                                    <div class="text-sm font-semibold text-gray-700 uppercase tracking-wide text-center">
                                        DELIVERY & PICKUP (RM)</div>
                                    <div></div>
                                </div>

                                <!-- Table Rows -->
                                <div>
                                    <!-- Row 1 -->
                                    <div class="grid grid-cols-4 gap-4 items-center py-3 px-4 border-b border-gray-200">
                                        <div class="font-medium text-gray-900">Bandar Puteri Puchong, Sel...</div>
                                        <div class="text-center font-semibold">1,000.00</div>
                                        <div class="text-center">20.00</div>
                                        <div class="text-center">
                                            <button
                                                class="px-6 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition duration-200">
                                                Select This Car
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Row 2 (Promo) -->
                                    <div class="grid grid-cols-4 gap-4 items-center py-3 px-4 border-b border-gray-200">
                                        <div>
                                            <div class="font-medium text-gray-900">Shah Alam, Selangor</div>
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-bold text-white bg-yellow-500 rounded mt-1">Discount
                                                Promo Rate</span>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-gray-400 line-through text-sm">1,099</div>
                                            <div class="font-semibold text-red-600">990.00</div>
                                        </div>
                                        <div class="text-center">20.00</div>
                                        <div class="text-center">
                                            <button
                                                class="px-6 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition duration-200">
                                                Select This Car
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Row 3 -->
                                    <div class="grid grid-cols-4 gap-4 items-center py-3 px-4 border-b border-gray-200">
                                        <div class="font-medium text-gray-900">Setapak, Kuala Lumpur</div>
                                        <div class="text-center font-semibold">1,000.00</div>
                                        <div class="text-center">20.00</div>
                                        <div class="text-center">
                                            <button
                                                class="px-6 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition duration-200">
                                                Select This Car
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Row 4 (Fully Booked) -->
                                    <div class="grid grid-cols-4 gap-4 items-center py-3 px-4 border-b border-gray-200">
                                        <div class="font-medium text-gray-900">Subang Jaya, Selangor</div>
                                        <div class="text-center font-semibold">1,050.00</div>
                                        <div class="text-center">15.00</div>
                                        <div class="text-center">
                                            <button disabled
                                                class="px-6 py-2 bg-gray-400 text-white text-sm font-semibold rounded-md cursor-not-allowed">
                                                Fully Booked
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Row 5 (Promo) -->
                                    <div class="grid grid-cols-4 gap-4 items-center py-3 px-4">
                                        <div>
                                            <div class="font-medium text-gray-900">USJ 1, Selangor</div>
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-bold text-white bg-yellow-500 rounded mt-1">Discount
                                                Promo Rate</span>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-gray-400 line-through text-sm">1,099</div>
                                            <div class="font-semibold text-red-600">980.00</div>
                                        </div>
                                        <div class="text-center">10.00</div>
                                        <div class="text-center">
                                            <button
                                                class="px-6 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition duration-200">
                                                Select This Car
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Cars Grid -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-8">
                    <!-- BMW 320D M-Sport (F30) -->
                    <div
                        class="overflow-hidden bg-white rounded-lg border border-gray-200 shadow-sm transition-shadow duration-200 hover:shadow-md">
                        <div class="flex justify-center p-4">
                            <div class="w-32 h-32 bg-red-600 rounded-full flex items-center justify-center">
                                <img src="/images/bmw-320d.jpg" alt="BMW 320D M-Sport" class="w-28 h-28 object-contain">
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <h3 class="text-lg font-bold text-center text-gray-900 mb-3">BMW 320D M-Sport (F30)</h3>
                            <div class="flex flex-wrap justify-center gap-3 text-xs text-gray-600 mb-4">
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/luggage.svg" alt="Luggage" class="w-3 h-3">
                                    <span>4 Luggage</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/seat.svg" alt="Seats" class="w-3 h-3">
                                    <span>10 Seats</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/door.svg" alt="Doors" class="w-3 h-3">
                                    <span>4 Doors</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/transmission.svg" alt="Transmission" class="w-3 h-3">
                                    <span>Auto</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/engine.svg" alt="Engine" class="w-3 h-3">
                                    <span>3.0 L</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/petrol.svg" alt="Fuel" class="w-3 h-3">
                                    <span>Petrol</span>
                                </div>
                            </div>
                            <div
                                class="block px-4 py-3 w-full font-semibold text-center text-white bg-red-600 rounded-b-lg transition duration-200 hover:bg-red-700 cursor-pointer">
                                View More
                            </div>
                        </div>
                    </div>

                    <!-- Honda CR-V -->
                    <div
                        class="overflow-hidden bg-white rounded-lg border border-gray-200 shadow-sm transition-shadow duration-200 hover:shadow-md">
                        <div class="flex justify-center p-4">
                            <div class="w-32 h-32 bg-red-600 rounded-full flex items-center justify-center">
                                <img src="/images/honda-crv.jpg" alt="Honda CR-V" class="w-28 h-28 object-contain">
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <h3 class="text-lg font-bold text-center text-gray-900 mb-3">Honda CR-V (5th Generation)
                            </h3>
                            <div class="flex flex-wrap justify-center gap-3 text-xs text-gray-600 mb-4">
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/luggage.svg" alt="Luggage" class="w-3 h-3">
                                    <span>4 Luggage</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/seat.svg" alt="Seats" class="w-3 h-3">
                                    <span>10 Seats</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/door.svg" alt="Doors" class="w-3 h-3">
                                    <span>4 Doors</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/transmission.svg" alt="Transmission" class="w-3 h-3">
                                    <span>Auto</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/engine.svg" alt="Engine" class="w-3 h-3">
                                    <span>3.0 L</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/petrol.svg" alt="Fuel" class="w-3 h-3">
                                    <span>Petrol</span>
                                </div>
                            </div>
                            <div
                                class="block px-4 py-3 w-full font-semibold text-center text-white bg-red-600 rounded-b-lg transition duration-200 hover:bg-red-700 cursor-pointer">
                                View More
                            </div>
                        </div>
                    </div>

                    <!-- Perodua Myvi -->
                    <div
                        class="overflow-hidden bg-white rounded-lg border border-gray-200 shadow-sm transition-shadow duration-200 hover:shadow-md">
                        <div class="flex justify-center p-4">
                            <div class="w-32 h-32 bg-red-600 rounded-full flex items-center justify-center">
                                <img src="/images/perodua-myvi.jpg" alt="Perodua Myvi" class="w-28 h-28 object-contain">
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <h3 class="text-lg font-bold text-center text-gray-900 mb-3">Perodua Myvi (M600) 1.5</h3>
                            <div class="flex flex-wrap justify-center gap-3 text-xs text-gray-600 mb-4">
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/luggage.svg" alt="Luggage" class="w-3 h-3">
                                    <span>4 Luggage</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/seat.svg" alt="Seats" class="w-3 h-3">
                                    <span>10 Seats</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/door.svg" alt="Doors" class="w-3 h-3">
                                    <span>4 Doors</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/transmission.svg" alt="Transmission" class="w-3 h-3">
                                    <span>Auto</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/engine.svg" alt="Engine" class="w-3 h-3">
                                    <span>3.0 L</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/petrol.svg" alt="Fuel" class="w-3 h-3">
                                    <span>Petrol</span>
                                </div>
                            </div>
                            <div
                                class="block px-4 py-3 w-full font-semibold text-center text-white bg-red-600 rounded-b-lg transition duration-200 hover:bg-red-700 cursor-pointer">
                                View More
                            </div>
                        </div>
                    </div>

                    <!-- Hyundai Starex Royale -->
                    <div
                        class="overflow-hidden bg-white rounded-lg border border-gray-200 shadow-sm transition-shadow duration-200 hover:shadow-md">
                        <div class="flex justify-center p-4">
                            <div class="w-32 h-32 bg-red-600 rounded-full flex items-center justify-center">
                                <img src="/images/hyundai-starex.jpg" alt="Hyundai Starex Royale"
                                    class="w-28 h-28 object-contain">
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <h3 class="text-lg font-bold text-center text-gray-900 mb-3">Hyundai Starex Royale</h3>
                            <div class="flex flex-wrap justify-center gap-3 text-xs text-gray-600 mb-4">
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/luggage.svg" alt="Luggage" class="w-3 h-3">
                                    <span>4 Luggage</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/seat.svg" alt="Seats" class="w-3 h-3">
                                    <span>10 Seats</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/door.svg" alt="Doors" class="w-3 h-3">
                                    <span>4 Doors</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/transmission.svg" alt="Transmission" class="w-3 h-3">
                                    <span>Auto</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/engine.svg" alt="Engine" class="w-3 h-3">
                                    <span>3.0 L</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <img src="/icons/petrol.svg" alt="Fuel" class="w-3 h-3">
                                    <span>Petrol</span>
                                </div>
                            </div>
                            <div
                                class="block px-4 py-3 w-full font-semibold text-center text-white bg-red-600 rounded-b-lg transition duration-200 hover:bg-red-700 cursor-pointer">
                                View More
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-6">
                    <button onclick="window.history.back()"
                        class="px-4 py-3 w-full font-semibold text-gray-700 bg-gray-100 rounded-lg transition duration-200 hover:bg-gray-200">
                        Back to Search
                    </button>
                </div>
            </div>
        </div>
    </x-affiliate-navbar>

    <script>
        function searchFormData() {
            return {
                formatDateFromUrl(dateString) {
                    // Check if date is in YYYY-MM-DD format and convert to dd-mm-YYYY
                    if (dateString && dateString.match(/^\d{4}-\d{2}-\d{2}$/)) {
                        const [year, month, day] = dateString.split('-');
                        return `${day}-${month}-${year}`;
                    }
                    // If already in dd-mm-YYYY format, return as is
                    return dateString;
                },

                init() {
                    // Get URL parameters
                    const urlParams = new URLSearchParams(window.location.search);

                    // Set pickup location from URL
                    if (urlParams.get('pickup_location')) {
                        const pickupLocation = urlParams.get('pickup_location');
                        this.$refs.pickupLocation.value = pickupLocation;
                        this.$parent.searchParams.pickup_location = pickupLocation;
                    }
                    if (urlParams.get('pickup_latitude')) {
                        this.$parent.searchParams.pickup_latitude = urlParams.get('pickup_latitude');
                    }
                    if (urlParams.get('pickup_longitude')) {
                        this.$parent.searchParams.pickup_longitude = urlParams.get('pickup_longitude');
                    }

                    // Set return location from URL
                    if (urlParams.get('return_location')) {
                        const returnLocation = urlParams.get('return_location');
                        this.$refs.returnLocation.value = returnLocation;
                        this.$parent.searchParams.return_location = returnLocation;
                    }
                    if (urlParams.get('return_latitude')) {
                        this.$parent.searchParams.return_latitude = urlParams.get('return_latitude');
                    }
                    if (urlParams.get('return_longitude')) {
                        this.$parent.searchParams.return_longitude = urlParams.get('return_longitude');
                    }

                    // Set pickup date and time from URL
                    if (urlParams.get('pickup_date')) {
                        const pickupDate = urlParams.get('pickup_date');
                        // Convert YYYY-MM-DD to dd-mm-YYYY if needed
                        const formattedDate = this.formatDateFromUrl(pickupDate);
                        this.$refs.pickupDate.value = formattedDate;
                        // Update Alpine.js searchParams
                        this.$parent.searchParams.pickup_date = formattedDate;
                    }
                    if (urlParams.get('pickup_time')) {
                        const pickupTime = urlParams.get('pickup_time');
                        this.$refs.pickupTime.value = pickupTime;
                        // Update Alpine.js searchParams
                        this.$parent.searchParams.pickup_time = pickupTime;
                    }

                    // Set return date and time from URL
                    if (urlParams.get('return_date')) {
                        const returnDate = urlParams.get('return_date');
                        // Convert YYYY-MM-DD to dd-mm-YYYY if needed
                        const formattedDate = this.formatDateFromUrl(returnDate);
                        this.$refs.returnDate.value = formattedDate;
                        // Update Alpine.js searchParams
                        this.$parent.searchParams.return_date = formattedDate;
                    }
                    if (urlParams.get('return_time')) {
                        const returnTime = urlParams.get('return_time');
                        this.$refs.returnTime.value = returnTime;
                        // Update Alpine.js searchParams
                        this.$parent.searchParams.return_time = returnTime;
                    }
                }
            }
        }

        function carListing() {
            return {
                loading: false,
                hasSearched: false,
                carModels: [],
                categories: [],
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
                    this.updateUrl();
                    this.initializeDateTimePicker();
                    this.initializeGooglePlaces();

                    // Sync form values with searchParams after a short delay
                    this.$nextTick(() => {
                        setTimeout(() => {
                            this.syncFormValuesWithSearchParams();
                        }, 500);
                    });
                },

                initializeDateTimePicker() {
                    this.$nextTick(() => {
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
                    $('#InputStartDate').on('changeDate', (e) => {
                        this.searchParams.pickup_date = this.formatDateForAlpine(e.date);
                        this.updateUrl();
                    });

                    $('#InputReturnDate').on('changeDate', (e) => {
                        this.searchParams.return_date = this.formatDateForAlpine(e.date);
                        this.updateUrl();
                    });

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

                handleSearch() {
                    // Redirect to index page with search parameters
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

                    const searchUrl = '{{ route('affiliate.car-listing.index') }}' + (params.toString() ? '?' + params
                        .toString() : '');
                    window.location.href = searchUrl;
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
                    if (typeof google !== 'undefined' && google.maps && google.maps.places) {
                        this.setupPickupLocationAutocomplete();
                        this.setupReturnLocationAutocomplete();
                    } else {
                        setTimeout(() => this.initializeGooglePlaces(), 100);
                    }
                },

                setupPickupLocationAutocomplete() {
                    const input = document.getElementById('pickup_location');
                    if (input) {
                        const autocomplete = new google.maps.places.Autocomplete(input);
                        autocomplete.addListener('place_changed', () => {
                            const place = autocomplete.getPlace();
                            if (place.geometry) {
                                this.searchParams.pickup_location = place.formatted_address;
                                this.searchParams.pickup_latitude = place.geometry.location.lat();
                                this.searchParams.pickup_longitude = place.geometry.location.lng();
                                this.updateUrl();
                            }
                        });
                    }
                },

                setupReturnLocationAutocomplete() {
                    const input = document.getElementById('return_location');
                    if (input) {
                        const autocomplete = new google.maps.places.Autocomplete(input);
                        autocomplete.addListener('place_changed', () => {
                            const place = autocomplete.getPlace();
                            if (place.geometry) {
                                this.searchParams.return_location = place.formatted_address;
                                this.searchParams.return_latitude = place.geometry.location.lat();
                                this.searchParams.return_longitude = place.geometry.location.lng();
                                this.updateUrl();
                            }
                        });
                    }
                },

                syncFormValuesWithSearchParams() {
                    // Sync form input values with Alpine.js searchParams
                    const pickupDateInput = document.getElementById('InputStartDate');
                    const returnDateInput = document.getElementById('InputReturnDate');
                    const pickupTimeInput = document.getElementById('InputStartTime');
                    const returnTimeInput = document.getElementById('InputReturnTime');
                    const pickupLocationInput = document.getElementById('pickup_location');
                    const returnLocationInput = document.getElementById('return_location');

                    if (pickupDateInput && pickupDateInput.value) {
                        this.searchParams.pickup_date = pickupDateInput.value;
                        console.log('Booking page - Synced pickup date:', pickupDateInput.value);
                    }
                    if (returnDateInput && returnDateInput.value) {
                        this.searchParams.return_date = returnDateInput.value;
                        console.log('Booking page - Synced return date:', returnDateInput.value);
                    }
                    if (pickupTimeInput && pickupTimeInput.value) {
                        this.searchParams.pickup_time = pickupTimeInput.value;
                    }
                    if (returnTimeInput && returnTimeInput.value) {
                        this.searchParams.return_time = returnTimeInput.value;
                    }
                    if (pickupLocationInput && pickupLocationInput.value) {
                        this.searchParams.pickup_location = pickupLocationInput.value;
                    }
                    if (returnLocationInput && returnLocationInput.value) {
                        this.searchParams.return_location = returnLocationInput.value;
                    }

                    console.log('Booking page - syncedFormValuesWithSearchParams - updated searchParams:', this
                        .searchParams);
                }
            }
        }
    </script>

    <!-- Date Time Picker -->
    <script src="{{ asset('js/date-time-picker.js') }}"></script>

    <!-- Date Picker Initialization -->
    <script>
        $(document).ready(function() {
            function initDatePickers() {
                if (typeof $ !== 'undefined' && $.fn.datepicker) {
                    console.log('Initializing date pickers on booking page...');

                    // Initialize Start Date Picker
                    if ($('#InputStartDate').length) {
                        $('#InputStartDate').datepicker({
                            format: 'dd-mm-yyyy',
                            autoclose: true,
                            startDate: '+0d',
                            todayHighlight: true,
                            clearBtn: true,
                            orientation: 'bottom auto'
                        });
                        console.log('Start date picker initialized on booking page');
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
                        console.log('Return date picker initialized on booking page');
                    }
                } else {
                    console.log('jQuery or datepicker not available, retrying...');
                    setTimeout(initDatePickers, 500);
                }
            }

            initDatePickers();
        });
    </script>

    <!-- Google Maps API -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('google.maps.api_key') }}&libraries=places&callback=Function.prototype"
        async defer></script>
@endsection
