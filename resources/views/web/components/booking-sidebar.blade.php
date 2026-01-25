{{-- Add-On Page Sidebar Details Component --}}
@php
    $carDetails = $carDetails ?? [];
@endphp

<div class="flex flex-col" x-data="{ expanded: true }"
    style="width: 300px; border-radius: var(--Radius-Medium, 8px); background: var(--Background-bg-dialog, #FFF); box-shadow: 0 2px 4px 0 rgba(51, 65, 85, 0.10), 0 6px 32px 0 rgba(51, 65, 85, 0.10);">

    <div class="flex flex-col gap-3 bg-white rounded-lg" style="padding: 12px;">


        {{-- Car Name --}}
        <div class="flex gap-2 justify-start items-start mb-3">
            <img src="{{ $carDetails['brand_logo'] ?? asset('images/ara-logo.png') }}" alt="Brand"
                style="width: 24px; height: 24px; border-radius: 4px;">
            <span class="text-xl font-semibold"
                style="color: #18181b; line-height: 24px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block;">
                {{ $carDetails['name'] ?? 'Unknown Car' }}
            </span>
        </div>

        {{-- Limited Time Offer Badge --}}
        @if (isset($carDetails['is_promo']) && $carDetails['is_promo'])
            <div class="flex gap-1.5 items-center px-2 py-0.5 mb-2"
                style="background-color: #ecfdf5; border: 1px solid rgba(21,128,61,0.2); border-radius: 4px; width: fit-content;">
                <span class="text-xs font-normal" style="color: #15803d; line-height: 18px;">Limited Time Offer</span>
            </div>
        @endif

        {{-- Car Image --}}
        <div class="mb-3" style="width: 100%; height: 206px;">
            <img src="{{ $carDetails['image'] ?? asset('images/ara-logo.png') }}" alt="Car"
                class="object-contain w-full h-full">
        </div>

        {{-- Tags --}}
        <div class="flex gap-1 mb-3">
            <span class="px-2 py-0.5 text-xs rounded-full"
                style="background-color: #f4f4f5; border: 1px solid rgba(82,82,91,0.2); color: #6b6b74;">
                Group {{ $carDetails['group'] ?? 'A' }}
            </span>
            <span class="px-2 py-0.5 text-xs rounded-full"
                style="background-color: #f4f4f5; border: 1px solid rgba(82,82,91,0.2); color: #6b6b74;">
                {{ $carDetails['category'] ?? 'Compact' }}
            </span>
        </div>

        <div class="w-full h-0 border-t" style="border-color: #d4d4d8;"></div>

        {{-- Pickup & Return Details --}}
        <div class="flex flex-col items-start py-3 w-full">
            {{-- Pickup Date/Time --}}
            <div class="flex gap-3 items-center px-0.5 w-full">
                <div class="shrink-0" style="width: 5px; height: 5px;">
                    <svg width="5" height="5" viewBox="0 0 5 5" fill="none">
                        <circle cx="2.5" cy="2.5" r="2.5" fill="#ec2028" />
                    </svg>
                </div>
                <div class="flex items-center text-sm font-normal" style="color: #18181b; line-height: 20px;">
                    <span>{{ $carDetails['pickup_date'] ?? '05-05-2024, 9:00 AM' }}</span>
                </div>
            </div>

            {{-- Vertical Line with Location Details --}}
            <div class="flex gap-3 items-start w-full">
                {{-- Vertical Line --}}
                <div class="flex flex-col gap-2 items-center pb-2 shrink-0" style="align-self: stretch;">
                    <div class="relative flex-1 w-0" style="min-height: 1px;"32q1qd>
                        <svg xmlns="http://www.w3.org/2000/svg" width="2" height="100%" viewBox="0 0 2 63"
                            preserveAspectRatio="none" class="absolute inset-0">
                            <path d="M0.75 0V63" stroke="url(#paint0_linear_784_9834)" stroke-width="1.5"
                                vector-effect="non-scaling-stroke" />
                            <defs>
                                <linearGradient id="paint0_linear_784_9834" x1="1.25" y1="0" x2="1.25"
                                    y2="63" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FFF1F2" />
                                    <stop offset="1" stop-color="#EC2028" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <div class="px-0.5 shrink-0" style="width: 5px; height: 5px;">
                        <svg width="5" height="5" viewBox="0 0 5 5" fill="none">
                            <circle cx="2.5" cy="2.5" r="2.5" fill="#ec2028" />
                        </svg>
                    </div>
                </div>

                {{-- Location Details --}}
                <div class="flex flex-col flex-1 gap-1 text-sm" style="line-height: 20px;">
                    <div class="flex flex-col">
                        <span class="font-medium" style="color: #18181b;">
                            {{ $carDetails['pickup_location'] ?? 'Pickup Location' }}
                        </span>
                        <span class="pb-4 font-normal" style="color: #6b6b74;">
                            Deliver to location
                        </span>
                    </div>

                    <div class="flex items-center text-sm font-normal" style="color: #18181b; line-height: 20px;">
                        <span>{{ $carDetails['return_date'] ?? '07-05-2024, 9:00 AM' }}</span>
                    </div>
                </div>
            </div>

            {{-- Return Location --}}
            <div class="flex flex-col pl-5 w-full">
                <span class="text-sm font-medium" style="color: #18181b;">
                    {{ $carDetails['return_location'] ?? 'Return Location' }}
                </span>
                <span class="text-sm font-normal" style="color: #6b6b74;">
                    Collect at location
                </span>
            </div>
        </div>

        <div class="w-full h-0 border border-t" style="border-color: #d4d4d8;"></div>


        <div class="flex overflow-hidden flex-col justify-center pt-4 pb-4 h-5 text-sm font-semibold whitespace-nowrap"
            style="color: #6b6b74; line-height: 20px;">
            <p>Cost Summary</p>
        </div>

        <div class="flex flex-col gap-3">
            {{-- Rental --}}
            <div class="flex flex-col w-full">
                <div class="flex justify-between items-center w-full">
                    <span class="text-sm font-medium" style="color: #18181b; line-height: 20px;">
                        Rental
                    </span>
                    <span class="text-sm font-semibold" style="color: #18181b; line-height: 20px;">
                        RM {{ number_format($carDetails['rental_price'] ?? 400, 2) }}
                    </span>
                </div>
                <span class="text-sm font-light" style="color: #6b6b74; line-height: 20px;">
                    (RM {{ number_format($carDetails['rental_price'] / ($carDetails['rental_days'] ?: 1), 2) }}/day)
                    x {{ $carDetails['rental_days'] ?? 2 }} Days
                </span>
            </div>

            {{-- Collapsible Content --}}
            <div class="flex overflow-hidden flex-col gap-3">

                <div class="w-full h-0 border-t border-dashed" style="border-color: #d4d4d8;"></div>

                {{-- Door-to-Door Delivery --}}
                <div class="flex flex-col w-full">
                    <div class="flex justify-between items-center w-full">
                        <span class="text-sm font-medium" style="color: #18181b; line-height: 20px;">
                            Door-to-Door Delivery
                        </span>
                        <span class="text-sm font-semibold" style="color: #18181b; line-height: 20px;">
                            RM {{ number_format($carDetails['door_to_door_delivery'] ?? 18, 2) }}
                        </span>
                    </div>
                    <span class="text-sm font-light" style="color: #6b6b74; line-height: 20px;">
                        From {{ $carDetails['pickup_location'] ?? 'Branch' }} to
                        {{ $carDetails['return_location'] ?? 'Location' }}
                    </span>
                </div>

                <div x-show="expanded" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100 max-h-screen" x-transition:leave-end="opacity-0 max-h-0"
                    class="w-full h-0 border-t" style="border-color: #d4d4d8;"></div>

                {{-- Door-to-Door Pickup --}}
                <div x-show="expanded" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100 max-h-screen" x-transition:leave-end="opacity-0 max-h-0"
                    class="flex flex-col w-full">
                    <div class="flex justify-between items-center w-full">
                        <span class="text-sm font-medium" style="color: #18181b; line-height: 20px;">
                            Door-to-Door Pickup
                        </span>
                        <span class="text-sm font-semibold" style="color: #18181b; line-height: 20px;">
                            RM {{ number_format($carDetails['door_to_door_pickup'] ?? 18, 2) }}
                        </span>
                    </div>
                    <span class="text-sm font-light" style="color: #6b6b74; line-height: 20px;">
                        From {{ $carDetails['pickup_location'] ?? 'Branch' }} to
                        {{ $carDetails['return_location'] ?? 'Location' }}
                    </span>
                </div>

                <div x-show="expanded" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100 max-h-screen" x-transition:leave-end="opacity-0 max-h-0"
                    class="w-full h-0 border-t border-dashed" style="border-color: #d4d4d8;"></div>

                @if (isset($carDetails['is_promo']) && $carDetails['is_promo'])
                    {{-- Discount --}}
                    <div x-show="expanded" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
                        x-transition:leave="transition ease-in duration-500"
                        x-transition:leave-start="opacity-100 max-h-screen" x-transition:leave-end="opacity-0 max-h-0"
                        class="flex flex-col gap-3 items-end">
                        <div class="flex gap-0 justify-end items-center pr-2">
                            <span class="z-10 px-2 py-0.5 -mr-2 text-xs font-medium"
                                style="background-color: #fff4ed; border: 1px solid #ff9960; color: #fe7439; border-radius: 6px 0 0 6px; padding-right: 12px; line-height: 18px;">
                                TOTAL DEAL
                            </span>
                            <span class="py-0.5 pr-2 pl-4 text-xs font-medium"
                                style="background-color: #fe7439; color: #fff4ed; border-radius: 6px; padding-left: 12px; line-height: 18px; border: 1.5px solid #ff9960;">
                                {{ $carDetails['promo_percentage'] ?? 10 }}% OFF
                            </span>
                        </div>

                        <div class="flex gap-3 justify-end items-start w-full" style="line-height: 20px;">
                            <div class="flex flex-col flex-1 items-start">
                                <span class="text-sm font-light" style="color: #18181b;">
                                    Discount
                                </span>
                                <span class="text-sm font-light" style="color: #6b6b74;">
                                    Seasonal Discount
                                </span>
                                <span class="text-sm font-light" style="color: #6b6b74;">
                                    Membership Discount
                                </span>
                                <span class="text-sm font-light" style="color: #6b6b74;">
                                    Special Adjustment
                                </span>
                            </div>
                            <div class="flex flex-col justify-center items-end">
                                <span class="text-sm font-semibold" style="color: #fe7439; line-height: 20px;">
                                    - RM {{ number_format(abs($carDetails['discount'] ?? 40), 2) }}
                                </span>
                                <span class="text-sm font-light" style="color: #6b6b74; line-height: 20px;">
                                    (RM {{ number_format(abs($carDetails['discount'] ?? 40), 2) }})
                                </span>
                                <span class="text-sm font-light" style="color: #6b6b74; line-height: 20px;">
                                    (RM 0.00)
                                </span>
                                <span class="text-sm font-light" style="color: #6b6b74; line-height: 20px;">
                                    (RM 0.00)
                                </span>
                            </div>
                        </div>
                    </div>
                @endif


            </div>
            {{-- End Collapsible Content --}}
        </div>
    </div>

    {{-- Price --}}
    <div x-show="expanded" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
        x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 max-h-screen"
        x-transition:leave-end="opacity-0 max-h-0" class="flex flex-col bg-[#ec2028] mt-1"">
        <div class="flex gap-3 justify-center items-start p-3 w-full text-white" style="background-color: #ec2028;">
            <div class="flex overflow-hidden flex-col justify-center text-sm font-semibold whitespace-nowrap shrink-0"
                style="line-height: 20px;">
                <span>Price</span>
            </div>
            <div class="flex flex-col flex-1 justify-center items-end text-right">
                <span class="text-lg font-semibold" style="line-height: 26px;">
                    RM {{ number_format($carDetails['total_price'] ?? 398, 2) }}
                </span>
                <span class="text-sm font-normal" style="line-height: 20px;">
                    Additional charges may apply
                </span>
            </div>
        </div>
    </div>

    {{-- Price Information --}}
    <div x-show="expanded" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" class="flex flex-col gap-3 bg-white rounded-lg"
        style="padding: 12px;">
        <div class="flex overflow-hidden flex-col justify-center h-5 text-sm font-semibold whitespace-nowrap"
            style="color: #6b6b74; line-height: 20px;">
            <span>Price Information</span>
        </div>

        {{-- Tax and charges --}}
        <div class="flex flex-col w-full">
            <div class="flex justify-between items-start w-full">
                <div class="flex gap-1 items-start">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" class="shrink-0">
                        <rect x="3.75" y="5.41602" width="12.5" height="10" rx="1.25" stroke="#18181b"
                            stroke-width="1.5" />
                        <path d="M3.75 8.74935H16.25" stroke="#18181b" stroke-width="1.5" />
                        <path d="M6.25 11.666H7.5" stroke="#18181b" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <span class="text-sm font-medium" style="color: #18181b; line-height: 20px;">
                        Tax and charges
                    </span>
                </div>
                <span class="text-sm font-semibold" style="color: #18181b; line-height: 20px;">
                    RM {{ number_format($carDetails['tax_amount'] ?? 31.68, 2) }}
                </span>
            </div>
            <span class="pl-6 text-sm font-light" style="color: #6b6b74; line-height: 20px;">
                8% SST Charge
            </span>
        </div>

        <div class="w-full h-0 border-t border-dashed" style="border-color: #d4d4d8;"></div>

        {{-- Security Deposit --}}
        <div class="flex justify-between items-start w-full">
            <div class="flex gap-1 items-start">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" class="shrink-0">
                    <circle cx="10" cy="10" r="7.5" stroke="#18181b" stroke-width="1.5" />
                    <path d="M10 10V6.25M10 13.125H10.0063" stroke="#18181b" stroke-width="1.5"
                        stroke-linecap="round" />
                </svg>
                <span class="text-sm font-medium" style="color: #18181b; line-height: 20px;">
                    Security Deposit (Refundable)
                </span>
            </div>
            <span class="text-sm font-semibold" style="color: #18181b; line-height: 20px;">
                RM {{ number_format($carDetails['security_deposit'] ?? 300.00, 2) }}
            </span>
        </div>

    </div>

    {{-- Collapse/Expand Button --}}
    <button @click="expanded = !expanded"
        class="flex gap-1.5 justify-center items-center px-2.5 py-1.5 w-[256px] h-8 bg-white rounded-lg  m-auto mb-3 mt-3"
        style="border-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); border: 1px solid #ec2028;">
        <span class="text-sm font-medium" style="color: #ec2028; line-height: 20px;"
            x-text="expanded ? 'Collapse' : 'Expand'">
        </span>
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
            :class="expanded ? 'transform rotate-180' : ''" class="transition-transform duration-500">
            <path d="M4 6L8 10L12 6" stroke="#ec2028" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </button>
</div>
