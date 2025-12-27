@props(['status' => '', 'size' => 'base'])

@php
    $statusConfig = [
        'Pending' => [
            'bg' => 'bg-[#FFF4E0]',
            'text' => 'text-[#FFB800]',
            'label' => 'Pending',
        ],
        'Confirmed' => [
            'bg' => 'bg-[#E8F5E8]',
            'text' => 'text-[#28A745]',
            'label' => 'Confirmed',
        ],
        'Completed' => [
            'bg' => 'bg-[#E3F2FD]',
            'text' => 'text-[#2196F3]',
            'label' => 'Completed',
        ],
        'Cancelled' => [
            'bg' => 'bg-[#FFEBEE]',
            'text' => 'text-[#F44336]',
            'label' => 'Cancelled',
        ],
        'Processing' => [
            'bg' => 'bg-[#F3EFFF]',
            'text' => 'text-[#A259FF]',
            'label' => 'Processing',
        ],
        'Processing on Branch' => [
            'bg' => 'bg-[#F3EFFF]',
            'text' => 'text-[#A259FF]',
            'label' => 'Processing',
        ],
        'Paid' => [
            'bg' => 'bg-[#E8F5E8]',
            'text' => 'text-[#28A745]',
            'label' => 'Paid',
        ],
        'Unpaid' => [
            'bg' => 'bg-[#FFEAEA]',
            'text' => 'text-[#EC2028]',
            'label' => 'Unpaid',
        ],
        'Overdue' => [
            'bg' => 'bg-[#FFF3E0]',
            'text' => 'text-[#FF9800]',
            'label' => 'Overdue',
        ],
    ];

    $config = $statusConfig[$status] ?? [
        'bg' => 'bg-gray-100',
        'text' => 'text-gray-600',
        'label' => $status,
    ];

    $sizeClasses = [
        'xs' => 'text-xs px-2 py-1',
        'sm' => 'text-sm px-2 py-1',
        'base' => 'text-base px-3 py-1',
        'lg' => 'text-lg px-4 py-2',
    ];
@endphp

<span
    class="rounded-lg font-normal whitespace-nowrap overflow-hidden text-ellipsis max-w-full {{ $config['bg'] }} {{ $config['text'] }} {{ $sizeClasses[$size] }}">
    {{ $config['label'] }}
</span>
