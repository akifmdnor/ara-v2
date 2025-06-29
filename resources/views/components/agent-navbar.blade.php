@props(['user' => null])

<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-60 bg-[#EC2028] text-white flex flex-col items-center py-4">
        <!-- Logo -->
        <div class="mb-4">
            <img src="/ara-logo.png" alt="ARA Logo" class="h-16 w-16 object-contain" />
        </div>
        <!-- Affiliates Button -->
        <button class="w-48 py-2 mb-6 rounded bg-white text-[#EC2028] font-bold text-lg shadow">
            AFFILIATES
        </button>
        <!-- Nav Links -->
        <nav class="flex-1 w-full px-4 space-y-2">
            <a href="{{ route('agent.dashboard') }}"
                class="flex items-center gap-2 py-2 px-3 rounded hover:bg-white hover:text-[#EC2028] font-semibold {{ request()->routeIs('agent.dashboard') ? 'bg-white text-[#EC2028]' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 0H7m6 0v6m0 0H7m6 0h6" />
                </svg>
                Dashboard
            </a>
            <a href="#"
                class="flex items-center gap-2 py-2 px-3 rounded hover:bg-white hover:text-[#EC2028] font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6" />
                </svg>
                Bookings
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Top Bar -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <div class="flex flex-col gap-1">
                <span class="text-base font-semibold text-gray-800">
                    Welcome back, {{ $user ? $user->name : 'Admin' }}!
                </span>
            </div>
            <div class="flex items-center gap-6">
                <span class="text-lg font-semibold text-gray-800">Ara Car Rental - HQ</span>
                <!-- Unique Code Box -->
                <div class="bg-gray-100 px-4 py-2 rounded flex items-center gap-2">
                    <span class="text-xs text-gray-500">Your Unique Code</span>
                    <span class="font-mono text-base font-bold text-[#4B5563]">A1B2C3D4</span>
                    <button title="Copy" onclick="copyToClipboard('A1B2C3D4')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16h8M8 12h8m-6 8h6a2 2 0 002-2V8a2 2 0 00-2-2h-2.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 0012.586 3H6a2 2 0 00-2 2v12a2 2 0 002 2h2" />
                        </svg>
                    </button>
                    <button title="Share">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 8a3 3 0 11-6 0 3 3 0 016 0zm6 8a6 6 0 00-12 0v1a2 2 0 002 2h8a2 2 0 002-2v-1z" />
                        </svg>
                    </button>
                </div>
                <!-- Bell Icon -->
                <button title="Notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
                <!-- Avatar -->
                <img src="/avatar.jpg" alt="Avatar" class="h-8 w-8 rounded-full border-2 border-gray-200" />
            </div>
        </header>
        <div class="p-6">
            {{ $slot }}
        </div>
    </main>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // You could add a toast notification here
            console.log('Copied to clipboard');
        });
    }
</script>
