@props(['user' => null, 'headerText' => null])

<div class="flex relative h-screen bg-gray-100">
    <!-- Sidebar and overlay for mobile -->
    <div>
        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="hidden fixed inset-0 z-20 bg-black bg-opacity-30 md:hidden">
        </div>
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-30 w-60 bg-[#EC2028] text-white flex flex-col items-center py-4 transform transition-transform duration-200
            ease-in-out h-screen -translate-x-full md:translate-x-0 md:relative md:z-0 md:flex md:w-60 md:inset-0 md:h-screen">
            <!-- Logo -->
            <div class="mb-4">
                <a href="/agent/dashboard">
                    <img src="{{ asset('/images/ara-logo.png') }}" alt="ARA Logo" class="h-12">
                </a>
            </div>
            <!-- Affiliates Button -->
            <button class="w-48 py-2 mb-6 rounded bg-white text-[#EC2028] font-bold text-lg shadow">
                AFFILIATES
            </button>
            <!-- Nav Links -->
            <nav class="flex flex-col gap-2 px-4 w-full">
                <a href="{{ route('agent.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                    {{ request()->routeIs('agent.dashboard') ? 'bg-white text-[#EC2028] font-bold' : 'hover:bg-[#d91b23] text-white' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('agent.bookings.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                    {{ request()->routeIs('agent.bookings.index') ? 'bg-white text-[#EC2028] font-bold' : 'hover:bg-[#d91b23] text-white' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Bookings
                </a>
            </nav>
        </aside>
    </div>
    <!-- Main Content -->
    <main class="overflow-y-auto flex-1 md:m-5 md:rounded-lg">
        <!-- Mobile Topbar -->
        <header class="flex items-center justify-between px-4 py-5 bg-[#EC2028] text-white md:hidden">
            <div class="flex gap-3 items-center">
                <button id="burger-btn" class="p-0 m-0 bg-transparent">
                    <img src="{{ asset('icons/hamburger.svg') }}" alt="Menu" class="w-7 h-7" />
                </button>
                <img src="{{ asset('/images/ara-logo.png') }}" alt="ARA Logo" class="object-contain w-8 h-8" />
                <span class="ml-2 text-lg font-bold">Bookings</span>
            </div>
            <div class="flex gap-3 items-center">
                <img src="{{ $user ? $user->profile_photo_url : asset('images/avatar.png') }}" alt="Avatar"
                    class="object-cover w-8 h-8 rounded-full border-2 border-white" />
                <button title="Notifications" class="bg-transparent">
                    <svg class="w-6 h-6 text-gray-400 md:stroke-black" viewBox="0 0 24 24" fill="none"
                        stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 22c1.1 0 2-.9 2-2h-4a2 2 0 0 0 2 2zm6-6V11c0-3.07-1.63-5.64-4.5-6.32V4a1.5 1.5 0 0 0-3 0v.68C7.63 5.36 6 7.92 6 11v5l-1.29 1.29A1 1 0 0 0 6 20h12a1 1 0 0 0 .71-1.71L18 16z" />
                    </svg>
                </button>
            </div>
        </header>
        <!-- Desktop Topbar -->
        <header class="hidden justify-between items-center px-6 py-4 text-gray-800 bg-white shadow md:flex">
            <div class="flex flex-col gap-1">
                <span class="text-base font-semibold">
                    {{ $headerText ?? 'Welcome back, ' . ($user ? $user->full_name : 'Agent') . '!' }}
                </span>
            </div>
            <div class="flex gap-4 items-center">
                <span class="text-base font-semibold">{{ $user ? $user->full_name : 'Unknown' }}</span>
                <button title="Notifications" class="bg-transparent">
                    <svg class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 22c1.1 0 2-.9 2-2h-4a2 2 0 0 0 2 2zm6-6V11c0-3.07-1.63-5.64-4.5-6.32V4a1.5 1.5 0 0 0-3 0v.68C7.63 5.36 6 7.92 6 11v5l-1.29 1.29A1 1 0 0 0 6 20h12a1 1 0 0 0 .71-1.71L18 16z" />
                    </svg>
                </button>
                <img src="{{ $user ? $user->profile_photo_url : asset('images/avatar.png') }}" alt="Avatar"
                    class="object-cover w-8 h-8 rounded-full border-2 border-gray-200" />
            </div>
        </header>
        <div class="p-2 pt-5">
            {{ $slot }}
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded',
        function() {
            const burgerBtn = document
                .getElementById('burger-btn');
            const sidebar = document
                .getElementById('sidebar');
            const overlay = document
                .getElementById(
                    'sidebar-overlay');

            burgerBtn.addEventListener(
                'click',
                function() {
                    sidebar.classList
                        .toggle(
                            '-translate-x-full'
                        );
                    overlay.classList
                        .toggle('hidden');
                });

            overlay.addEventListener('click',
                function() {
                    sidebar.classList.add(
                        '-translate-x-full'
                    );
                    overlay.classList.add(
                        'hidden');
                });
        });

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(
            function() {
                // You could add a toast notification here
                console.log(
                    'Copied to clipboard');
            });
    }
</script>
