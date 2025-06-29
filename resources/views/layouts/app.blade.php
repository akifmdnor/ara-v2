<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ARA Car Rental')</title>
    <meta name="description" content="@yield('description', 'ARA Car Rental Agent Portal')">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body class="@yield('body-class', 'bg-gray-100')">
    @yield('content')

    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
