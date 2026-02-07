@extends('web.layouts.app')

@section('title', 'Booking Confirmation - ARA Car Rental')

@section('content')
    <div class="w-full min-h-screen bg-white">
        {{-- Navigation --}}
        @include('web.components.navbar')

        {{-- Main Content --}}
        <div class="py-12 w-full bg-white">
            <div class="mx-auto max-w-[800px] px-4">
                {{-- Success Message --}}
                <div class="flex flex-col gap-6 items-center p-8 bg-white rounded-lg"
                    style="border-radius: var(--Radius-Medium, 8px); background: var(--Background-bg-dialog, #FFF); box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05);">

                    {{-- Success Icon --}}
                    <div class="flex items-center justify-center w-20 h-20 bg-[#10b981] rounded-full">
                        <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>

                    {{-- Title --}}
                    <div class="flex flex-col gap-2 items-center text-center">
                        <span class="text-2xl font-bold text-[#18181b] leading-8">
                            Booking Confirmed!
                        </span>
                        <span class="text-base font-light text-[#6b6b74] leading-6">
                            Your booking has been successfully created
                        </span>
                    </div>

                    {{-- Booking Number --}}
                    <div class="flex flex-col items-center gap-2 p-4 bg-[#f4f4f5] rounded-lg w-full">
                        <span class="text-sm font-normal text-[#6b6b74] leading-5">Booking Number</span>
                        <span class="text-xl font-bold text-[#ec2028] leading-7">
                            BK{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    {{-- Booking Details --}}
                    <div class="flex flex-col gap-4 w-full border-t border-[#e4e4e7] pt-6">
                        <span class="text-base font-semibold text-[#18181b] leading-6">Booking Details</span>

                        <div class="flex justify-between">
                            <span class="text-sm font-light text-[#6b6b74]">Car</span>
                            <span
                                class="text-sm font-normal text-[#18181b]">{{ $booking->car_model->model_specification->model_name ?? 'N/A' }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm font-light text-[#6b6b74]">Pickup</span>
                            <span class="text-sm font-normal text-[#18181b]">{{ $booking->pickup_datetime }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm font-light text-[#6b6b74]">Drop-off</span>
                            <span class="text-sm font-normal text-[#18181b]">{{ $booking->dropoff_datetime }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm font-light text-[#6b6b74]">Total Amount</span>
                            <span class="text-lg font-bold text-[#ec2028]">RM
                                {{ number_format($booking->amount, 2) }}</span>
                        </div>

                        @if ($booking->payment_status === 'Pending')
                            <div class="flex flex-col gap-2 p-4 bg-[#fef2f2] border border-[#fecaca] rounded-lg">
                                <span class="text-sm font-normal text-[#dc2626] leading-5">
                                    Payment Required: Please pay at the counter when picking up your vehicle
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 pt-4 w-full">
                        <a href="{{ route('web.index') }}"
                            class="flex-1 flex justify-center items-center h-10 px-4 py-2 border border-[#e4e4e7] rounded-lg bg-white text-[#3f3f46] font-medium text-base hover:bg-gray-50 transition-colors">
                            Back to Home
                        </a>
                        <button type="button" onclick="window.print()"
                            class="flex-1 flex justify-center items-center h-10 px-4 py-2 bg-[#ec2028] border border-[#ec2028] rounded-lg text-white font-medium text-base hover:opacity-90 transition-opacity">
                            Print Confirmation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
