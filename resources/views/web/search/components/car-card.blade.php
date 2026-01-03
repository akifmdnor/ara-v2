{{-- Car Card Component - Matches Figma Design with Collapsible Car Models --}}
@php
    use App\Services\StorageHelper;

    // Get car models for this model spec (already processed with pricing and availability)
    $carModels = $modelSpec->car_models ?? collect();

    // Check for limited stock/unavailable and promo (from model spec level)
    $isLimitedStock = isset($modelSpec->unavailable) && $modelSpec->unavailable;
    $isPromo = isset($modelSpec->is_promo) && $modelSpec->is_promo;
    $isPopular = isset($modelSpec->is_popular) && $modelSpec->is_popular;

    // Get image URL
    $imageUrl = asset('images/ara-logo.png');
    if (isset($modelSpec->pictures) && count($modelSpec->pictures) > 0) {
        $imageUrl = StorageHelper::v1Url($modelSpec->pictures[0]->file_name);
    }

    // Generate unique ID for this card
    $cardId = 'card-' . ($modelSpec->id ?? uniqid());
@endphp

<div class="bg-white rounded-lg overflow-hidden relative cursor-pointer transition-all duration-200 ease-in-out hover:shadow-lg"
    @click="if ({{ $carModels->count() > 0 ? 'true' : 'false' }}) toggleCard('{{ $cardId }}')"
    style="box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05);">

    {{-- Main Card (Always Visible) --}}
    <div class="flex gap-3 items-start p-3 relative" style="min-height: 170px;">
        {{-- Car Image --}}
        <div class="flex items-center justify-center shrink-0" style="width: 160px; height: 100px;">
            <div class="relative" style="width: 160px; height: 119.66px;">
                {{-- Red Shadow for Promo Items --}}
                @if ($isPromo)
                    <div class="absolute left-0 right-0 bottom-0 h-8 pointer-events-none"
                        style="background: radial-gradient(ellipse 80% 100% at 50% 100%, rgba(236, 32, 40, 0.35) 0%, transparent 70%); filter: blur(6px); z-index: 0;">
                    </div>
                @endif

                <img src="{{ $imageUrl }}" alt="{{ $modelSpec->model_name ?? 'Car' }}"
                    class="relative w-full h-full object-contain z-10 @if ($isLimitedStock) opacity-50 @endif"
                    @if ($isLimitedStock) style="filter: blur(0.5px);" @endif>
            </div>
        </div>

        {{-- Car Details --}}
        <div class="flex-1 flex flex-col justify-between" style="min-width: 0; min-height: 146px;">
            {{-- Header --}}
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2">
                    {{-- Brand Logo --}}
                    <div class="flex items-center justify-center shrink-0"
                        style="width: 24px; height: 24px; background-color: #e5e7eb; border-radius: 4px; overflow: hidden;">
                        @if (isset($modelSpec->brand_logo))
                            <img src="{{ StorageHelper::v1Url($modelSpec->brand_logo) }}"
                                alt="{{ $modelSpec->brand_logo ?? 'Brand' }}" class="w-full h-full object-cover">
                        @endif
                    </div>

                    {{-- Car Name --}}
                    <h3 class="text-xl font-semibold shrink-0" style="color: #18181b; line-height: 30px;">
                        {{ $modelSpec->model_name ?? 'Unknown Model' }}
                    </h3>

                    {{-- Status Badges --}}
                    @if (!$isLimitedStock)
                        {{-- Popular Car Badge --}}
                        @if ($isPopular)
                            <div class="flex items-center gap-1.5 px-2 py-0.5 text-[12px] font-medium rounded border shrink-0"
                                style="background-color: #fff1f2; border-color: rgba(236,32,40,0.2); color: #ec2028; height: 22px;">
                                <div class="w-1.5 h-1.5 rounded-full" style="background-color: #ec2028;"></div>
                                <span>Popular Car</span>
                            </div>
                        @endif

                        {{-- Limited Time Offer Badge --}}
                        @if ($isPromo)
                            <div class="flex items-center gap-1.5 px-2 py-0.5 text-[12px] font-medium rounded border shrink-0"
                                style="background-color: #f0fdf4; border-color: rgba(21,128,61,0.2); color: #15803d; height: 22px;">
                                <span>Limited Time Offer</span>
                            </div>
                        @endif
                    @else
                        {{-- Limited Stock Badge --}}
                        <div class="px-2 py-0.5 text-[12px] font-medium rounded border shrink-0"
                            style="background-color: #f4f4f5; border-color: rgba(82,82,91,0.2); color: #6b6b74; height: 22px;">
                            LIMITED STOCK
                        </div>
                    @endif
                </div>

                {{-- Category Tags --}}
                <div class="flex gap-1 flex-wrap">
                    @if (isset($modelSpec->group))
                        <span class="px-2 py-0.5 text-[12px] font-medium rounded-full border shrink-0"
                            style="background-color: #f4f4f5; border-color: rgba(82,82,91,0.2); color: #6b6b74; height: 22px;">
                            Group {{ $modelSpec->group }}
                        </span>
                    @endif
                    @if (isset($modelSpec->car_model->category))
                        <span class="px-2 py-0.5 text-[12px] font-medium rounded-full border shrink-0"
                            style="background-color: #f4f4f5; border-color: rgba(82,82,91,0.2); color: #6b6b74; height: 22px;">
                            {{ $modelSpec->car_model->category }}
                        </span>
                    @endif
                    <span class="px-2 py-0.5 text-[12px] font-medium rounded-full border shrink-0"
                        style="background-color: #f4f4f5; border-color: rgba(82,82,91,0.2); color: #6b6b74; height: 22px;">
                        {{ $carModels->count() }} Branches
                    </span>
                </div>
            </div>

            {{-- Features Icons --}}
            <div class="flex items-center gap-2">
                {{-- Transmission --}}
                <div class="flex items-center gap-0 px-0 py-1 shrink-0">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->transmission_type ?? 'Auto' }}</span>
                </div>

                {{-- Seats --}}
                <div class="flex items-center gap-0 px-0 py-1 shrink-0">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->seats ?? '4' }}
                        Seats</span>
                </div>

                {{-- Doors --}}
                <div class="flex items-center gap-0 px-0 py-1 shrink-0">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->doors ?? '4' }}
                        Doors</span>
                </div>

                {{-- Luggage --}}
                <div class="flex items-center gap-0 px-0 py-1 shrink-0">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->luggage ?? '2' }}
                        Luggage</span>
                </div>

                {{-- Engine --}}
                <div class="flex items-center gap-0 px-0 py-1 shrink-0">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->fuel_tank ?? '1.5' }}
                        L</span>
                </div>

                {{-- Fuel --}}
                <div class="flex items-center gap-0 px-0 py-1 shrink-0">
                    <div class="flex items-center justify-center w-6 h-6">
                        <svg class="w-4 h-4" style="color: #18181b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->fuel_type ?? 'Petrol' }}</span>
                </div>
            </div>
        </div>

        {{-- Vertical Divider (hidden for limited stock) --}}
        @if (!$isLimitedStock && $carModels->count() > 0)
            <div class="h-full w-0 border-r self-stretch" style="border-color: #e4e4e7;"></div>
        @endif

        {{-- Price Section --}}
        <div class="flex flex-col gap-3 items-end shrink-0" style="width: 200px;">
            @if (!$isLimitedStock)
                {{-- Normal or Sale State --}}
                @if ($isPromo)
                    {{-- Sale Tags --}}
                    <div class="flex items-start justify-end">
                        <div class="flex items-center gap-0">
                            <div class="flex items-center px-2 py-0.5 text-[12px] font-medium border"
                                style="height: 22px; background-color: #fff4ed; border-color: #ff9960; color: #fe7439; border-radius: 6px 0 0 6px; padding-right: 12px; margin-right: -8px; z-index: 1;">
                                SALE
                            </div>
                            <div class="flex items-center px-2 py-0.5 text-[12px] font-medium"
                                style="height: 22px; background-color: #fe7439; color: #fff4ed; border-radius: 6px; padding-left: 8px; margin-right: -8px;">
                                10% OFF TODAY
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Price Display --}}
                <div class="flex flex-col items-end justify-center" style="width: 200px;">
                    <p class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">Prices from</p>

                    @if (
                        $isPromo &&
                            isset($modelSpec->normal_price_perday) &&
                            $modelSpec->normal_price_perday > $modelSpec->total_price_perday)
                        {{-- Show crossed out original price --}}
                        <p class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">RM
                            {{ number_format($modelSpec->normal_price_perday, 2) }}</p>
                        <div class="relative">
                            <div class="flex items-baseline">
                                <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                                    {{ number_format($modelSpec->total_price_perday, 2) }}</span>
                                <span class="text-sm font-normal"
                                    style="color: #6b6b74; line-height: 20px;">/day</span>
                            </div>
                            {{-- Strike through line --}}
                            <div class="absolute h-0.5 w-full"
                                style="background-color: #6b6b74; top: -18px; right: -1px;">
                            </div>
                        </div>
                    @else
                        {{-- Normal price --}}
                        <div class="flex items-baseline">
                            <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                                {{ number_format($modelSpec->total_price_perday ?? 0, 2) }}</span>
                            <span class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">/day</span>
                        </div>
                    @endif

                    <p class="text-sm font-normal" style="color: #3f3f46; line-height: 20px;">Total RM
                        {{ number_format($modelSpec->total_price ?? 0, 2) }}</p>
                </div>

                {{-- Expand/Collapse Button (only show if there are car models) --}}
                @if ($carModels->count() > 0)
                    <button @click.stop="toggleCard('{{ $cardId }}')"
                        class="flex items-center justify-center p-1.5 rounded-lg border transition-colors hover:bg-gray-50"
                        style="width: 32px; height: 32px; background-color: #fafafa; border-color: #d4d4d8; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                        <svg class="w-4 h-4 transition-transform"
                            :class="isExpanded('{{ $cardId }}') ? 'rotate-180' : ''" style="color: #18181b;"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif
            @else
                {{-- Limited Stock State --}}
                <div class="flex flex-col gap-3 items-end" style="width: 200px;">
                    {{-- Request Availability Button --}}
                    <div class="flex items-center justify-end">
                        <button @click.stop=""
                            class="flex items-center justify-center px-2.5 py-1.5 rounded-lg border transition-colors hover:bg-gray-50 whitespace-nowrap"
                            style="height: 32px; background-color: white; border-color: #ffc6c8; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                            <span class="text-sm font-medium" style="color: #ec2028; line-height: 20px;">Request
                                Availability</span>
                        </button>
                    </div>

                    {{-- Price Range Display --}}
                    <div class="flex flex-col items-end flex-1" style="width: 200px;">
                        <p class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">Prices from</p>
                        <div class="flex items-baseline">
                            <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                                {{ number_format($modelSpec->total_price_perday ?? 100, 2) }}</span>
                            <span class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">/day</span>
                        </div>
                        <p class="text-sm font-normal" style="color: #3f3f46; line-height: 20px;">~ Max. RM
                            {{ number_format(($modelSpec->total_price_perday ?? 100) * 1.8, 2) }}/day
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Expandable Car Models Section (only if not limited stock and has car models) --}}
    @if (!$isLimitedStock && $carModels->count() > 0)
        {{-- Add dividers and car model rows here --}}
        <template x-if="isExpanded('{{ $cardId }}')">
            <div>
                @foreach ($carModels as $carModelIndex => $carModel)
                    @include('web.search.components.car-model-row', [
                        'carModel' => $carModel,
                        'modelSpec' => $modelSpec,
                    ])

                    {{-- Divider between car models --}}
                    @if ($carModelIndex < $carModels->count() - 1)
                        <div class="h-[1.5px]" style="background-color: #e4e4e7;"></div>
                    @endif
                @endforeach
            </div>
        </template>
    @endif
</div>
