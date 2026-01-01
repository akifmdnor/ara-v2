{{-- Car Card Component - Matches Figma Design with Expandable Sections --}}
<div class="bg-white rounded-lg overflow-hidden"
    style="box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05);" x-data="{ expanded: false, selectedVariant: 'low' }">

    {{-- Main Card (Collapsed View) --}}
    <div class="flex gap-3 items-start p-3 relative">
        {{-- Car Image --}}
        <div class="flex items-center justify-center" style="height: 100px;">
            <div style="width: 160px; height: 119.66px;">
                <img src="{{ $car['image'] ?? asset('images/ara-logo.png') }}" alt="{{ $car['name'] ?? 'Car' }}"
                    class="w-full h-full object-contain">
            </div>
        </div>

        {{-- Car Details --}}
        <div class="flex-1 flex flex-col justify-between" style="min-height: 146px;">
            {{-- Header --}}
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2">
                    <div style="width: 24px; height: 24px; background-color: #e5e7eb; border-radius: 4px;"></div>
                    <h3 class="text-xl font-semibold" style="color: #18181b; line-height: 30px;">
                        {{ $car['name'] ?? 'Perodua Myvi' }}
                    </h3>
                    @if (isset($car['limited_offer']) && $car['limited_offer'])
                        <span class="px-2 py-0.5 text-[14px] font-normal rounded border"
                            style="background-color: #f0fdf4; border-color: rgba(21,128,61,0.2); color: #15803d; height: 22px;">
                            Limited Time Offer
                        </span>
                    @endif
                </div>

                {{-- Tags --}}
                <div class="flex gap-1">
                    @if (isset($car['tags']))
                        @foreach ($car['tags'] as $tag)
                            <span class="px-2 py-0.5 text-[14px] font-normal rounded-full border"
                                style="background-color: #f4f4f5; border-color: rgba(82,82,91,0.2); color: #6b6b74; height: 22px;">
                                {{ $tag }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Features Icons --}}
            <div class="flex items-center gap-2">
                {{-- Transmission --}}
                <div class="flex items-center px-0 py-1">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <span class=" font-normal" style="color: #18181b;">{{ $car['transmission'] ?? 'Auto' }}</span>
                </div>

                {{-- Seats --}}
                <div class="flex items-center px-0 py-1">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class=" font-normal" style="color: #18181b;">{{ $car['seats'] ?? '4' }} Seats</span>
                </div>

                {{-- Doors --}}
                <div class="flex items-center px-0 py-1">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span class=" font-normal" style="color: #18181b;">{{ $car['doors'] ?? '4' }} Doors</span>
                </div>

                {{-- Luggage --}}
                <div class="flex items-center px-0 py-1">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <span class=" font-normal" style="color: #18181b;">{{ $car['luggage'] ?? '2' }} Luggage</span>
                </div>

                {{-- Engine --}}
                <div class="flex items-center px-0 py-1">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class=" font-normal" style="color: #18181b;">{{ $car['engine'] ?? '1.5 L' }}</span>
                </div>

                {{-- Fuel --}}
                <div class="flex items-center px-0 py-1">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                    <span class=" font-normal" style="color: #18181b;">{{ $car['fuel'] ?? 'Petrol' }}</span>
                </div>
            </div>
        </div>

        {{-- Vertical Divider --}}
        <div class="h-full w-0 border-r" style="border-color: #e4e4e7;"></div>

        {{-- Price Section --}}
        <div class="flex flex-col gap-1 items-end" style="width: 230px;">
            @if (isset($car['sale_tags']) && count($car['sale_tags']) > 0)
                <div class="flex items-start justify-end pr-2">
                    @foreach ($car['sale_tags'] as $saleTag)
                        <div class="flex items-center gap-1.5 px-2 py-0.5 text-[14px] font-normal rounded"
                            style="height: 22px; background-color: {{ $saleTag['bg'] ?? '#fff4ed' }}; border: 1px solid {{ $saleTag['border'] ?? '#ff9960' }}; color: {{ $saleTag['color'] ?? '#fe7439' }}; margin-right: -8px;">
                            {{ $saleTag['text'] }}
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex flex-col items-end justify-center" style="height: 84px; width: 230px;">
                <p class="" style="color: #6b6b74; line-height: 20px;">Prices from</p>
                @if (isset($car['original_price']))
                    <p class=" line-through" style="color: #6b6b74; line-height: 20px;">RM
                        {{ $car['original_price'] }}</p>
                    <div class="relative">
                        <div class="flex items-baseline">
                            <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                                {{ $car['price'] ?? '180.00' }}</span>
                            <span class="" style="color: #6b6b74; line-height: 20px;">/day</span>
                        </div>
                        <div class="absolute h-0.5 w-full" style="background-color: #6b6b74; top: 13.575px;"></div>
                    </div>
                @else
                    <div class="flex items-baseline">
                        <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                            {{ $car['price'] ?? '180.00' }}</span>
                        <span class="" style="color: #6b6b74; line-height: 20px;">/day</span>
                    </div>
                @endif
                <p class="" style="color: #3f3f46; line-height: 20px;">Total RM
                    {{ $car['total_price'] ?? '360.00' }}</p>
            </div>

            {{-- Expand/Collapse Button --}}
            <button @click="expanded = !expanded"
                class="flex items-center justify-center p-1.5 rounded-lg border transition-colors hover:bg-gray-50"
                style="width: 32px; height: 32px; background-color: #fafafa; border-color: #d4d4d8; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                <svg class="w-4 h-4 transition-transform" :class="expanded ? 'rotate-180' : ''"
                    style="color: #18181b;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Expandable Variants Section --}}
    @if (isset($car['variants']) && count($car['variants']) > 0)
        @foreach ($car['variants'] as $variantIndex => $variant)
            <div x-show="expanded" x-transition class="flex gap-6 p-6"
                style="background-color: rgba(244,244,245,0.4);">

                {{-- Variant Image and Options --}}
                <div class="flex flex-col gap-3" style="width: 172px;">
                    <p class="text-base font-normal" style="color: #18181b; line-height: 24px;">
                        {{ $variant['name'] ?? 'Myvi 1.5H (M800)' }}
                    </p>
                    <div style="width: 160px; height: 120px;">
                        <img src="{{ $car['image'] ?? asset('images/ara-logo.png') }}"
                            alt="{{ $variant['name'] ?? 'Car' }}" class="w-full h-full object-contain">
                    </div>

                    {{-- Variant Selection --}}
                    <div class="flex flex-col gap-1">
                        <p class="text-[14px] font-normal" style="color: #6b6b74; line-height: 18px;">Choose spec
                            variant:
                        </p>
                        <div class="flex rounded-lg" style="background-color: #f4f4f5;">
                            <button @click="selectedVariant = 'low'"
                                :class="selectedVariant === 'low' ? 'bg-red-600 shadow-sm' : ''"
                                class="flex-1 min-h-8 px-2.5 py-1.5  font-normal rounded-lg transition-colors"
                                :style="selectedVariant === 'low' ? 'color: white;' : 'color: #6b6b74;'">
                                Low
                            </button>
                            <button @click="selectedVariant = 'med'"
                                class="flex-1 min-h-8 px-2.5 py-1.5  font-normal rounded-lg transition-colors"
                                style="color: #6b6b74;">
                                Med
                            </button>
                            <div class="h-3 w-0 border-r self-center" style="border-color: #d4d4d8;"></div>
                            <button @click="selectedVariant = 'full'"
                                class="flex-1 min-h-8 px-2.5 py-1.5  font-normal rounded-lg transition-colors"
                                style="color: #6b6b74;">
                                Full
                            </button>
                            <div class="h-3 w-0 border-r self-center" style="border-color: #d4d4d8;"></div>
                            <button @click="selectedVariant = 'premium'"
                                class="flex-1 min-h-8 px-2.5 py-1.5  font-normal rounded-lg transition-colors"
                                style="color: #6b6b74;">
                                Premium
                            </button>
                        </div>
                    </div>

                    {{-- View Image Button --}}
                    <button
                        class="flex items-center gap-1.5 h-8 px-2.5 py-1.5 rounded-lg border transition-colors hover:bg-gray-50"
                        style="background-color: white; border-color: #e4e4e7; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                        <svg class="w-4 h-4" style="color: #3f3f46;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class=" font-normal" style="color: #3f3f46;">View Actual Car Image</span>
                    </button>
                </div>

                {{-- Vertical Divider --}}
                <div class="h-full w-0 border-r" style="border-color: #e4e4e7;"></div>

                {{-- Variant Details --}}
                <div class="flex-1 flex flex-col gap-3">
                    {{-- Location --}}
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4.5 h-4.5" style="color: #3f3f46;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                </path>
                            </svg>
                            <p class="text-base underline flex-1 overflow-hidden text-ellipsis whitespace-nowrap"
                                style="color: #ec2028; line-height: 24px; text-decoration-line: underline;">
                                {{ $variant['location'] ?? 'Bandar Puteri, Puchong, Selangor' }}
                            </p>
                        </div>
                    </div>

                    {{-- Opening Hours --}}
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4.5 h-4.5" style="color: #3f3f46;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-base flex-1 overflow-hidden text-ellipsis whitespace-nowrap"
                                style="color: #3f3f46; line-height: 24px;">
                                Opening Hours : 09:00 AM - 05:00 PM
                            </p>
                        </div>
                    </div>

                    {{-- Features --}}
                    <div class="flex gap-1">
                        <div class="flex-1 flex flex-col gap-1">
                            @if (isset($variant['features']))
                                @foreach (array_slice($variant['features'], 0, 3) as $feature)
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3 h-3" style="color: #34c759;" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                        <span class=""
                                            style="color: #6b6b74; line-height: 20px;">{{ $feature }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="flex-1 flex flex-col gap-1">
                            @if (isset($variant['features']))
                                @foreach (array_slice($variant['features'], 3) as $feature)
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3 h-3" style="color: #34c759;" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                        <span class=""
                                            style="color: #6b6b74; line-height: 20px;">{{ $feature }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Variant Price and Action --}}
                <div class="flex flex-col items-end justify-between">
                    {{-- Sale Tags for Variant --}}
                    @if (isset($variant['sale']))
                        <div class="flex flex-col gap-1">
                            <div class="flex items-start justify-end pr-2">
                                <div class="flex items-center gap-1.5 px-2 py-0.5 text-[14px] font-normal rounded"
                                    style="height: 22px; background-color: #fff4ed; border: 1px solid #ff9960; color: #fe7439; margin-right: -8px;">
                                    SALE
                                </div>
                                <div class="flex items-center gap-1.5 px-2 py-0.5 text-[14px] font-normal rounded"
                                    style="height: 22px; background-color: #fe7439; color: #fff4ed; margin-right: -8px;">
                                    10% OFF TODAY
                                </div>
                            </div>

                            <div class="flex flex-col items-end justify-center" style="height: 84px; width: 230px;">
                                <p class="" style="color: #6b6b74; line-height: 20px;">Prices from</p>
                                <p class=" line-through" style="color: #6b6b74; line-height: 20px;">RM
                                    {{ $variant['original_price'] ?? '200.00' }}</p>
                                <div class="relative">
                                    <div class="flex items-baseline">
                                        <span class="text-2xl font-semibold"
                                            style="color: #18181b; line-height: 32px;">RM
                                            {{ $variant['price'] ?? '180.00' }}</span>
                                        <span class="" style="color: #6b6b74; line-height: 20px;">/day</span>
                                    </div>
                                    <div class="absolute h-0.5 w-full"
                                        style="background-color: #6b6b74; top: 13.575px;"></div>
                                </div>
                                <p class="" style="color: #3f3f46; line-height: 20px;">Total RM
                                    {{ $variant['total_price'] ?? '360.00' }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-end justify-center" style="width: 230px;">
                            <p class="" style="color: #6b6b74; line-height: 20px;">Prices from</p>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                                    {{ $variant['price'] ?? '200.00' }}</span>
                                <span class="" style="color: #6b6b74; line-height: 20px;">/day</span>
                            </div>
                            <p class="" style="color: #3f3f46; line-height: 20px;">Total RM
                                {{ $variant['total_price'] ?? '400.00' }}</p>
                        </div>
                    @endif

                    {{-- Select Button --}}
                    <button
                        class="flex items-center justify-center gap-1.5 h-8 px-2.5 py-1.5 rounded-lg border transition-colors hover:opacity-90"
                        style="background-color: #ec2028; border-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                        <span class=" font-normal text-white">Select this car</span>
                    </button>
                </div>
            </div>

            {{-- Divider between variants --}}
            @if ($variantIndex < count($car['variants']) - 1)
                <div class="h-0.5" style="background-color: #e4e4e7;"></div>
            @endif
        @endforeach
    @endif
</div>
