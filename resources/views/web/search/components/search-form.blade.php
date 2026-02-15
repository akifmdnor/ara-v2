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
                <input type="text" name="pickup_location" id="pickup_location"
                    value="{{ app('request')->input('pickup_location', 'Bandar Puteri, Puchong, Selangor') }}"
                    class="block py-1.5 pr-3 pl-9 w-full rounded-lg border focus:outline-none focus:ring-1"
                    style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); focus:ring-color: #ec2028; focus:border-color: #ec2028; min-width: 220px;"
                    placeholder="Enter location" required>
                <input type="hidden" name="pickup_latitude" id="pickup_latitude"
                    value="{{ app('request')->input('pickup_latitude') }}" />
                <input type="hidden" name="pickup_longitude" id="pickup_longitude"
                    value="{{ app('request')->input('pickup_longitude') }}" />
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
                <input type="text" name="pickup_date" id="InputStartDate"
                    value="{{ app('request')->input('pickup_date') ? str_replace('-', '/', app('request')->input('pickup_date')) : now()->format('d/m/Y') }}"
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
                <select name="pickup_time" id="InputStartTime"
                    class="block py-1.5 pr-3 pl-9 w-full rounded-lg border appearance-none focus:outline-none focus:ring-1"
                    style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);"
                    required>
                    <option value="9:00 AM" @if (app('request')->input('pickup_time') == '9:00 AM') selected @endif>9:00 AM
                    </option>
                    <option value="9:30 AM" @if (app('request')->input('pickup_time') == '9:30 AM') selected @endif>9:30 AM
                    </option>
                    <option value="10:00 AM" @if (app('request')->input('pickup_time') == '10:00 AM') selected @endif>10:00 AM
                    </option>
                    <option value="10:30 AM" @if (app('request')->input('pickup_time') == '10:30 AM') selected @endif>10:30 AM
                    </option>
                    <option value="11:00 AM" @if (app('request')->input('pickup_time') == '11:00 AM') selected @endif>11:00 AM
                    </option>
                    <option value="11:30 AM" @if (app('request')->input('pickup_time') == '11:30 AM') selected @endif>11:30 AM
                    </option>
                    <option value="12:00 PM" @if (app('request')->input('pickup_time') == '12:00 PM') selected @endif>12:00 PM
                    </option>
                    <option value="12:30 PM" @if (app('request')->input('pickup_time') == '12:30 PM') selected @endif>12:30 PM
                    </option>
                    <option value="1:00 PM" @if (app('request')->input('pickup_time') == '1:00 PM') selected @endif>1:00 PM
                    </option>
                    <option value="1:30 PM" @if (app('request')->input('pickup_time') == '1:30 PM') selected @endif>1:30 PM
                    </option>
                    <option value="2:00 PM" @if (app('request')->input('pickup_time') == '2:00 PM') selected @endif>2:00 PM
                    </option>
                    <option value="2:30 PM" @if (app('request')->input('pickup_time') == '2:30 PM') selected @endif>2:30 PM
                    </option>
                    <option value="3:00 PM" @if (app('request')->input('pickup_time') == '3:00 PM') selected @endif>3:00 PM
                    </option>
                    <option value="3:30 PM" @if (app('request')->input('pickup_time') == '3:30 PM') selected @endif>3:30 PM
                    </option>
                    <option value="4:00 PM" @if (app('request')->input('pickup_time') == '4:00 PM') selected @endif>4:00 PM
                    </option>
                    <option value="4:30 PM" @if (app('request')->input('pickup_time') == '4:30 PM') selected @endif>4:30 PM
                    </option>
                    <option value="5:00 PM" @if (app('request')->input('pickup_time') == '5:00 PM') selected @endif>5:00 PM
                    </option>
                    <option value="5:30 PM" @if (app('request')->input('pickup_time') == '5:30 PM') selected @endif>5:30 PM
                    </option>
                    <option value="6:00 PM" @if (app('request')->input('pickup_time') == '6:00 PM') selected @endif>6:00 PM
                    </option>
                    <option value="6:30 PM" @if (app('request')->input('pickup_time') == '6:30 PM') selected @endif>6:30 PM
                    </option>
                    <option value="7:00 PM" @if (app('request')->input('pickup_time') == '7:00 PM') selected @endif>7:00 PM
                    </option>
                    <option value="7:30 PM" @if (app('request')->input('pickup_time') == '7:30 PM') selected @endif>7:30 PM
                    </option>
                    <option value="8:00 PM" @if (app('request')->input('pickup_time') == '8:00 PM') selected @endif>8:00 PM
                    </option>
                    <option value="8:30 PM" @if (app('request')->input('pickup_time') == '8:30 PM') selected @endif>8:30 PM
                    </option>
                    <option value="9:00 PM" @if (app('request')->input('pickup_time') == '9:00 PM') selected @endif>9:00 PM
                    </option>
                    <option value="9:30 PM" @if (app('request')->input('pickup_time') == '9:30 PM') selected @endif>9:30 PM
                    </option>
                    <option value="10:00 PM" @if (app('request')->input('pickup_time') == '10:00 PM') selected @endif>10:00 PM
                    </option>
                    <option value="10:30 PM" @if (app('request')->input('pickup_time') == '10:30 PM') selected @endif>10:30 PM
                    </option>
                    <option value="11:00 PM" @if (app('request')->input('pickup_time') == '11:00 PM') selected @endif>11:00 PM
                    </option>
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
                <span id="rental-days-badge"
                    class="px-2 py-0.5 text-[11px] whitespace-nowrap rounded-full border-1 border-[#EC2028] leading-[18px]""
                    style="background-color: #fff1f2; border-color: #ec202866; color: #ec2028;">
                    {{ isset($rentalDays) ? $rentalDays : 2 }} {{ isset($rentalDays) && $rentalDays == 1 ? 'Day' : 'Days' }}
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
                <input type="text" name="return_location" id="return_location"
                    value="{{ app('request')->input('return_location', 'Bandar Puteri, Puchong, Selangor') }}"
                    class="block py-1.5 pr-3 pl-9 w-full rounded-lg border focus:outline-none focus:ring-1"
                    style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); min-width: 230px;"
                    placeholder="Enter location">
                <input type="hidden" name="return_latitude" id="return_latitude"
                    value="{{ app('request')->input('return_latitude') }}" />
                <input type="hidden" name="return_longitude" id="return_longitude"
                    value="{{ app('request')->input('return_longitude') }}" />
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
                <input type="text" name="return_date" id="InputReturnDate"
                    value="{{ app('request')->input('return_date') ? str_replace('-', '/', app('request')->input('return_date')) : now()->addDays(2)->format('d/m/Y') }}"
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
                <select name="return_time" id="InputReturnTime"
                    class="block py-1.5 pr-3 pl-9 w-full rounded-lg border appearance-none focus:outline-none focus:ring-1"
                    style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                    <option value="9:00 AM" @if (app('request')->input('return_time') == '9:00 AM') selected @endif>9:00 AM
                    </option>
                    <option value="9:30 AM" @if (app('request')->input('return_time') == '9:30 AM') selected @endif>9:30 AM
                    </option>
                    <option value="10:00 AM" @if (app('request')->input('return_time') == '10:00 AM') selected @endif>10:00 AM
                    </option>
                    <option value="10:30 AM" @if (app('request')->input('return_time') == '10:30 AM') selected @endif>10:30 AM
                    </option>
                    <option value="11:00 AM" @if (app('request')->input('return_time') == '11:00 AM') selected @endif>11:00 AM
                    </option>
                    <option value="11:30 AM" @if (app('request')->input('return_time') == '11:30 AM') selected @endif>11:30 AM
                    </option>
                    <option value="12:00 PM" @if (app('request')->input('return_time') == '12:00 PM') selected @endif>12:00 PM
                    </option>
                    <option value="12:30 PM" @if (app('request')->input('return_time') == '12:30 PM') selected @endif>12:30 PM
                    </option>
                    <option value="1:00 PM" @if (app('request')->input('return_time') == '1:00 PM') selected @endif>1:00 PM
                    </option>
                    <option value="1:30 PM" @if (app('request')->input('return_time') == '1:30 PM') selected @endif>1:30 PM
                    </option>
                    <option value="2:00 PM" @if (app('request')->input('return_time') == '2:00 PM') selected @endif>2:00 PM
                    </option>
                    <option value="2:30 PM" @if (app('request')->input('return_time') == '2:30 PM') selected @endif>2:30 PM
                    </option>
                    <option value="3:00 PM" @if (app('request')->input('return_time') == '3:00 PM') selected @endif>3:00 PM
                    </option>
                    <option value="3:30 PM" @if (app('request')->input('return_time') == '3:30 PM') selected @endif>3:30 PM
                    </option>
                    <option value="4:00 PM" @if (app('request')->input('return_time') == '4:00 PM') selected @endif>4:00 PM
                    </option>
                    <option value="4:30 PM" @if (app('request')->input('return_time') == '4:30 PM') selected @endif>4:30 PM
                    </option>
                    <option value="5:00 PM" @if (app('request')->input('return_time') == '5:00 PM') selected @endif>5:00 PM
                    </option>
                    <option value="5:30 PM" @if (app('request')->input('return_time') == '5:30 PM') selected @endif>5:30 PM
                    </option>
                    <option value="6:00 PM" @if (app('request')->input('return_time') == '6:00 PM') selected @endif>6:00 PM
                    </option>
                    <option value="6:30 PM" @if (app('request')->input('return_time') == '6:30 PM') selected @endif>6:30 PM
                    </option>
                    <option value="7:00 PM" @if (app('request')->input('return_time') == '7:00 PM') selected @endif>7:00 PM
                    </option>
                    <option value="7:30 PM" @if (app('request')->input('return_time') == '7:30 PM') selected @endif>7:30 PM
                    </option>
                    <option value="8:00 PM" @if (app('request')->input('return_time') == '8:00 PM') selected @endif>8:00 PM
                    </option>
                    <option value="8:30 PM" @if (app('request')->input('return_time') == '8:30 PM') selected @endif>8:30 PM
                    </option>
                    <option value="9:00 PM" @if (app('request')->input('return_time') == '9:00 PM') selected @endif>9:00 PM
                    </option>
                    <option value="9:30 PM" @if (app('request')->input('return_time') == '9:30 PM') selected @endif>9:30 PM
                    </option>
                    <option value="10:00 PM" @if (app('request')->input('return_time') == '10:00 PM') selected @endif>10:00 PM
                    </option>
                    <option value="10:30 PM" @if (app('request')->input('return_time') == '10:30 PM') selected @endif>10:30 PM
                    </option>
                    <option value="11:00 PM" @if (app('request')->input('return_time') == '11:00 PM') selected @endif>11:00 PM
                    </option>
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



    {{-- Different Return Location Section --}}
    <div class="mb-3 input-group d-none" id="return-location" style="margin-top: 16px;">
        <span class="input-group-text">
            <i class="bi bi-geo-alt"></i>
        </span>
        <input type="text" class="form-control" id="return_location_2" autocomplete="on" name="return_location"
            placeholder="Return Location">
        <input type="hidden" name="return_latitude" id="return_latitude" />
        <input type="hidden" name="return_longitude" id="return_longitude" />
    </div>

    {{-- New Form for Different Location --}}
    <form method="GET" action="{{ route('web.search') }}" class="flex gap-2 items-end d-none"
        id="different-location-form" style="margin-top: 16px;">
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
                <input type="text" name="return_location" value="{{ app('request')->input('return_location') }}"
                    class="block py-1.5 pr-3 pl-9 w-full rounded-lg border focus:outline-none focus:ring-1"
                    style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); min-width: 230px;"
                    placeholder="Enter location">
                <input type="hidden" name="return_latitude" id="return_latitude_2" />
                <input type="hidden" name="return_longitude" id="return_longitude_2" />
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
                <input type="text" name="return_date" id="InputReturnDateAlt"
                    value="{{ app('request')->input('return_date') ? str_replace('-', '/', app('request')->input('return_date')) : now()->addDays(2)->format('d/m/Y') }}"
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
    </form>
