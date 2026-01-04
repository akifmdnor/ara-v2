@extends('web.layouts.app')

@section('content')
    <div class="w-full min-h-screen" style="background-color: #fff;">
        {{-- Navigation --}}
        @include('web.search.components.navbar')


        {{-- Main Content --}}
        <div class="w-[1280px] mx-auto py-12 bg-[#FFF]" style="background-color: #FFF;">
            {{-- Search Form Section --}}
            @include('web.search.components.search-form')

            <div class="flex gap-3">
                {{-- Sidebar Filter --}}
                <div class="flex-shrink-0" style="width: 300px;">
                    @include('web.search.components.sidebar-filter', ['categories' => $categories])
                </div>

                {{-- Main Content Area --}}
                <div class="flex-1">
                    @include('web.search.components.main-content')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Alpine.js data for filter interactions
        document.addEventListener('alpine:init', () => {
            Alpine.data('filterData', () => ({
                showBrandDropdown: false,
                showCategoryDropdown: false,
                selectedBrands: [],
                selectedCategories: [],
                sortBy: '{{ request('sort_by') === 'ASC' ? 'low-to-high' : 'high-to-low' }}',

                // Price slider
                minprice: {{ request('min_price', 0) }},
                maxprice: {{ request('max_price', 1500) }},
                priceMin: 0,
                priceMax: 2000,
                minthumb: 0,
                maxthumb: 0,

                init() {
                    // Initialize thumbs after data is set
                    this.$nextTick(() => {
                        this.mintrigger();
                        this.maxtrigger();
                    });
                },

                mintrigger() {
                    this.minprice = Math.min(this.minprice, this.maxprice - 10);
                    this.minthumb = ((this.minprice - this.priceMin) / (this.priceMax - this
                        .priceMin)) * 100;
                },

                maxtrigger() {
                    this.maxprice = Math.max(this.maxprice, this.minprice + 10);
                    this.maxthumb = 100 - (((this.maxprice - this.priceMin) / (this.priceMax - this
                        .priceMin)) * 100);
                },

                toggleBrand(brand) {
                    const index = this.selectedBrands.indexOf(brand);
                    if (index > -1) {
                        this.selectedBrands.splice(index, 1);
                    } else {
                        this.selectedBrands.push(brand);
                    }
                },

                toggleCategory(category) {
                    const index = this.selectedCategories.indexOf(category);
                    if (index > -1) {
                        this.selectedCategories.splice(index, 1);
                    } else {
                        this.selectedCategories.push(category);
                    }
                },

                applyFilters() {
                    // Update hidden inputs before submitting to ensure current values
                    const minPriceInput = document.querySelector('input[name="min_price"]');
                    const maxPriceInput = document.querySelector('input[name="max_price"]');
                    const sortByInput = document.querySelector('input[name="sort_by"]');

                    if (minPriceInput) minPriceInput.value = this.minprice;
                    if (maxPriceInput) maxPriceInput.value = this.maxprice;
                    if (sortByInput) sortByInput.value = this.sortBy === 'low-to-high' ? 'ASC' : 'DESC';

                    // Submit the filter form
                    const form = document.querySelector('form[action*="web.search"]');
                    if (form) {
                        form.submit();
                    }
                },

                updateSort(sortValue) {
                    this.sortBy = sortValue;
                    // Immediately submit the form when sort changes
                    this.applyFilters();
                },

                resetFilters() {
                    // Redirect to clean search URL
                    const currentUrl = new URL(window.location);
                    const baseParams = ['pickup_location', 'pickup_latitude', 'pickup_longitude',
                        'pickup_date', 'pickup_time', 'return_location', 'return_latitude',
                        'return_longitude', 'return_date', 'return_time'
                    ];

                    // Keep only the base search parameters
                    const newParams = new URLSearchParams();
                    baseParams.forEach(param => {
                        if (currentUrl.searchParams.has(param)) {
                            newParams.set(param, currentUrl.searchParams.get(param));
                        }
                    });
                    newParams.set('reset', '1');

                    window.location.href = currentUrl.pathname + '?' + newParams.toString();
                }
            }));

            // Car listing data - handles card expansion (only one at a time)
            Alpine.data('carListing', () => ({
                expandedCardId: null,

                toggleCard(cardId) {
                    if (this.expandedCardId === cardId) {
                        this.expandedCardId = null;
                    } else {
                        this.expandedCardId = cardId;
                    }
                },

                isExpanded(cardId) {
                    return this.expandedCardId === cardId;
                }
            }));
        });
    </script>
@endpush
