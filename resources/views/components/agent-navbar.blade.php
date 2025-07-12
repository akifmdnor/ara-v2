@props(['user' => null])

<div class="flex relative h-screen bg-gray-100">
    <!-- Sidebar and overlay for mobile -->
    <div>
        <!-- Overlay for mobile -->
        <div id="sidebar-overlay"
            class="hidden fixed inset-0 z-20 bg-black bg-opacity-30 md:hidden">
        </div>
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-30 w-60 bg-[#EC2028] text-white flex flex-col items-center py-4 transform transition-transform duration-200 ease-in-out h-screen -translate-x-full md:translate-x-0 md:relative md:z-0 md:flex md:w-60 md:static md:inset-0 md:h-screen">
            <!-- Logo -->
            <div class="mb-4">
                <img src="/images/ara-logo.png" alt="ARA Logo"
                    class="object-contain w-16 h-16" />
            </div>
            <!-- Affiliates Button -->
            <button
                class="w-48 py-2 mb-6 rounded bg-white text-[#EC2028] font-bold text-lg shadow">
                AFFILIATES
            </button>
            <!-- Nav Links -->
            <nav class="flex-1 px-4 space-y-2 w-full">
                <a href="{{ route('agent.dashboard') }}"
                    class="flex items-center gap-2 py-2 px-3 rounded hover:bg-white hover:text-[#EC2028] font-semibold {{ request()->routeIs('agent.dashboard') ? 'bg-white text-[#EC2028]' : '' }}">
                    <!-- Material Design clipboard/assignment icon -->
                    <svg class="w-5 h-5 {{ request()->routeIs('agent.dashboard') ? 'fill-[#EC2028]' : 'fill-white' }}"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19 3h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm7 18H5V5h2v2h10V5h2v16z" />
                    </svg>
                    Dashboard
                </a>
                <a href="#"
                    class="flex items-center gap-2 py-2 px-3 rounded hover:bg-white hover:text-[#EC2028] font-semibold {{ request()->routeIs('agent.bookings') ? 'bg-white text-[#EC2028]' : '' }}">
                    <!-- Material Design event_available icon -->
                    <svg class="w-5 h-5 {{ request()->routeIs('agent.bookings') ? 'fill-[#EC2028]' : 'fill-white' }}"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.53 11.06l-4.24 4.24-2.12-2.12-1.06 1.06 3.18 3.18 5.3-5.3z" />
                        <path
                            d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H5V8h14v13z" />
                    </svg>
                    Bookings
                </a>
            </nav>
        </aside>
    </div>
    <!-- Main Content -->
    <main class="overflow-y-auto flex-1">
        <!-- Mobile Topbar -->
        <header
            class="flex items-center justify-between px-4 py-3 bg-[#EC2028] text-white md:hidden">
            <div class="flex gap-3 items-center">
                <button id="burger-btn" class="p-0 m-0 bg-transparent">
                    <img src="{{ asset('icons/hamburger.svg') }}" alt="Menu"
                        class="w-7 h-7" />
                </button>
                <img src="/ara-logo.png" alt="ARA Logo"
                    class="object-contain w-8 h-8" />
                <span class="ml-2 text-lg font-bold">Bookings</span>
            </div>
            <div class="flex gap-3 items-center">
                <img src="{{ $user && $user->profile_photo ? asset($user->profile_photo) : '/avatar.jpg' }}"
                    alt="Avatar"
                    class="object-cover w-8 h-8 rounded-full border-2 border-white" />
                <img src="{{ asset('icons/bell.svg') }}" alt="Notifications"
                    class="w-7 h-7" />
            </div>
        </header>
        <!-- Desktop Topbar -->
        <header
            class="hidden justify-between items-center px-6 py-4 text-gray-800 bg-white shadow md:flex">
            <div class="flex flex-col gap-1">
                <span class="text-base font-semibold">
                    Welcome back, {{ $user ? $user->full_name : 'Admin' }}!
                </span>
            </div>
            <div class="flex gap-4 items-center">
                <span class="text-lg font-semibold">Ara Car Rental - HQ</span>
                <button title="Notifications" class="bg-transparent">
                    <img src="{{ asset('icons/bell.svg') }}" alt="Notifications"
                        class="w-6 h-6 text-gray-400" />
                </button>
                <img src="{{ $user && $user->profile_photo ? asset($user->profile_photo) : asset('images/avatar.png') }}"
                    alt="Avatar"
                    class="object-cover w-8 h-8 rounded-full border-2 border-gray-200" />
            </div>
        </header>
        <div class="p-6">
            {{ $slot }}
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const burgerBtn = document.getElementById('burger-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        burgerBtn.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    });

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // You could add a toast notification here
            console.log('Copied to clipboard');
        });
    }
</script>
