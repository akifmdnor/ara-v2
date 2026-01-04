{{-- Sidebar Filter Component - Matches Figma Design --}}
<form method="GET" action="{{ route('web.search') }}"
    class="flex flex-col gap-6 px-[12px] py-3 rounded-lg by-2.5 g-white p" x-data="filterData" {{-- Preserve search form data --}}
    style="box-shadow: 0px 2px 4px 0px rgba(51,65,85,0.1), 0px 6px 32px 0px rgba(51,65,85,0.1);">

    <input type="hidden" name="pickup_location" value="{{ app('request')->input('pickup_location') }}">
    <input type="hidden" name="pickup_latitude" value="{{ app('request')->input('pickup_latitude') }}">
    <input type="hidden" name="pickup_longitude" value="{{ app('request')->input('pickup_longitude') }}">
    <input type="hidden" name="pickup_date" value="{{ app('request')->input('pickup_date') }}">
    <input type="hidden" name="pickup_time" value="{{ app('request')->input('pickup_time') }}">
    <input type="hidden" name="return_location" value="{{ app('request')->input('return_location') }}">
    <input type="hidden" name="return_latitude" value="{{ app('request')->input('return_latitude') }}">
    <input type="hidden" name="return_longitude" value="{{ app('request')->input('return_longitude') }}">
    <input type="hidden" name="return_date" value="{{ app('request')->input('return_date') }}">
    <input type="hidden" name="return_time" value="{{ app('request')->input('return_time') }}">

    {{-- Price Range --}}
    <div class="flex flex-col gap-2">
        <h3 class="text-sm" style="color: #3f3f46; ">Price range</h3>

        {{-- Price Range Slider --}}
        <div class="relative py-1.5 w-full" x-init="init()">

            <input type="range" step="10" x-bind:min="priceMin" x-bind:max="priceMax"
                x-on:input="mintrigger" x-model="minprice"
                class="absolute z-20 w-full h-2 opacity-0 appearance-none cursor-pointer pointer-events-none">

            <input type="range" step="10" x-bind:min="priceMin" x-bind:max="priceMax"
                x-on:input="maxtrigger" x-model="maxprice"
                class="absolute z-20 w-full h-2 opacity-0 appearance-none cursor-pointer pointer-events-none">

            <div class="relative z-10 h-[2px]">
                {{-- Background Track --}}
                <div class="absolute top-0 right-0 bottom-0 left-0 z-10 rounded-full"
                    style="background-color: #e4e4e7;"></div>

                {{-- Active Track --}}
                <div class="absolute z-20 top-0 bottom-0 rounded-full bg-[#C60F16]"
                    style="background-color: #c60f16 !important;"
                    x-bind:style="'right:' + maxthumb + '%; left:' + minthumb + '%'"></div>

                {{-- Min Thumb --}}
                <div class="absolute z-30 w-4 h-4  left-0 rounded-full border-2 -mt-2 bg-[#fff] border-[#C60F16]"
                    style="background-color: white; border-color: #C60F16; box-shadow: 0 1px 3px rgba(0,0,0,0.15);"
                    x-bind:style="'left: ' + minthumb + '%'"></div>

                {{-- Max Thumb --}}
                <div class="absolute z-30 w-4 h-4 right-0 rounded-full border-2 -mt-2 bg-[#fff] border-[#C60F16]"
                    style="background-color: white; border-color: #c60f16; box-shadow: 0 1px 3px rgba(0,0,0,0.15);"
                    x-bind:style="'right: ' + maxthumb + '%'"></div>
            </div>
        </div>

        {{-- Price Inputs --}}
        <div class="flex gap-1 items-center h-8">
            <div class="flex flex-1 gap-1.5 items-center px-2.5 py-1.5 rounded-full border"
                style="height: 32px; background-color: white; border-color: #e4e4e7; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                <span class="text-sm leading-[20px]" style="color: #6b6b74;">RM</span>
                <span class="flex-1 font-sm text-right text-sm leading-[20px]" style="color: #18181b;"
                    x-text="minprice.toFixed(2)"></span>
            </div>
            <span class="text-sm leading-[20px]" style="color: #6b6b74;">-</span>
            <div class="flex flex-1 gap-1.5 items-center px-2.5 py-1.5 rounded-full border"
                style="height: 32px; background-color: white; border-color: #e4e4e7; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                <span class="text-sm leading-[20px]" style="color: #6b6b74;">RM</span>
                <span class="flex-1 font-normal text-right text-sm leading-[20px]" style="color: #18181b;"
                    x-text="maxprice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
            </div>
        </div>
    </div>

    {{-- Sort by Price --}}
    <div class="flex flex-col gap-3">
        <h3 class="text-sm" style="color: #3f3f46;">Sort by price</h3>
        <div class="flex justify-center items-center rounded-lg" style="background-color: #f4f4f5;">
            <button @click="updateSort('low-to-high')" :class="sortBy === 'low-to-high' ? 'bg-white border' : ''"
                class="flex-1 px-2.5 py-1.5 text-sm rounded-lg transition-colors min-h-8"
                :style="sortBy === 'low-to-high' ?
                    'border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                    'color: #6b6b74;'">
                Low to high
            </button>
            <button @click="updateSort('high-to-low')" :class="sortBy === 'high-to-low' ? 'bg-white border' : ''"
                class="flex-1 px-2.5 py-1.5 text-sm rounded-lg transition-colors min-h-8"
                :style="sortBy === 'high-to-low' ?
                    'border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                    'color: #6b6b74;'">
                High to low
            </button>
        </div>
    </div>

    {{-- Brand Filter --}}
    <div class="flex flex-col gap-3">
        <h3 class="text-sm" style="color: #3f3f46;">Brand</h3>
        <div class="flex flex-col gap-3">
            @if (isset($brands) && $brands->count() > 0)
                @foreach ($brands as $brand)
                    <label class="flex gap-2.5 items-start">
                        <div class="flex justify-center items-center px-0 py-0.5">
                            <input type="checkbox" name="brand[]" value="{{ strtolower($brand) }}"
                                @change="toggleBrand('{{ strtolower($brand) }}')"
                                class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                                style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);"
                                {{ in_array(strtolower($brand), request('brand', [])) ? 'checked' : '' }}>
                        </div>
                        <div class="flex flex-col flex-1 justify-center items-center">
                            <span class="w-full text-sm" style="color: #18181b;">{{ $brand }}</span>
                        </div>
                    </label>
                @endforeach
            @else
                {{-- Fallback hardcoded brands --}}
                <label class="flex gap-2.5 items-start">
                    <div class="flex justify-center items-center px-0 py-0.5">
                        <input type="checkbox" name="brand[]" value="proton" @change="toggleBrand('proton')"
                            class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                            style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                    </div>
                    <div class="flex flex-col flex-1 justify-center items-center">
                        <span class="w-full text-sm" style="color: #18181b;">Proton</span>
                    </div>
                </label>
            @endif
        </div>
    </div>

    {{-- Category Filter --}}
    <div class="flex flex-col gap-3">
        <h3 class="text-sm" style="color: #3f3f46;">Category</h3>
        <div class="flex flex-col gap-3">
            @if (isset($categories) && $categories->count() > 0)
                @foreach ($categories as $category)
                    <label class="flex gap-2.5 items-start">
                        <div class="flex justify-center items-center px-0 py-0.5">
                            <input type="checkbox" name="category[]" value="{{ strtolower($category) }}"
                                @change="toggleCategory('{{ strtolower($category) }}')"
                                class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                                style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);"
                                {{ in_array(strtolower($category), request('category', [])) ? 'checked' : '' }}>
                        </div>
                        <div class="flex flex-col flex-1 justify-center items-center">
                            <span class="w-full text-sm" style="color: #18181b;">{{ $category }}</span>
                        </div>
                    </label>
                @endforeach
            @else
                {{-- Fallback hardcoded categories --}}
                <label class="flex gap-2.5 items-start">
                    <div class="flex justify-center items-center px-0 py-0.5">
                        <input type="checkbox" name="category[]" value="compact" @change="toggleCategory('compact')"
                            class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                            style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                    </div>
                    <div class="flex flex-col flex-1 justify-center items-center">
                        <span class="w-full text-sm" style="color: #18181b;">Compact</span>
                    </div>
                </label>
            @endif
        </div>
    </div>

    {{-- Hidden inputs for price range --}}
    <input type="hidden" name="min_price" value="{{ request('min_price', 0) }}">
    <input type="hidden" name="max_price" value="{{ request('max_price', 1500) }}">
    <input type="hidden" name="sort_by" value="{{ request('sort_by') === 'ASC' ? 'ASC' : 'DESC' }}">

    {{-- Action Buttons --}}
    <div class="flex flex-col gap-2.5">
        <button type="submit"
            class="flex gap-1.5 justify-center items-center px-2.5 py-1.5 w-full h-8 rounded-lg border transition-colors hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2"
            style="background-color: #ec2028; border-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); focus:ring-color: #ec2028;">
            <span class="text-sm text-white">Filter</span>
        </button>
        <button type="submit" name="reset" value="1"
            class="flex gap-1.5 justify-center items-center px-2.5 py-1.5 w-full h-8 rounded-lg border transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2"
            style="background-color: white; border-color: #e4e4e7; color: #3f3f46; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); focus:ring-color: #6b6b74;">
            <span class="text-sm">Reset filter</span>
        </button>
    </div>
</form>
