{{-- Booking Stepper Component --}}
@php
    $currentStep = $currentStep ?? 2; // Default to step 2 (Choose add-ons)
    $steps = [
        [
            'number' => 1,
            'title' => 'Select Car',
            'icon' => 'car',
            'status' => $currentStep > 1 ? 'completed' : ($currentStep == 1 ? 'active' : 'inactive'),
        ],
        [
            'number' => 2,
            'title' => 'Choose add-ons',
            'icon' => 'add-on',
            'status' => $currentStep > 2 ? 'completed' : ($currentStep == 2 ? 'active' : 'inactive'),
        ],
        [
            'number' => 3,
            'title' => "Enter driver's info",
            'icon' => 'id-card',
            'status' => $currentStep > 3 ? 'completed' : ($currentStep == 3 ? 'active' : 'inactive'),
        ],
        [
            'number' => 4,
            'title' => 'Make payment',
            'icon' => 'money',
            'status' => $currentStep > 4 ? 'completed' : ($currentStep == 4 ? 'active' : 'inactive'),
        ],
    ];
@endphp

<div class="flex flex-col gap-3 justify-center items-start pb-4 m-auto">
    {{-- First Row: Step Indicators --}}
    <div class="flex gap-0 justify-center items-start m-auto w-full">
        @foreach ($steps as $index => $step)
            {{-- Step --}}
            <div class="flex flex-col flex-1 gap-4 items-center">
                {{-- Step Indicator --}}
                <div class="flex justify-center items-center w-full">

                    <div class="flex-1 h-0.5"
                        style="background-color: {{ $index - 1 === -1 ? '#fff' : ($steps[$index - 1]['status'] === 'completed' ? '#ec2028' : '#e4e4e7') }};">
                    </div>

                    {{-- Icon --}}
                    <div class="flex justify-center items-center shrink-0"
                        style="width: 44px; height: 44px; background-color: white; border: 1px solid #e4e4e7; border-radius: 8px; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); padding: 10px;">
                        @if ($step['icon'] === 'car')
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16"
                                fill="none">
                                <path
                                    d="M3 7L4.54415 2.36754C4.81638 1.55086 5.58066 1 6.44152 1H15.5585C16.4193 1 17.1836 1.55086 17.4558 2.36754L19 7"
                                    stroke="#18181B" stroke-width="2" stroke-linejoin="round" />
                                <path
                                    d="M21 5.5C20.042 5.5 19.387 6.46752 19.7428 7.35695L19.8847 7.71164C19.9609 7.90213 20 8.10541 20 8.31058V12H2V8.31058C2 8.10541 2.03915 7.90213 2.11535 7.71164L2.25722 7.35695C2.61299 6.46752 1.95795 5.5 1 5.5"
                                    stroke="#18181B" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M20 12H2V6H20V12ZM4 8C3.44772 8 3 8.44772 3 9C3 9.55228 3.44772 10 4 10H6C6.55228 10 7 9.55228 7 9C7 8.44772 6.55228 8 6 8H4ZM16 8C15.4477 8 15 8.44772 15 9C15 9.55228 15.4477 10 16 10H18C18.5523 10 19 9.55228 19 9C19 8.44772 18.5523 8 18 8H16Z"
                                    fill="#18181B" />
                                <path d="M3 13V14" stroke="#18181B" stroke-width="4" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M19 13V14" stroke="#18181B" stroke-width="4" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @elseif($step['icon'] === 'add-on')
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path
                                    d="M2.85 13.05C1.6902 13.05 0.75 12.4098 0.75 11.25V3.15C0.75 1.82452 1.82452 0.75 3.15 0.75H11.25C12.4098 0.75 13.35 1.6902 13.35 2.85M12.45 9.15V15.75M15.75 12.45H9.15M8.55 6.15H16.35C17.6755 6.15 18.75 7.22452 18.75 8.55V16.35C18.75 17.6755 17.6755 18.75 16.35 18.75H8.55C7.22452 18.75 6.15 17.6755 6.15 16.35V8.55C6.15 7.22452 7.22452 6.15 8.55 6.15Z"
                                    stroke="#18181B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @elseif($step['icon'] === 'id-card')
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="17" viewBox="0 0 22 17"
                                fill="none">
                                <path
                                    d="M19 0C20.6569 0 22 1.34315 22 3V14C22 15.6569 20.6569 17 19 17H3C1.34315 17 4.02666e-08 15.6569 0 14V3C0 1.34315 1.34315 4.83192e-08 3 0H19ZM13.667 10C12.1942 10 11 11.1942 11 12.667C11.0002 12.8508 11.1492 12.9998 11.333 13H19.667C19.8508 12.9998 19.9998 12.8508 20 12.667C20 11.1942 18.8058 10 17.333 10H13.667ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75H8C8.41421 12.75 8.75 12.4142 8.75 12C8.75 11.5858 8.41421 11.25 8 11.25H4ZM4 8.25C3.58579 8.25 3.25 8.58579 3.25 9C3.25 9.41421 3.58579 9.75 4 9.75H10C10.4142 9.75 10.75 9.41421 10.75 9C10.75 8.58579 10.4142 8.25 10 8.25H4ZM15.5 4C14.1193 4 13 5.11929 13 6.5C13 7.88071 14.1193 9 15.5 9C16.8807 9 18 7.88071 18 6.5C18 5.11929 16.8807 4 15.5 4ZM4 5.25C3.58579 5.25 3.25 5.58579 3.25 6C3.25 6.41421 3.58579 6.75 4 6.75H8C8.41421 6.75 8.75 6.41421 8.75 6C8.75 5.58579 8.41421 5.25 8 5.25H4Z"
                                    fill="#27272A" />
                            </svg>
                        @elseif($step['icon'] === 'money')
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M14.7008 8.0998H11.2508C10.1738 8.0998 9.30078 8.97285 9.30078 10.0498C9.30078 11.1268 10.1738 11.9998 11.2508 11.9998H12.7508C13.8278 11.9998 14.7008 12.8728 14.7008 13.9498C14.7008 15.0268 13.8278 15.8998 12.7508 15.8998H9.30078M12.0008 6.8998V7.4998M12.0008 16.4998V17.0998M20.7008 11.9998C20.7008 16.8047 16.8057 20.6998 12.0008 20.6998C7.1959 20.6998 3.30078 16.8047 3.30078 11.9998C3.30078 7.19493 7.1959 3.2998 12.0008 3.2998C16.8057 3.2998 20.7008 7.19493 20.7008 11.9998Z"
                                    stroke="#6B6B74" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @endif
                    </div>


                    <div class="flex-1 h-0.5"
                        style="background-color: {{ $index === count($steps) - 1 ? '#fff' : ($step['status'] === 'completed' ? '#ec2028' : '#e4e4e7') }};">
                    </div>

                </div>


            </div>
        @endforeach
    </div>

    {{-- Second Row: Step Content --}}
    <div class="flex gap-0 justify-center items-start w-full">
        @foreach ($steps as $index => $step)
            {{-- Step Content --}}
            <div class="flex flex-col gap-0.5 items-center px-4 w-1/4 text-center">
                <span class="text-base font-semibold leading-6"
                    style="color: {{ in_array($step['status'], ['completed', 'active']) ? '#18181b' : '#6b6b74' }}; font-family: 'Inter', sans-serif; overflow: hidden; text-overflow: ellipsis;">
                    {{ $step['title'] }}
                </span>

            </div>
        @endforeach
    </div>
</div>
