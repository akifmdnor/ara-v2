@props([
    'code',
    'branch',
    'amount' => null,
    'dateTime',
    'carModel' => null,
    'status',
    'image' => '/car.png',
    'showDate' => true,
])

<div
    class="flex items-center px-6 py-4 mx-auto w-full bg-white rounded-2xl shadow-md">
    <!-- Car image with red ellipse shadow -->
    <div class="relative flex-shrink-0">
        <div
            class="absolute -bottom-2 left-1/2 z-0 w-20 h-4 bg-red-100 rounded-full blur-sm -translate-x-1/2">
        </div>
        <img src="{{ $image }}"
            class="object-contain relative z-10 w-24 h-16" alt="Car Image" />
    </div>
    <!-- Info -->
    <div class="flex flex-col flex-1 justify-between ml-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="font-bold text-[#EC2028] text-lg">{{ $code }}
                </p>
            </div>
            @if ($showDate)
                <div
                    class="flex items-center space-x-1 text-xs font-medium text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Date & Time</span>
                    <span class="ml-2">{{ $dateTime }}</span>
                </div>
            @endif
        </div>
        <div class="flex mt-2 w-full">
            <!-- Branch -->
            <div class="flex-1">
                <div class="text-sm font-semibold text-gray-700">Branch</div>
                <div class="pr-1 text-sm text-gray-800">{{ $branch }}
                </div>
            </div>
            <!-- Amount -->
            <div class="flex-1">
                <div class="text-sm font-semibold text-gray-700">Amount (RM)
                </div>
                <div class="text-sm text-gray-800">{{ $amount }}</div>
            </div>
            <!-- Status -->
            <div class="flex flex-col flex-1 items-end">
                <div class="text-sm font-semibold text-gray-700">Booking Status
                </div>
                <span
                    class="mt-1 text-sm font-semibold px-4 py-1 rounded-lg bg-orange-50 text-orange-500 min-w-[90px] text-center">
                    {{ $status }}
                </span>
            </div>
        </div>
    </div>
</div>
