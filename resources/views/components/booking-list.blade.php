<div x-data="bookingList()" x-init="fetchBookings()" class="mt-4" @filters-changed.window="onFiltersChanged($event)">
    <div class="flex justify-between items-center mb-2">
        <h2 class="text-lg font-semibold">Bookings</h2>
    </div>
    <template x-if="loading">
        <div class="py-8 text-center text-gray-400">Loading bookings...</div>
    </template>
    <template x-if="!loading && bookings.length === 0">
        <div class="py-4 text-center text-gray-400">No bookings found.</div>
    </template>
    <div class="space-y-4">
        <template x-for="booking in bookings" :key="booking.id">
            <div x-data="{ expanded: false }"
                class="p-4 w-full bg-white rounded-2xl border border-gray-100 shadow transition-all duration-200 md:p-6">
                <div class="flex flex-row gap-6">
                    <!-- Left: Car Image -->
                    <div class="hidden flex-col flex-shrink-0 justify-center items-center w-32 md:flex">
                        <div class="relative">
                            <div
                                class="absolute -bottom-2 left-1/2 z-0 w-24 h-6 bg-red-100 rounded-full blur-sm -translate-x-1/2">
                            </div>
                            <img :src="booking.car_model?.model_specification?.picture_url" alt='Car'
                                class='object-contain relative z-10 w-28 h-20' />
                        </div>
                    </div>

                    <div class="flex flex-col flex-1 gap-1">
                        <!-- Right: Info -->

                        <!-- Row 1: Booking ID (left), Commission (right) -->
                        <div class="flex flex-row justify-between items-start">
                            <span class="text-[#EC2028] font-bold text-base md:text-lg"
                                x-text="booking.bk_id ?? ('BK' + String(booking.id).padStart(4, '0'))"></span>
                            <div class="hidden gap-2 items-center md:flex">
                                <span class="text-base text-gray-400">Commission (RM)</span>
                                <span class="text-base font-semibold text-gray-800"
                                    x-text="Number(booking.commission).toFixed(2)"></span>
                                <div class="ml-2"
                                    x-html="getStatusBadge(booking.commission_status ?? 'Pending', 'sm')"></div>
                            </div>
                        </div>
                        <div class="flex flex-row justify-between items-start">
                            <div class="flex flex-col justify-center items-center w-full md:hidden">


                                <img :src="booking.car_model?.model_specification?.picture_url" alt='Car'
                                    class='object-contain relative z-10 w-full' />

                            </div>
                        </div>

                        <!-- Row 2: Client Name -->
                        <div class="flex flex-col">
                            <span class="text-base font-medium text-gray-800">Client’s Name</span>
                            <span class="text-base text-gray-700 truncate" x-text="booking.user?.name ?? '-' "></span>
                        </div>
                        <!-- Row 3: Brand, Model, Start, End, Statuses (full width grid) -->
                        <div class="grid grid-cols-2 gap-4 items-center mt-1 w-full text-base md:grid-cols-6">
                            <div>
                                <span class="block text-base text-gray-400">Car Brand</span>
                                <span x-text="booking.car_model?.model_specification?.brand ?? '-' "></span>
                            </div>
                            <div>
                                <span class="block text-base text-gray-400">Car Model</span>
                                <span x-text="booking.car_model?.model_specification?.model_name ?? '-' "></span>
                            </div>
                            <div>
                                <span class="block text-base text-gray-400">Start Date & Time</span>
                                <span
                                    x-text="booking.pickup_datetime ? (new Date(booking.pickup_datetime).toLocaleString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false })) : '-' "></span>
                            </div>
                            <div>
                                <span class="block text-base text-gray-400">End Date & Time</span>
                                <span
                                    x-text="booking.dropoff_datetime ? (new Date(booking.dropoff_datetime).toLocaleString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false })) : '-' "></span>
                            </div>
                            <div>
                                <span class="block text-base text-gray-400">Booking Status</span>
                                <div x-html="getStatusBadge(booking.booking_status)"></div>
                            </div>
                            <div class="hidden px-4 md:block">
                                <span class="block text-base text-gray-400">Payment Status</span>
                                <div x-html="getStatusBadge(booking.payment_status)"></div>
                            </div>
                            <div class="block md:hidden">
                                <span class="block text-base text-gray-400">Commission (RM)</span>
                                <span class="text-base font-semibold text-gray-800"
                                    x-text="Number(booking.commission).toFixed(2)"></span>
                                <span
                                    class="ml-2 px-3 py-1 rounded-lg text-base font-semibold bg-[#FFF4E0] text-[#FFB800]"
                                    x-text="booking.commission_status ?? 'Pending'"></span>
                            </div>
                        </div>
                        <!-- Expand Button centered below -->
                        <div class="flex justify-center mt-4">
                            <button @click="expanded = !expanded"
                                class="flex gap-1 items-center text-base font-medium text-gray-600 focus:outline-none hover:text-gray-800">
                                <span x-text="expanded ? 'Collapse' : 'Expand'"></span>
                                <svg x-show="!expanded" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                <svg x-show="expanded" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Expanded Details (unchanged, below main card) -->
                <div x-show="expanded" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 max-h-0 overflow-hidden"
                    x-transition:enter-end="opacity-100 max-h-screen overflow-visible"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 max-h-screen overflow-visible"
                    x-transition:leave-end="opacity-0 max-h-0 overflow-hidden">
                    <div class="flex flex-col pt-4 mt-4 border-t md:flex-row md:gap-8">
                        <!-- Left: Client & Car Details -->
                        <div class="flex-1 mb-4 md:mb-0">
                            <div class="mb-2">
                                <div class="mb-1 text-base font-bold">Client's Details</div>
                                <div class="flex flex-col gap-1 text-base text-gray-700">
                                    <div class="flex justify-between"><span class="text-[#cccccc]">Name</span><span
                                            x-text="booking.user?.name ?? '-' "></span></div>
                                    <div class="flex justify-between"><span class="text-[#cccccc]">Phone
                                            Number</span><span x-text="booking.user?.phone_number ?? '-' "></span>
                                    </div>
                                    <div class="flex justify-between"><span class="text-[#cccccc]">IC/Passport
                                            Number</span><span x-text="booking.user?.nric ?? '-' "></span></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="mb-1 text-base font-bold">Car Details</div>
                                <div class="flex flex-col gap-1 text-base text-gray-700">
                                    <div class="flex justify-between"><span class="text-[#cccccc]">Plat
                                            Number</span><span x-text="booking.car?.plat_number ?? '-' "></span></div>
                                    <div class="flex justify-between"><span class="text-[#cccccc]">Handling
                                            Branch</span><span x-text="booking.branch?.branch_name ?? '-' "></span>
                                    </div>
                                    <div class="flex justify-between"><span class="text-[#cccccc]">Assigned
                                            Staff</span><span
                                            x-text="booking.staff?.first_name + ' ' + booking.staff?.last_name ?? '-' "></span>
                                    </div>
                                    <div class="flex justify-between"><span class="text-[#cccccc]">Staff's Phone
                                            Number</span><span x-text="booking.staff?.phone_number ?? '-' "></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right: Start & Return, Sale Details -->
                        <div class="flex-1">
                            <div class="mb-2">
                                <div class="mb-1 text-base font-bold">Start & Return</div>
                                <div class="flex flex-col gap-2 text-base text-gray-700">
                                    <div class="flex gap-2 items-center mx-3 mt-3">
                                        <!-- Solid Dot Icon -->
                                        <svg class="w-4 h-4 text-[#EC2028]" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="6" />
                                        </svg>
                                        <div class="flex flex-col w-1/2">
                                            <span x-text="booking.pickup_location ?? '-' "></span>
                                            <div class="flex flex-row justify-between mt-1 text-base">
                                                <span class="flex items-center text-gray-500">
                                                    <svg class="mr-1 w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <span
                                                        x-text="booking.pickup_datetime ? (new Date(booking.pickup_datetime).toLocaleDateString('en-GB')) : '-' "></span>
                                                </span>
                                                <span
                                                    class="flex items-center ml-4 text-right border-gray-400 border-l-1">
                                                    <svg class="mr-1 w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span
                                                        x-text="booking.pickup_datetime ? (new Date(booking.pickup_datetime).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', hour12: false })) : '' "></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="ml-[1.1rem] flex flex-col gap-2 w-1 h-[50px] border-l-4 border-dotted border-[#EC2028]">
                                    </div>
                                    <div class="flex gap-2 items-center mx-3 mb-3">
                                        <svg class="w-4 h-4 text-[#EC2028]" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                                            <circle cx="12" cy="9" r="2.5" />
                                        </svg>
                                        <div class="flex flex-col w-1/2">
                                            <span
                                                x-text="booking.dropoff_location
                                            ?? '-' "></span>
                                            <div class="flex flex-row justify-between mt-1 text-base">
                                                <span class="flex items-center text-gray-500">
                                                    <svg class="mr-1 w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <span
                                                        x-text="booking.dropoff_datetime ? (new Date(booking.dropoff_datetime).toLocaleDateString('en-GB')) : '-' "></span>
                                                </span>
                                                <span class="flex items-center ml-4 text-right">
                                                    <svg class="mr-1 w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span
                                                        x-text="booking.dropoff_datetime ? (new Date(booking.dropoff_datetime).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', hour12: false })) : '' "></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="mb-1 text-base font-bold">Sale Details Type</div>
                                <div class="flex flex-col gap-1 text-base text-gray-700">
                                    <div class="flex justify-between"><span class="text-[#cccccc]">Sale
                                            Type</span><span>Normal
                                            Rate</span></div>
                                    <div class="flex justify-between"><span class="text-[#cccccc]">Sale Amount
                                            (RM)</span><span x-text="Number(booking.amount).toFixed(2)"></span></div>
                                    <div class="flex justify-between"><span class="text-[#cccccc]">Commission
                                            (RM)</span><span x-text="Number(booking.commission).toFixed(2)"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end mt-4" x-show="booking.booking_status === 'Pending'">
                                <button
                                    class="bg-[#EC2028] text-white rounded-xl px-4 py-2 font-bold text-base flex items-center gap-2">
                                    Resend Quotation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <!-- Pagination Controls -->
    <div class="flex justify-center mt-6" x-show="!loading && meta && meta.last_page > 1">
        <button @click="prevPage" :disabled="!meta || meta.current_page === 1"
            class="px-3 py-1 mx-1 text-base rounded border"
            :class="!meta || meta.current_page === 1 ? 'bg-gray-100 text-gray-400' : 'bg-white text-gray-700'">Prev</button>
        <template x-for="page in meta ? meta.last_page : 0" :key="page">
            <button @click="goToPage(page)"
                :class="meta && meta.current_page === page ? 'bg-[#EC2028] text-white' : 'bg-white text-gray-700'"
                class="px-3 py-1 mx-1 text-base rounded border" x-text="page"></button>
        </template>
        <button @click="nextPage" :disabled="!meta || meta.current_page === meta.last_page"
            class="px-3 py-1 mx-1 text-base rounded border"
            :class="!meta || meta.current_page === meta.last_page ? 'bg-gray-100 text-gray-400' :
                'bg-white text-gray-700'">Next</button>
    </div>
