@props(['stats'])

<div x-data="bookingFiltersStats()" x-init="initFilters()" @stats-updated.window="updateStats($event.detail)">
    <!-- Mobile Topbar: Sort, Filter, and Statistics only -->
    <div class="flex flex-col gap-3 p-4 mb-4 bg-white rounded-2xl border border-gray-100 shadow md:hidden">
        <div class="flex justify-between items-center">
            <!-- Sort Dropdown Custom -->
            <div class="relative flex-1" id="sort-dropdown-wrapper-mobile">
                <button type="button" @click="toggleMonthDropdown('mobile')"
                    class="flex flex-col justify-center items-start p-2 w-full bg-white rounded-xl border border-gray-200 shadow focus:outline-none">
                    <span class="text-xs leading-tight text-gray-400">Sort By</span>
                    <div class="flex items-center">
                        <span x-text="selectedMonthLabel" class="mr-2 text-sm font-normal text-gray-800"></span>
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
                <div x-show="showMonthDropdownMobile" @click.away="showMonthDropdownMobile = false"
                    class="absolute left-0 z-20 mt-2 w-full bg-white rounded-xl border border-gray-200 shadow-lg">
                    <div class="flex flex-col">
                        <template x-for="(month, idx) in months" :key="month.value">
                            <button type="button"
                                class="px-5 py-2 text-sm text-left text-gray-800 hover:bg-gray-100 sort-option-mobile"
                                :class="{
                                    'rounded-t-xl': idx === 0,
                                    'rounded-b-xl': idx === months.length - 1
                                }"
                                @click="selectMonth(month.value)">
                                <span x-text="month.label"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
            <!-- Filter Icon -->
            <button id="open-filter-modal" class="p-2 ml-2 bg-white rounded-full border border-gray-200 shadow">
                <svg class="w-6 h-6 text-[#EC2028]" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
            </button>
        </div>
        <!-- Statistics -->
        <div class="flex flex-row gap-2 justify-between mt-2 max-w-[100px]">
            <div class="flex flex-col p-1 bg-white max-h-[100px]">
                <div class="text-xs leading-tight text-gray-500">Total Bookings</div>
                <div class="flex justify-between items-end pt-2 mt-auto">
                    <div class="text-base font-bold" x-text="statsDisplay.total_bookings"></div>
                    <div class="flex gap-1 items-center text-xs font-semibold text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        <span x-text="statsDisplay.total_bookings_growth"></span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col p-1 bg-white max-h-[100px]">
                <div class="text-xs leading-tight text-gray-500">Total Sales</div>
                <div class="flex justify-between items-end pt-2 mt-auto">
                    <div class="text-base font-bold" x-text="'RM' + statsDisplay.total_sales"></div>
                    <div class="flex gap-1 items-center text-xs font-semibold text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        <span x-text="statsDisplay.total_sales_growth"></span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col p-1 bg-white max-h-[100px]">
                <div class="text-xs leading-tight text-gray-500">Total Commission</div>
                <div class="flex justify-between items-end pt-2 mt-auto">
                    <div class="text-base font-bold" x-text="'RM' + statsDisplay.total_commission"></div>
                    <div class="flex gap-1 items-center text-xs font-semibold text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        <span x-text="statsDisplay.total_commission_growth"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-2 mt-4">
            <button
                class="flex-1 border border-[#EC2028] text-[#EC2028] rounded-lg px-4 py-2 font-bold text-sm flex items-center justify-center">
                <svg class="mr-2 w-5 h-5" fill="none" stroke="#EC2028" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M13 3a9 9 0 1 0 8 9" />
                    <path d="M12 7v5l3 3" />
                </svg>
                Sales History
            </button>
            <button
                class="flex-1 bg-[#EC2028] text-white rounded-lg px-4 py-2 font-bold text-sm flex items-center justify-center">
                <span class="mr-2 text-2xl leading-none">+</span>
                Create Booking
            </button>
        </div>
    </div>

    <!-- Desktop Topbar: unchanged except dropdown logic -->
    <div class="hidden flex-col gap-4 p-6 bg-white rounded-2xl border border-gray-100 shadow md:flex">
        <div class="flex flex-col gap-4 w-full md:flex-row md:items-center md:justify-between">
            <!-- Statistics -->
            <div class="flex flex-col flex-1 gap-4 md:flex-row">
                <div class="flex flex-col p-1 bg-white max-h-[100px]">
                    <div class="text-xs leading-tight text-gray-500">Total Booking This Month</div>
                    <div class="flex justify-between items-end pt-2 mt-auto">
                        <div class="text-base font-bold">
                            <span x-text="statsDisplay.total_bookings"></span>
                            <span class="text-base font-normal">Cars</span>
                        </div>
                        <div class="flex gap-1 items-center text-xs font-semibold text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            <span x-text="statsDisplay.total_bookings_growth"></span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col p-1 bg-white max-h-[100px]">
                    <div class="text-xs leading-tight text-gray-500">Total Sales This Month</div>
                    <div class="flex justify-between items-end pt-2 mt-auto">
                        <div class="text-base font-bold">
                            <span x-text="'RM' + statsDisplay.total_sales"></span>
                            <span class="text-base font-normal">RM</span>
                        </div>
                        <div class="flex gap-1 items-center text-xs font-semibold text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            <span x-text="statsDisplay.total_sales_growth"></span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col p-1 bg-white max-h-[100px]">
                    <div class="text-xs leading-tight text-gray-500">Total Estimated Commission This Month</div>
                    <div class="flex justify-between items-end pt-2 mt-auto">
                        <div class="text-base font-bold">
                            <span x-text="'RM' + statsDisplay.total_commission"></span>
                            <span class="text-base font-normal">RM</span>
                        </div>
                        <div class="flex gap-1 items-center text-xs font-semibold text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            <span x-text="statsDisplay.total_commission_growth"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sort and Actions (right-aligned, styled as per image) -->
            <div class="flex flex-row gap-3 justify-end items-end mt-4 md:items-center md:mt-0">
                <!-- Sort Dropdown Custom -->
                <div class="relative" id="sort-dropdown-wrapper">
                    <button type="button" @click="toggleMonthDropdown('desktop')"
                        class="flex flex-col items-start justify-center bg-white rounded-xl p-2 shadow border border-gray-200 min-w-[100px] mr-0 focus:outline-none">
                        <span class="text-xs leading-tight text-gray-400">Sort By</span>
                        <div class="flex items-center">
                            <span x-text="selectedMonthLabel" class="mr-2 text-sm font-normal text-gray-800"></span>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="showMonthDropdownDesktop" @click.away="showMonthDropdownDesktop = false"
                        class="absolute right-0 z-20 mt-2 w-full bg-white rounded-xl border border-gray-200 shadow-lg">
                        <div class="flex flex-col">
                            <template x-for="(month, idx) in months" :key="month.value">
                                <button type="button" class="px-5 py-2 text-gray-800 hover:bg-gray-100 sort-option"
                                    :class="{
                                        'rounded-t-xl': idx === 0,
                                        'rounded-b-xl': idx === months.length - 1
                                    }"
                                    @click="selectMonth(month.value)">
                                    <span x-text="month.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
                <!-- Sales History Button -->
                <button
                    class="flex items-center gap-2 border-2 border-[#EC2028] text-[#EC2028]
                        bg-white rounded-xl px-3 py-2 font-bold text-xs shadow hover:bg-red-50 transition">
                    <svg class="w-6 h-6" fill="none" stroke="#EC2028" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M13 3a9 9 0 1 0 8 9" />
                        <path d="M12 7v5l3 3" />
                    </svg>
                    Sales History
                </button>
                <!-- Create Booking Button -->
                <button
                    class="flex items-center gap-2 bg-[#EC2028] text-white rounded-xl px-3 py-2 font-bold text-xs shadow hover:bg-red-600 transition">
                    <span class="text-2xl leading-none">+</span>
                    Create Booking
                </button>
            </div>
        </div>
        <!-- Filters & Search -->
        <div class="flex flex-col gap-4 mt-2 w-full md:flex-row md:items-center md:justify-between">
            <div class="flex flex-col gap-4 w-full md:flex-row md:items-center">
                <!-- Commission Payment Status -->
                <div class="flex flex-col">
                    <span class="mb-3 text-xs font-semibold">Commission Payment Status</span>
                    <div class="inline-flex">
                        <template x-for="(status, i) in commissionStatuses" :key="status">
                            <button class="px-3 py-2 text-xs font-semibold border transition"
                                :class="commissionStatus === status ? 'bg-[#EC2028] text-white border-[#EC2028]' :
                                    'bg-white text-gray-700 border-gray-200' +
                                    (i === 0 ? ' rounded-l-lg' : '') +
                                    (i === commissionStatuses.length - 1 ? ' rounded-r-lg' : '') +
                                    (i !== 0 ? ' -ml-px' : '')"
                                @click="setCommissionStatus(status)">
                                <span x-text="status"></span>
                            </button>
                        </template>
                    </div>
                </div>
                <!-- Customer Payment Status and Search Inputs -->
                <div class="flex flex-col flex-1 ml-0 w-full md:flex-row md:items-end md:ml-4">
                    <div class="flex flex-col">
                        <span class="mb-3 text-xs font-semibold">Customer Payment Status</span>
                        <div class="inline-flex">
                            <template x-for="(status, i) in customerStatuses" :key="status">
                                <button class="px-3 py-2 text-xs font-semibold border transition"
                                    :class="customerStatus === status ? 'bg-[#EC2028] text-white border-[#EC2028]' :
                                        'bg-white text-gray-700 border-gray-200' +
                                        (i === 0 ? ' rounded-l-lg' : '') +
                                        (i === customerStatuses.length - 1 ? ' rounded-r-lg' : '') +
                                        (i !== 0 ? ' -ml-px' : '')"
                                    @click="setCustomerStatus(status)">
                                    <span x-text="status"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    <form @submit.prevent="applySearch"
                        class="flex flex-1 gap-2 items-center mt-2 w-full min-w-0 md:justify-end md:ml-4 md:mt-0">
                        <div class="flex flex-1 min-w-0">
                            <input type="text" x-model="bookingNumber"
                                class="px-3 py-2 w-full min-w-0 text-xs rounded-lg border"
                                placeholder="Booking Number">
                        </div>
                        <div class="flex flex-1 min-w-0">
                            <input type="text" x-model="customerName"
                                class="px-3 py-2 w-full min-w-0 text-xs rounded-lg border"
                                placeholder="Customer Name">
                        </div>
                        <button type="submit"
                            class="bg-[#FFB800] hover:bg-[#EC2028] transition text-white rounded-lg px-4 py-2 flex items-center">
                            <svg xmlns='http://www.w3.org/2000/svg' class='mr-1 w-5 h-5' fill='none'
                                viewBox='0 0 24 24' stroke='currentColor'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
                                    d='M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z' />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Modal (mobile only) -->
    <div id="filter-modal"
        class="flex hidden fixed inset-0 z-50 justify-center items-center bg-black bg-opacity-30 md:hidden">
        <div class="relative p-6 mx-auto w-11/12 max-w-sm bg-white rounded-2xl">
            <button id="close-filter-modal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="mb-4 text-lg font-bold">Filter By</div>
            <div class="mb-4">
                <div class="mb-2 text-xs font-semibold">Commission Payment Status</div>
                <div class="inline-flex w-full">
                    <template x-for="(status, i) in commissionStatuses" :key="status">
                        <button class="flex-1 px-3 py-2 text-xs font-semibold border transition"
                            :class="commissionStatus === status ? 'bg-[#EC2028] text-white border-[#EC2028]' :
                                'bg-white text-gray-700 border-gray-200' +
                                (i === 0 ? ' rounded-l-lg' : '') +
                                (i === commissionStatuses.length - 1 ? ' rounded-r-lg' : '') +
                                (i !== 0 ? ' -ml-px' : '')"
                            @click="setCommissionStatus(status)">
                            <span x-text="status"></span>
                        </button>
                    </template>
                </div>
            </div>
            <div class="mb-4">
                <div class="mb-2 text-xs font-semibold">Customer Payment Status</div>
                <div class="inline-flex w-full">
                    <template x-for="(status, i) in customerStatuses" :key="status">
                        <button class="flex-1 px-3 py-2 text-xs font-semibold border transition"
                            :class="customerStatus === status ? 'bg-[#EC2028] text-white border-[#EC2028]' :
                                'bg-white text-gray-700 border-gray-200' +
                                (i === 0 ? ' rounded-l-lg' : '') +
                                (i === customerStatuses.length - 1 ? ' rounded-r-lg' : '') +
                                (i !== 0 ? ' -ml-px' : '')"
                            @click="setCustomerStatus(status)">
                            <span x-text="status"></span>
                        </button>
                    </template>
                </div>
            </div>
            <div class="mb-4">
                <input type="text" class="px-3 py-2 mb-2 w-full text-xs rounded-lg border"
                    placeholder="Booking Number">
                <input type="text" class="px-3 py-2 w-full text-xs rounded-lg border" placeholder="Customer Name">
            </div>
            <div class="flex gap-2 mt-4">
                <button
                    class="flex-1 border border-[#EC2028] text-[#EC2028] rounded-lg px-4 py-2 font-bold text-sm">Reset</button>
                <button class="flex-1 bg-[#EC2028] text-white rounded-lg px-4 py-2 font-bold text-sm">Search</button>
            </div>
        </div>
    </div>
