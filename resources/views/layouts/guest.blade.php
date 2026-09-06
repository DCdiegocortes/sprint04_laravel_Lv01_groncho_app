<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|dm-mono:400,500" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-ink antialiased bg-paper">
        <div class="min-h-screen flex flex-col items-center sm:justify-center sm:py-10 sm:bg-ink/[0.03]">
            <div class="w-full min-h-screen sm:min-h-0 sm:w-[420px] sm:rounded-3xl sm:shadow-neu-card bg-paper flex flex-col overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
