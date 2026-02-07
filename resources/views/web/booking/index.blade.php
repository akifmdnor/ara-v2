@extends('web.layouts.app')

@section('title', 'Booking & Payment - ARA Car Rental')

@section('content')
    <div class="w-full min-h-screen bg-white">
        {{-- Navigation --}}
        @include('web.components.navbar')

        {{-- Main Content --}}
        <div class="w-full bg-white">
            {{-- Stepper --}}
            <div class="mx-auto max-w-[1280px] pt-12">
                @include('web.components.stepper', ['currentStep' => 4])
            </div>

            {{-- Content Area --}}
            <div class="flex mx-auto max-w-[1280px] gap-2.5 pt-12 pb-[148px]">
                {{-- Sidebar --}}
                <div class="shrink-0 w-[300px]">
                    @include('web.components.booking-sidebar', ['carDetails' => $carDetails, 'addons' => $addons ?? []])
                </div>

                {{-- Main Content --}}
                <div class="flex flex-col flex-1 w-[968px] gap-2.5">
                    {{-- Payment Card - Figma Design --}}
                    <div class="flex flex-col items-center justify-center gap-6 p-6 bg-white border border-[#e4e4e7] rounded-lg min-h-[766px]"
                        style="box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05);">

                        {{-- Header Section --}}
                        <div class="flex flex-col gap-1 justify-center items-center text-center">
                            <p class="text-sm font-medium text-[#18181b] leading-5">
                                Pay booking deposit
                            </p>
                            <p class="text-[30px] font-semibold text-[#ff6a0c] leading-[38px]">
                                RM {{ number_format($carDetails['security_deposit'] ?? 0, 2) }}
                            </p>
                            <p class="text-sm font-medium text-[#18181b] leading-5">
                                now via:
                            </p>
                        </div>

                        {{-- Payment Buttons --}}
                        <form id="booking-form" action="{{ route('web.booking.store') }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                            <input type="hidden" name="agree_terms" value="1">

                            <div class="flex gap-6 justify-center items-center">
                                {{-- Credit Card Button --}}
                                <div class="flex flex-col gap-1 items-center">
                                    <button type="submit" name="payment_method" value="online"
                                        class="flex items-center justify-center gap-[6px] h-11 px-[10px] py-2 bg-white border border-[#e4e4e7] rounded-lg hover:border-[#ec2028] transition-colors"
                                        style="box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.6667 3.33334H3.33333C2.41286 3.33334 1.66667 4.07954 1.66667 5.00001V15C1.66667 15.9205 2.41286 16.6667 3.33333 16.6667H16.6667C17.5871 16.6667 18.3333 15.9205 18.3333 15V5.00001C18.3333 4.07954 17.5871 3.33334 16.6667 3.33334Z"
                                                stroke="#3F3F46" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M1.66667 8.33334H18.3333" stroke="#3F3F46" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="text-lg font-medium text-[#3f3f46] leading-[26px]">Credit Card</span>
                                    </button>
                                    <div class="flex gap-1 items-start">
                                        <span class="text-xs font-medium text-[#18181b] leading-[18px]">Powered by</span>
                                        <span class="text-xs font-semibold text-[#635bff] leading-[18px]">stripe</span>
                                    </div>
                                </div>

                                {{-- Online Banking Button --}}
                                <div class="flex flex-col gap-1 items-center">
                                    <button type="submit" name="payment_method" value="online"
                                        class="flex items-center justify-center gap-[6px] h-11 px-[10px] py-2 bg-white border border-[#e4e4e7] rounded-lg hover:border-[#ec2028] transition-colors"
                                        style="box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.5 15.5833C12.4119 15.5833 15.5833 12.4119 15.5833 8.49999C15.5833 4.58806 12.4119 1.41666 8.5 1.41666C4.58807 1.41666 1.41667 4.58806 1.41667 8.49999C1.41667 12.4119 4.58807 15.5833 8.5 15.5833Z"
                                                stroke="#3F3F46" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M1.41667 8.5H15.5833" stroke="#3F3F46" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M8.5 1.41666C10.2663 3.33129 11.2589 5.85567 11.2589 8.49999C11.2589 11.1443 10.2663 13.6687 8.5 15.5833C6.73369 13.6687 5.74113 11.1443 5.74113 8.49999C5.74113 5.85567 6.73369 3.33129 8.5 1.41666Z"
                                                stroke="#3F3F46" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="text-lg font-medium text-[#3f3f46] leading-[26px]">Online
                                            Banking</span>
                                    </button>
                                    <div class="flex gap-1 items-start">
                                        <span class="text-xs font-medium text-[#18181b] leading-[18px]">Powered by</span>
                                        <img src="https://www.billplz.com/assets/brand/logo-1cd67bf944e1f4f8927c49257cea2aeb.svg"
                                            alt="Billplz" class="h-[18px]">
                                    </div>
                                </div>
                            </div>
                        </form>

                        {{-- Terms Text --}}
                        <div class="flex flex-col gap-2 items-center text-sm leading-5 text-center">
                            <p class="font-normal text-[#6b6b74]">
                                By making payment, you agree that you have read and understood our
                            </p>
                            <div class="flex gap-2 justify-center items-center">
                                <a href="#" class="font-medium text-[#3f3f46] underline hover:text-[#18181b]">Terms &
                                    Conditions</a>
                                <span class="font-normal text-[#6b6b74]">and</span>
                                <a href="#" class="font-medium text-[#3f3f46] underline hover:text-[#18181b]">Privacy
                                    Policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
