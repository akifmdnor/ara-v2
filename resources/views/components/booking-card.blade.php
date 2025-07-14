@props(['booking'])

<div x-data="{ expanded: false }"
    class="p-4 w-full bg-white rounded-2xl border border-gray-100 shadow transition-all duration-200 md:p-6">
    <!-- Top Row: Booking Number, Commission, Status (Desktop) -->
    <div class="hidden justify-between items-start mb-2 md:flex">
        <div class="flex gap-4 items-center">
            <span class="text-[#EC2028] font-bold text-base md:text-lg"
                x-text="booking.bk_id ?? ('BK' + String(booking.id).padStart(4, '0'))"></span>
        </div>
        <div class="flex gap-4 items-center">
            <div class="flex gap-2 items-center">
                <span class="text-xs text-gray-400">Commission (RM)</span>
                <span class="text-base font-semibold text-gray-800"
                    x-text="Number(booking.commission).toFixed(2)"></span>
                <span class="ml-2 px-3 py-1 rounded-lg text-xs font-semibold bg-[#FFF4E0] text-[#FFB800]">Pending</span>
            </div>
            <div class="flex gap-2 items-center">
                <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-[#F3EFFF] text-[#A259FF]"
                    x-text="booking.booking_status"></span>
                <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-[#FFEAEA] text-[#EC2028]"
                    x-text="booking.payment_status"></span>
            </div>
        </div>
    </div>

    <!-- Mobile: Booking Number -->
    <div class="flex justify-between items-center mb-2 md:hidden">
        <span class="text-[#EC2028] font-bold text-base"
            x-text="booking.bk_id ?? ('BK' + String(booking.id).padStart(4, '0'))"></span>
    </div>

    <!-- Car Image -->
    <div class="flex justify-center mb-2 md:justify-start md:mb-0">
        <img src="{{ $booking->car_model->model_specification->picture_url ?? '/images/agent.svg' }}" alt="Car"
            class="object-contain w-32 h-20" />
    </div>

    <!-- Main Info Row -->
    <div class="flex flex-col gap-2 mb-2 md:flex-row md:items-center md:justify-between md:gap-0">
        <div class="flex-1">
            <div class="text-xs font-semibold text-gray-800">Client's Name</div>
            <div class="text-sm font-medium text-gray-900" x-text="booking.user?.name ?? '-' "></div>
        </div>
        <div class="flex-1">
            <div class="text-xs font-semibold text-gray-800">Car Brand</div>
            <div class="text-sm font-medium text-gray-900"
                x-text="booking.car_model?.model_specification?.brand ?? '-' ">
            </div>
        </div>
        <div class="flex-1">
            <div class="text-xs font-semibold text-gray-800">Car Model</div>
            <div class="text-sm font-medium text-gray-900"
                x-text="booking.car_model?.model_specification?.model_name ?? '-' ">
            </div>
        </div>
        <div class="flex-1">
            <div class="text-xs font-semibold text-gray-800">Start Date & Time</div>
            <div class="text-sm font-medium text-gray-900"
                x-text="booking.pickup_datetime ? (new Date(booking.pickup_datetime).toLocaleString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true })) : '-' ">
            </div>
        </div>
        <div class="flex-1">
            <div class="text-xs font-semibold text-gray-800">End Date & Time</div>
            <div class="text-sm font-medium text-gray-900"
                x-text="booking.dropoff_datetime ? (new Date(booking.dropoff_datetime).toLocaleString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true })) : '-' ">
            </div>
        </div>
    </div>

    <!-- Status Row (Mobile) -->
    <div class="flex flex-row gap-2 mb-2 md:hidden">
        <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-[#F3EFFF] text-[#A259FF]"
            x-text="booking.booking_status"></span>
        <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-[#FFEAEA] text-[#EC2028]"
            x-text="booking.payment_status"></span>
        <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-[#FFF4E0] text-[#FFB800]">Pending</span>
    </div>

    <!-- Commission (Mobile) -->
    <div class="flex gap-2 items-center mb-2 md:hidden">
        <span class="text-xs text-gray-400">Commission (RM)</span>
        <span class="text-base font-semibold text-gray-800" x-text="Number(booking.commission).toFixed(2)"></span>
    </div>

    <!-- Expand Button -->
    <div class="flex justify-center mt-2">
        <button @click="expanded = !expanded"
            class="flex gap-1 items-center text-sm font-medium text-gray-600 focus:outline-none">
            <span x-text="expanded ? 'Collapse' : 'Expand'"></span>
            <!-- Material Icon: Expand More -->
            <svg x-show="!expanded" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            <svg x-show="expanded" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
        </button>
    </div>

    <!-- Expanded Details -->
    <div x-show="expanded" x-transition class="pt-4 mt-4 border-t">
        <div class="flex flex-col md:flex-row md:gap-8">
            <!-- Left: Client & Car Details -->
            <div class="flex-1 mb-4 md:mb-0">
                <div class="mb-2">
                    <div class="mb-1 text-sm font-bold">Client's Details</div>
                    <div class="flex flex-col gap-1 text-xs text-gray-700">
                        <div class="flex justify-between"><span class="text-[#cccccc]">Name</span><span
                                x-text="booking.user?.name ?? '-' "></span></div>
                        <div class="flex justify-between"><span class="text-[#cccccc]">Phone Number</span><span
                                x-text="booking.user?.phone_number ?? '-' "></span></div>
                        <div class="flex justify-between"><span class="text-[#cccccc]">IC/Passport Number</span><span
                                x-text="booking.user?.nric ?? '-' "></span></div>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="mb-1 text-sm font-bold">Car Details</div>
                    <div class="flex flex-col gap-1 text-xs text-gray-700">
                        <div class="flex justify-between"><span class="text-[#cccccc]">Plat Number</span><span
                                x-text="booking.car?.plat_number ?? '-' "></span></div>
                        <div class="flex justify-between"><span class="text-[#cccccc]">Handling Branch</span><span
                                x-text="booking.branch?.branch_name ?? '-' "></span></div>
                        <div class="flex justify-between"><span class="text-[#cccccc]">Assigned Staff</span><span
                                x-text="booking.staff?.first_name + ' ' + booking.staff?.last_name ?? '-' "></span>
                        </div>
                        <div class="flex justify-between"><span class="text-[#cccccc]">Staff's Phone
                                Number</span><span x-text="booking.staff?.phone_number ?? '-' "></span></div>
                    </div>
                </div>
            </div>
            <!-- Right: Start & Return, Sale Details -->
            <div class="flex-1">
                <div class="mb-2">
                    <div class="mb-1 text-sm font-bold">Start & Return</div>
                    <div class="flex flex-col gap-2 text-xs text-gray-700">
                        <div class="flex gap-2 items-center mx-3 mt-3">
                            <!-- Solid Dot Icon -->
                            <svg class="w-4 h-4 text-[#EC2028]" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="6" />
                            </svg>
                            <span x-text="booking.pickup_location ?? '-' "></span>
                            <span class="ml-2 text-gray-400"
                                x-text="booking.pickup_datetime ? (new Date(booking.pickup_datetime).toLocaleDateString('en-GB')) : '-' "></span>
                            <span class="flex items-center ml-2 text-gray-400"><svg class="mr-1 w-4 h-4"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                </svg><span
                                    x-text="booking.pickup_datetime ? (new Date(booking.pickup_datetime).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' })) : '-' "></span></span>
                        </div>
                        <div
                            class="ml-[1.1rem] flex flex-col gap-2 w-1 h-[50px] border-l-4 border-dotted border-[#EC2028]">
                        </div>
                        <div class="flex gap-2 items-center mx-3 mb-3">
                            <!-- Material Icon: Location -->
                            <svg class="w-4 h-4 text-[#EC2028]" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                                <circle cx="12" cy="9" r="2.5" />
                            </svg>
                            <span x-text="booking.dropoff_location ?? '-' "></span>
                            <span class="ml-2 text-gray-400"
                                x-text="booking.dropoff_datetime ? (new Date(booking.dropoff_datetime).toLocaleDateString('en-GB')) : '-' "></span>
                            <span class="flex items-center ml-2 text-gray-400"><svg class="mr-1 w-4 h-4"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                </svg><span
                                    x-text="booking.dropoff_datetime ? (new Date(booking.dropoff_datetime).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' })) : '-' "></span></span>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="mb-1 text-sm font-bold">Sale Details Type</div>
                    <div class="flex flex-col gap-1 text-xs text-gray-700">
                        <div class="flex justify-between"><span class="text-[#cccccc]">Sale Type</span><span>Normal
                                Rate</span></div>
                        <div class="flex justify-between"><span class="text-[#cccccc]">Sale Amount (RM)</span><span
                                x-text="Number(booking.amount).toFixed(2)"></span></div>
                        <div class="flex justify-between"><span class="text-[#cccccc]">Commission (RM)</span><span
                                x-text="Number(booking.commission).toFixed(2)"></span></div>
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button
                        class="bg-[#EC2028] text-white rounded-xl px-4 py-2 font-bold text-sm flex items-center gap-2">
                        Resend Quotation
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