</div>

<script>
    function bookingFiltersStats() {
        return {
            months: [],
            selectedMonth: 'all',
            selectedMonthLabel: 'All time',
            showMonthDropdownMobile: false,
            showMonthDropdownDesktop: false,
            commissionStatuses: ['All', 'Pending', 'Paid'],
            commissionStatus: 'All',
            customerStatuses: ['All', 'Not Paid', 'Partial', 'Paid'],
            customerStatus: 'All',
            bookingNumber: '',
            customerName: '',
            statsDisplay: {
                total_bookings: '0',
                total_bookings_growth: '0%',
                total_sales: '0.00',
                total_sales_growth: '0%',
                total_commission: '0.00',
                total_commission_growth: '0%',
            },
            initFilters() {
                // Generate months from now to Jan 2024
                const now = new Date();
                const months = [];
                months.push({
                    value: 'all',
                    label: 'All time'
                });
                let d = new Date(now.getFullYear(), now.getMonth(), 1);
                const oldest = new Date(2024, 0, 1);
                while (d >= oldest) {
                    const label = d.toLocaleString('default', {
                        month: 'long',
                        year: 'numeric'
                    });
                    const value = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`;
                    months.push({
                        value,
                        label
                    });
                    d.setMonth(d.getMonth() - 1);
                }
                this.months = months;
                this.selectedMonth = 'all';
                this.selectedMonthLabel = 'All time';
            },
            toggleMonthDropdown(type) {
                if (type === 'mobile') {
                    this.showMonthDropdownMobile = !this.showMonthDropdownMobile;
                } else {
                    this.showMonthDropdownDesktop = !this.showMonthDropdownDesktop;
                }
            },
            selectMonth(value) {
                this.selectedMonth = value;
                this.selectedMonthLabel = this.months.find(m => m.value === value)?.label || 'All time';
                this.showMonthDropdownMobile = false;
                this.showMonthDropdownDesktop = false;
                this.$dispatch('filters-changed', this.getFilters());
            },
            setCommissionStatus(status) {
                this.commissionStatus = status;
                this.$dispatch('filters-changed', this.getFilters());
            },
            setCustomerStatus(status) {
                this.customerStatus = status;
                this.$dispatch('filters-changed', this.getFilters());
            },
            applySearch() {
                this.$dispatch('filters-changed', this.getFilters());
            },
            getFilters() {
                return {
                    month: this.selectedMonth,
                    customer_status: this.customerStatus,
                    booking_number: this.bookingNumber,
                    customer_name: this.customerName,
                };
            },
            updateStats(stats) {
                this.statsDisplay = stats;
            }
        }
    }
</script>
