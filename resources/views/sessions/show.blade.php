@extends('layouts.app')

@section('title', 'Session detail')
@section('heading', 'Session')
@section('subheading', $case->title)

@section('toolbar')
    <a href="{{ route('counseling-cases.sessions.edit', [$case, $session]) }}" class="btn-secondary text-xs lg:text-sm">Edit</a>
    <a href="{{ route('counseling-cases.show', $case) }}" class="btn-primary text-xs lg:text-sm">Back to case</a>
@endsection

@section('content')
    <article class="panel mx-auto max-w-2xl space-y-6 p-8">
        <header>
            <time class="text-lg font-semibold text-[var(--color-copper-dim)]">{{ $session->session_at->format('l, F j, Y — g:i A') }}</time>
            <p class="mt-1 text-sm text-[var(--color-ink)]/55">Duration: {{ $session->duration_minutes }} minutes</p>
        </header>
        <div>
            <h2 class="text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/45">Notes</h2>
            <p class="mt-2 whitespace-pre-wrap text-sm leading-relaxed text-[var(--color-ink)]/85">{{ $session->notes }}</p>
        </div>
        @if ($session->next_steps)
            <div class="rounded-xl border border-dashed border-[var(--color-copper)]/40 bg-amber-50/50 px-4 py-3">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-[var(--color-copper-dim)]">Next steps</h2>
                <p class="mt-2 whitespace-pre-wrap text-sm">{{ $session->next_steps }}</p>
            </div>
        @endif
    </article>
@endsection
