{{-- Search Form Section - Matches Figma Design --}}
<div class="pb-6 mx-auto w-full">
    <form method="GET" action="{{ route('web.search') }}" class="flex gap-2 items-end">
        {{-- Start Location --}}
        <div class="flex flex-col flex-1 gap-1">
            <label style="color: #3f3f46;">Start location</label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-2.5 pointer-events-none">
                    <svg class="w-4 h-4" style="color: #3f3f46;" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                        </path>
                    </svg>
                </div>
                <input type="text" name="pickup_location" value="Bandar Puteri, Puchong, Selangor"
                    class="block py-1.5 pr-3 pl-9 w-full rounded-lg border focus:outline-none focus:ring-1"
                    style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); focus:ring-color: #ec2028; focus:border-color: #ec2028; min-width: 220px;"
                    placeholder="Enter location" required>
            </div>
        </div>

        {{-- Start Date --}}
        <div class="flex flex-col gap-1" style="width: 130px;">
            <label style="color: #3f3f46;">Start Date</label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-2.5 pointer-events-none">
                    <svg class="w-4 h-4" style="color: #3f3f46;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <input type="text" name="pickup_date" value="05/05/2024"
                    class="block py-1.5 pr-3 pl-9 w-full rounded-lg border focus:outline-none focus:ring-1"
                    style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);"
                    placeholder="DD/MM/YYYY" required>
            </div>
        </div>

        {{-- Start Time --}}
        <div class="flex flex-col gap-1" style="width: 125px;">
            <label style="color: #3f3f46;">Start Time</label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-2.5 pointer-events-none">
                    <svg class="w-4 h-4" style="color: #3f3f46;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <select name="pickup_time"
                    class="block py-1.5 pr-3 pl-7 w-full rounded-lg border appearance-none focus:outline-none focus:ring-1"
                    style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);"
                    required>
                    <option value="9:00 AM" selected>9:00 AM</option>
                    <option value="10:00 AM">10:00 AM</option>
                    <option value="11:00 AM">11:00 AM</option>
                    <option value="12:00 PM">12:00 PM</option>
                    <option value="1:00 PM">1:00 PM</option>
                    <option value="2:00 PM">2:00 PM</option>
                    <option value="3:00 PM">3:00 PM</option>
                    <option value="4:00 PM">4:00 PM</option>
                    <option value="5:00 PM">5:00 PM</option>
                </select>
                <div class="flex absolute inset-y-0 right-0 items-center pr-2.5 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M5.00195 6.1001H11.0703C11.5158 6.1001 11.7388 6.63863 11.4238 6.95361L8.38965 9.98779C8.19438 10.183 7.87787 10.183 7.68262 9.98779L4.64844 6.95361C4.35323 6.65837 4.53067 6.16643 4.9209 6.10596L5.00195 6.1001Z"
                            fill="#18181B" stroke="#6B6B74" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Duration Tag --}}
        <div class="flex gap-2 items-center" style="width: 95px; height: 56px;">
            <div class="flex gap-2 justify-center items-center w-full">
                {{-- Dashed line on left --}}
                <svg class="flex-1" width="2" height="2" viewBox="0 0 13 2" fill="none"
                    xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <line x1="0" y1="1" x2="200" y2="1" stroke="#ec2028"
                        stroke-width="1.5" stroke-dasharray="6 3" stroke-linecap="round" />
                </svg>

                {{-- Badge --}}
                <span
                    class="px-2 py-0.5 text-[11px] whitespace-nowrap rounded-full border-1 border-[#EC2028] leading-[18px]""
                    style="background-color: #fff1f2; border-color: #ec202866; color: #ec2028;">
                    2 Days
                </span>

                {{-- Solid arrow on right --}}
                <svg class="flex-shrink-0" width="20" height="8" viewBox="0 0 20 8" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 4H18M18 4L15 1M18 4L15 7" stroke="#ec2028" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
        </div>

        {{-- Return Location --}}
        <div class="flex flex-col flex-1 gap-1">
            <label style="color: #3f3f46;">Return location</label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-2.5 pointer-events-none">
                    <svg class="w-4 h-4" style="color: #3f3f46;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                        </path>
                    </svg>
                </div>
                <input type="text" name="return_location" value="Bandar Puteri, Puchong, Selangor"
                    class="block py-1.5 pr-3 pl-9 w-full rounded-lg border focus:outline-none focus:ring-1"
                    style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); min-width: 230px;"
                    placeholder="Enter location">
            </div>
        </div>

        {{-- Return Date --}}
        <div class="flex flex-col gap-1" style="width: 130px;">
            <label style="color: #3f3f46;">Return Date</label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-2.5 pointer-events-none">
                    <svg class="w-4 h-4" style="color: #3f3f46;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <input type="text" name="return_date" value="07/05/2024"
                    class="block py-1.5 pr-3 pl-9 w-full rounded-lg border focus:outline-none focus:ring-1"
                    style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);"
                    placeholder="DD/MM/YYYY">
            </div>
        </div>

        {{-- Return Time --}}
        <div class="flex flex-col gap-1" style="width: 125px;">
            <label style="color: #3f3f46;">Return Time</label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-2.5 pointer-events-none">
                    <svg class="w-4 h-4" style="color: #3f3f46;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <select name="return_time"
                    class="block py-1.5 pr-3 pl-9 w-full rounded-lg border appearance-none focus:outline-none focus:ring-1"
                    style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                    <option value="9:00 AM" selected>9:00 AM</option>
                    <option value="10:00 AM">10:00 AM</option>
                    <option value="11:00 AM">11:00 AM</option>
                    <option value="12:00 PM">12:00 PM</option>
                    <option value="1:00 PM">1:00 PM</option>
                    <option value="2:00 PM">2:00 PM</option>
                    <option value="3:00 PM">3:00 PM</option>
                    <option value="4:00 PM">4:00 PM</option>
                    <option value="5:00 PM">5:00 PM</option>
                </select>
                <div class="flex absolute inset-y-0 right-0 items-center pr-2.5 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <path
                            d="M5.00195 6.1001H11.0703C11.5158 6.1001 11.7388 6.63863 11.4238 6.95361L8.38965 9.98779C8.19438 10.183 7.87787 10.183 7.68262 9.98779L4.64844 6.95361C4.35323 6.65837 4.53067 6.16643 4.9209 6.10596L5.00195 6.1001Z"
                            fill="#18181B" stroke="#6B6B74" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Search Button --}}
        <button type="submit"
            class="p-1.5 rounded-lg border transition-colors hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2"
            style="height: 32px; width: 32px; background-color: white; border-color: #e4e4e7; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); focus:ring-color: #ec2028;">
            <svg class="w-4 h-4" style="color: #3f3f46;" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                </path>
            </svg>
        </button>
    </form>
</div>
