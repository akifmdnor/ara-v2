@props([
    'id' => '',
    'name' => '',
    'required' => false,
    'placeholder' => '',
    'value' => '',
    'rows' => 4,
])

<textarea 
    id="{{ $id }}" 
    name="{{ $name }}" 
    {{ $required ? 'required' : '' }}
    rows="{{ $rows }}"
    class="flex min-h-[120px] items-start gap-2 self-stretch rounded-lg border border-[#e4e4e7] bg-white px-3 py-3 text-base font-light leading-6 focus:outline-none focus:ring-2 focus:ring-[#ec2028] focus:border-transparent resize-none shadow-[0px_1px_3px_0px_rgba(0,0,0,0.07)] w-full placeholder:text-[#6B6B74] placeholder:text-base placeholder:font-light placeholder:leading-6 placeholder:overflow-hidden placeholder:text-ellipsis"
    placeholder="{{ $placeholder }}"
    {{ $attributes }}
>{{ $value }}</textarea>
