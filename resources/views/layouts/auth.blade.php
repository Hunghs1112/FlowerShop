<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $siteSettings['site_name'] ?? config('app.name')) - {{ $siteSettings['site_name'] ?? config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    @include('partials.theme-head')
</head>
<body>
    @yield('content')

    @stack('scripts')
</body>
</html>
