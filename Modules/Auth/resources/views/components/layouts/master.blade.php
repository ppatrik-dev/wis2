<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Auth Module - {{ config('app.name', 'Laravel') }}</title>

        <meta name="description" content="{{ $description ?? '' }}">
        <meta name="keywords" content="{{ $keywords ?? '' }}">
        <meta name="author" content="{{ $author ?? '' }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite('resources/css/app.css')
    </head>
 <body class="bg-white dark:bg-gray-900">
    <!-- Nadpis s logo -->
    <div class="pt-8 text-center">
        <div class="flex items-center justify-center gap-3 mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="WIS2 Logo" class="w-16 h-16">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">WIS2</h1>
        </div>
    </div>

    <div class="flex items-center justify-center min-h-screen -mt-20">
        {{ $slot }}
    </div>
</body>

</html>
