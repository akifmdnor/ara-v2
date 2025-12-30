{{-- Sidebar Filter Component - Matches Figma Design --}}
<div class="flex flex-col gap-6 p-3 bg-white rounded-lg" x-data="filterData()"
    style="box-shadow: 0px 2px 4px 0px rgba(51,65,85,0.1), 0px 6px 32px 0px rgba(51,65,85,0.1);">

    {{-- Price Range --}}
    <div class="flex flex-col gap-3">
        <h3 class=" font-medium" style="color: #3f3f46;">Price range</h3>

        {{-- Price Range Slider --}}
        <div class="relative px-0 py-3">
            <div class="relative h-1 bg-gray-200 rounded-full">
                <div class="absolute h-1 rounded-full" style="background-color: #c60f16; left: 0; width: 68%;"></div>
            </div>
            <div class="absolute w-2.5 h-2.5 rounded-full border-2 border-white"
                style="background-color: #c60f16; left: 0; top: 50%; transform: translate(-50%, -50%); box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
            </div>
            <div class="absolute w-2.5 h-2.5 rounded-full border-2 border-white"
                style="background-color: #c60f16; left: 68%; top: 50%; transform: translate(-50%, -50%); box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
            </div>
        </div>

        {{-- Price Inputs --}}
        <div class="flex gap-1 items-center h-8">
            <div class="flex flex-1 items-center px-2.5 py-1.5  rounded-full border"
                style="height: 32px; background-color: white; border-color: #e4e4e7; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                <span style="color: #6b6b74;">RM</span>
                <span class="flex-1 font-medium text-right" style="color: #18181b;">0.00</span>
            </div>
            <span class="" style="color: #6b6b74;">-</span>
            <div class="flex flex-1 items-center px-2.5 py-1.5  rounded-full border"
                style="height: 32px; background-color: white; border-color: #e4e4e7; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                <span style="color: #6b6b74;">RM</span>
                <span class="flex-1 font-medium text-right" style="color: #18181b;">2,000.00</span>
            </div>
        </div>
    </div>

    {{-- Sort by Price --}}
    <div class="flex flex-col gap-3">
        <h3 class=" font-medium" style="color: #3f3f46;">Sort by price</h3>
        <div class="flex rounded-lg" style="background-color: #f4f4f5;">
            <button @click="sortBy = 'low-to-high'" :class="sortBy === 'low-to-high' ? 'bg-white border shadow-sm' : ''"
                class="flex-1 px-2.5 py-1.5  font-medium rounded-lg transition-colors min-h-8"
                :style="sortBy === 'low-to-high' ?
                    'border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                    'color: #6b6b74;'">
                Low to high
            </button>
            <button @click="sortBy = 'high-to-low'" :class="sortBy === 'high-to-low' ? 'bg-white border shadow-sm' : ''"
                class="flex-1 px-2.5 py-1.5  font-medium rounded-lg transition-colors min-h-8"
                :style="sortBy === 'high-to-low' ?
                    'border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);' :
                    'color: #6b6b74;'">
                High to low
            </button>
        </div>
    </div>

    {{-- Brand Filter --}}
    <div class="flex flex-col gap-3">
        <h3 class=" font-medium" style="color: #3f3f46;">Brand</h3>
        <div class="flex flex-col gap-3">
            {{-- Proton --}}
            <label class="flex gap-2.5 items-start">
                <div class="flex justify-center items-center px-0 py-0.5">
                    <input type="checkbox" value="proton" @change="toggleBrand('proton')"
                        class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                        style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); focus:ring-color: #ec2028;">
                </div>
                <div class="flex flex-col flex-1 justify-center items-center">
                    <span class="w-full  font-medium" style="color: #18181b;">Proton</span>
                </div>
            </label>

            {{-- Perodua --}}
            <label class="flex gap-2.5 items-start">
                <div class="flex justify-center items-center px-0 py-0.5">
                    <input type="checkbox" value="perodua" @change="toggleBrand('perodua')"
                        class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                        style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                </div>
                <div class="flex flex-col flex-1 justify-center items-center">
                    <span class="w-full  font-medium" style="color: #18181b;">Perodua</span>
                </div>
            </label>

            {{-- Mercedes --}}
            <label class="flex gap-2.5 items-start">
                <div class="flex justify-center items-center px-0 py-0.5">
                    <input type="checkbox" value="mercedes" @change="toggleBrand('mercedes')"
                        class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                        style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                </div>
                <div class="flex flex-col flex-1 justify-center items-center">
                    <span class="w-full  font-medium" style="color: #18181b;">Mercedes</span>
                </div>
            </label>

            {{-- BMW --}}
            <label class="flex gap-2.5 items-start">
                <div class="flex justify-center items-center px-0 py-0.5">
                    <input type="checkbox" value="bmw" @change="toggleBrand('bmw')"
                        class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                        style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                </div>
                <div class="flex flex-col flex-1 justify-center items-center">
                    <span class="w-full  font-medium" style="color: #18181b;">BMW</span>
                </div>
            </label>

            {{-- Volvo --}}
            <label class="flex gap-2.5 items-start">
                <div class="flex justify-center items-center px-0 py-0.5">
                    <input type="checkbox" value="volvo" @change="toggleBrand('volvo')"
                        class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                        style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                </div>
                <div class="flex flex-col flex-1 justify-center items-center">
                    <span class="w-full  font-medium" style="color: #18181b;">Volvo</span>
                </div>
            </label>

            {{-- Show All Button --}}
            <button class="flex gap-1.5 items-center rounded-lg" @click="showBrandDropdown = !showBrandDropdown">
                <span class=" font-medium" style="color: #ec2028;">Show All</span>
            </button>
        </div>
    </div>

    {{-- Category Filter --}}
    <div class="flex flex-col gap-3">
        <h3 class=" font-medium" style="color: #3f3f46;">Category</h3>
        <div class="flex flex-col gap-3">
            {{-- Compact --}}
            <label class="flex gap-2.5 items-start">
                <div class="flex justify-center items-center px-0 py-0.5">
                    <input type="checkbox" value="compact" @change="toggleCategory('compact')"
                        class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                        style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                </div>
                <div class="flex flex-col flex-1 justify-center items-center">
                    <span class="w-full  font-medium" style="color: #18181b;">Compact</span>
                </div>
            </label>

            {{-- Sedan --}}
            <label class="flex gap-2.5 items-start">
                <div class="flex justify-center items-center px-0 py-0.5">
                    <input type="checkbox" value="sedan" @change="toggleCategory('sedan')"
                        class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                        style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                </div>
                <div class="flex flex-col flex-1 justify-center items-center">
                    <span class="w-full  font-medium" style="color: #18181b;">Sedan</span>
                </div>
            </label>

            {{-- SUV --}}
            <label class="flex gap-2.5 items-start">
                <div class="flex justify-center items-center px-0 py-0.5">
                    <input type="checkbox" value="suv" @change="toggleCategory('suv')"
                        class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                        style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                </div>
                <div class="flex flex-col flex-1 justify-center items-center">
                    <span class="w-full  font-medium" style="color: #18181b;">SUV</span>
                </div>
            </label>

            {{-- MPV/Minivan --}}
            <label class="flex gap-2.5 items-start">
                <div class="flex justify-center items-center px-0 py-0.5">
                    <input type="checkbox" value="mpv" @change="toggleCategory('mpv')"
                        class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                        style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                </div>
                <div class="flex flex-col flex-1 justify-center items-center">
                    <span class="w-full  font-medium" style="color: #18181b;">MPV/ Minivan</span>
                </div>
            </label>

            {{-- 4WD --}}
            <label class="flex gap-2.5 items-start">
                <div class="flex justify-center items-center px-0 py-0.5">
                    <input type="checkbox" value="4wd" @change="toggleCategory('4wd')"
                        class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                        style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                </div>
                <div class="flex flex-col flex-1 justify-center items-center">
                    <span class="w-full  font-medium" style="color: #18181b;">4WD</span>
                </div>
            </label>

            {{-- Van --}}
            <label class="flex gap-2.5 items-start">
                <div class="flex justify-center items-center px-0 py-0.5">
                    <input type="checkbox" value="van" @change="toggleCategory('van')"
                        class="w-4 h-4 rounded border focus:ring-1 focus:ring-offset-0"
                        style="color: #ec2028; border-color: #e4e4e7; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                </div>
                <div class="flex flex-col flex-1 justify-center items-center">
                    <span class="w-full  font-medium" style="color: #18181b;">Van</span>
                </div>
            </label>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col gap-2.5">
        <button @click="applyFilters()"
            class="flex gap-1.5 justify-center items-center px-2.5 py-1.5 w-full h-8 rounded-lg border transition-colors hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2"
            style="background-color: #ec2028; border-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); focus:ring-color: #ec2028;">
            <span class=" font-medium text-white">Filter</span>
        </button>
        <button @click="resetFilters()"
            class="flex gap-1.5 justify-center items-center px-2.5 py-1.5 w-full h-8 rounded-lg border transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2"
            style="background-color: white; border-color: #e4e4e7; color: #3f3f46; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); focus:ring-color: #6b6b74;">
            <span class=" font-medium">Reset filter</span>
        </button>
    </div>
</div>
