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

<div class="overflow-hidden relative bg-white rounded-lg transition-shadow duration-200 ease-in-out cursor-pointer"
    @click="if ({{ $carModels->count() > 0 ? 'true' : 'false' }}) toggleCard('{{ $cardId }}')"
    style="box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05);">

    {{-- Main Card (Always Visible) --}}
    <div class="flex relative items-start" style="height: 170px;">
        {{-- Car Image --}}
        <div class="flex justify-center items-centershrink-0" style="width: 160px;"
            style="box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05);">
            <div class="relative" style="width: 160px; height: 120px;">
                {{-- Red Shadow for Promo Items --}}
                @if ($isPromo)
                    <div class="absolute right-0 bottom-0 left-0 h-8 pointer-events-none"
                        style="background: radial-gradient(ellipse 80% 100% at 50% 100%, rgba(236, 32, 40, 0.35) 0%, transparent 70%); filter: blur(6px); z-index: 0;">
                    </div>
                @endif

                <img src="{{ $imageUrl }}" alt="{{ $modelSpec->model_name ?? 'Car' }}"
                    class="relative w-full h-full object-contain z-10 @if ($isLimitedStock) opacity-50 @endif"
                    @if ($isLimitedStock) style="filter: blur(0.5px);" @endif>
            </div>
        </div>

        {{-- Car Details --}}
        <div class="flex flex-col flex-1 justify-between px-[16px] py-3">
            {{-- Header --}}
            <div class="flex flex-col">
                <div class="flex gap-2 items-center">
                    {{-- Brand Logo --}}
                    <div class="flex justify-center items-center shrink-0"
                        style="width: 24px; height: 24px; background-color: #e5e7eb; border-radius: 4px; overflow: hidden;">
                        @if (isset($modelSpec->brand_logo))
                            <img src="{{ StorageHelper::v1Url($modelSpec->brand_logo) }}"
                                alt="{{ $modelSpec->brand_logo ?? 'Brand' }}" class="object-cover w-full h-full">
                        @endif
                    </div>

                    {{-- Car Name --}}
                    <span class="text-xl font-semibold shrink-0" style="color: #18181b; line-height: 30px;">
                        {{ $modelSpec->model_name ?? 'Unknown Model' }}
                    </span>

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
                <div class="flex flex-wrap gap-1">
                    @if (isset($modelSpec->group))
                        <span class="px-2 py-0.5 text-[12px] font-normal rounded-full border shrink-0"
                            style="background-color: #f4f4f5; border-color: rgba(82,82,91,0.2); color: #6b6b74; height: 22px;">
                            Group {{ $modelSpec->group }}
                        </span>
                    @endif
                    @if (isset($modelSpec->car_model->category))
                        <span class="px-2 py-0.5 text-[12px] font-normal rounded-full border shrink-0"
                            style="background-color: #f4f4f5; border-color: rgba(82,82,91,0.2); color: #6b6b74; height: 22px;">
                            {{ $modelSpec->car_model->category }}
                        </span>
                    @endif
                    <span class="px-2 py-0.5 text-[12px] font-normal rounded-full border shrink-0"
                        style="background-color: #f4f4f5; border-color: rgba(82,82,91,0.2); color: #6b6b74; height: 22px;">
                        {{ $carModels->count() }} Branches
                    </span>
                </div>
            </div>

            {{-- Features Icons always bottom --}}
            <div class="flex absolute bottom-0 gap-2 py-2">
                {{-- Transmission --}}
                <div class="flex gap-0 items-center px-0 py-1 shrink-0">
                    <div class="flex justify-center items-center w-6 h-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14"
                            fill="none">
                            <circle cx="1.75" cy="1.75" r="1.75" fill="#6B6B74" />
                            <circle cx="1.75" cy="12.25" r="1.75" fill="#6B6B74" />
                            <circle cx="8.75" cy="1.75" r="1.75" fill="#6B6B74" />
                            <circle cx="8.75" cy="12.25" r="1.75" fill="#6B6B74" />
                            <circle cx="15.75" cy="1.75" r="1.75" fill="#6B6B74" />
                            <circle cx="15.75" cy="12.25" r="1.75" fill="#6B6B74" />
                            <path d="M1.79688 2.03369V11.5337" stroke="#6B6B74" stroke-width="1.5" />
                            <path d="M8.77344 2.03369V11.5337" stroke="#6B6B74" stroke-width="1.5" />
                            <path d="M16.5977 6.77881L1.34961 6.77881" stroke="#6B6B74" stroke-width="1.5" />
                            <path d="M15.8477 2.03369V7.03137" stroke="#6B6B74" stroke-width="1.5" />
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->transmission_type ?? 'Auto' }}</span>
                </div>

                {{-- Seats --}}
                <div class="flex gap-0 items-center px-0 py-1 shrink-0">
                    <div class="flex justify-center items-center w-6 h-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" viewBox="0 0 16 20"
                            fill="none">
                            <path
                                d="M0.828125 2.25L1.32066 6.07257M1.32066 6.07257L2.70761 16.8367C2.83613 17.8342 3.68545 18.5811 4.69121 18.5811H12.1029C13.0194 18.5811 13.8186 17.9582 14.0424 17.0694L14.3848 15.7096C14.7153 14.3972 13.674 13.1423 12.3231 13.225L8.98694 13.4292C7.99726 13.4898 7.1126 12.8161 6.90784 11.846L5.96741 7.39025C5.75594 6.38832 4.82186 5.70796 3.80336 5.81403L1.32066 6.07257Z"
                                stroke="#6B6B74" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M3.35036 0.76456L1.55007 1.0293C1.00876 1.1089 0.650823 1.63381 0.774414 2.1668C1.00137 3.14555 1.96046 3.77062 2.94751 3.58308L3.79792 3.42151C4.54162 3.28021 5.02302 2.55418 4.86371 1.81413C4.71436 1.12034 4.05249 0.661311 3.35036 0.76456Z"
                                stroke="#6B6B74" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M13.5979 15.9419L2.93359 16.1899" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->seats ?? '4' }}
                        Seats</span>
                </div>

                {{-- Doors --}}
                <div class="flex gap-0 items-center px-0 py-1 shrink-0">
                    <div class="flex justify-center items-center w-6 h-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18"
                            fill="none">
                            <path
                                d="M18 12.3412V4.75C18 2.54086 16.2091 0.75 14 0.75H8.85702C7.73011 0.75 6.65549 1.22534 5.89741 2.05914L1.80049 6.56525C0.710872 7.7637 0.451551 9.50096 1.14368 10.9654L2.60181 14.0505C3.26288 15.4491 4.6712 16.3412 6.21823 16.3412H14C16.2091 16.3412 18 14.5503 18 12.3412Z"
                                stroke="#6B6B74" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M14.7004 9.32153H5.59753C4.34595 9.32153 3.64481 7.87912 4.41796 6.89491L6.64347 4.06187C7.02263 3.5792 7.60244 3.29736 8.21623 3.29736H14.2097C15.0396 3.29736 15.7119 3.97135 15.7097 4.80132L15.7004 8.32416C15.6989 8.87541 15.2516 9.32153 14.7004 9.32153Z"
                                fill="#6B6B74" />
                            <path d="M14.9436 10.7783H12.3887" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path d="M14.9436 13.0342L5.32617 13.0342" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->doors ?? '4' }}
                        Doors</span>
                </div>

                {{-- Luggage --}}
                <div class="flex gap-0 items-center px-0 py-1 shrink-0">
                    <div class="flex justify-center items-center w-6 h-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="22" viewBox="0 0 15 22"
                            fill="none">
                            <rect x="0.75" y="6.29053" width="13" height="13.1097" rx="1.75"
                                stroke="#6B6B74" stroke-width="1.5" />
                            <circle cx="2.5" cy="20.3921" r="1" fill="#6B6B74" />
                            <circle cx="12" cy="20.3921" r="1" fill="#6B6B74" />
                            <path
                                d="M8.11719 0.75C9.08369 0.75 9.86719 1.5335 9.86719 2.5V6.29688H4.63086V2.5C4.63086 1.5335 5.41436 0.75 6.38086 0.75H8.11719Z"
                                stroke="#6B6B74" stroke-width="1.5" />
                            <path d="M4.85547 9.89893V16.4796M9.64395 9.89893V16.4796" stroke="#6B6B74"
                                stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->luggage ?? '2' }}
                        Luggage</span>
                </div>

                {{-- Engine --}}
                <div class="flex gap-0 items-center px-0 py-1 shrink-0">
                    <div class="flex justify-center items-center w-6 h-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"
                            fill="none">
                            <path d="M15.7667 1.85889H6.78516" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path d="M15.7676 4.72217L7.16406 4.72217" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path d="M6.39453 6.94714L5.30273 5.9375" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path d="M9.98242 10.8285L8.89062 9.81885" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path d="M5.84426 11.6569L6.78125 10.1748" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path d="M8.49856 6.77112L9.43555 5.28906" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path d="M4.09484 8.73418L5.6253 8.58091" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path d="M9.44055 8.27959L10.971 8.12632" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path d="M16.1973 5.77405L16.1973 0.75" stroke="#6B6B74" stroke-width="1.5"
                                stroke-linecap="round" />
                            <mask id="path-10-inside-1_523_2900" fill="white">
                                <path
                                    d="M6.79314 1.10663C5.26399 1.25139 3.81616 1.86216 2.64536 2.85638C1.47456 3.8506 0.637251 5.18032 0.246611 6.6658C-0.144029 8.15128 -0.0691598 9.72088 0.461099 11.1624C0.991358 12.604 1.95144 13.848 3.21155 14.7262C4.47167 15.6045 5.97106 16.0747 7.50704 16.0732C9.04302 16.0718 10.5415 15.5988 11.8 14.7182C13.0585 13.8375 14.0162 12.5917 14.5438 11.1492C15.0713 9.70666 15.1432 8.13692 14.7498 6.65218L13.3073 7.03441C13.6225 8.22374 13.5648 9.48114 13.1423 10.6367C12.7197 11.7922 11.9525 12.7901 10.9444 13.4955C9.93636 14.2009 8.73601 14.5798 7.50564 14.581C6.27527 14.5821 5.07421 14.2055 4.06482 13.502C3.05543 12.7985 2.28638 11.802 1.86162 10.6473C1.43687 9.49253 1.3769 8.23523 1.68981 7.04532C2.00273 5.85541 2.67344 4.79026 3.61129 3.99386C4.54913 3.19746 5.70889 2.70821 6.93378 2.59225L6.79314 1.10663Z" />
                            </mask>
                            <path
                                d="M6.79314 1.10663C5.26399 1.25139 3.81616 1.86216 2.64536 2.85638C1.47456 3.8506 0.637251 5.18032 0.246611 6.6658C-0.144029 8.15128 -0.0691598 9.72088 0.461099 11.1624C0.991358 12.604 1.95144 13.848 3.21155 14.7262C4.47167 15.6045 5.97106 16.0747 7.50704 16.0732C9.04302 16.0718 10.5415 15.5988 11.8 14.7182C13.0585 13.8375 14.0162 12.5917 14.5438 11.1492C15.0713 9.70666 15.1432 8.13692 14.7498 6.65218L13.3073 7.03441C13.6225 8.22374 13.5648 9.48114 13.1423 10.6367C12.7197 11.7922 11.9525 12.7901 10.9444 13.4955C9.93636 14.2009 8.73601 14.5798 7.50564 14.581C6.27527 14.5821 5.07421 14.2055 4.06482 13.502C3.05543 12.7985 2.28638 11.802 1.86162 10.6473C1.43687 9.49253 1.3769 8.23523 1.68981 7.04532C2.00273 5.85541 2.67344 4.79026 3.61129 3.99386C4.54913 3.19746 5.70889 2.70821 6.93378 2.59225L6.79314 1.10663Z"
                                stroke="#6B6B74" stroke-width="3" stroke-linejoin="round"
                                mask="url(#path-10-inside-1_523_2900)" />
                            <mask id="path-11-inside-2_523_2900" fill="white">
                                <path
                                    d="M7.06465 3.97466C6.12775 4.06336 5.2403 4.43611 4.52107 5.04303C3.80183 5.64995 3.28514 6.46207 3.04014 7.37071C2.79514 8.27934 2.83352 9.24114 3.15015 10.1274C3.46678 11.0136 4.04655 11.782 4.81186 12.3296C5.57718 12.8773 6.49151 13.1781 7.4325 13.1919C8.37349 13.2056 9.29623 12.9316 10.0772 12.4066C10.8582 11.8815 11.4602 11.1304 11.8026 10.2538C12.145 9.37722 12.2114 8.41696 11.9931 7.50155L10.5428 7.84747C10.6907 8.4674 10.6457 9.11771 10.4138 9.71136C10.1819 10.305 9.77425 10.8137 9.24535 11.1693C8.71644 11.5249 8.09155 11.7104 7.45429 11.7011C6.81703 11.6918 6.19782 11.488 5.67953 11.1171C5.16125 10.7463 4.76861 10.2259 4.55419 9.62573C4.33976 9.02556 4.31376 8.37421 4.47968 7.75886C4.6456 7.14351 4.99552 6.59352 5.4826 6.1825C5.96968 5.77148 6.57068 5.51905 7.20517 5.45898L7.06465 3.97466Z" />
                            </mask>
                            <path
                                d="M7.06465 3.97466C6.12775 4.06336 5.2403 4.43611 4.52107 5.04303C3.80183 5.64995 3.28514 6.46207 3.04014 7.37071C2.79514 8.27934 2.83352 9.24114 3.15015 10.1274C3.46678 11.0136 4.04655 11.782 4.81186 12.3296C5.57718 12.8773 6.49151 13.1781 7.4325 13.1919C8.37349 13.2056 9.29623 12.9316 10.0772 12.4066C10.8582 11.8815 11.4602 11.1304 11.8026 10.2538C12.145 9.37722 12.2114 8.41696 11.9931 7.50155L10.5428 7.84747C10.6907 8.4674 10.6457 9.11771 10.4138 9.71136C10.1819 10.305 9.77425 10.8137 9.24535 11.1693C8.71644 11.5249 8.09155 11.7104 7.45429 11.7011C6.81703 11.6918 6.19782 11.488 5.67953 11.1171C5.16125 10.7463 4.76861 10.2259 4.55419 9.62573C4.33976 9.02556 4.31376 8.37421 4.47968 7.75886C4.6456 7.14351 4.99552 6.59352 5.4826 6.1825C5.96968 5.77148 6.57068 5.51905 7.20517 5.45898L7.06465 3.97466Z"
                                stroke="#6B6B74" stroke-width="3" stroke-linejoin="round"
                                mask="url(#path-11-inside-2_523_2900)" />
                            <circle cx="14.0312" cy="6.86377" r="0.75" fill="#6B6B74" />
                            <circle cx="11.2695" cy="7.69727" r="0.75" fill="#6B6B74" />
                            <circle cx="7.60547" cy="8.44727" r="1.60938" stroke="#6B6B74" />
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->fuel_tank ?? '1.5' }}
                        L</span>
                </div>

                {{-- Fuel --}}
                <div class="flex gap-0 items-center px-0 py-1 shrink-0">
                    <div class="flex justify-center items-center w-6 h-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 16 19"
                            fill="none">
                            <circle cx="13.166" cy="5.55811" r="1.20898" fill="#6B6B74" />
                            <path
                                d="M10.3574 7.5209H10.6152C11.7198 7.5209 12.6152 8.41633 12.6152 9.5209V14.9693C12.6152 15.2034 12.7082 15.4279 12.8737 15.5934C13.2841 16.0038 13.9721 15.9132 14.2622 15.4106L14.5122 14.9777C14.6233 14.7852 14.6818 14.5669 14.6818 14.3446V6.7209C14.6818 6.19046 14.4711 5.68175 14.096 5.30668L11.8327 3.0434"
                                stroke="#6B6B74" stroke-width="1.5" stroke-linecap="round" />
                            <rect x="0.75" y="0.75" width="9.36914" height="16.796" rx="0.75" stroke="#6B6B74"
                                stroke-width="1.5" />
                            <mask id="path-4-inside-1_523_2918" fill="white">
                                <rect x="2.10352" y="2.11475" width="6.78516" height="4.65222" rx="1" />
                            </mask>
                            <rect x="2.10352" y="2.11475" width="6.78516" height="4.65222" rx="1"
                                stroke="#6B6B74" stroke-width="3" mask="url(#path-4-inside-1_523_2918)" />
                        </svg>
                    </div>
                    <span class="text-sm font-normal"
                        style="color: #18181b; line-height: 20px;">{{ $modelSpec->fuel_type ?? 'Petrol' }}</span>
                </div>
            </div>
        </div>

        {{-- Vertical Divider (hidden for limited stock) --}}
        @if (!$isLimitedStock && $carModels->count() > 0)
            <div class="self-stretch w-0 h-full border-r" style="border-color: #e4e4e7;"></div>
        @endif

        {{-- Price Section --}}
        <div class="flex relative flex-col gap-1 items-end px-3 py-2 h-full shrink-0" style="width: 230px;">
            @if (!$isLimitedStock)
                {{-- Normal or Sale State --}}
                @if ($isPromo)
                    {{-- Sale Tags --}}
                    <div class="flex justify-end items-start">
                        <div class="flex gap-0 items-center">
                            <div class="flex items-center px-2 py-0.5 text-[12px] font-medium border"
                                style="height: 22px; background-color: #fff4ed; border-color: #ff9960; color: #fe7439; border-radius: 6px 0 0 6px; padding-right: 12px; margin-right: -8px; z-index: 1;">
                                SALE
                            </div>
                            <div class="flex items-center px-2 py-0.5 text-[12px] font-medium"
                                style="height: 22px; background-color: #fe7439; color: #fff4ed; border-radius: 6px; padding-left: 8px; margin-right: -8px; margin-left:8px">
                                {{ $modelSpec->promo_percentage }}% OFF TODAY
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Price Display --}}
                <div class="flex flex-col justify-start items-end h-full" style="width: 200px;">
                    <span class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">Prices from</span>

                    @if ($isPromo)
                        {{-- Show crossed out original price using strike through --}}
                        <span class="text-sm font-normal line-through" style="color: #6b6b74; line-height: 20px; ">RM
                            {{ number_format($modelSpec->normal_price_perday, 2) }}</span>
                        <div class="relative">
                            <div class="flex items-baseline">
                                <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                                    {{ number_format($modelSpec->total_price_perday, 2) }}</span>
                                <span class="text-sm font-normal"
                                    style="color: #6b6b74; line-height: 20px;">/day</span>
                            </div>

                        </div>
                    @else
                        {{-- Normal price --}}
                        <div class="flex items-baseline">
                            <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                                {{ number_format($modelSpec->total_price_perday ?? 0, 2) }}</span>
                            <span class="text-base font-normal" style="color: #6b6b74; line-height: 20px;">/day</span>
                        </div>
                    @endif

                    <span class="text-sm font-normal" style="color: #3f3f46; line-height: 20px;">Total RM
                        {{ number_format($modelSpec->total_price ?? 0, 2) }}</span>
                </div>

                {{-- Expand/Collapse Button (only show if there are car models) --}}
                @if ($carModels->count() > 0)
                    <button @click.stop="toggleCard('{{ $cardId }}')"
                        class="flex absolute right-3 bottom-[10px] justify-center items-center p-1.5 rounded-lg border transition-colors hover:bg-gray-50"
                        style="width: 32px; height: 32px; background-color: #fafafa; border-color: #d4d4d8; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                            class="transition-transform duration-500"
                            :class="!isExpanded('{{ $cardId }}') ? 'rotate-180' : ''" fill="none">
                            <path
                                d="M5.002 5.6001C4.1111 5.6001 3.66493 6.67724 4.2949 7.3072L7.32921 10.3415C7.71974 10.732 8.3529 10.732 8.74343 10.3415L11.7777 7.30721C12.4077 6.67724 11.9615 5.6001 11.0706 5.6001H5.002Z"
                                fill="#18181B" />
                        </svg>
                    </button>
                @endif
            @else
                {{-- Limited Stock State --}}
                <div class="flex flex-col gap-3 items-end" style="width: 200px;">
                    {{-- Request Availability Button --}}
                    <div class="flex justify-end items-center">
                        <button @click.stop=""
                            class="flex justify-center items-center px-2.5 py-1.5 whitespace-nowrap rounded-lg border transition-colors hover:bg-gray-50"
                            style="height: 32px; background-color: white; border-color: #ffc6c8; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                            <span class="text-base font-medium" style="color: #ec2028; line-height: 20px;">Request
                                Availability</span>
                        </button>
                    </div>

                    {{-- Price Range Display --}}
                    <div class="flex flex-col flex-1 items-end" style="width: 200px;">
                        <p class="text-base font-normal" style="color: #6b6b74; line-height: 20px;">Prices from</p>
                        <div class="flex items-baseline">
                            <span class="text-2xl font-semibold" style="color: #18181b; line-height: 32px;">RM
                                {{ number_format($modelSpec->total_price_perday ?? 100, 2) }}</span>
                            <span class="text-base font-normal" style="color: #6b6b74; line-height: 20px;">/day</span>
                        </div>
                        <p class="text-base font-normal" style="color: #3f3f46; line-height: 20px;">~ Max. RM
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
        <template x-if="isExpanded('{{ $cardId }}')" x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
            x-transition:leave="transition ease-in duration-700" x-transition:leave-start="opacity-100 max-h-screen"
            x-transition:leave-end="opacity-0 max-h-0">
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