</div>

{{-- Load Flatpickr CSS and JS for datepickers --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/date-fns@3.6.0/cdn.min.js"></script>

<style>
    /* Ensure Flatpickr calendar is visible */
    .flatpickr-calendar {
        z-index: 9999 !important;
        position: absolute !important;
        background: white !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .flatpickr-input {
        cursor: pointer !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const today = new Date();
        let datearray = [];
        const currentTime = today.getHours() + today.getMinutes() / 60;

        const minPickupDate = dateFns.format(today, "yyyy-MM-dd");
        const returnMinDate = dateFns.format(
            dateFns.addDays(today, 1),
            "yyyy-MM-dd"
        );

        const pickupTimeSelect = document.getElementById("InputStartTime");

        // Get the input element value to preserve URL parameter dates
        const startDateInput = document.getElementById("InputStartDate");
        const startDateValue = startDateInput ? startDateInput.value : null;
        
        console.log('Start date from input:', startDateValue);
        console.log('Pickup date URL param:', '{{ app("request")->input("pickup_date") }}');

        const pickupDatePicker = flatpickr("#InputStartDate", {
            minDate: minPickupDate,
            dateFormat: "d/m/Y",
            defaultDate: startDateValue || minPickupDate,
            allowInput: true,
            onChange: function(selectedDates, dateStr, instance) {
                const pickupDate = selectedDates[0];
                if (pickupDate) {
                    const returnStartDate = dateFns.addDays(
                        new Date(pickupDate),
                        1
                    );

                    if (
                        dateFns.isAfter(
                            pickupDate,
                            returnDatePicker.selectedDates[0]
                        ) ||
                        dateFns.isSameDay(
                            pickupDate,
                            returnDatePicker.selectedDates[0]
                        )
                    ) {
                        returnDatePicker.setDate(returnStartDate);
                    }
                    returnDatePicker.set("minDate", returnStartDate);
                }

                // Handle time availability based on selected date
                handleTimeAvailability(selectedDates[0]);
                
                // Update rental days badge
                updateRentalDaysBadge();
            },
            onOpen: function(selectedDates, dateStr, instance) {
                handleTimeAvailability(selectedDates[0]);
            },
        });

        // Get the return date input element value to preserve URL parameter dates
        const returnDateInput = document.getElementById("InputReturnDate");
        const returnDateValue = returnDateInput ? returnDateInput.value : null;
        
        console.log('Return date from input:', returnDateValue);
        console.log('Return date URL param:', '{{ app("request")->input("return_date") }}');

        const returnDatePicker = flatpickr("#InputReturnDate", {
            minDate: returnMinDate,
            dateFormat: "d/m/Y",
            defaultDate: returnDateValue || returnMinDate,
            allowInput: true,
            onChange: function(selectedDates, dateStr, instance) {
                // Update rental days badge when return date changes
                updateRentalDaysBadge();
            },
        });

        function blockRestricted() {
            //v1 url from config/app.php
            fetch("{{ config('app.v1_url') }}/restricted-date")
                .then((response) => response.json())
                .then((data) => {
                    datearray = datearray.concat(data);
                    //sort date array based on date dd-mm-yyyy
                    datearray.sort(function(a, b) {
                        var aa = a.split("-").reverse().join(),
                            bb = b.split("-").reverse().join();
                        return aa < bb ? -1 : aa > bb ? 1 : 0;
                    });

                    console.log("datearray", datearray);

                    checkDate = new Date(today);
                    checkDate.setHours(8, 0, 0, 0);
                    datearray = datearray.filter(function(date) {
                        var dateObj = new Date(date.split("-").reverse().join("-"));
                        return dateObj >= checkDate;
                    });

                    // Only update dates if no URL parameters exist (first time loading)
                    const hasPickupDateParam = '{{ app("request")->input("pickup_date") }}';
                    const hasReturnDateParam = '{{ app("request")->input("return_date") }}';
                    
                    if (!hasPickupDateParam || !hasReturnDateParam) {
                        for (let i = 0; i < datearray.length; i++) {
                            var date = datearray[i];
                            var dateObj = new Date(date.split("-").reverse().join("-"));

                            if (dateObj < checkDate) {
                                continue;
                            }
                            if (dateFns.isSameDay(dateObj, checkDate)) {
                                console.log("today is restricted");
                                checkDate.setDate(checkDate.getDate() + 1);
                                pickupDatePicker.setDate(checkDate);
                                pickupDatePicker.set("minDate", checkDate);
                                returnDatePicker.set(
                                    "minDate",
                                    dateFns.addDays(checkDate, 1)
                                );
                                returnDatePicker.setDate(dateFns.addDays(checkDate, 1));
                            }
                        }
                    }
                    
                    // Always set disabled dates
                    pickupDatePicker.set("disable", datearray);
                    returnDatePicker.set("disable", datearray);
                })
                .catch((error) => {
                    console.error(
                        "There was an error fetching the restricted dates:",
                        error
                    );
                });
        }

        function handleTimeAvailability(selectedPickupDate) {
            let options = pickupTimeSelect.options;
            let minAvailableTime;
            let selectedDate = new Date(selectedPickupDate);
            let todayRef = new Date(today);

            // If the selected pickup date is today
            if (dateFns.isSameDay(selectedDate, todayRef)) {
                if (currentTime >= 19) {
                    // After 7 PM, force tomorrow as pickup date and set minimum time to 10:30 AM
                    todayRef = dateFns.addDays(today, 1);
                    pickupDatePicker.setDate(todayRef);
                    pickupDatePicker.set("minDate", todayRef);
                    if (
                        dateFns.isAfter(
                            todayRef,
                            returnDatePicker.selectedDates[0]
                        ) ||
                        !returnDatePicker.selectedDates[0]
                    ) {
                        returnDatePicker.setDate(dateFns.addDays(todayRef, 1));
                    }
                    returnDatePicker.set("minDate", dateFns.addDays(todayRef, 1));
                    minAvailableTime = 10.5; // 10:30 AM
                    pickupTimeSelect.value = "10:30 AM";
                } else if (currentTime < 9) {
                    pickupDatePicker.setDate(todayRef);
                    returnDatePicker.set("minDate", dateFns.addDays(todayRef, 1));
                    if (
                        dateFns.isAfter(
                            todayRef,
                            returnDatePicker.selectedDates[0]
                        ) ||
                        !returnDatePicker.selectedDates[0]
                    ) {
                        returnDatePicker.setDate(dateFns.addDays(todayRef, 1));
                    }
                    minAvailableTime = 10.5;
                    pickupTimeSelect.value = "10:30 AM";
                } else {
                    // Before 7 PM, allow today, but only after 1.5 hours from now
                    pickupDatePicker.setDate(todayRef);
                    returnDatePicker.set("minDate", dateFns.addDays(todayRef, 1));
                    if (
                        dateFns.isAfter(
                            todayRef,
                            returnDatePicker.selectedDates[0]
                        ) ||
                        !returnDatePicker.selectedDates[0]
                    ) {
                        returnDatePicker.setDate(dateFns.addDays(todayRef, 1));
                    }
                    minAvailableTime = currentTime + 1.5;
                    pickupTimeSelect.value = convertDecimalToTime(minAvailableTime);
                }
            } else if (dateFns.isSameDay(selectedDate, dateFns.addDays(today, 1))) {
                if (currentTime < 19) {
                    minAvailableTime = 9; // 9:00 AM
                    pickupTimeSelect.value = "9:00 AM";
                } else {
                    // If the selected pickup date is tomorrow, set minimum time to 10:30 AM
                    minAvailableTime = 10.5; // 10:30 AM
                    pickupTimeSelect.value = "10:30 AM";
                }
            } else {
                // If the selected pickup date is after tomorrow, no time restrictions
                minAvailableTime = 9;
                pickupTimeSelect.value = "9:00 AM";
            }

            // Enable or disable time options based on available time
            for (let i = 0; i < options.length; i++) {
                let optionTime = convertTimeToDecimal(options[i].value);
                options[i].disabled = optionTime < minAvailableTime;
            }
        }

        // Helper function to convert time string to number
        function convertTimeToDecimal(timeString) {
            const [time, modifier] = timeString.split(" ");
            let [hours, minutes] = time.split(":");
            hours = parseInt(hours, 10);
            minutes = parseInt(minutes, 10) / 60;
            if (modifier === "PM" && hours < 12) hours += 12;
            if (modifier === "AM" && hours === 12) hours = 0;
            return hours + minutes;
        }

        // Helper function to convert number to time string
        function convertDecimalToTime(decimalTime) {
            let hours = Math.floor(decimalTime);
            let minutes = (decimalTime - hours) * 60;

            // Rounding logic
            if (minutes > 30) {
                hours += 1; // Round up to the next hour
                minutes = 0; // Set minutes to 00
            } else if (minutes > 0) {
                minutes = 30; // Round to 30 minutes
            } else {
                minutes = 0; // Keep minutes at 00
            }

            // Handle AM/PM format
            const modifier = hours >= 12 ? "PM" : "AM";
            let adjustedHours = hours % 12;
            if (adjustedHours === 0) adjustedHours = 12;

            const formattedMinutes = minutes === 0 ? "00" : "30";
            return `${adjustedHours}:${formattedMinutes} ${modifier}`;
        }

        // Function to update rental days badge
        function updateRentalDaysBadge() {
            const badge = document.getElementById('rental-days-badge');
            if (!badge) return;

            const pickupDate = pickupDatePicker.selectedDates[0];
            const returnDate = returnDatePicker.selectedDates[0];

            if (pickupDate && returnDate) {
                const days = Math.max(1, dateFns.differenceInDays(returnDate, pickupDate));
                badge.textContent = `${days} ${days === 1 ? 'Day' : 'Days'}`;
            }
        }

        // Only run time availability check on the selected date if it exists, otherwise use today
        const selectedPickupDate = pickupDatePicker.selectedDates[0] || today;
        handleTimeAvailability(selectedPickupDate);
        
        blockRestricted();
        
        // Initialize rental days badge
        setTimeout(() => {
            updateRentalDaysBadge();
        }, 100);
    });


    // Handle different location checkbox
    const differentLocationCheck = document.getElementById("different-location");
    const returnLocationDiv = document.getElementById("return-location");
    const differentLocationForm = document.getElementById("different-location-form");
    const mainForm = document.querySelector("form[action*='web.search']");

    if (differentLocationCheck && returnLocationDiv && differentLocationForm && mainForm) {
        differentLocationCheck.addEventListener("change", function(event) {
            if (event.currentTarget.checked) {
                returnLocationDiv.classList.remove("d-none");
                differentLocationForm.classList.remove("d-none");
                // Hide the return location fields in the main form
                const mainReturnFields = mainForm.querySelectorAll(
                    '[name="return_location"], [name="return_date"], [name="return_time"]');
                mainReturnFields.forEach(field => {
                    const parentDiv = field.closest('.flex');
                    if (parentDiv) parentDiv.style.display = 'none';
                });
            } else {
                returnLocationDiv.classList.add("d-none");
                differentLocationForm.classList.add("d-none");
                // Show the return location fields in the main form
                const mainReturnFields = mainForm.querySelectorAll(
                    '[name="return_location"], [name="return_date"], [name="return_time"]');
                mainReturnFields.forEach(field => {
                    const parentDiv = field.closest('.flex');
                    if (parentDiv) parentDiv.style.display = '';
                });
            }
        });
    }
</script>

{{-- Include Maps functionality --}}
@include('web.landing.maps')

<script>
    (function() {
        // Ensure Google Maps autocomplete is initialized for search form
        function initializeSearchFormAutocomplete() {
            if (typeof google !== 'undefined' && google.maps && google.maps.places) {
                // Call the initialize function from maps.blade.php with error checking
                if (typeof initialize === 'function') {
                    try {
                        initialize();
                    } catch (error) {
                        console.log('Google Maps initialize error:', error);
                    }
                }
            }
        }

        // If Google Maps is already loaded, initialize immediately
        if (typeof google !== 'undefined' && google.maps && google.maps.places) {
            // Small delay to ensure DOM is ready
            setTimeout(initializeSearchFormAutocomplete, 100);
        }

        // Also set up a global callback for when Google Maps loads
        window.initializeSearchAutocomplete = initializeSearchFormAutocomplete;
    })();
</script>
