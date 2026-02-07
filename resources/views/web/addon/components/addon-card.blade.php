{{-- Add-On Card Component --}}
@php
    $addon = $addon ?? [];
@endphp

<div class="flex gap-3 items-center px-6 py-4 bg-white rounded-lg border border-[#e4e4e7]">

    {{-- Icon/Picture --}}
    <div class="flex overflow-hidden justify-center items-center shrink-0"
        style="width: 50px; height: 50px; background-color: #f4f4f5; border-radius: 8px;">
        @if (!empty($addon['picture']))
            <img src="{{ $addon['picture'] }}" alt="{{ $addon['name'] ?? 'Add-on' }}"
                class="object-cover w-full h-full rounded-lg">
        @else
            {{-- Fallback icon if no picture --}}
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="3" width="18" height="18" rx="2" stroke="#a1a1aa" stroke-width="1.5" />
                <circle cx="12" cy="12" r="3" stroke="#a1a1aa" stroke-width="1.5" />
            </svg>
        @endif
    </div>

    {{-- Content --}}
    <div class="flex flex-col flex-1 gap-0.5" style="min-width: 0;">
        <span class="text-base font-semibold" style="color: #18181b; line-height: 24px;">
            {{ $addon['name'] ?? 'Add-on Name' }}
        </span>
        <span class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">
            {!! $addon['description'] ?? 'Description' !!}
        </span>
    </div>

    {{-- Price --}}
    <div class="text-right shrink-0">
        <div class="flex gap-1 justify-end items-baseline whitespace-nowrap">
            <span class="text-base font-semibold" style="color: #18181b; line-height: 24px;">
                RM {{ number_format($addon['price'] ?? 0, 2) }}
            </span>
            <span class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">/day</span>
        </div>
    </div>

    {{-- Input (Checkbox or Quantity) --}}
    <div class="flex justify-end items-center shrink-0">
        @if(($addon['type'] ?? 'checkbox') === 'quantity')
            <div class="flex items-center gap-2">
                <button type="button" class="quantity-btn flex justify-center items-center w-6 h-6 rounded border border-[#e4e4e7] text-[#6b6b74] hover:border-[#ec2028] hover:text-[#ec2028] transition-colors"
                    data-action="decrease" data-addon-id="{{ $addon['id'] ?? 0 }}">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M2 6H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </button>
                <input type="number" min="0" value="0" class="quantity-input w-12 h-8 text-center border border-[#e4e4e7] rounded text-sm font-medium"
                    name="addons[{{ $addon['id'] ?? 0 }}]" data-addon-id="{{ $addon['id'] ?? 0 }}">
                <button type="button" class="quantity-btn flex justify-center items-center w-6 h-6 rounded border border-[#e4e4e7] text-[#6b6b74] hover:border-[#ec2028] hover:text-[#ec2028] transition-colors"
                    data-action="increase" data-addon-id="{{ $addon['id'] ?? 0 }}">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M6 2V10M2 6H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
        @else
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" value="1" class="addon-checkbox rounded border-2 transition-colors cursor-pointer"
                    style="width: 20px; height: 20px; border-color: #e4e4e7; color: #ec2028; accent-color: #ec2028;"
                    name="addons[{{ $addon['id'] ?? 0 }}]" data-addon-id="{{ $addon['id'] ?? 0 }}">
            </label>
        @endif
    </div>
</div>
