{{-- Car Model Row Component - Matches Figma Design for Expanded Car Details --}}
@php
    use App\Services\StorageHelper;

    // Check if this car model is fully booked/unavailable (already calculated in SearchService)
    $isFullyBooked = isset($carModel->unavailable) && $carModel->unavailable;
    $isPromo = isset($carModel->is_promo) && $carModel->is_promo;

    // Get car image
    $carImageUrl = asset('images/web/homepage/car_undercover.png');
    if (isset($carModel->feature_picture) && count($carModel->feature_picture) > 0) {
        $carImageUrl = StorageHelper::v1Url($carModel->feature_picture);
    }

    // Generate unique ID for spec variant selector
    $variantId = 'variant-  ' . ($carModel->id ?? uniqid());

    // Prepare modal data
    $modalData = [
        'modelName' => $carModel->name ?? ($modelSpec->model_name . ' ' . $modelSpec->model_code ?? 'Car Model'),
        'brandLogo' => isset($modelSpec->brand_logo) ? StorageHelper::v1Url($modelSpec->brand_logo) : null,
        'pictures' => isset($carModel->pictures)
            ? $carModel->pictures
                ->map(function ($pic) {
                    return StorageHelper::v1Url($pic->file_name);
                })
                ->toArray()
            : [],
    ];
@endphp

