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
                @include('web.components.stepper')
            </div>

            {{-- Content Area --}}
            <div class="flex mx-auto max-w-[1280px] gap-3 pt-12 pb-[148px]">
                {{-- Sidebar --}}
                <div class="shrink-0 w-[300px]">
                    @include('web.addon.components.sidebar-details', ['carDetails' => $carDetails])
                </div>

                {{-- Main Content --}}
                <div class="flex flex-col flex-1 w-[968px] gap-3">
                    {{-- Start & Return Location Card --}}
                    <div class="flex flex-col bg-white rounded-lg border border-[#e4e4e7] p-6"
                        style="box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05);">
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
                                            <span class="text-xs font-normal text-[#6b6b74] leading-3">(RM 1.80/km)</span>
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
                                            <span class="text-xs font-normal text-[#6b6b74] leading-3">(RM 1.80/km)</span>
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

                    {{-- Add-ons Card --}}
                    <div class="flex flex-col bg-white rounded-lg border border-[#e4e4e7]"
                        style="box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05);">
                        <div class="px-6 pt-6">
                            <p class="text-sm font-semibold text-[#6b6b74] leading-5">Choose add-on</p>
                        </div>

                        <div class="flex flex-col p-6">
                            @foreach ($addOns as $addon)
                                @include('web.addon.components.addon-card', ['addon' => $addon])
                            @endforeach
                        </div>
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

                    <a href="#"
                        class="flex justify-center items-center h-8 px-[10px] py-[6px] gap-[6px] font-medium text-sm leading-5 text-white bg-[#ec2028] border border-[#ec2028] rounded-lg transition-colors hover:opacity-90 no-underline"
                        style="box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                        Save & Continue
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
