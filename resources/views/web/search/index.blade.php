@extends('web.layouts.app')

@section('content')
    <div class="w-full min-h-screen" style="background-color: #fafafa;">
        {{-- Navigation --}}
        @include('web.search.components.navbar')


        {{-- Main Content --}}
        <div class="px-[280px] py-11 bg-[#FFF]" style="background-color: #FFF;">
            {{-- Search Form Section --}}
            @include('web.search.components.search-form')

            <div class="flex gap-6">
                {{-- Sidebar Filter --}}
                <div class="flex-shrink-0" style="width: 300px;">
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
                priceRange: [0, 2000],
                sortBy: 'low-to-high',

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
                        priceRange: this.priceRange,
                        sortBy: this.sortBy
                    });
                },

                resetFilters() {
                    this.selectedBrands = [];
                    this.selectedCategories = [];
                    this.priceRange = [0, 2000];
                    this.sortBy = 'low-to-high';
                }
            }));
        });
    </script>
@endpush
