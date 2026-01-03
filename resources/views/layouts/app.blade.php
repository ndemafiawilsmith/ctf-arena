<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <title>{{ $title ?? 'Dashboard' }} - CTF Arena | Nigeria's Premier Cybersecurity Platform</title>
    <meta name="description" content="{{ $metaDescription ?? 'Access your CTF Arena dashboard. Track your progress, join cybersecurity competitions, and compete with Africa\'s top hackers.' }}">
    <meta name="keywords" content="CTF dashboard, Capture The Flag Nigeria, cybersecurity challenges Africa, hacking competition, Nigerian hackers, ethical hacking platform">
    <meta name="robots" content="noindex, nofollow">
    <link rel="canonical" href="https://ctf.cyberwilsmith.com.ng{{ request()->getPathInfo() }}">

    {{-- Geo Tags --}}
    <meta name="geo.region" content="NG">
    <meta name="geo.placename" content="Nigeria">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://ctf.cyberwilsmith.com.ng{{ request()->getPathInfo() }}">
    <meta property="og:title" content="{{ $title ?? 'Dashboard' }} - CTF Arena">
    <meta property="og:description" content="Africa's premier Capture The Flag cybersecurity competition platform">
    <meta property="og:image" content="https://ctf.cyberwilsmith.com.ng/images/og-image.png">
    <meta property="og:site_name" content="CTF Arena">

    {{-- Theme Color --}}
    <meta name="theme-color" content="#0d0015">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans text-gray-100 antialiased">
    <div class="min-h-screen bg-[#0d0015]">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @livewire('auth-modal')
    @livewireScripts
</body>

</html>