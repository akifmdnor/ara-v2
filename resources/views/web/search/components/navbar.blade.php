{{-- Search Page Navbar - Matches Figma Design --}}
<nav class="relative z-10 bg-white"
    style="box-shadow: 0px 2px 4px 0px rgba(51,65,85,0.08), 0px 6px 32px 0px rgba(51,65,85,0.12);">
    <div class="px-[277px]  mr-1 py-[3px]">
        <div class="flex justify-between items-center" style="height: 52px; ">
            {{-- Logo & Navigation --}}
            <div class="flex flex-1 gap-3 items-center">
                {{-- Logo --}}
                <a href="{{ route('web.index') }}" class="flex items-center" style="width: 126px;">
                    <img src="{{ asset('images/web/ara-logo-new.jpg') }}" alt="ARA Car Rental" class="w-auto h-full">
                </a>

                {{-- Navigation Links --}}
                <div class="flex items-center">
                    <a href="{{ route('web.index') }}" class="px-2.5 py-1.5 rounded-lg transition-colors"
                        style="color: #3f3f46; text-decoration: none; font-weight:400;">
                        Home
                    </a>
                    <a href="#" class="px-2.5 py-1.5 rounded-lg transition-colors hover:bg-gray-100"
                        style="color: #3f3f46; text-decoration: none; font-weight:400;">
                        Our Locations
                    </a>
                    <a href="{{ url('/contact-us') }}"
                        class="px-2.5 py-1.5 rounded-lg transition-colors hover:bg-gray-100"
                        style="color: #3f3f46; text-decoration: none; font-weight:400;">
                        Contact Us
                    </a>
                    <a href="{{ url('/about') }}"
                        class="px-2.5 py-1.5 rounded-lg transition-colors font-xs hover:bg-gray-100"
                        style="color: #3f3f46; text-decoration: none; font-weight:400;">
                        About Us
                    </a>
                </div>
            </div>

            {{-- Right side actions --}}
            <div class="flex gap-1 items-center">
                {{-- Dark mode toggle --}}
                <button class="p-1.5 rounded-lg transition-colors hover:bg-gray-100" style="height: 32px; width: 32px;">
                    <svg class="w-4 h-4" fill="none" stroke="#3f3f46" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                </button>

                {{-- Language selector --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex gap-1.5 items-center px-2.5 py-1.5 font-normal rounded-lg border transition-colors hover:bg-gray-50"
                        style="height: 32px; background-color: white; border-color: #e4e4e7; color: #18181b; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span>EN</span>
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 z-10 mt-2 w-48 bg-white rounded-lg border shadow-lg"
                        style="border-color: #e4e4e7;">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-50"
                                style="color: #3f3f46;">English</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-50" style="color: #3f3f46;">Bahasa
                                Malaysia</a>
                        </div>
                    </div>
                </div>

                {{-- Login button --}}
                <a href="#"
                    class="px-2.5 py-1.5 font-normal text-white rounded-lg border transition-colors hover:opacity-90"
                    style="height: 32px; background-color: #ec2028; border-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); text-decoration: none; font-weight:400;">
                    Log In
                </a>
            </div>
        </div>
    </div>
</nav>
