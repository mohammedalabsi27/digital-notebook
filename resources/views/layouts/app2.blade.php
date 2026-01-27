<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
    <title>{{ config('app.name', 'دفتر المحل') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

    <div class="app-layout">
        @include('partials.navigation')

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    
</body>
</html>