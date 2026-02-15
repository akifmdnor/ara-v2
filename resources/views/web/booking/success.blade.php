@extends('web.layouts.app')

@section('title', 'Payment Success - ARA Car Rental')

@section('content')
    @php
        $bookingNumber = $booking->booking_number ?? 'BK' . str_pad($booking->id, 4, '0', STR_PAD_LEFT);
        $paidDate = \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y');
        $paidDateParts = explode('/', $paidDate);
    @endphp

    <div class="w-full min-h-screen bg-white">
        {{-- Navigation --}}
        @include('web.components.navbar')

        {{-- Main Content --}}
        <div class="w-full bg-white">
            {{-- Content Area --}}
            <div class="flex mx-auto max-w-[1280px] gap-3 px-4 lg:px-[190px] py-12">
                {{-- Left Sidebar --}}
                <div class="shrink-0 w-[300px]">
                    @include('web.components.booking-sidebar', [
                        'carDetails' => $carDetails,
                        'addons' => $addons ?? [],
                    ])
                </div>

                {{-- Main Card --}}
                <div class="flex flex-col flex-1">
                    @include('web.components.payment-result', [
                        'type' => 'success',
                        'booking' => $booking,
                        'bookingNumber' => $bookingNumber,
                        'carDetails' => $carDetails,
                        'addons' => $addons ?? [],
                        'subtotal' => $subtotal ?? 0,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
