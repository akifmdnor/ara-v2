@props([
    'type' => 'text',
    'id' => '',
    'name' => '',
    'required' => false,
    'placeholder' => '',
    'value' => '',
])

<div class="relative">
    @if(isset($icon))
        <div class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#3f3f46] pointer-events-none">
            {{ $icon }}
        </div>
    @endif
    
    <input 
        type="{{ $type }}" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        class="flex h-10 items-center gap-2 self-stretch rounded-lg border border-[#e4e4e7] bg-white py-2 text-base font-light leading-6 focus:outline-none focus:ring-2 focus:ring-[#ec2028] focus:border-transparent shadow-[0px_1px_3px_0px_rgba(0,0,0,0.07)] w-full placeholder:text-[#6B6B74] placeholder:text-base placeholder:font-light placeholder:leading-6 placeholder:overflow-hidden placeholder:text-ellipsis {{ isset($icon) ? 'pl-10 pr-3' : 'px-3' }}"
        placeholder="{{ $placeholder }}" 
        value="{{ $value }}"
        {{ $attributes }}
    >
</div>
