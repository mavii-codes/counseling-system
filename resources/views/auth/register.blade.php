@extends('layouts.guest')

@section('title', 'Create account')

@section('content')
    <div class="panel p-8">
        <h2 class="font-display text-2xl font-semibold bg-gradient-to-r from-pink-600 via-violet-600 to-sky-500 bg-clip-text text-transparent">Join {{ config('app.name') }}</h2>
        <p class="mt-1 text-sm text-[var(--color-care-muted)]">Register as a counselor to manage student wellness records</p>

        <form method="POST" action="{{ route('register.store', absolute: false) }}" class="mt-8 space-y-5">
            @csrf
            <div>
                <label class="label" for="name">Full name</label>
                <input class="input" type="text" name="name" id="name" value="{{ old('name') }}" required autocomplete="name" autofocus maxlength="255">
            </div>
            <div>
                <label class="label" for="email">Email</label>
                <input class="input" type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" maxlength="255">
            </div>
            <div>
                <label class="label" for="password">Password</label>
                <input class="input" type="password" name="password" id="password" required autocomplete="new-password">
            </div>
            <div>
                <label class="label" for="password_confirmation">Confirm password</label>
                <input class="input" type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn-primary w-full">Create account</button>
        </form>
        <p class="mt-6 text-center text-sm text-[var(--color-care-muted)]">
            Already registered?
            <a href="{{ route('login') }}" class="font-bold text-[var(--color-care-teal)] hover:underline">Sign in</a>
        </p>
    </div>
@endsection
