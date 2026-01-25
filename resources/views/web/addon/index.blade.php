@extends('web.layouts.app')

@section('title', 'Choose Add-ons - ARA Car Rental')

@section('content')
    <div class="w-full min-h-screen bg-white">
        {{-- Navigation --}}
        @include('web.components.navbar')

        {{-- Main Content --}}
        <div class="w-full bg-white">
            {{-- Stepper --}}
            <div class="mx-auto max-w-[1280px] pt-12">
                @include('web.components.stepper', ['currentStep' => 2])
            </div>

            {{-- Content Area --}}
            <div class="flex mx-auto max-w-[1280px] gap-3 pt-12 pb-[148px]">
                {{-- Sidebar --}}
                <div class="shrink-0 w-[300px]">
                    @include('web.components.booking-sidebar', ['carDetails' => $carDetails])
                </div>

                {{-- Main Content --}}
                <div class="flex flex-col flex-1 w-[968px] gap-3">
                    {{-- Start & Return Location Card --}}
                    <div class="flex flex-col p-6 bg-white rounded-lg"
                        style="border-radius: var(--Radius-Medium, 8px); background: var(--Background-bg-dialog, #FFF); box-shadow: 0 2px 4px 0 rgba(51, 65, 85, 0.10), 0 6px 32px 0 rgba(51, 65, 85, 0.10);">
                        <p class="text-sm font-semibold text-[#6b6b74] leading-5 mb-6">
                            Start & return location
                        </p>

                        <div class="flex gap-6">
                            {{-- Start --}}
                            <div class="flex-1">
                                <p class="text-base font-medium text-[#18181b] leading-6 mb-1">Start</p>

                                <div class="flex flex-col gap-[5px]">
                                    {{-- Location Details --}}
                                    <div class="flex gap-1 pb-[5px]">
                                        <span
                                            class="text-sm font-medium text-[#3f3f46] leading-5 min-w-[70px]">Location</span>
                                        <span class="text-sm font-normal text-[#3f3f46] leading-5">:</span>
                                        <span class="flex-1 text-sm font-medium text-[#18181b] leading-5">
                                            <span class="font-normal text-[#3f3f46]">From</span>
                                            {{ $carDetails['pickup_location'] ?? 'Bandar Puteri, Puchong, Selangor' }}
                                            <span class="font-normal text-[#3f3f46]">to</span>
                                            {{ $carDetails['return_location'] ?? 'Subang Jaya' }}
                                        </span>
                                    </div>

                                    <div class="flex gap-1">
                                        <span
                                            class="text-sm font-medium text-[#3f3f46] leading-5 min-w-[70px]">Distance</span>
                                        <span class="text-sm font-normal text-[#3f3f46] leading-5">:</span>
                                        <span class="flex-1 text-sm font-medium text-[#18181b] leading-5">
                                            {{ $carDetails['pickup_distance'] ?? '10 km' }}
                                        </span>
                                    </div>

                                    <div class="flex gap-1">
                                        <div class="flex flex-col min-w-[70px]">
                                            <div class="flex gap-1">
                                                <span class="text-sm font-medium text-[#3f3f46] leading-5">Charge</span>
                                                <span class="text-sm font-normal text-[#3f3f46] leading-5">:</span>
                                            </div>
                                            <span class="text-xs font-normal text-[#6b6b74] leading-3">(RM
                                                {{ number_format($carDetails['price_per_km'] ?? 1.8, 2) }}/km)</span>
                                        </div>
                                        <span class="text-sm font-medium text-[#18181b] leading-5">
                                            RM {{ number_format($carDetails['pickup_charge'] ?? 18.0, 2) }}
                                        </span>
                                    </div>

                                    {{-- Radio Options --}}
                                    <div class="flex flex-col gap-[5px] mt-[5px]">
                                        <label class="flex items-center cursor-pointer gap-[10px]">
                                            <input type="radio" name="start_option" value="deliver" checked
                                                class="shrink-0 w-4 h-4 accent-[#ec2028] border border-[#e4e4e7] rounded-full">
                                            <span class="text-sm font-medium text-[#3f3f46] leading-5">
                                                Please deliver to my location
                                            </span>
                                        </label>

                                        <label class="flex items-center cursor-pointer gap-[10px]">
                                            <input type="radio" name="start_option" value="pickup"
                                                class="shrink-0 w-4 h-4 accent-[#ec2028] border border-[#e4e4e7] rounded-full">
                                            <span class="text-sm font-medium text-[#3f3f46] leading-5">
                                                I will self pickup at branch location
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Timeline Indicator --}}
                            <div class="flex items-center pt-8">
                                <div class="relative w-[64.9px] h-[8.4px]">
                                    <div class="absolute top-[3.2px] left-0 w-[30px] h-[2px] bg-[#e4e4e7]"></div>
                                    <div class="absolute top-[3.2px] left-[30px] w-[23.3px] h-[2px] bg-[#e4e4e7]"></div>
                                    <svg width="12" height="8.4" viewBox="0 0 12 8.4" fill="none"
                                        class="absolute top-0 right-0">
                                        <path d="M8 0.5L11.5 4.2L8 7.9" stroke="#ec2028" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M0.5 4.2H11" stroke="#ec2028" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Return --}}
                            <div class="flex-1">
                                <p class="text-base font-medium text-[#18181b] leading-6 mb-1">Return</p>

                                <div class="flex flex-col gap-[5px]">
                                    {{-- Location Details --}}
                                    <div class="flex gap-1 pb-[5px]">
                                        <span
                                            class="text-sm font-medium text-[#3f3f46] leading-5 min-w-[70px]">Location</span>
                                        <span class="text-sm font-normal text-[#3f3f46] leading-5">:</span>
                                        <span class="flex-1 text-sm font-medium text-[#18181b] leading-5">
                                            <span class="font-normal text-[#3f3f46]">From</span>
                                            {{ $carDetails['return_location'] ?? 'Subang Jaya' }}
                                            <span class="font-normal text-[#3f3f46]">to</span>
                                            {{ $carDetails['pickup_location'] ?? 'Bandar Puteri, Puchong, Selangor' }}
                                        </span>
                                    </div>

                                    <div class="flex gap-1">
                                        <span
                                            class="text-sm font-medium text-[#3f3f46] leading-5 min-w-[70px]">Distance</span>
                                        <span class="text-sm font-normal text-[#3f3f46] leading-5">:</span>
                                        <span class="flex-1 text-sm font-medium text-[#18181b] leading-5">
                                            {{ $carDetails['return_distance'] ?? '10 km' }}
                                        </span>
                                    </div>

                                    <div class="flex gap-1">
                                        <div class="flex flex-col min-w-[70px]">
                                            <div class="flex gap-1">
                                                <span class="text-sm font-medium text-[#3f3f46] leading-5">Charge</span>
                                                <span class="text-sm font-normal text-[#3f3f46] leading-5">:</span>
                                            </div>
                                            <span class="text-xs font-normal text-[#6b6b74] leading-3">(RM
                                                {{ number_format($carDetails['price_per_km'] ?? 1.8, 2) }}/km)</span>
                                        </div>
                                        <span class="text-sm font-medium text-[#18181b] leading-5">
                                            RM {{ number_format($carDetails['return_charge'] ?? 18.0, 2) }}
                                        </span>
                                    </div>

                                    {{-- Radio Options --}}
                                    <div class="flex flex-col gap-[5px] mt-[5px]">
                                        <label class="flex items-center cursor-pointer gap-[10px]">
                                            <input type="radio" name="return_option" value="collect" checked
                                                class="shrink-0 w-4 h-4 accent-[#ec2028] border border-[#e4e4e7] rounded-full">
                                            <span class="text-sm font-medium text-[#3f3f46] leading-5">
                                                Please collect at my location
                                            </span>
                                        </label>

                                        <label class="flex items-center cursor-pointer gap-[10px]">
                                            <input type="radio" name="return_option" value="return"
                                                class="shrink-0 w-4 h-4 accent-[#ec2028] border border-[#e4e4e7] rounded-full">
                                            <span class="text-sm font-medium text-[#3f3f46] leading-5">
                                                I will self return to branch location
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Add-ons Section --}}
                    <div class="flex flex-col gap-3 p-6 bg-white rounded-lg"
                        style="border-radius: var(--Radius-Medium, 8px); background: var(--Background-bg-dialog, #FFF); box-shadow: 0 2px 4px 0 rgba(51, 65, 85, 0.10), 0 6px 32px 0 rgba(51, 65, 85, 0.10);">
                        <p class="text-sm font-semibold text-[#6b6b74] leading-5">Choose add-on</p>

                        @foreach ($addOns as $addon)
                            @include('web.addon.components.addon-card', ['addon' => $addon])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer - Fixed at bottom --}}
        <div class="fixed bottom-0 left-0 right-0 w-full bg-white border-t border-[#e4e4e7] px-[150px] z-50">
            <div class="flex items-center mx-auto max-w-[1280px] h-[100px] gap-3">
                <img src="{{ $carDetails['image'] ?? asset('images/ara-logo.png') }}" alt="Car"
                    class="object-cover w-32 h-20">
                <div class="flex gap-2 items-center">
                    <img src="{{ $carDetails['brand_logo'] ?? asset('images/ara-logo.png') }}" alt="Brand"
                        class="object-cover w-6 h-6 rounded">
                    <span class="text-xl font-semibold text-[#18181b] leading-[30px]">
                        {{ $carDetails['name'] ?? 'Perodua Myvi 1.5H' }}
                    </span>
                </div>

                <div class="flex flex-1 gap-3 justify-end items-center">
                    <div class="flex gap-1 items-baseline">
                        <p class="text-sm font-medium text-[#18181b] leading-5">Total</p>
                        <p class="text-xl font-semibold text-right text-[#ff6a0c] leading-[30px] min-w-[101px]">
                            RM {{ number_format($carDetails['total_price'] ?? 727.68, 2) }}
                        </p>
                    </div>

                    <a href="{{ route('web.customer-info.index') }}"
                        class="flex justify-center items-center h-8 px-[10px] py-[6px] gap-[6px] font-medium text-sm leading-5 text-white bg-[#ec2028] border border-[#ec2028] rounded-lg transition-colors hover:opacity-90 no-underline"
                        style="box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                        Save & Continue
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const basePrice = {{ $carDetails['rental_price'] ?? 0 }};
            const deliveryCharge = {{ $carDetails['door_to_door_delivery'] ?? 0 }};
            const pickupCharge = {{ $carDetails['door_to_door_pickup'] ?? 0 }};
            const taxRate = 0.06; // 6% SST
            const securityDeposit = {{ $carDetails['security_deposit'] ?? 0 }};

            const rentalDays = {{ $carDetails['rental_days'] ?? 1 }};
            const totalPriceElement = document.querySelector(
                '.text-xl.font-semibold.text-right.text-\\[\\#ff6a0c\\]');

            function calculateTotal() {
                let addonTotal = 0;

                // Calculate checkbox add-on costs
                document.querySelectorAll('input[type="checkbox"][name^="addon_"]:checked').forEach(function(
                    checkbox) {
                    const addonId = checkbox.name.replace('addon_', '');
                    const addonCard = checkbox.closest('.flex.gap-3.items-center');
                    const priceText = addonCard.querySelector('.text-base.font-semibold');
                    const priceMatch = priceText.textContent.match(/RM ([\d.]+)/);
                    if (priceMatch) {
                        const dailyPrice = parseFloat(priceMatch[1]);
                        addonTotal += dailyPrice * rentalDays;
                    }
                });

                // Calculate quantity add-on costs
                document.querySelectorAll('input[name^="addon_quantity_"]').forEach(function(input) {
                    const quantity = parseInt(input.value) || 0;
                    if (quantity > 0) {
                        const addonCard = input.closest('.flex.gap-3.items-center');
                        const priceText = addonCard.querySelector('.text-base.font-semibold');
                        const priceMatch = priceText.textContent.match(/RM ([\d.]+)/);
                        if (priceMatch) {
                            const dailyPrice = parseFloat(priceMatch[1]);
                            addonTotal += (dailyPrice * quantity) * rentalDays;
                        }
                    }
                });

                // Calculate subtotal (rental + delivery + add-ons)
                const subtotal = basePrice + deliveryCharge + pickupCharge + addonTotal;

                // Add tax
                const tax = subtotal * taxRate;

                // Total = subtotal + tax + security deposit
                const total = subtotal + tax + securityDeposit;

                // Update display
                if (totalPriceElement) {
                    totalPriceElement.textContent = 'RM ' + total.toFixed(2);
                }
            }

            // Listen for checkbox and quantity changes
            document.addEventListener('change', function(e) {
                if ((e.target.type === 'checkbox' && e.target.name.startsWith('addon_')) ||
                    (e.target.type === 'number' && e.target.name.startsWith('addon_quantity_'))) {
                    calculateTotal();
                }
            });

            // Listen for quantity button clicks
            document.addEventListener('click', function(e) {
                if (e.target.closest('.quantity-btn')) {
                    const button = e.target.closest('.quantity-btn');
                    const addonId = button.dataset.addonId;
                    const action = button.dataset.action;
                    const input = document.querySelector(`input[name="addon_quantity_${addonId}"]`);

                    if (input) {
                        let currentValue = parseInt(input.value) || 0;

                        if (action === 'increase') {
                            input.value = currentValue + 1;
                        } else if (action === 'decrease' && currentValue > 0) {
                            input.value = currentValue - 1;
                        }

                        // Trigger change event
                        const event = new Event('change', {
                            bubbles: true
                        });
                        input.dispatchEvent(event);
                    }
                }
            });

            // Initial calculation
            calculateTotal();
        });
    </script>
@endsection
