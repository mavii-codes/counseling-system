<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=lora:500,600|plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="relative flex min-h-full flex-col lg:flex-row">
        <div class="care-blob left-1/4 top-20 h-64 w-64 bg-pink-400 lg:left-auto lg:right-1/3"></div>
        <div class="care-blob bottom-10 right-1/4 h-48 w-48 bg-violet-300"></div>
        <div class="care-blob top-1/2 left-10 h-40 w-40 bg-sky-300"></div>

        <div class="relative flex flex-1 flex-col justify-center px-8 py-14 text-white lg:max-w-lg lg:px-14" style="background: linear-gradient(160deg, #db2777 0%, #a855f7 40%, #38bdf8 75%, #f472b6 100%);">
            <div class="relative z-10">
                <x-brand-mark size="lg" class="mb-6" />
                <p class="font-display text-3xl font-semibold leading-tight">{{ config('app.name') }}</p>
                <p class="mt-1 text-sm font-medium text-white/80">Student Counseling System</p>
                <p class="mt-6 max-w-sm text-sm leading-relaxed text-white/75">
                    A calm, secure space to support students — track cases, log sessions, and guide every step of their wellness journey.
                </p>
                <ul class="mt-10 space-y-3 text-sm text-white/70">
                    <li class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-violet-400/50">📚</span>
                        Academic & personal case categories
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-400/50">🕐</span>
                        Session history & scheduling
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-300/50">📋</span>
                        Confidential student records
                    </li>
                </ul>
            </div>
        </div>

        <div class="relative flex flex-1 items-center justify-center px-4 py-12 lg:px-14">
            <div class="w-full max-w-md">
                @if (session('warning'))
                    <div class="alert-warning" role="alert">{{ session('warning') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert-success" role="alert">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert-error">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
