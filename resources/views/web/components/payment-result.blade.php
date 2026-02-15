{{-- Reusable Payment Result Component --}}
@php
    $type = $type ?? 'success'; // 'success', 'failed', or 'second-payment'

    // Determine icon, title, and messages based on type
    if ($type === 'success') {
        $iconType = 'success';
        $iconColor = '#15803d'; // green
        $title = 'Payment Success!';
        $messageLines = ['Your payment is successful.', 'We have sent the receipt to your email.'];
    } elseif ($type === 'second-payment') {
        $iconType = 'info'; // We'll use inline SVG for info icon
        $iconColor = '#ff6a0c'; // orange
        $title = 'Complete Your Payment';
        $messageLines = [
            'Your deposit payment was successful.',
            'Please complete the remaining balance payment below.',
        ];
    } else {
        // failed
        $iconType = 'fail';
        $iconColor = '#dc2626'; // red
        $title = 'Payment Failed';
        $messageLines = [
            'Your payment could not be processed.',
            'Please try again to continue or check with your bank.',
        ];
    }

$showPaymentOptions = $type === 'failed' || $type === 'second-payment';
@endphp

<div class="flex flex-col gap-6 p-6 bg-white rounded-lg"
    style="border-radius: 8px; background: #FFF; box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05);">

    {{-- Status Message --}}
    <div class="flex flex-col gap-3 justify-center items-center">
        @if ($iconType === 'success')
            {{-- Success Checkmark Icon --}}
            <div class="w-[42px] h-[42px] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" fill="none">
                    <path d="M14.6984 23.5499L17.064 26.2743C17.9717 27.3198 19.6249 27.2161 20.3949 26.0655L27.2984 15.7499M36.2234 20.9999C36.2234 29.4084 29.407 36.2249 20.9984 36.2249C12.5899 36.2249 5.77344 29.4084 5.77344 20.9999C5.77344 12.5914 12.5899 5.7749 20.9984 5.7749C29.407 5.7749 36.2234 12.5914 36.2234 20.9999Z" stroke="#15803D" stroke-width="3.15" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        @elseif ($iconType === 'fail')
            {{-- Fail X Icon --}}
            <div class="w-[42px] h-[42px] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" fill="none">
                    <path d="M27.2984 14.6999L14.6984 27.2999M14.6984 14.6999L27.2984 27.2999M36.2234 20.9999C36.2234 29.4084 29.407 36.2249 20.9984 36.2249C12.5899 36.2249 5.77344 29.4084 5.77344 20.9999C5.77344 12.5914 12.5899 5.7749 20.9984 5.7749C29.407 5.7749 36.2234 12.5914 36.2234 20.9999Z" stroke="#EC2028" stroke-width="3.15" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        @else
            {{-- Info Circle Icon for Second Payment --}}
            <div class="w-[42px] h-[42px] flex items-center justify-center">
                <svg class="w-full h-full" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="21" cy="21" r="19" stroke="{{ $iconColor }}" stroke-width="3" />
                    <path d="M21 14V22M21 28H21.01" stroke="{{ $iconColor }}" stroke-width="3" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
        @endif
        <h1 class="text-[18px] font-semibold text-[#18181b] leading-[26px]">
            {{ $title }}
        </h1>
        <div class="text-center text-[14px] font-normal text-[#3f3f46] leading-[20px]">
            @foreach ($messageLines as $line)
                <span class="{{ $loop->first ? 'mb-3' : '' }} block">{{ $line }}</span>
            @endforeach
        </div>
    </div>

    {{-- Payment Options (Only for Failed or Second Payment) --}}
    @if ($showPaymentOptions)
        <div class="flex flex-col gap-3 items-center">
            @if ($type === 'second-payment')
                {{-- Second Payment Info --}}
                <div
                    class="flex flex-col gap-1 items-center justify-center text-[14px] bg-[#f4f4f5] rounded-lg p-4 w-full max-w-md">
                    <p class="font-medium leading-[20px] text-[#6b6b74]">
                        Deposit Paid
                    </p>
                    <p class="font-semibold leading-[26px] text-[#18181b] text-[18px]">
                        RM {{ number_format($amountPaid ?? 0, 2) }}
                    </p>
                    <div class="w-full h-px bg-[#e4e4e7] my-2"></div>
                    <p class="font-medium leading-[20px] text-[#18181b]">
                        Remaining Balance
                    </p>
                    <p class="font-semibold leading-[38px] text-[#ff6a0c] text-[30px]">
                        RM {{ number_format($remainingAmount ?? 0, 2) }}
                    </p>
                </div>
                <p class="font-medium leading-[20px] text-[#18181b]">
                    Pay now via:
                </p>
            @else
                {{-- First Payment (Failed) Info --}}
                <div class="flex flex-col gap-1 items-center justify-center text-[14px]">
                    <p class="font-medium leading-[20px] text-[#18181b]">
                        Pay booking deposit
                    </p>
                    <p class="font-semibold leading-[38px] text-[#ff6a0c] text-[30px]">
                        RM {{ number_format($depositAmount ?? 300, 2) }}
                    </p>
                    <p class="font-medium leading-[20px] text-[#18181b]">
                        now via:
                    </p>
                </div>
            @endif

            <div class="flex gap-6 justify-center items-center">
                {{-- Credit Card Button --}}
                <div class="flex flex-col gap-1 items-center">
                    <a href="{{ route('web.booking.index', ['booking' => $booking->id]) }}"
                        class="flex gap-1.5 items-center justify-center h-11 px-[10px] py-2 text-[18px] font-medium text-[#3f3f46] rounded-lg border border-[#e4e4e7] bg-white no-underline"
                        style="box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.5 7.5H17.5M2.5 10H17.5M5.83333 15H14.1667C15.5 15 16.1667 15 16.6833 14.7275C17.1417 14.4878 17.5211 14.1083 17.7608 13.65C18.0333 13.1333 18.0333 12.4667 18.0333 11.1333V8.86667C18.0333 7.53333 18.0333 6.86667 17.7608 6.35C17.5211 5.89167 17.1417 5.51222 16.6833 5.2725C16.1667 5 15.5 5 14.1667 5H5.83333C4.5 5 3.83333 5 3.31667 5.2725C2.85833 5.51222 2.47889 5.89167 2.23917 6.35C1.96667 6.86667 1.96667 7.53333 1.96667 8.86667V11.1333C1.96667 12.4667 1.96667 13.1333 2.23917 13.65C2.47889 14.1083 2.85833 14.4878 3.31667 14.7275C3.83333 15 4.5 15 5.83333 15Z"
                                stroke="#3f3f46" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>Credit Card</span>
                    </a>
                    <div class="flex gap-1 items-start text-[12px]">
                        <p class="font-medium leading-[18px] text-[#18181b]">Powered by</p>
                        <img src="https://www.figma.com/api/mcp/asset/1a06d860-1254-4a7c-b0fe-078850e74c84"
                            alt="Stripe" class="h-5 w-[36px] object-contain">
                    </div>
                </div>

                {{-- Online Banking Button --}}
                <div class="flex flex-col gap-1 items-center">
                    <form action="{{ route('web.billplz.process', ['booking' => $booking->id]) }}" method="POST"
                        class="inline">
                        @csrf
                        <button type="submit"
                            class="flex gap-1.5 items-center justify-center h-11 px-[10px] py-2 text-[18px] font-medium text-[#3f3f46] rounded-lg border border-[#e4e4e7] bg-white"
                            style="box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                            <svg class="w-[17px] h-[17px]" viewBox="0 0 17 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.5 15.5833C12.4121 15.5833 15.5833 12.4121 15.5833 8.5C15.5833 4.58792 12.4121 1.41667 8.5 1.41667M8.5 15.5833C4.58792 15.5833 1.41667 12.4121 1.41667 8.5C1.41667 4.58792 4.58792 1.41667 8.5 1.41667M8.5 15.5833C6.54458 15.5833 4.95833 12.4121 4.95833 8.5C4.95833 4.58792 6.54458 1.41667 8.5 1.41667M8.5 15.5833C10.4554 15.5833 12.0417 12.4121 12.0417 8.5C12.0417 4.58792 10.4554 1.41667 8.5 1.41667M1.41667 8.5H15.5833"
                                    stroke="#3f3f46" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>Online Banking</span>
                        </button>
                    </form>
                    <div class="flex gap-1 items-start text-[12px]">
                        <p class="font-medium leading-[18px] text-[#18181b]">Powered by</p>
                        <img src="https://www.figma.com/api/mcp/asset/69adc841-10db-491f-bb12-ac6cdfa70d6a"
                            alt="Billplz" class="h-5 w-[68px] object-contain">
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-2 items-center text-[14px] text-center leading-[20px]">
                <p class="font-normal text-[#6b6b74]">
                    By making payment, you agree that you have read and understood our
                </p>
                <div class="flex gap-2 justify-center items-center">
                    <a href="#" class="font-medium text-[#3f3f46] underline decoration-solid">Terms &
                        Conditions</a>
                    <p class="font-normal text-[#6b6b74]">and</p>
                    <a href="#" class="font-medium text-[#3f3f46] underline decoration-solid">Privacy Policy</a>
                </div>
            </div>
        </div>
    @endif

    {{-- Payment Details Row --}}
    <div class="flex justify-between items-center px-3">
        <div class="flex flex-col gap-1 w-[466px] shrink-0">
            <span class="text-[14px] font-semibold text-[#6b6b74] leading-[20px]">Payment Details</span>
            <div class="flex gap-1 items-center">
                <span class="text-[14px] font-medium text-[#6b6b74] leading-[20px]">Booking No :</span>
                <span class="text-[16px] font-semibold text-[#18181b] leading-[24px]">{{ $bookingNumber }}</span>
            </div>
        </div>
        <button type="button"
            class="flex items-center justify-center h-8 px-[10px] py-[6px] text-[14px] font-medium text-[#3f3f46] rounded-[8px] border border-[#e4e4e7] bg-white"
            style="box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);" onclick="emailQuotation()">
            Email this quotation
        </button>
    </div>

    {{-- Customer + Company Details --}}
    <div class="flex gap-3 justify-between items-start px-3">
        <div class="flex flex-col gap-[15px] text-[14px] text-[#18181b]">
            <span class="text-[16px] font-medium leading-[24px] block">{{ $booking->driver_name ?? 'N/A' }}</span>
            <div class="text-[14px] font-normal leading-[normal] text-[#18181b]">
                <span class="block mb-3">{{ optional($booking->user)->address ?? 'N/A' }}</span>
                <span class="block mb-3">{{ $booking->driver_mobile_number ?? 'N/A' }}</span>
                <span class="block mb-3">{{ optional($booking->user)->email ?? 'N/A' }}</span>
                <span class="block">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</span>
            </div>
        </div>
        <div class="flex flex-col items-end gap-[10px] text-right">
            <img src="{{ asset('images/web/ara-logo-new.jpg') }}" alt="ARA Car Rental"
                class="h-[32px] w-[145px] object-contain">
            <div class="text-[14px] font-normal leading-[normal] text-[#18181b]">
                <span class="block mb-3 font-normal">ARA TIME TRAVEL & TOURS SDN BHD</span>
                <span class="block mb-3">(201801036977)</span>
                <span class="block mb-3">E-1-01 Blok E, Jalan Vita 1,</span>
                <span class="block mb-3">Plaza Crystalville,</span>
                <span class="block mb-3">63000 Cyberjaya, Selangor</span>
                <span class="block mb-3">Tel : +603-8322 6469</span>
                <span class="block mb-3">Email : support@aracarrental.com.my</span>
                <span class="block">SST: W24-2507-32000017</span>
            </div>
        </div>
    </div>

    {{-- Car Title + Tags --}}
    <div class="flex flex-col gap-1 px-3">
        <div class="flex gap-2 items-center">
            @if ($carDetails['brand_logo'])
                <img src="{{ $carDetails['brand_logo'] }}" alt="Brand" class="object-contain w-6 h-6">
            @endif
            <span class="text-[20px] font-semibold text-[#18181b] leading-[30px]">
                {{ $carDetails['name'] ?? 'Car' }}
            </span>
        </div>
        <div class="flex gap-1">
            <span class="px-2 py-0.5 text-[12px] rounded-full font-medium"
                style="background-color: #f4f4f5; border: 1px solid rgba(82,82,91,0.2); color: #6b6b74; line-height: 18px;">
                Group {{ $carDetails['group'] ?? 'A' }}
            </span>
            <span class="px-2 py-0.5 text-[12px] rounded-full font-medium"
                style="background-color: #f4f4f5; border: 1px solid rgba(82,82,91,0.2); color: #6b6b74; line-height: 18px;">
                {{ $carDetails['category'] ?? 'Compact' }}
            </span>
        </div>
    </div>

    {{-- Cost Summary --}}
    <div class="flex flex-col gap-3 px-3">
        <span class="text-[14px] font-semibold text-[#6b6b74] leading-[20px]">Cost Summary</span>

        {{-- Rental --}}
        <div class="flex gap-5 justify-between items-start w-full">
            <div class="flex flex-col flex-1 text-[16px] leading-[24px]">
                <span class="font-medium text-[#18181b]">Rental</span>
                <span class="text-[14px] font-normal text-[#6b6b74]">
                    {{ \Carbon\Carbon::parse($booking->pickup_datetime)->format('d/m/Y, g:i A') }} to
                    {{ \Carbon\Carbon::parse($booking->dropoff_datetime)->format('d/m/Y, g:i A') }}
                </span>
                <span class="text-[14px] font-normal text-[#6b6b74]">
                    (RM {{ number_format($booking->amount_rent_per_day, 2) }}/day) x {{ $booking->duration_days }} Day
                </span>
            </div>
            <span class="text-[18px] font-semibold text-[#18181b] leading-[26px] shrink-0">
                RM {{ number_format($booking->amount_rent, 2) }}
            </span>
        </div>

        <div class="w-full h-0 border-t" style="border-color: #e4e4e7;"></div>

        {{-- Door-to-Door Delivery --}}
        @if ($booking->amount_delivery > 0)
            <div class="flex gap-5 justify-between items-start w-full">
                <div class="flex flex-col flex-1 text-[16px] leading-[24px]">
                    <span class="font-medium text-[#18181b]">Door-to-Door Delivery</span>
                    <span class="text-[14px] font-normal text-[#6b6b74]">
                        From Bandar Puteri, Puchong, Selangor to {{ $booking->pickup_location }}
                    </span>
                </div>
                <span class="text-[18px] font-semibold text-[#18181b] leading-[26px] shrink-0">
                    RM {{ number_format($booking->amount_delivery, 2) }}
                </span>
            </div>
            <div class="w-full h-0 border-t" style="border-color: #e4e4e7;"></div>
        @endif

        {{-- Door-to-Door Pickup --}}
        @if ($booking->amount_dropoff > 0)
            <div class="flex gap-5 justify-between items-start w-full">
                <div class="flex flex-col flex-1 text-[16px] leading-[24px]">
                    <span class="font-medium text-[#18181b]">Door-to-Door Pickup</span>
                    <span class="text-[14px] font-normal text-[#6b6b74]">
                        From {{ $booking->dropoff_location }} to Bandar Puteri, Puchong, Selangor
                    </span>
                </div>
                <span class="text-[18px] font-semibold text-[#18181b] leading-[26px] shrink-0">
                    RM {{ number_format($booking->amount_dropoff, 2) }}
                </span>
            </div>
            <div class="w-full h-0 border-t" style="border-color: #e4e4e7;"></div>
        @endif

        {{-- Add-Ons --}}
        @if (isset($addons) && count($addons) > 0)
            <div class="flex items-center">
                <span class="text-[14px] font-semibold text-[#6b6b74] leading-[20px]">Add-Ons</span>
            </div>

            @foreach ($addons as $addon)
                <div class="flex gap-5 justify-between items-start w-full">
                    <div class="flex flex-col flex-1 text-[16px] leading-[24px]">
                        <span class="font-medium text-[#18181b]">{{ $addon['name'] }}</span>
                        <span class="text-[14px] font-normal text-[#6b6b74]">
                            RM {{ number_format($addon['price'], 2) }}/{{ $addon['unit'] ?? 'pcs' }}
                        </span>
                        @if ($addon['quantity'] > 1)
                            <span class="text-[14px] font-normal text-[#6b6b74]">
                                Total {{ $addon['quantity'] }} {{ $addon['unit'] ?? 'pcs' }}
                            </span>
                        @endif
                        <span class="text-[14px] font-normal text-[#6b6b74]">
                            (RM {{ number_format($addon['price'] * $addon['quantity'], 2) }}/day)
                            x {{ $booking->duration_days }} Day
                        </span>
                    </div>
                    <span class="text-[18px] font-semibold text-[#18181b] leading-[26px] shrink-0">
                        RM {{ number_format($addon['total_price'], 2) }}
                    </span>
                </div>
                @if (!$loop->last)
                    <div class="w-full h-0 border-t" style="border-color: #e4e4e7;"></div>
                @endif
            @endforeach

            <div class="w-full h-0 border-t" style="border-color: #e4e4e7;"></div>
        @endif

        {{-- Discount --}}
        @if (isset($carDetails['is_promo']) && $carDetails['is_promo'] && $carDetails['discount'] > 0)
            <div class="flex gap-0 justify-end items-center">
                <span class="z-10 px-2 py-0.5 -mr-2 text-[12px] font-medium"
                    style="background-color: #fff4ed; border: 1px solid #ff9960; color: #fe7439; border-radius: 6px 0 0 6px; padding-right: 12px; line-height: 18px;">
                    TOTAL DEAL
                </span>
                <span class="py-0.5 pr-2 pl-4 text-[12px] font-medium"
                    style="background-color: #fe7439; color: #fff4ed; border-radius: 6px; padding-left: 12px; line-height: 18px; border: 1.5px solid #ff9960;">
                    {{ $carDetails['promo_percentage'] ?? 10 }}% OFF
                </span>
            </div>

            <div class="flex gap-5 justify-between items-start w-full">
                <div class="flex flex-col flex-1 text-[16px] leading-[24px]">
                    <span class="font-medium text-[#18181b]">Discount</span>
                    <span class="text-[14px] font-normal text-[#6b6b74]">Seasonal Discount</span>
                    <span class="text-[14px] font-normal text-[#6b6b74]">Special Adjustment</span>
                </div>
                <span class="text-[18px] font-semibold text-[#fe7439] leading-[26px] shrink-0">
                    - RM {{ number_format($carDetails['discount'], 2) }}
                </span>
            </div>
        @endif

        <div class="bg-[#f4f4f5] rounded-lg p-3 flex flex-col gap-6 w-full">
            <div class="flex justify-between items-center">
                <span class="text-[16px] font-semibold text-[#18181b] leading-[24px]">Sub-Total</span>
                <span class="text-[18px] font-semibold text-[#18181b] leading-[26px]">
                    RM {{ number_format($subtotal ?? 0, 2) }}
                </span>
            </div>

            <div class="w-full h-0 border-t" style="border-color: #e4e4e7;"></div>

            <div class="flex gap-5 justify-between items-start w-full">
                <div class="flex flex-col flex-1 text-[16px] leading-[24px]">
                    <span class="font-medium text-[#18181b]">Taxes and Charge</span>
                    <span class="text-[14px] font-normal text-[#6b6b74]">8% SST Charge</span>
                </div>
                <span class="text-[18px] font-semibold text-[#18181b] leading-[26px] shrink-0">
                    RM {{ number_format($booking->amount_sst ?? 0, 2) }}
                </span>
            </div>

            <div class="w-full h-0 border-t" style="border-color: #e4e4e7;"></div>

            <div class="flex gap-5 justify-between items-start w-full">
                <span class="text-[16px] font-medium text-[#18181b] leading-[24px] flex-1">
                    Security Deposit (Refundable)
                </span>
                <span class="text-[18px] font-semibold text-[#18181b] leading-[26px] shrink-0">
                    RM {{ number_format($booking->amount_secd ?? 0, 2) }}
                </span>
            </div>

            <div class="w-full h-0 border-t" style="border-color: #e4e4e7;"></div>

            <div class="flex justify-between items-center w-full">
                <span class="text-[24px] font-semibold text-[#18181b] leading-[32px]">
                    {{ $type === 'failed' ? 'Remaining Balance' : 'Total' }}
                </span>
                <span class="text-[24px] font-semibold text-[#ff6a0c] leading-[32px]">
                    RM
                    {{ number_format($type === 'failed' ? $booking->amount - ($booking->amount_secd ?? 0) : $booking->amount, 2) }}
                </span>
            </div>
        </div>

        {{-- Amount Paid Section (Only for Success) --}}
        @if ($type === 'success' && isset($paymentDisplay))
            @php
                $paidDate = \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y');
                $paidDateParts = explode('/', $paidDate);
            @endphp
            <div class="bg-[#fff5ed] rounded-lg p-3 flex flex-col gap-3 w-full">
                <div class="flex gap-5 justify-between items-start w-full">
                    <div class="flex flex-col flex-1">
                        <span class="text-[16px] font-medium text-[#18181b] leading-[24px]">Amount Paid</span>
                        <div class="flex items-center text-[16px] leading-[24px]">
                            <span class="text-[#18181b]">{{ $paidDateParts[0] ?? '' }}</span>
                            <span class="text-[14px] text-[#a1a1aa]">/</span>
                            <span class="text-[#18181b]">{{ $paidDateParts[1] ?? '' }}</span>
                            <span class="text-[14px] text-[#a1a1aa]">/</span>
                            <span class="text-[#18181b]">{{ $paidDateParts[2] ?? '' }}</span>
                        </div>
                    </div>
                    <span class="text-[18px] font-semibold text-[#18181b] leading-[26px] shrink-0">
                        RM {{ number_format($paymentDisplay['amountPaid'] ?? 0, 2) }}
                    </span>
                </div>

                @if (($paymentDisplay['showRemaining'] ?? true) && $paymentDisplay['remainingBalance'] > 0)
                    <div class="w-full h-0 border-t" style="border-color: #e4e4e7;"></div>

                    <div class="flex gap-5 justify-between items-start w-full">
                        <span class="text-[16px] font-medium text-[#18181b] leading-[24px] flex-1">Remaining
                            Balance</span>
                        <span class="text-[18px] font-semibold text-[#18181b] leading-[26px] shrink-0">
                            RM {{ number_format($paymentDisplay['remainingBalance'] ?? 0, 2) }}
                        </span>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <a href="{{ route('web.index') }}"
        class="flex justify-center items-center h-8 px-[10px] py-[6px] text-[14px] font-medium text-[#3f3f46] rounded-[8px] border border-[#e4e4e7] bg-white no-underline"
        style="box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
        Back to main
    </a>
</div>

<script>
    function emailQuotation() {
        alert('Email quotation functionality coming soon!');
        // TODO: Implement email quotation
    }
</script>
