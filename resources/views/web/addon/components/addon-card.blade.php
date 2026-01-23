{{-- Add-On Card Component --}}
@php
    $addon = $addon ?? [];
    $isQuantity = ($addon['type'] ?? 'checkbox') === 'quantity';
@endphp

<div class="flex gap-3 items-center p-3 bg-white" style="border-bottom: 1px solid #e4e4e7;" x-data="{ quantity: 0 }">

    {{-- Icon/Picture --}}
    <div class="flex overflow-hidden justify-center items-center shrink-0"
        style="width: 50px; height: 50px; background-color: #f4f4f5; border-radius: 8px;">
        @if (!empty($addon['picture']))
            <img src="{{ $addon['picture'] }}" alt="{{ $addon['name'] ?? 'Add-on' }}" class="object-cover w-full h-full">
        @else
            {{-- Fallback icon if no picture --}}
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="3" width="18" height="18" rx="2" stroke="#a1a1aa" stroke-width="1.5" />
                <circle cx="12" cy="12" r="3" stroke="#a1a1aa" stroke-width="1.5" />
            </svg>
        @endif
    </div>

    {{-- Content --}}
    <div class="flex flex-col flex-1 gap-1">
        <p class="text-base font-semibold" style="color: #18181b; line-height: 24px;">
            {{ $addon['name'] ?? 'Add-on Name' }}
        </p>
        <p class="text-sm font-normal" style="color: #6b6b74; line-height: 18px; white-space: pre-line;">
            {{ $addon['description'] ?? 'Description' }}
        </p>
    </div>

    {{-- Price --}}
    <div class="text-right shrink-0" style="min-width: 96px;">
        <div class="flex gap-1 justify-end items-baseline">
            <span class="text-base font-semibold" style="color: #18181b; line-height: 20px;">
                RM {{ number_format($addon['price'] ?? 0, 2) }}
            </span>
            <span class="text-sm font-normal" style="color: #6b6b74; line-height: 20px;">/day</span>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="shrink-0" style="min-width: 105px;">
        @if ($isQuantity)
            {{-- Quantity Controls --}}
            <div class="flex gap-2 items-center">
                {{-- Minus Button --}}
                <button @click="if(quantity > 0) quantity--"
                    class="flex justify-center items-center rounded-lg border transition-colors"
                    style="width: 32px; height: 32px; background-color: white; border-color: #e4e4e7; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);"
                    :disabled="quantity === 0">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M12.5 8H3.5" stroke="#ff9ea2" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </button>

                {{-- Quantity Display --}}
                <span class="text-base font-normal text-center"
                    style="color: #18181b; line-height: 24px; min-width: 25px;" x-text="quantity">
                    0
                </span>

                {{-- Plus Button --}}
                <button @click="quantity++"
                    class="flex justify-center items-center rounded-lg border transition-colors hover:opacity-90"
                    style="width: 32px; height: 32px; background-color: #ec2028; border-color: #ec2028; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M8 3.5V12.5M12.5 8H3.5" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
        @else
            {{-- Checkbox --}}
            <div class="flex justify-center">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" class="rounded border-2 transition-colors form-checkbox"
                        style="width: 20px; height: 20px; border-color: #e4e4e7; color: #ec2028;"
                        name="addon_{{ $addon['id'] ?? 0 }}">
                </label>
            </div>
        @endif
    </div>
</div>