<div class="flex relative gap-1 p-3 transition-all duration-500 ease-in-out transform"
    style="background-color: {{ $isFullyBooked ? 'rgba(244,244,245,0.4)' : 'rgba(244,244,245,0.4)' }}; {{ $isFullyBooked ? 'border-top: 1px solid #d4d4d8; border-bottom: 1px solid #d4d4d8;' : '' }}"
    x-data="{ selectedVariant: 'disabled', isExpanded: true }" x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95">

    {{-- Left Section: Car Model Image and Options --}}
    <div class="flex flex-col gap-3 transition-all duration-500 ease-in-out w-[240px]"
        style="width: 240px; {{ $isFullyBooked ? 'opacity: 0.2;' : '' }}"
        x-transition:enter="transition ease-out duration-500 delay-100"
        x-transition:enter-start="opacity-0 transform translate-x-[-20px]"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-x-[-20px]">
        <p class="text-base font-medium" style="color: #18181b; line-height: 24px;">
            {{ $carModel->name ?? ($modelSpec->brand . ' ' . $modelSpec->model_name . ' ' . $modelSpec->model_code ?? 'Car Model') }}
        </p>

        <div style="width: 160px; height: 120px;"
            class="transition-all duration-300 ease-in-out cursor-pointer hover:scale-105">
            <img src="{{ $carImageUrl }}" alt="{{ $carModel->name ?? 'Car' }}"
                class="object-contain w-full h-full transition-all duration-300 ease-in-out">
        </div>

        {{-- Variant Selection --}}
        <div class="flex flex-col gap-1">
            <span class="text-[12px] font-normal" style="color: #6b6b74; line-height: 18px;">
                Choose spec variant:
            </span>
            <div class="flex rounded-lg transition-all duration-300 ease-in-out w-[240px]"
                style="background-color: #f4f4f5;">
                <button @click.stop="selectedVariant = 'low'" disabled
                    :class="selectedVariant === 'low' ? 'bg-red-600 shadow-sm transform scale-105' : ''"
                    class="flex-1 px-2.5 py-1.5 text-sm font-normal rounded-lg transition-all duration-200 ease-in-out min-h-8 hover:scale-105"
                    :style="selectedVariant === 'low' ?
                        'color: white; background-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                        'color: #6b6b74;'">
                    Low
                </button>
                <button @click.stop="selectedVariant = 'med'" disabled
                    :class="selectedVariant === 'med' ? 'bg-red-600 shadow-sm transform scale-105' : ''"
                    class="flex-1 px-2.5 py-1.5 text-sm font-normal rounded-lg transition-all duration-200 ease-in-out min-h-8 hover:scale-105"
                    :style="selectedVariant === 'med' ?
                        'color: white; background-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                        'color: #6b6b74;'">
                    Med
                </button>
                <div class="self-center w-0 h-3 border-r transition-all duration-300 ease-in-out"
                    style="border-color: #d4d4d8;"></div>
                <button @click.stop="selectedVariant = 'full'" disabled
                    :class="selectedVariant === 'full' ? 'bg-red-600 shadow-sm transform scale-105' : ''"
                    class="flex-1 px-2.5 py-1.5 text-sm font-normal rounded-lg transition-all duration-200 ease-in-out min-h-8 hover:scale-105"
                    :style="selectedVariant === 'full' ?
                        'color: white; background-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                        'color: #6b6b74;'">
                    Full
                </button>

                <div class="self-center w-0 h-3 border-r transition-all duration-300 ease-in-out"
                    style="border-color: #d4d4d8;"></div>

                <button @click.stop="selectedVariant = 'premium'" disabled
                    :class="selectedVariant === 'premium' ? 'bg-red-600 shadow-sm transform scale-105' : ''"
                    class="flex-1 px-2.5 py-1.5 text-sm font-normal rounded-lg transition-all duration-200 ease-in-out min-h-8 hover:scale-105"
                    :style="selectedVariant === 'premium' ?
                        'color: white; background-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                        'color: #6b6b74;'">
                    Premium
                </button>
            </div>
        </div>

        {{-- View Image Button --}}
        <button @click.stop="$dispatch('open-car-modal', {{ json_encode($modalData) }})"
            class="flex gap-1.5 items-center px-2.5 py-1.5 h-8 rounded-lg border transition-all duration-200 ease-in-out hover:bg-gray-50 hover:scale-105 hover:shadow-md"
            style="background-color: white; border-color: #e4e4e7; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
            <svg class="w-4 h-4" style="color: #3f3f46;" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
            </svg>
            <span class="text-sm font-normal" style="color: #3f3f46; line-height: 20px;">View Actual Car Image</span>
        </button>
    </div>

    <div class="self-stretch pr-3 ml-3 w-px border-l" style="border-color: #e4e4e7;"></div> {{-- Middle Section: Location, Hours, Features --}}
    <div class="flex flex-col flex-1 gap-2 transition-all duration-500 ease-in-out"
        style="{{ $isFullyBooked ? 'opacity: 0.2;' : '' }}"
        x-transition:enter="transition ease-out duration-500 delay-200"
        x-transition:enter-start="opacity-0 transform translate-y-[20px]"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300 delay-100"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-[20px]">
        {{-- Location --}}
        <div class="flex flex-col">
            <div class="flex gap-1.5 items-center w-4.5 h-4.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                    fill="none">
                    <path
                        d="M6.52461 2.4751L2.47461 4.2751V15.5251L6.52461 13.7251M6.52461 2.4751V13.7251M6.52461 2.4751L11.4746 4.2751M6.52461 13.7251L11.4746 15.5251M11.4746 4.2751L15.5246 2.4751V13.7251L11.4746 15.5251M11.4746 4.2751V15.5251"
                        stroke="#3F3F46" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="flex-1 text-base underline"
                    style="color: #ec2028; line-height: 24px; text-decoration-line: underline;">
                    {{ $carModel->branch->city ?? '' }}{{ $carModel->branch->city && $carModel->branch->country ? ', ' : '' }}{{ $carModel->branch->country ?? '' }}
                </span>
            </div>
        </div>

        {{-- Opening Hours --}}
        <div class="flex flex-col">
            <div class="flex gap-1 items-center w-4.5 h-4.5">
                <svg class="w-4.5 h-4.5" style="color: #3f3f46; width: 18px; height: 18px;" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                <span class="flex-1 text-base font-normal" style="color: #3f3f46; line-height: 24px;">
                    Opening Hours : {{ $carModel->branch->opening_hours ?? '09:00 AM - 11:00 PM' }}
                </span>
            </div>
        </div>

        {{-- Add-ons Included --}}
        <div class="flex gap-1">
            <div class="flex flex-col flex-1 gap-1">
                @php
                    $includedItems = [];
                    if (isset($modelSpec->includedArray)) {
                        $includedItems = array_slice($modelSpec->includedArray, 0, 3);
                    }
                @endphp
                @foreach ($includedItems as $item)
                    <div class="flex gap-1.5 items-start">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                            class="flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 11.2143L8.12645 12.5116C8.55869 13.0095 9.34594 12.9601 9.71261 12.4122L13 7.5M17.25 10C17.25 14.0041 14.0041 17.25 10 17.25C5.99594 17.25 2.75 14.0041 2.75 10C2.75 5.99594 5.99594 2.75 10 2.75C14.0041 2.75 17.25 5.99594 17.25 10Z"
                                stroke="#15803D" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span class="text-base font-normal"
                            style="color: #6b6b74; line-height: 20px;">{!! $item !!}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex flex-col flex-1 gap-1">
                @php
                    $includedItems2 = [];
                    if (isset($modelSpec->includedArray)) {
                        $includedItems2 = array_slice($modelSpec->includedArray, 3, 3);
                    }
                @endphp
                @foreach ($includedItems2 as $item)
                    <div class="flex gap-1.5 items-center">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 11.2143L8.12645 12.5116C8.55869 13.0095 9.34594 12.9601 9.71261 12.4122L13 7.5M17.25 10C17.25 14.0041 14.0041 17.25 10 17.25C5.99594 17.25 2.75 14.0041 2.75 10C2.75 5.99594 5.99594 2.75 10 2.75C14.0041 2.75 17.25 5.99594 17.25 10Z"
                                stroke="#15803D" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span class="text-base font-normal"
                            style="color: #6b6b74; line-height: 20px;">{{ $item }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right Section: Price and Action --}}
    <div class="flex relative flex-col justify-between items-end transition-all duration-500 ease-in-out"
        x-transition:enter="transition ease-out duration-500 delay-300"
        x-transition:enter-start="opacity-0 transform translate-x-[20px]"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-300 delay-200"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-x-[20px]">
        @if ($isFullyBooked)
            {{-- Sale Tags (show even for fully booked if promo available) --}}
            @if ($carModel->is_promo)
                <div class="flex justify-end items-start">
                    <div class="flex gap-0 items-center">
                        <div class="flex items-center px-2 py-0.5 text-[12px] font-medium border"
                            style="height: 22px; background-color: #fff4ed; border-color: #ff9960; color: #fe7439; border-radius: 6px 0 0 6px; padding-right: 12px; margin-right: -8px; z-index: 1;">
                            SALE
                        </div>
                        <div class="flex items-center px-2 py-0.5 text-[12px] font-medium"
                            style="height: 22px; background-color: #fe7439; color: #fff4ed; border-radius: 6px; padding-left: 8px; margin-right: -8px; margin-left:8px">
                            {{ $carModel->promo_percentage }}% OFF TODAY
                        </div>
                    </div>
                </div>
            @endif

            {{-- Fully Booked Badge --}}
            <div class="flex items-center px-2 py-0.5 text-[24px] font-medium rounded border"
                style="background-color: #fff1f2; border-color: #ff9ea2; color: #ec2028; height: auto; line-height: 32px;">
                FULLY BOOKED
            </div>

            {{-- Price Display (with opacity) --}}
            <div class="flex flex-col justify-center items-end" style="width: 230px; opacity: 0.2;">
                <p class="text-base font-normal" style="color: #6b6b74; line-height: 20px;">Prices from</p>
                <div class="flex items-baseline">
                    <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                        {{ number_format($carModel->price_per_day ?? 210, 2) }}</span>
                    <span class="text-base font-normal" style="color: #6b6b74; line-height: 20px;">/day</span>
                </div>
                <p class="text-base font-normal" style="color: #3f3f46; line-height: 20px;">Total RM
                    {{ number_format($carModel->total_price ?? 420, 2) }}</p>
            </div>
        @else
            @if ($carModel->is_promo)
                {{-- Sale Tags --}}
                <div class="flex justify-end items-start">
                    <div class="flex gap-0 items-center">
                        <div class="flex items-center px-2 py-0.5 text-[12px] font-medium border"
                            style="height: 22px; background-color: #fff4ed; border-color: #ff9960; color: #fe7439; border-radius: 6px 0 0 6px; padding-right: 12px; margin-right: -8px; z-index: 1;">
                            SALE
                        </div>
                        <div class="flex items-center px-2 py-0.5 text-[12px] font-medium"
                            style="height: 22px; background-color: #fe7439; color: #fff4ed; border-radius: 6px; padding-left: 8px; margin-right: -8px; margin-left:8px">
                            {{ $carModel->promo_percentage }}% OFF TODAY
                        </div>
                    </div>
                </div>
            @endif

            {{-- Price Display --}}
            <div class="flex flex-col justify-start items-end h-full" style="width: 200px;">
                <span class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">Prices from</span>

                @if ($carModel->is_promo)
                    {{-- Show crossed out original price using strike through --}}
                    <span class="text-sm font-normal line-through" style="color: #6b6b74; line-height: 20px; ">RM
                        {{ number_format($carModel->normal_price_perday, 2) }}</span>
                    <div class="relative">
                        <div class="flex items-baseline">
                            <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                                {{ number_format($carModel->price_per_day, 2) }}</span>
                            <span class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">/day</span>
                        </div>
                        {{-- Strike through line --}}

                    </div>
                @else
                    {{-- Normal price --}}
                    <div class="flex items-baseline">
                        <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                            {{ number_format($carModel->normal_price_per_day ?? 0, 2) }}</span>
                        <span class="text-base font-normal" style="color: #6b6b74; line-height: 20px;">/day</span>
                    </div>
                @endif

                <span class="text-sm font-normal" style="color: #3f3f46; line-height: 20px;">Total RM
                    {{ number_format($carModel->total_price ?? 0, 2) }}</span>
            </div>

            {{-- Select Button --}}
            <a href="{{ route('web.addon', [
                'car_model_id' => $carModel->id,
                'model_spec_id' => $modelSpec->id,
                'pickup_location' => request('pickup_location'),
                'pickup_latitude' => request('pickup_latitude'),
                'pickup_longitude' => request('pickup_longitude'),
                'pickup_date' => request('pickup_date'),
                'pickup_time' => request('pickup_time'),
                'return_location' => request('return_location'),
                'return_latitude' => request('return_latitude'),
                'return_longitude' => request('return_longitude'),
                'return_date' => request('return_date'),
                'return_time' => request('return_time'),
            ]) }}"
                class="flex gap-1.5 justify-center items-center px-2.5 py-1.5 h-8 rounded-lg border transition-all duration-200 ease-in-out transform hover:opacity-90 hover:scale-105 hover:shadow-lg"
                style="background-color: #ec2028; border-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); text-decoration: none;">
                <span class="text-sm font-normal text-white" style="line-height: 20px;">Select this car</span>
            </a>
        @endif
    </div>
</div>
