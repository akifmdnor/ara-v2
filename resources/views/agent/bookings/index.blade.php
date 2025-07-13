@extends('layouts.app')

@section('title', 'Agent Bookings')
@section('description', 'Agent Bookings - Manage your bookings')

@section('content')
    <x-agent-navbar :user="auth()->user()" headerText="Bookings">
        <!-- Mobile Topbar: Sort, Filter, and Statistics only -->
        <div class="flex flex-col gap-3 p-4 mb-4 bg-white rounded-2xl border border-gray-100 shadow md:hidden">
            <div class="flex justify-between items-center">
                <!-- Sort Dropdown Custom -->
                <div class="relative flex-1" id="sort-dropdown-wrapper-mobile">
                    <button type="button" id="sort-dropdown-btn-mobile"
                        class="flex flex-col justify-center items-start p-2 w-full bg-white rounded-xl border border-gray-200 shadow focus:outline-none">
                        <span class="text-xs leading-tight text-gray-400">Sort By</span>
                        <div class="flex items-center">
                            <span id="sort-dropdown-value-mobile" class="mr-2 text-sm font-normal text-gray-800">January
                                2025</span>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div id="sort-dropdown-menu-mobile"
                        class="hidden absolute left-0 z-20 mt-2 w-full bg-white rounded-xl border border-gray-200 shadow-lg">
                        <div class="flex flex-col">
                            <button type="button"
                                class="px-5 py-2 text-sm text-left text-gray-800 rounded-t-xl hover:bg-gray-100 sort-option-mobile">January
                                2025</button>
                            <button type="button"
                                class="px-5 py-2 text-sm text-left text-gray-800 hover:bg-gray-100 sort-option-mobile">Date</button>
                            <button type="button"
                                class="px-5 py-2 text-sm text-left text-gray-800 rounded-b-xl hover:bg-gray-100 sort-option-mobile">Amount</button>
                        </div>
                    </div>
                </div>
                <!-- Filter Icon -->
                <button id="open-filter-modal" class="p-2 ml-2 bg-white rounded-full border border-gray-200 shadow">
                    <svg class="w-6 h-6 text-[#EC2028]" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
            <!-- Statistics -->
            <div class="flex flex-row gap-2 justify-between mt-2 max-w-[100px]">
                <x-statistic-card label="Total Bookings" :value="$stats['total_bookings'] ?? '0' . ' Cars'" :percent="$stats['total_bookings_growth'] ?? '36%'" :isNegative="false"
                    unit="" />

                <x-statistic-card label="Total Sales" :value="'RM' . number_format($stats['total_sales'] ?? 0, 2)" :percent="$stats['total_sales_growth'] ?? '36%'" :isNegative="false"
                    unit="" />
                <x-statistic-card label="Total Commission" :value="'RM' . number_format($stats['total_commission'] ?? 0, 2)" :percent="$stats['total_commission_growth'] ?? '36%'" :isNegative="false"
                    unit="" />
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

        <!-- Desktop Topbar: unchanged -->
        <div class="hidden flex-col gap-4 p-6 bg-white rounded-2xl border border-gray-100 shadow md:flex">
            <div class="flex flex-col gap-4 w-full md:flex-row md:items-center md:justify-between">
                <!-- Statistics -->
                <div class="flex flex-col flex-1 gap-4 md:flex-row">
                    <x-statistic-card label="Total Booking This Month" :value="$stats['total_bookings'] ?? '0'" :percent="$stats['total_bookings_growth'] ?? '36%'"
                        :isNegative="false" unit="Cars" />
                    <x-statistic-card label="Total Sales This Month" :value="'RM' . number_format($stats['total_sales'] ?? 0, 2)" :percent="$stats['total_sales_growth'] ?? '36%'"
                        :isNegative="false" unit="RM" />
                    <x-statistic-card label="Total Estimated Commission This Month" :value="'RM' . number_format($stats['total_commission'] ?? 0, 2)" :percent="$stats['total_commission_growth'] ?? '36%'"
                        :isNegative="false" unit="RM" />
                </div>
                <!-- Sort and Actions (right-aligned, styled as per image) -->
                <div class="flex flex-row gap-3 justify-end items-end mt-4 md:items-center md:mt-0">
                    <!-- Sort Dropdown Custom -->
                    <div class="relative" id="sort-dropdown-wrapper">
                        <button type="button" id="sort-dropdown-btn"
                            class="flex flex-col items-start justify-center bg-white rounded-xl p-2 shadow border border-gray-200 min-w-[100px] mr-0 focus:outline-none">
                            <span class="text-xs leading-tight text-gray-400">Sort By</span>
                            <div class="flex items-center">
                                <span id="sort-dropdown-value" class="mr-2 text-sm font-normal text-gray-800">All
                                    Time</span>
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div id="sort-dropdown-menu"
                            class="hidden absolute right-0 z-20 mt-2 w-full bg-white rounded-xl border border-gray-200 shadow-lg">
                            <div class="flex flex-col">
                                <button type="button"
                                    class="px-5 py-2 text-gray-800 rounded-t-xl text-smtext-left hover:bg-gray-100 sort-option">All
                                    Time</button>
                                <button type="button"
                                    class="px-5 py-2 text-sm text-left text-gray-800 hover:bg-gray-100 sort-option">Date</button>
                                <button type="button"
                                    class="px-5 py-2 text-sm text-left text-gray-800 rounded-b-xl hover:bg-gray-100 sort-option">Amount</button>
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
                            @foreach (['All', 'Pending', 'Paid'] as $i => $status)
                                <button
                                    class="px-3 py-2 text-xs font-semibold border transition
                                        {{ request('commission_status', 'All') === $status
                                            ? 'bg-[#EC2028] text-white border-[#EC2028]'
                                            : 'bg-white text-gray-700 border-gray-200' }}
                                        {{ $i === 0 ? 'rounded-l-lg' : '' }}
                                        {{ $i === 2 ? 'rounded-r-lg' : '' }}
                                        {{ $i !== 0 ? '-ml-px' : '' }}
                                    ">
                                    {{ $status }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <!-- Customer Payment Status and Search Inputs -->
                    <div class="flex flex-col flex-1 ml-0 w-full md:flex-row md:items-end md:ml-4">
                        <div class="flex flex-col">
                            <span class="mb-3 text-xs font-semibold">Customer Payment Status</span>
                            <div class="inline-flex">
                                @foreach (['All', 'Not Paid', 'Partial', 'Paid'] as $i => $status)
                                    <button
                                        class="px-3 py-2 text-xs font-semibold border transition
                                            {{ request('customer_status', 'All') === $status
                                                ? 'bg-[#EC2028] text-white border-[#EC2028]'
                                                : 'bg-white text-gray-700 border-gray-200' }}
                                            {{ $i === 0 ? 'rounded-l-lg' : '' }}
                                            {{ $i === 3 ? 'rounded-r-lg' : '' }}
                                            {{ $i !== 0 ? '-ml-px' : '' }}
                                        ">
                                        {{ $status }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <form class="flex flex-1 gap-2 items-center mt-2 w-full min-w-0 md:justify-end md:ml-4 md:mt-0">
                            <div class="flex flex-1 min-w-0">
                                <input type="text" class="px-3 py-2 w-full min-w-0 text-xs rounded-lg border"
                                    placeholder="Booking Number">
                            </div>
                            <div class="flex flex-1 min-w-0">
                                <input type="text" class="px-3 py-2 w-full min-w-0 text-xs rounded-lg border"
                                    placeholder="Customer Name">
                            </div>
                            <button
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
        <!-- Add filter icon button for mobile only -->
        <div class="flex justify-end mb-2 md:hidden">
            <button id="open-filter-modal" class="p-2 bg-white rounded-full border border-gray-200 shadow">
                <svg class="w-6 h-6 text-[#EC2028]" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
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
                        @foreach (['All', 'Pending', 'Paid'] as $i => $status)
                            <button
                                class="flex-1 px-3 py-2 text-xs font-semibold border transition
                                    {{ request('commission_status', 'All') === $status ? 'bg-[#EC2028] text-white border-[#EC2028]' : 'bg-white text-gray-700 border-gray-200' }}
                                    {{ $i === 0 ? 'rounded-l-lg' : '' }}
                                    {{ $i === 2 ? 'rounded-r-lg' : '' }}
                                    {{ $i !== 0 ? '-ml-px' : '' }}
                                ">
                                {{ $status }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="mb-4">
                    <div class="mb-2 text-xs font-semibold">Customer Payment Status</div>
                    <div class="inline-flex w-full">
                        @foreach (['All', 'Not Paid', 'Partial', 'Paid'] as $i => $status)
                            <button
                                class="flex-1 px-3 py-2 text-xs font-semibold border transition
                                    {{ request('customer_status', 'All') === $status ? 'bg-[#EC2028] text-white border-[#EC2028]' : 'bg-white text-gray-700 border-gray-200' }}
                                    {{ $i === 0 ? 'rounded-l-lg' : '' }}
                                    {{ $i === 3 ? 'rounded-r-lg' : '' }}
                                    {{ $i !== 0 ? '-ml-px' : '' }}
                                ">
                                {{ $status }}
                            </button>
                        @endforeach
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
        <!-- Bookings List -->
        <div class="mt-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold">Bookings</h2>
            </div>
            <div class="space-y-4">
                @php $count = $bookings->count(); @endphp

                @if ($count === 0)
                    <div class="py-4 text-center text-gray-400">No bookings found.</div>
                @endif
            </div>
        </div>
        </div>
    </x-agent-navbar>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sort dropdown logic
            const sortBtn = document.getElementById('sort-dropdown-btn');
            const sortMenu = document.getElementById('sort-dropdown-menu');
            const sortValue = document.getElementById('sort-dropdown-value');
            const sortOptions = sortMenu.querySelectorAll('.sort-option');
            let sortOpen = false;

            sortBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sortMenu.classList.toggle('hidden');
                sortOpen = !sortOpen;
            });
            sortOptions.forEach(option => {
                option.addEventListener('click', function() {
                    sortValue.textContent = this.textContent;
                    sortMenu.classList.add('hidden');
                    sortOpen = false;
                });
            });
            document.addEventListener('click', function() {
                if (sortOpen) {
                    sortMenu.classList.add('hidden');
                    sortOpen = false;
                }
            });

            // Mobile sort dropdown logic
            const sortBtnMobile = document.getElementById('sort-dropdown-btn-mobile');
            const sortMenuMobile = document.getElementById('sort-dropdown-menu-mobile');
            const sortValueMobile = document.getElementById('sort-dropdown-value-mobile');
            const sortOptionsMobile = sortMenuMobile ? sortMenuMobile.querySelectorAll('.sort-option-mobile') : [];
            let sortOpenMobile = false;
            if (sortBtnMobile && sortMenuMobile) {
                sortBtnMobile.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sortMenuMobile.classList.toggle('hidden');
                    sortOpenMobile = !sortOpenMobile;
                });
                sortOptionsMobile.forEach(option => {
                    option.addEventListener('click', function() {
                        sortValueMobile.textContent = this.textContent;
                        sortMenuMobile.classList.add('hidden');
                        sortOpenMobile = false;
                    });
                });
                document.addEventListener('click', function() {
                    if (sortOpenMobile) {
                        sortMenuMobile.classList.add('hidden');
                        sortOpenMobile = false;
                    }
                });
            }

            // Filter modal logic (mobile only)
            const openFilterBtn = document.getElementById('open-filter-modal');
            const closeFilterBtn = document.getElementById('close-filter-modal');
            const filterModal = document.getElementById('filter-modal');
            if (openFilterBtn && closeFilterBtn && filterModal) {
                openFilterBtn.addEventListener('click', function() {
                    filterModal.classList.remove('hidden');
                });
                closeFilterBtn.addEventListener('click', function() {
                    filterModal.classList.add('hidden');
                });
                filterModal.addEventListener('click', function(e) {
                    if (e.target === filterModal) {
                        filterModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endpush
