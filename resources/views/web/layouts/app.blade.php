<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ARA Car Rental')</title>
    <meta name="description" content="@yield('description', 'ARA Car Rental Agent Portal')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS and Datepicker CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    @stack('styles')
    <style>
        /* Default text styling for web layout - using px to match Figma exactly */
        body {
            color: #3F3F46;
            font-family: Inter;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 24px;
        }

        /* Ensure all text elements inherit these defaults */
        * {
            color: inherit;
            font-family: inherit;
            font-size: inherit;
            font-weight: inherit;
            line-height: inherit;
        }

        /* Range slider thumb styling */
        input[type=range]::-webkit-slider-thumb {
            pointer-events: all;
            width: 24px;
            height: 24px;
            -webkit-appearance: none;
        }

        input[type=range]::-moz-range-thumb {
            pointer-events: all;
            width: 24px;
            height: 24px;
        }
    </style>
    @stack('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="@yield('body-class', 'bg-gray-100') font-['Inter'] text-sm">
    @yield('content')
    
    {{-- Global Modals --}}
    @include('web.components.actual-car-image-modal')
</body>

</html>
