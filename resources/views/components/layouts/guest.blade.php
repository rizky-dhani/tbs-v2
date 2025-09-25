<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title . ' - ' . config('app.name') ?? 'Laravel' }}</title>

    <!-- Styles -->
    @vite('resources/css/app.css')
    {{-- Timeline --}}
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/regular.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/solid.min.css') }}">
</head>

<body class="min-h-screen bg-base-200">
    <main class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl">
            {{ $slot }}
        </div>
    </main>
</body>

</html>
