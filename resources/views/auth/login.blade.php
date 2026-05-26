@extends('layouts.guest')

@section('title', 'Sign in')

@section('content')
    <div class="mb-6 lg:hidden">
        <x-brand-mark />
        <p class="mt-3 font-display text-2xl font-semibold text-[var(--color-care-teal)]">{{ config('app.name') }}</p>
    </div>

    <div class="panel p-8">
        <h2 class="font-display text-2xl font-semibold bg-gradient-to-r from-pink-600 via-violet-600 to-sky-500 bg-clip-text text-transparent">Welcome back</h2>
        <p class="mt-1 text-sm text-[var(--color-care-muted)]">Sign in to your counselor dashboard</p>

        <form method="POST" action="{{ route('login.store', absolute: false) }}" class="mt-8 space-y-5">
            @csrf
            <div>
                <label class="label" for="email">Email address</label>
                <input class="input" type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="username" autofocus placeholder="e.g. example@gmail.com">
            </div>
            <div>
                <label class="label" for="password">Password</label>
                <input class="input" type="password" name="password" id="password" required autocomplete="current-password" placeholder="••••••••">
            </div>
            <label class="flex items-center gap-2 text-sm text-[var(--color-care-muted)]">
                <input type="checkbox" name="remember" value="1" class="rounded border-[var(--color-care-border)] text-[var(--color-care-teal)] focus:ring-[var(--color-care-teal-light)]">
                Keep me signed in
            </label>
            <button type="submit" class="btn-primary w-full">Sign in to dashboard</button>
        </form>
        <p class="mt-6 text-center text-sm text-[var(--color-care-muted)]">
            New counselor?
            <a href="{{ route('register') }}" class="font-bold text-[var(--color-care-teal)] hover:underline">Create an account</a>
        </p>
    </div>
@endsection
