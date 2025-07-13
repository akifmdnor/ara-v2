@props(['label', 'value', 'percent', 'isNegative' => false, 'unit' => ''])
<div class="flex flex-col p-1 bg-white max-h-[100px]">
    <div class="text-xs leading-tight text-gray-500">{{ $label }}</div>
    <div class="flex justify-between items-end pt-2 mt-auto">
        <div class="text-base font-bold">
            {{ $value }}
            @if ($unit && !str_starts_with($value, $unit))
                <span class="text-base font-normal">{{ $unit }}</span>
            @endif
        </div>
        <div class="flex gap-1 items-center text-xs font-semibold {{ $isNegative ? 'text-red-500' : 'text-green-500' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                @if ($isNegative)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 15l-7 7-7-7" />
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                @endif
            </svg>
            {{ $percent }}
        </div>
    </div>
</div>