</div>

@push('scripts')
    <script>
        function bookingList() {
            return {
                bookings: [],
                meta: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 10,
                    total: 0
                },
                loading: false,
                filters: {
                    month: 'all',
                    customer_status: 'All',
                    booking_number: '',
                    customer_name: '',
                },
                fetchBookings(page = 1) {
                    this.loading = true;
                    // Build query params from filters
                    const params = new URLSearchParams({
                        page,
                        month: this.filters.month,
                        customer_status: this.filters.customer_status,
                        booking_number: this.filters.booking_number,
                        customer_name: this.filters.customer_name,
                    });
                    fetch(`/api/affiliate/bookings?${params.toString()}`)
                        .then(res => res.json())
                        .then(data => {
                            this.bookings = data.data || [];
                            this.meta = data.meta || {
                                current_page: 1,
                                last_page: 1,
                                per_page: 10,
                                total: 0
                            };
                            this.loading = false;
                            // If stats are returned, dispatch to filters-stats
                            if (data.stats) {
                                this.$dispatch('stats-updated', data.stats);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching bookings:', error);
                            this.bookings = [];
                            this.meta = {
                                current_page: 1,
                                last_page: 1,
                                per_page: 10,
                                total: 0
                            };
                            this.loading = false;
                        });
                },
                prevPage() {
                    if (this.meta && this.meta.current_page > 1) {
                        this.fetchBookings(this.meta.current_page - 1);
                    }
                },
                nextPage() {
                    if (this.meta && this.meta.current_page < this.meta.last_page) {
                        this.fetchBookings(this.meta.current_page + 1);
                    }
                },
                goToPage(page) {
                    this.fetchBookings(page);
                },
                onFiltersChanged(event) {
                    this.filters = {
                        ...event.detail
                    };
                    this.fetchBookings(1); // Reset to first page on filter change
                },
                getStatusBadge(status, size = 'base') {
                    return window.StatusUtils.generateBadge(status, size);
                },
            }
        }
        // Helper to convert API booking to Blade model (for x-detailed-booking-card)
        window.__bookingAlpineToBlade = function(booking) {
            return booking;
        };
    </script>
@endpush
