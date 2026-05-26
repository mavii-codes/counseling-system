<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=lora:500,600|plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="flex min-h-full">
        <aside class="sidebar-shell hidden lg:flex">
            <div class="care-blob -left-20 top-0 h-48 w-48 bg-pink-300"></div>
            <div class="care-blob bottom-20 -right-10 h-32 w-32 bg-violet-300"></div>
            <div class="relative flex flex-1 flex-col p-5">
                <a href="{{ route('dashboard') }}" class="mb-8 flex items-center gap-3 rounded-2xl p-2 transition hover:bg-[var(--color-care-teal-light)]">
                    <x-brand-mark />
                    <div>
                        <p class="font-display text-lg font-semibold leading-tight text-[var(--color-care-teal)]">{{ config('app.name') }}</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-care-muted)]">Counseling System</p>
                    </div>
                </a>

                <nav class="flex flex-1 flex-col gap-1.5">
                    <a href="{{ route('dashboard') }}" class="sidebar-link nav-dash {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : '' }}">
                        <span class="nav-icon nav-icon-dash"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></span>
                        Dashboard
                    </a>
                    <a href="{{ route('students.index') }}" class="sidebar-link nav-students {{ request()->routeIs('students.*') ? 'sidebar-link-active' : '' }}">
                        <span class="nav-icon nav-icon-students"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></span>
                        Students
                    </a>
                    <a href="{{ route('counseling-cases.index') }}" class="sidebar-link nav-cases {{ request()->routeIs('counseling-cases.*') && !request()->routeIs('counseling-cases.sessions.*') ? 'sidebar-link-active' : '' }}">
                        <span class="nav-icon nav-icon-cases"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></span>
                        Cases
                    </a>
                    <a href="{{ route('sessions.timeline') }}" class="sidebar-link nav-sessions {{ request()->routeIs('sessions.*') || request()->routeIs('counseling-cases.sessions.*') ? 'sidebar-link-active' : '' }}">
                        <span class="nav-icon nav-icon-sessions"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                        Sessions
                    </a>
                </nav>

                <div class="profile-card mt-6">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-pink-500 via-violet-500 to-sky-400 text-sm font-bold text-white shadow-md">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-[var(--color-care-ink)]">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-[var(--color-care-muted)]">Counselor</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout', absolute: false) }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn-ghost w-full justify-center text-xs">Sign out</button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <div class="flex gap-2 overflow-x-auto border-b border-[var(--color-care-border)] bg-white/70 px-4 py-3 backdrop-blur-md lg:hidden">
                <a href="{{ route('dashboard') }}" class="mobile-nav-pill {{ request()->routeIs('dashboard') ? 'mobile-nav-pill-active' : 'mobile-nav-pill-inactive' }}">Home</a>
                <a href="{{ route('students.index') }}" class="mobile-nav-pill {{ request()->routeIs('students.*') ? 'mobile-nav-pill-active' : 'mobile-nav-pill-inactive' }}">Students</a>
                <a href="{{ route('counseling-cases.index') }}" class="mobile-nav-pill {{ request()->routeIs('counseling-cases.*') && !request()->routeIs('counseling-cases.sessions.*') ? 'mobile-nav-pill-active' : 'mobile-nav-pill-inactive' }}">Cases</a>
                <a href="{{ route('sessions.timeline') }}" class="mobile-nav-pill {{ request()->routeIs('sessions.*') || request()->routeIs('counseling-cases.sessions.*') ? 'mobile-nav-pill-active' : 'mobile-nav-pill-inactive' }}">Sessions</a>
            </div>

            <header class="page-header mx-4 mt-4 lg:mx-8 lg:mt-6">
                <div class="relative flex flex-wrap items-center justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-care-teal-mid)]">{{ config('app.name') }}</p>
                        <h1 class="font-display text-xl font-semibold text-[var(--color-care-ink)] lg:text-2xl">@yield('heading')</h1>
                        @hasSection('subheading')
                            <p class="mt-1 text-sm text-[var(--color-care-muted)]">@yield('subheading')</p>
                        @endif
                    </div>
                    <div class="flex shrink-0 flex-wrap items-center gap-2">
                        @yield('toolbar')
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 py-6 lg:px-8 lg:py-8">
                @if (session('success'))
                    <div class="alert-success" role="alert">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-error" role="alert">
                        <p class="font-semibold">Please fix the following:</p>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
