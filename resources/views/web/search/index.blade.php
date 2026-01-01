@extends('web.layouts.app')

@section('content')
    <div class="w-full min-h-screen" style="background-color: #fafafa;">
        {{-- Navigation --}}
        @include('web.search.components.navbar')


        {{-- Main Content --}}
        <div class="px-[277px] py-11 bg-[#FFF]" style="background-color: #FFF;">
            {{-- Search Form Section --}}
            @include('web.search.components.search-form')

            <div class="flex gap-3">
                {{-- Sidebar Filter --}}
                <div class="flex-shrink-0" style="width: 265px;">
                    @include('web.search.components.sidebar-filter')
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
                sortBy: 'low-to-high',

                // Price slider
                minprice: 0,
                maxprice: 1360,
                priceMin: 0,
                priceMax: 2000,
                minthumb: 0,
                maxthumb: 0,

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
                    // Apply filter logic here
                    console.log('Filters applied:', {
                        brands: this.selectedBrands,
                        categories: this.selectedCategories,
                        priceRange: [this.minprice, this.maxprice],
                        sortBy: this.sortBy
                    });
                },

                resetFilters() {
                    this.selectedBrands = [];
                    this.selectedCategories = [];
                    this.minprice = 0;
                    this.maxprice = 2000;
                    this.sortBy = 'low-to-high';
                    this.mintrigger();
                    this.maxtrigger();
                }
            }));
        });
    </script>
@endpush
