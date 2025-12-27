<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-[#0d0015] text-white">
        <div class="min-h-screen">
            {{ $slot }}
        </div>

        <!-- Global Toast Notifications -->
        <div
            x-data="{ show: false, message: '', type: 'info', timeout: null }"
            x-on:success.window="
                clearTimeout(timeout);
                show = true; 
                message = ($event.detail && typeof $event.detail === 'object' && $event.detail.message) ? $event.detail.message : $event.detail; 
                type = 'success'; 
                timeout = setTimeout(() => show = false, 3000);
            "
            x-on:error.window="
                clearTimeout(timeout);
                show = true; 
                message = ($event.detail && typeof $event.detail === 'object' && $event.detail.message) ? $event.detail.message : $event.detail; 
                type = 'error'; 
                timeout = setTimeout(() => show = false, 3000);
            "
            x-on:info.window="
                clearTimeout(timeout);
                show = true; 
                message = ($event.detail && typeof $event.detail === 'object' && $event.detail.message) ? $event.detail.message : $event.detail; 
                type = 'info'; 
                timeout = setTimeout(() => show = false, 3000);
            "
            x-show="show"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            class="fixed bottom-4 right-4 px-6 py-4 rounded-lg shadow-lg text-white font-mono text-sm z-50 flex items-center gap-2"
            :class="{
                'bg-green-600': type === 'success',
                'bg-red-600': type === 'error',
                'bg-blue-600': type === 'info'
            }"
        >
            <span x-text="message"></span>
        </div>

        @livewire('auth-modal')
        @livewireScripts
    </body>
</html>
