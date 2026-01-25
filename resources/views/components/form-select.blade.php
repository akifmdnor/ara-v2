@props([
    'id' => '',
    'name' => '',
    'required' => false,
])

<div class="relative">
    <select
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        class="flex h-10 items-center gap-2 self-stretch rounded-lg border border-[#e4e4e7] bg-white py-2 text-base font-light leading-6 focus:outline-none focus:ring-2 focus:ring-[#ec2028] focus:border-transparent shadow-[0px_1px_3px_0px_rgba(0,0,0,0.07)] w-full text-[#18181b] [&>option[value='']]:text-[#6B6B74] appearance-none {{ isset($icon) ? 'pl-10 pr-10' : 'px-3 pr-10' }}"
        {{ $attributes }}
    >
        {{ $slot }}
    </select>
    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M6.25293 7.5H13.8379C14.5061 7.5 14.8406 8.3078 14.3682 8.78027L10.5762 12.5732C10.2833 12.8661 9.80754 12.8661 9.51465 12.5732L5.72266 8.78027C5.27979 8.33741 5.54549 7.59949 6.13086 7.50879L6.25293 7.5Z" fill="#18181B" stroke="#6B6B74"/>
        </svg>
    </div>
</div>
