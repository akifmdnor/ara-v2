@extends('web.layouts.app')

@section('title', 'Customer Information - ARA Car Rental')

@section('content')
    <div class="w-full min-h-screen bg-white">
        {{-- Navigation --}}
        @include('web.components.navbar')

        {{-- Main Content --}}
        <div class="w-full bg-white">
            {{-- Stepper --}}
            <div class="mx-auto max-w-[1280px] pt-12">
                @include('web.components.stepper', ['currentStep' => 3])
            </div>

            {{-- Content Area --}}
            <div class="flex mx-auto max-w-[1280px] gap-2.5 pt-12 pb-[148px]">
                {{-- Sidebar --}}
                <div class="shrink-0 w-[300px]">
                    @include('web.components.booking-sidebar', ['carDetails' => $carDetails])
                </div>

                {{-- Main Content --}}
                <div class="flex flex-col flex-1 w-[968px] gap-2.5">
                    <form id="customer-info-form" action="{{ route('web.customer-info.store') }}" method="POST">
                        @csrf

                        {{-- Customer Information Card --}}
                        <div class="flex flex-col p-6 bg-white rounded-lg gap-8"
                            style="border-radius: var(--Radius-Medium, 8px); background: var(--Background-bg-dialog, #FFF); box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05);">

                            {{-- Driver's Personal Details Section --}}
                            <div class="flex flex-col gap-3">
                                <span class="text-sm font-semibold text-[#6b6b74] leading-5 block">
                                    Driver's Personal Details
                                </span>

                                <div class="flex flex-col gap-[12px]">
                                    {{-- Name --}}
                                    <div class="flex flex-col gap-[6px]">
                                        <label for="name" class="text-base font-normal text-[#3f3f46] leading-6">
                                            Name
                                        </label>
                                        <x-form-input id="name" name="name" :required="true"
                                            placeholder="Enter your full name" :value="old('name')" />
                                        @error('name')
                                            <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Email & Country of Origin --}}
                                    <div class="flex gap-3">
                                        <div class="flex flex-col gap-[6px] flex-1">
                                            <label for="email" class="text-base font-normal text-[#3f3f46] leading-6">
                                                Email
                                            </label>
                                            <x-form-input type="email" id="email" name="email" :required="true"
                                                placeholder="your.email@example.com" :value="old('email')">
                                                <x-slot name="icon">
                                                    <svg viewBox="0 0 20 20" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                                        <path
                                                            d="M3 4C2.44772 4 2 4.44772 2 5V15C2 15.5523 2.44772 16 3 16H17C17.5523 16 18 15.5523 18 15V5C18 4.44772 17.5523 4 17 4H3Z"
                                                            stroke="currentColor" stroke-width="1.5" />
                                                        <path d="M2 5L10 10L18 5" stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </x-slot>
                                            </x-form-input>
                                            @error('email')
                                                <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="flex flex-col gap-[6px] flex-1">
                                            <label for="country" class="text-base font-normal text-[#3f3f46] leading-6">
                                                Country of Origin
                                            </label>
                                            <x-form-select id="country" name="country" :required="true">
                                                <option value="MY" selected>Malaysia</option>
                                                <option value="">Select country</option>
                                            </x-form-select>
                                            @error('country')
                                                <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Age & Mobile Number --}}
                                    <div class="flex gap-3">
                                        <div class="flex flex-col gap-[6px] flex-1">
                                            <label for="age" class="text-base font-normal text-[#3f3f46] leading-6">
                                                Age
                                            </label>
                                            <x-form-input type="number" id="age" name="age" :required="true"
                                                min="18" max="100" placeholder="Age" :value="old('age')" />
                                            @error('age')
                                                <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="flex flex-col gap-[6px] flex-1">
                                            <label for="phone" class="text-base font-normal text-[#3f3f46] leading-6">
                                                Mobile Number
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="flex h-10 items-center gap-2 self-stretch rounded-lg border border-[#e4e4e7] bg-white shadow-[0px_1px_3px_0px_rgba(0,0,0,0.07)]">
                                                    <select id="country_code" name="country_code"
                                                        class="flex items-center gap-0.5 px-2 py-2 bg-transparent text-base text-[#3f3f46] focus:outline-none cursor-pointer appearance-none pr-6 w-[53px]">
                                                        <option value="+60" selected>+60</option>
                                                    </select>
                                                    <div
                                                        class="absolute left-12 top-1/2 -translate-y-1/2 pointer-events-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                            height="7" viewBox="0 0 12 7" fill="none">
                                                            <path d="M0.75 0.75L5.75 5.75L10.75 0.75" stroke="#6B6B74"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                    <input type="tel" id="phone" name="phone" required
                                                        class="flex-1 pl-2 pr-3 py-2 text-base font-light leading-6 focus:outline-none focus:ring-2 focus:ring-[#ec2028] bg-transparent placeholder:text-[#6B6B74] placeholder:text-base placeholder:font-light placeholder:leading-6 placeholder:overflow-hidden placeholder:text-ellipsis"
                                                        placeholder="123456789" value="{{ old('phone') }}">
                                                </div>
                                            </div>
                                            @error('phone')
                                                <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Address --}}
                                    <div class="flex flex-col gap-[6px]">
                                        <label for="address" class="text-base font-normal text-[#3f3f46] leading-6">
                                            Address
                                        </label>
                                        <x-form-textarea id="address" name="address" :required="true"
                                            placeholder="Enter your full address" :value="old('address')" />
                                        @error('address')
                                            <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Zip Code, City, State --}}
                                    <div class="flex gap-3">
                                        <div class="flex flex-col gap-[6px] flex-1">
                                            <label for="postal_code" class="text-base font-normal text-[#3f3f46] leading-6">
                                                Zip Code
                                            </label>
                                            <x-form-input id="postal_code" name="postal_code" type="number"
                                                :required="true" placeholder="Postal code" :value="old('postal_code')" />
                                            @error('postal_code')
                                                <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="flex flex-col gap-[6px] flex-1">
                                            <label for="city" class="text-base font-normal text-[#3f3f46] leading-6">
                                                City
                                            </label>
                                            <x-form-input id="city" name="city" :required="true"
                                                placeholder="City" :value="old('city')" />
                                            @error('city')
                                                <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="flex flex-col gap-[6px] flex-1">
                                            <label for="state" class="text-base font-normal text-[#3f3f46] leading-6">
                                                State
                                            </label>
                                            <x-form-select id="state" name="state" :required="true">
                                                <option value="">Select state</option>
                                            </x-form-select>
                                            @error('state')
                                                <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Company Name (Optional) --}}
                                    <div class="flex flex-col gap-[6px]">
                                        <label for="company_name" class="text-base font-normal text-[#3f3f46] leading-6">
                                            Company Name (Optional)
                                        </label>
                                        <x-form-input id="company_name" name="company_name" placeholder="Company Name"
                                            :value="old('company_name')" />
                                        @error('company_name')
                                            <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Notes --}}
                                    <div class="flex flex-col gap-[6px]">
                                        <label for="notes" class="text-base font-normal text-[#3f3f46] leading-6">
                                            Notes
                                        </label>
                                        <x-form-textarea id="notes" name="notes"
                                            placeholder="Write your notes here" :value="old('notes')" />
                                        @error('notes')
                                            <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Driver's ID Details Section --}}
                            <div class="flex flex-col gap-6">
                                <span class="text-sm font-semibold text-[#6b6b74] leading-5 block">
                                    Driver's ID Details
                                </span>

                                {{-- Checkbox for different driver --}}
                                <div class="flex gap-[10px] items-start">
                                    <div class="flex items-start justify-center py-0.5 shrink-0">
                                        <input type="checkbox" id="different_driver" name="different_driver"
                                            class="w-5 h-5 border-2 border-[#e4e4e7] rounded-[5px] text-[#ec2028] focus:ring-2 focus:ring-[#ec2028] shadow-[0px_1px_3px_0px_rgba(0,0,0,0.07)]"
                                            value="1" {{ old('different_driver') ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex flex-col gap-1 flex-1">
                                        <label for="different_driver"
                                            class="text-base font-normal text-[#3f3f46] leading-6 cursor-pointer">
                                            I am not a driver for this vehicle. I am making this reservation for someone
                                            else.
                                        </label>
                                        <span class="text-sm text-[#6b6b74] leading-5 block">
                                            Check this if you are booking this vehicle for someone else.
                                        </span>
                                    </div>
                                </div>

                                {{-- Driver's IC/Passport Number --}}
                                <div class="flex flex-col gap-[6px]">
                                    <label for="driver_id_number" class="text-base font-normal text-[#3f3f46] leading-6">
                                        Driver's IC/Passport Number
                                    </label>
                                    <x-form-input id="driver_id_number" name="driver_id_number" :required="true"
                                        placeholder="Enter IC or Passport number" :value="old('driver_id_number')" />
                                    @error('driver_id_number')
                                        <span class="text-xs text-[#ec2028]">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Upload Documents --}}
                                <div class="flex flex-col gap-3">
                                    <span class="text-sm text-[#6b6b74] leading-5 block">
                                        Please upload the necessary documents
                                    </span>

                                    {{-- Upload IC/Passport --}}
                                    <div class="flex flex-col gap-4 p-4 border border-[#e4e4e7] rounded-lg bg-white">
                                        <div class="flex flex-wrap gap-3 items-center">
                                            <div class="flex flex-col gap-1 flex-1 min-w-[200px]">
                                                <span class="text-base font-medium text-[#18181b] leading-6 block">
                                                    Upload IC (Front& Back)/Passport Image
                                                </span>
                                                <div class="flex flex-col gap-1 text-sm text-[#6b6b74] leading-5">
                                                    <span class="block">File types: JPG, PNG & PDF</span>
                                                    <span class="block">Max file size: 25MB</span>
                                                </div>
                                            </div>
                                            <label for="ic_passport_upload"
                                                class="flex items-center justify-center gap-[6px] h-10 px-3 py-2 border border-[#e4e4e7] rounded-lg bg-white cursor-pointer hover:bg-gray-50 transition-colors shadow-[0px_1px_3px_0px_rgba(0,0,0,0.07)]">
                                                <svg class="w-5 h-5 text-[#3f3f46]" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 13.75V5M10 5L6.25 8.75M10 5L13.75 8.75"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M2.75 13.75V14.25C2.75 15.7688 3.98122 17 5.5 17H14.5C16.0188 17 17.25 15.7688 17.25 14.25V13.75"
                                                        stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                </svg>
                                                <span class="text-base font-medium text-[#3f3f46]">Upload</span>
                                            </label>
                                            <input type="file" id="ic_passport_upload" name="ic_passport[]"
                                                class="hidden" accept=".jpg,.jpeg,.png,.pdf" multiple>
                                        </div>

                                        {{-- Uploaded files preview --}}
                                        <div id="ic_passport_preview" class="flex flex-wrap gap-2">
                                            {{-- Files will be displayed here via JavaScript --}}
                                        </div>
                                    </div>

                                    {{-- Upload License --}}
                                    <div class="flex flex-col gap-4 p-4 border border-[#e4e4e7] rounded-lg bg-white">
                                        <div class="flex flex-wrap gap-3 items-center">
                                            <div class="flex flex-col gap-1 flex-1 min-w-[200px]">
                                                <span class="text-base font-medium text-[#18181b] leading-6 block">
                                                    Upload License Image
                                                </span>
                                                <div class="flex flex-col gap-1 text-sm text-[#6b6b74] leading-5">
                                                    <span class="block">File types: JPG, PNG & PDF</span>
                                                    <span class="block">Max file size: 25MB</span>
                                                </div>
                                            </div>
                                            <label for="license_upload"
                                                class="flex items-center justify-center gap-[6px] h-10 px-3 py-2 border border-[#e4e4e7] rounded-lg bg-white cursor-pointer hover:bg-gray-50 transition-colors shadow-[0px_1px_3px_0px_rgba(0,0,0,0.07)]">
                                                <svg class="w-5 h-5 text-[#3f3f46]" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 13.75V5M10 5L6.25 8.75M10 5L13.75 8.75"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M2.75 13.75V14.25C2.75 15.7688 3.98122 17 5.5 17H14.5C16.0188 17 17.25 15.7688 17.25 14.25V13.75"
                                                        stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                </svg>
                                                <span class="text-base font-medium text-[#3f3f46]">Upload</span>
                                            </label>
                                            <input type="file" id="license_upload" name="license[]" class="hidden"
                                                accept=".jpg,.jpeg,.png,.pdf" multiple>
                                        </div>

                                        {{-- Uploaded files preview --}}
                                        <div id="license_preview" class="flex flex-wrap gap-2">
                                            {{-- Files will be displayed here via JavaScript --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Terms & Conditions --}}
                            <div class="flex gap-[10px] items-start">
                                <div class="flex items-start justify-center py-0.5 shrink-0">
                                    <input type="checkbox" id="accept_terms" name="accept_terms" required
                                        class="w-5 h-5 border-2 border-[#ec2028] rounded-[5px] text-[#ec2028] focus:ring-2 focus:ring-[#ec2028] shadow-[0px_1px_3px_0px_rgba(0,0,0,0.07)] checked:bg-[#ec2028]"
                                        value="1" {{ old('accept_terms') ? 'checked' : '' }}>
                                </div>
                                <label for="accept_terms"
                                    class="text-base font-normal text-[#3f3f46] leading-6 cursor-pointer flex-1">
                                    It is essential that you understand the <a href="#"
                                        class="text-[#ec2028] underline hover:text-[#d11d24]">terms & conditions</a> before
                                    submitting your reservation. Please indicate acceptance by checking this box.
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Footer - Fixed at bottom --}}
        <div class="fixed bottom-0 left-0 right-0 w-full bg-white border-t border-[#e4e4e7] px-[150px] z-50">
            <div class="flex items-center mx-auto max-w-[1280px] h-[100px] gap-3">
                <img src="{{ $carDetails['image'] ?? asset('images/ara-logo.png') }}" alt="Car"
                    class="object-cover w-32 h-20">
                <div class="flex gap-2 items-center">
                    <img src="{{ $carDetails['brand_logo'] ?? asset('images/ara-logo.png') }}" alt="Brand"
                        class="object-cover w-6 h-6 rounded">
                    <span class="text-xl font-semibold text-[#18181b] leading-[30px]">
                        {{ $carDetails['name'] ?? 'Perodua Myvi 1.5H' }}
                    </span>
                </div>

                <div class="flex flex-1 gap-3 justify-end items-center">
                    <div class="flex gap-1 items-baseline">
                        <span class="text-sm font-medium text-[#18181b] leading-5">Total</span>
                        <span class="text-xl font-semibold text-right text-[#ff6a0c] leading-[30px] min-w-[101px]">
                            RM {{ number_format($carDetails['total_price'] ?? 436.0, 2) }}
                        </span>
                    </div>

                    <button type="submit" form="customer-info-form"
                        class="flex justify-center items-center h-8 px-[10px] py-[6px] gap-[6px] font-medium text-sm leading-5 text-white bg-[#ec2028] border border-[#ec2028] rounded-lg transition-colors hover:opacity-90"
                        style="box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                        Save & Continue
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- File Upload Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File upload handlers
            setupFileUpload('ic_passport_upload', 'ic_passport_preview');
            setupFileUpload('license_upload', 'license_preview');

            function setupFileUpload(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const dataTransfer = new DataTransfer();

                input.addEventListener('change', function(e) {
                    const files = Array.from(e.target.files);

                    files.forEach(file => {
                        if (file.size > 25 * 1024 * 1024) {
                            alert('File size must be less than 25MB');
                            return;
                        }

                        const validTypes = ['image/jpeg', 'image/jpg', 'image/png',
                            'application/pdf'
                        ];
                        if (!validTypes.includes(file.type)) {
                            alert('Only JPG, PNG & PDF files are allowed');
                            return;
                        }

                        dataTransfer.items.add(file);
                        addFilePreview(file, preview, dataTransfer, input);
                    });

                    input.files = dataTransfer.files;
                });
            }

            function addFilePreview(file, previewContainer, dataTransfer, input) {
                const fileItem = document.createElement('div');
                fileItem.className =
                    'flex items-center gap-2 p-2 border border-[#e4e4e7] rounded-lg bg-white w-[217px]';

                const thumbnail = document.createElement('div');
                thumbnail.className =
                    'flex items-center justify-center w-[38px] h-[38px] bg-[#f4f4f5] rounded overflow-hidden shrink-0';

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.className = 'w-full h-full object-cover';
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    thumbnail.appendChild(img);
                } else {
                    thumbnail.innerHTML = `
                        <svg class="w-5 h-5 text-[#6b6b74]" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 2C4.89543 2 4 2.89543 4 4V16C4 17.1046 4.89543 18 6 18H14C15.1046 18 16 17.1046 16 16V7L11 2H6Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M11 2V7H16" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    `;
                }

                const fileInfo = document.createElement('div');
                fileInfo.className = 'flex flex-col flex-1 min-w-0';

                const fileName = document.createElement('div');
                fileName.className = 'flex items-center text-sm text-[#18181b] leading-5';
                const nameParts = file.name.split('.');
                const extension = nameParts.pop();
                const baseName = nameParts.join('.');
                fileName.innerHTML = `
                    <span class="max-w-[85px] overflow-hidden text-ellipsis whitespace-nowrap">${baseName}</span>
                    <span>.${extension}</span>
                `;

                const fileSize = document.createElement('span');
                fileSize.className = 'text-xs text-[#6b6b74] leading-[18px] block';
                fileSize.textContent = formatFileSize(file.size);

                fileInfo.appendChild(fileName);
                fileInfo.appendChild(fileSize);

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className =
                    'flex items-center justify-center w-8 h-8 p-1.5 rounded-lg hover:bg-gray-100 transition-colors shrink-0';
                removeBtn.innerHTML = `
                    <svg class="w-4 h-4 text-[#4f4f4f]" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4L12 12M12 4L4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                `;
                removeBtn.title = 'Remove file';

                removeBtn.addEventListener('click', function() {
                    // Remove from DataTransfer
                    const files = Array.from(dataTransfer.files);
                    const index = files.indexOf(file);
                    if (index > -1) {
                        // Create new DataTransfer without this file
                        const newDataTransfer = new DataTransfer();
                        files.forEach((f, i) => {
                            if (i !== index) {
                                newDataTransfer.items.add(f);
                            }
                        });

                        // Update input files
                        input.files = newDataTransfer.files;

                        // Update the reference
                        for (let i = dataTransfer.items.length - 1; i >= 0; i--) {
                            dataTransfer.items.remove(i);
                        }
                        Array.from(newDataTransfer.files).forEach(f => {
                            dataTransfer.items.add(f);
                        });
                    }

                    fileItem.remove();
                });

                fileItem.appendChild(thumbnail);
                fileItem.appendChild(fileInfo);
                fileItem.appendChild(removeBtn);

                previewContainer.appendChild(fileItem);
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round((bytes / Math.pow(k, i)) * 10) / 10 + ' ' + sizes[i];
            }
        });

        // Country and State Management
        const countrySelect = document.getElementById('country');
        const stateSelect = document.getElementById('state');
        const countryCodeSelect = document.getElementById('country_code');

        // Load countries on page load
        loadCountries().then(() => {
            // Set initial phone country code after countries are loaded
            setTimeout(() => {
                const initialCountry = countrySelect.value;
                if (initialCountry) {
                    updatePhoneCountryCode(initialCountry);
                }
            }, 100);
        });

        // Handle country change
        countrySelect.addEventListener('change', function() {
            const countryCode = this.value;
            const selectedOption = this.querySelector(`option[value="${countryCode}"]`);
            const countryName = selectedOption ? selectedOption.textContent : '';

            if (countryCode && countryName) {
                // Show loading state
                stateSelect.innerHTML = '<option value="">Loading...</option>';
                stateSelect.disabled = true;

                loadStates(countryCode, countryName);
                // Update phone country code based on selected country
                updatePhoneCountryCode(countryCode);
            } else {
                // Clear states if no country selected
                stateSelect.innerHTML = '<option value="">Select state</option>';
                stateSelect.disabled = false;
            }
        });

        async function loadCountries() {
            try {
                const response = await fetch('/api/countries');
                const data = await response.json();

                // Clear existing options except the placeholder
                countrySelect.innerHTML = '<option value="">Select country</option>';

                // Get unique calling codes (1, 2, or 3 digits) and sort them
                const callingCodes = [...new Set(data.countries
                    .map(country => country.calling_code)
                    .filter(code => code && code.trim() !== '' && /^\+\d{1,2}$/.test(code))
                )].sort();

                // Populate country code dropdown
                const countryCodeSelect = document.getElementById('country_code');
                countryCodeSelect.innerHTML = '';

                callingCodes.forEach(code => {
                    const option = document.createElement('option');
                    option.value = code;
                    option.textContent = code;
                    countryCodeSelect.appendChild(option);
                });

                // Set default +60 for Malaysia
                const malaysiaOption = countryCodeSelect.querySelector('option[value="+60"]');
                if (malaysiaOption) {
                    malaysiaOption.selected = true;
                }

                // Add countries
                data.countries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.code;
                    option.textContent = country.name;
                    option.dataset.callingCode = country.calling_code;

                    // Set Malaysia as default if no old value
                    if (country.code === 'MY' && !'{{ old('country') }}') {
                        option.selected = true;
                        // Show loading state and load Malaysian states by default
                        stateSelect.innerHTML = '<option value="">Loading...</option>';
                        stateSelect.disabled = true;
                        loadStates('MY', 'Malaysia');
                    }

                    // Set old value if exists
                    if (country.code === '{{ old('country') }}') {
                        option.selected = true;
                        // Show loading state while loading states
                        stateSelect.innerHTML = '<option value="">Loading...</option>';
                        stateSelect.disabled = true;
                        loadStates(country.code, country.name);
                    }

                    countrySelect.appendChild(option);
                });

                return Promise.resolve();
            } catch (error) {
                console.error('Error loading countries:', error);
                // Fallback to basic countries
                loadFallbackCountries();
                return Promise.resolve();
            }
        }

        async function loadStates(countryCode, countryName) {
            try {
                const response = await fetch('/api/states/' + countryCode, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                // Re-enable the dropdown
                stateSelect.disabled = false;

                // Clear existing options
                stateSelect.innerHTML = '<option value="">Select state</option>';

                // Add states
                if (data.states && data.states.length > 0) {
                    data.states.forEach(state => {
                        const option = document.createElement('option');
                        option.value = state;
                        option.textContent = state;

                        // Set old value if exists
                        if (state === '{{ old('state') }}') {
                            option.selected = true;
                        }

                        stateSelect.appendChild(option);
                    });
                } else {
                    // No states available for this country
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No states available';
                    option.disabled = true;
                    stateSelect.appendChild(option);
                }
            } catch (error) {
                console.error('Error loading states:', error);

                // Re-enable the dropdown
                stateSelect.disabled = false;
                stateSelect.innerHTML = '<option value="">Select state</option>';

                // Add error option
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Error loading states';
                option.disabled = true;
                stateSelect.appendChild(option);
            }
        }

        function updatePhoneCountryCode(countryCode) {
            const selectedOption = countrySelect.querySelector(`option[value="${countryCode}"]`);
            if (selectedOption && selectedOption.dataset.callingCode) {
                // Update country code dropdown
                Array.from(countryCodeSelect.options).forEach(option => {
                    if (option.value === selectedOption.dataset.callingCode) {
                        option.selected = true;
                    }
                });
            }
        }

        function loadFallbackCountries() {
            const countries = [{
                    name: 'Malaysia',
                    code: 'MY',
                    calling_code: '+60'
                },
                {
                    name: 'Singapore',
                    code: 'SG',
                    calling_code: '+65'
                },
                {
                    name: 'Indonesia',
                    code: 'ID',
                    calling_code: '+62'
                },
                {
                    name: 'Thailand',
                    code: 'TH',
                    calling_code: '+66'
                },
                {
                    name: 'United States',
                    code: 'US',
                    calling_code: '+1'
                },
                {
                    name: 'United Kingdom',
                    code: 'GB',
                    calling_code: '+44'
                },
                {
                    name: 'India',
                    code: 'IN',
                    calling_code: '+91'
                },
                {
                    name: 'Australia',
                    code: 'AU',
                    calling_code: '+61'
                },
                {
                    name: 'Canada',
                    code: 'CA',
                    calling_code: '+1'
                },
                {
                    name: 'Germany',
                    code: 'DE',
                    calling_code: '+49'
                }
            ];

            // Get unique calling codes (1, 2, or 3 digits) and sort them
            const callingCodes = [...new Set(countries
                .map(country => country.calling_code)
                .filter(code => code && code.trim() !== '' && /^\+\d{1,3}$/.test(code))
            )].sort();

            // Populate country code dropdown
            const countryCodeSelect = document.getElementById('country_code');
            countryCodeSelect.innerHTML = '';

            callingCodes.forEach(code => {
                const option = document.createElement('option');
                option.value = code;
                option.textContent = code;
                countryCodeSelect.appendChild(option);
            });

            // Set default +60 for Malaysia
            const malaysiaOption = countryCodeSelect.querySelector('option[value="+60"]');
            if (malaysiaOption) {
                malaysiaOption.selected = true;
            }

            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.code;
                option.textContent = country.name;
                option.dataset.callingCode = country.calling_code;

                if (country.code === 'MY' && !'{{ old('country') }}') {
                    option.selected = true;
                    // Show loading state and load Malaysian states by default
                    stateSelect.innerHTML = '<option value="">Loading...</option>';
                    stateSelect.disabled = true;
                    loadStates('MY', 'Malaysia');
                }

                countrySelect.appendChild(option);
            });
        }
    </script>
@endsection
