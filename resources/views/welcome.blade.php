<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} Dashboard</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="antialiased">
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold mb-4">{{ config('app.name', 'Laravel') }}</h1>
        <p class="mb-6">Welcome to your wis2:</p>

        <ul class="space-y-2">
            <li><a href="{{ route('user.index') }}" class="text-blue-600 hover:underline">Users Module</a></li>
            <li><a href="{{ route('course.index') }}" class="text-blue-600 hover:underline">Courses Module</a></li>
            <li><a href="{{ route('term.index') }}" class="text-blue-600 hover:underline">Terms Module</a></li>
        </ul>
    </div>
</body>
</html>
