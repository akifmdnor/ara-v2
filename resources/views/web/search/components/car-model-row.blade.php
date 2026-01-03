{{-- Car Model Row Component - Matches Figma Design for Expanded Car Details --}}
@php
    use App\Services\StorageHelper;

    // Check if this car model is fully booked/unavailable (already calculated in SearchService)
    $isFullyBooked = isset($carModel->unavailable) && $carModel->unavailable;
    $isPromo = isset($carModel->is_promo) && $carModel->is_promo;

    // Get car image
    $carImageUrl = asset('images/ara-logo.png');
    if (isset($carModel->pictures) && count($carModel->pictures) > 0) {
        $carImageUrl = StorageHelper::v1Url($carModel->pictures[0]->file_name);
    }

    // Generate unique ID for spec variant selector
    $variantId = 'variant-' . ($carModel->id ?? uniqid());
@endphp

<div class="flex gap-6 p-3 relative transition-all duration-500 ease-in-out transform"
    style="background-color: {{ $isFullyBooked ? 'rgba(244,244,245,0.4)' : 'rgba(244,244,245,0.4)' }}; {{ $isFullyBooked ? 'border-top: 1px solid #d4d4d8; border-bottom: 1px solid #d4d4d8;' : '' }}"
    x-data="{ selectedVariant: 'low', isExpanded: true }" x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95">

    {{-- Left Section: Car Model Image and Options --}}
    <div class="flex flex-col gap-3 transition-all duration-500 ease-in-out"
        style="width: 172px; {{ $isFullyBooked ? 'opacity: 0.2;' : '' }}"
        x-transition:enter="transition ease-out duration-500 delay-100"
        x-transition:enter-start="opacity-0 transform translate-x-[-20px]"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-x-[-20px]">
        <p class="text-base font-medium" style="color: #18181b; line-height: 24px;">
            {{ $carModel->name ?? ($modelSpec->model_name ?? 'Car Model') }}
        </p>

        <div style="width: 160px; height: 120px;"
            class="transition-all duration-300 ease-in-out hover:scale-105 cursor-pointer">
            <img src="{{ $carImageUrl }}" alt="{{ $carModel->name ?? 'Car' }}"
                class="w-full h-full object-contain transition-all duration-300 ease-in-out">
        </div>

        {{-- Variant Selection --}}
        <div class="flex flex-col gap-1">
            <p class="text-[12px] font-normal" style="color: #6b6b74; line-height: 18px;">
                Choose spec variant:
            </p>
            <div class="flex rounded-lg transition-all duration-300 ease-in-out" style="background-color: #f4f4f5;">
                <button @click.stop="selectedVariant = 'low'"
                    :class="selectedVariant === 'low' ? 'bg-red-600 shadow-sm transform scale-105' : ''"
                    class="flex-1 min-h-8 px-2.5 py-1.5 text-sm font-normal rounded-lg transition-all duration-200 ease-in-out hover:scale-105"
                    :style="selectedVariant === 'low' ?
                        'color: white; background-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                        'color: #6b6b74;'">
                    Low
                </button>
                <button @click.stop="selectedVariant = 'med'"
                    :class="selectedVariant === 'med' ? 'bg-red-600 shadow-sm transform scale-105' : ''"
                    class="flex-1 min-h-8 px-2.5 py-1.5 text-sm font-normal rounded-lg transition-all duration-200 ease-in-out hover:scale-105"
                    :style="selectedVariant === 'med' ?
                        'color: white; background-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                        'color: #6b6b74;'">
                    Med
                </button>
                <div class="h-3 w-0 border-r self-center transition-all duration-300 ease-in-out"
                    style="border-color: #d4d4d8;"></div>
                <button @click.stop="selectedVariant = 'full'"
                    :class="selectedVariant === 'full' ? 'bg-red-600 shadow-sm transform scale-105' : ''"
                    class="flex-1 min-h-8 px-2.5 py-1.5 text-sm font-normal rounded-lg transition-all duration-200 ease-in-out hover:scale-105"
                    :style="selectedVariant === 'full' ?
                        'color: white; background-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                        'color: #6b6b74;'">
                    Full
                </button>

                <div class="h-3 w-0 border-r self-center transition-all duration-300 ease-in-out"
                    style="border-color: #d4d4d8;"></div>

                <button @click.stop="selectedVariant = 'premium'"
                    :class="selectedVariant === 'premium' ? 'bg-red-600 shadow-sm transform scale-105' : ''"
                    class="flex-1 min-h-8 px-2.5 py-1.5  w-[50px] text-sm font-normal rounded-lg transition-all duration-200 ease-in-out hover:scale-105"
                    :style="selectedVariant === 'premium' ?
                        'color: white; background-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                        'color: #6b6b74;'">
                    Premium
                </button>
            </div>
        </div>

        {{-- View Image Button --}}
        <button @click.stop=""
            class="flex items-center gap-1.5 h-8 px-2.5 py-1.5 rounded-lg border transition-all duration-200 ease-in-out hover:bg-gray-50 hover:scale-105 hover:shadow-md"
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

    {{-- Vertical Divider --}}
    <div class="h-full w-0 border-r transition-all duration-500 ease-in-out"
        style="border-color: #e4e4e7; {{ $isFullyBooked ? 'opacity: 0.2;' : '' }}"
        x-transition:enter="transition ease-out duration-500 delay-150" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300 delay-50"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    {{-- Middle Section: Location, Hours, Features --}}
    <div class="flex-1 flex flex-col gap-3 transition-all duration-500 ease-in-out"
        style="{{ $isFullyBooked ? 'opacity: 0.2;' : '' }}"
        x-transition:enter="transition ease-out duration-500 delay-200"
        x-transition:enter-start="opacity-0 transform translate-y-[20px]"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300 delay-100"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-[20px]">
        {{-- Location --}}
        <div class="flex flex-col">
            <div class="flex items-center gap-1.5 w-4.5 h-4.5">
                <svg class="w-4.5 h-4.5" style="color: #3f3f46; width: 18px; height: 18px;" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                    </path>
                </svg>
                <p class="text-base underline flex-1"
                    style="color: #ec2028; line-height: 24px; text-decoration-line: underline;">
                    {{ $carModel->branch->city ?? '' }}{{ $carModel->branch->city && $carModel->branch->country ? ', ' : '' }}{{ $carModel->branch->country ?? '' }}
                </p>
            </div>
        </div>

        {{-- Opening Hours --}}
        <div class="flex flex-col">
            <div class="flex items-center gap-1.5 w-4.5 h-4.5">
                <svg class="w-4.5 h-4.5" style="color: #3f3f46; width: 18px; height: 18px;" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                <p class="text-base font-normal flex-1" style="color: #3f3f46; line-height: 24px;">
                    Opening Hours : {{ $carModel->branch->opening_hours ?? '09:00 AM - 05:00 PM' }}
                </p>
            </div>
        </div>

        {{-- Add-ons Included --}}
        <div class="flex gap-1">
            <div class="flex-1 flex flex-col gap-1">
                @php
                    $includedItems = [];
                    if (isset($modelSpec->includedArray)) {
                        $includedItems = array_slice($modelSpec->includedArray, 0, 3);
                    }
                @endphp
                @foreach ($includedItems as $item)
                    <div class="flex items-center gap-1.5">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 11.2143L8.12645 12.5116C8.55869 13.0095 9.34594 12.9601 9.71261 12.4122L13 7.5M17.25 10C17.25 14.0041 14.0041 17.25 10 17.25C5.99594 17.25 2.75 14.0041 2.75 10C2.75 5.99594 5.99594 2.75 10 2.75C14.0041 2.75 17.25 5.99594 17.25 10Z"
                                stroke="#15803D" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span class="text-sm font-normal"
                            style="color: #6b6b74; line-height: 20px;">{{ $item }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex-1 flex flex-col gap-1">
                @php
                    $includedItems2 = [];
                    if (isset($modelSpec->includedArray)) {
                        $includedItems2 = array_slice($modelSpec->includedArray, 3, 3);
                    }
                @endphp
                @foreach ($includedItems2 as $item)
                    <div class="flex items-center gap-1.5">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 11.2143L8.12645 12.5116C8.55869 13.0095 9.34594 12.9601 9.71261 12.4122L13 7.5M17.25 10C17.25 14.0041 14.0041 17.25 10 17.25C5.99594 17.25 2.75 14.0041 2.75 10C2.75 5.99594 5.99594 2.75 10 2.75C14.0041 2.75 17.25 5.99594 17.25 10Z"
                                stroke="#15803D" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span class="text-sm font-normal"
                            style="color: #6b6b74; line-height: 20px;">{{ $item }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right Section: Price and Action --}}
    <div class="flex flex-col items-end justify-between relative transition-all duration-500 ease-in-out"
        x-transition:enter="transition ease-out duration-500 delay-300"
        x-transition:enter-start="opacity-0 transform translate-x-[20px]"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-300 delay-200"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-x-[20px]">
        @if ($isFullyBooked)
            {{-- Fully Booked Badge --}}
            <div class="flex items-center px-2 py-0.5 text-[24px] font-medium rounded border"
                style="background-color: #fff1f2; border-color: #ff9ea2; color: #ec2028; height: auto; line-height: 32px;">
                FULLY BOOKED
            </div>

            {{-- Price Display (with opacity) --}}
            <div class="flex flex-col items-end justify-center" style="width: 230px; opacity: 0.2;">
                <p class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">Prices from</p>
                <div class="flex items-baseline">
                    <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                        {{ number_format($carModel->price_per_day ?? 210, 2) }}</span>
                    <span class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">/day</span>
                </div>
                <p class="text-sm font-normal" style="color: #3f3f46; line-height: 20px;">Total RM
                    {{ number_format($carModel->total_price ?? 420, 2) }}</p>
            </div>
        @else
            {{-- Sale Tags (if applicable) --}}
            @if ($isPromo)
                <div class="flex flex-col gap-1">
                    <div class="flex items-start justify-end relative z-10 -mr-2">
                        <div class="flex items-center px-2 py-0.5 text-[12px] font-medium rounded-l border"
                            style="height: 22px; background-color: #fff4ed; border-color: #ff9960; color: #fe7439; margin-right: -8px; border-radius: 6px 0 0 6px;">
                            SALE
                        </div>
                        <div class="flex items-center px-2 py-0.5 text-[12px] font-medium rounded"
                            style="height: 22px; background-color: #fe7439; color: #fff4ed; border-radius: 6px;">
                            10% OFF TODAY
                        </div>
                    </div>

                    <div class="flex flex-col items-end justify-center" style="height: 84px; width: 230px;">
                        <p class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">Prices from</p>
                        <p class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">RM
                            {{ number_format($carModel->normal_price_per_day ?? 200, 2) }}</p>
                        <div class="relative">
                            <div class="flex items-baseline">
                                <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                                    {{ number_format($carModel->price_per_day ?? 180, 2) }}</span>
                                <span class="text-sm font-normal"
                                    style="color: #6b6b74; line-height: 20px;">/day</span>
                            </div>
                            <div class="absolute h-0.5 w-[74px]"
                                style="background-color: #6b6b74; top: -18px; right: -1px;"></div>
                        </div>
                        <p class="text-sm font-normal" style="color: #3f3f46; line-height: 20px;">Total RM
                            {{ number_format($carModel->total_price ?? 360, 2) }}</p>
                    </div>
                </div>
            @else
                {{-- Normal Price Display --}}
                <div class="flex flex-col items-end justify-center" style="width: 230px;">
                    <p class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">Prices from</p>
                    <div class="flex items-baseline">
                        <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                            {{ number_format($carModel->price_per_day ?? 200, 2) }}</span>
                        <span class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">/day</span>
                    </div>
                    <p class="text-sm font-normal" style="color: #3f3f46; line-height: 20px;">Total RM
                        {{ number_format($carModel->total_price ?? 400, 2) }}</p>
                </div>
            @endif

            {{-- Select Button --}}
            <button @click.stop=""
                class="flex items-center justify-center gap-1.5 h-8 px-2.5 py-1.5 rounded-lg border transition-all duration-200 ease-in-out hover:opacity-90 hover:scale-105 hover:shadow-lg transform"
                style="background-color: #ec2028; border-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                <span class="text-sm font-normal text-white" style="line-height: 20px;">Select this car</span>
            </button>
        @endif
    </div>
</div>
