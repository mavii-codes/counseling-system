@extends('layouts.app')

@section('title', 'Session history')
@section('heading', 'Session history')
@section('subheading', 'Chronological log across all cases.')

@section('toolbar')
    <a href="{{ route('counseling-cases.index') }}" class="btn-secondary text-xs lg:text-sm">Browse cases</a>
@endsection

@section('content')
    <form method="GET" class="panel mb-6 flex flex-wrap items-end gap-4 p-4">
        <div class="min-w-[180px] flex-1">
            <label class="label" for="q">Search notes</label>
            <input class="input" type="search" name="q" id="q" value="{{ request('q') }}" placeholder="Notes, title, student…">
        </div>
        <div class="w-full sm:w-48">
            <label class="label" for="case_id">Case ID</label>
            <input class="input" type="number" name="case_id" id="case_id" value="{{ request('case_id') }}" placeholder="Filter by ID">
        </div>
        <button type="submit" class="btn-primary">Filter</button>
        @if (request()->filled('q') || request()->filled('case_id'))
            <a href="{{ route('sessions.timeline') }}" class="btn-ghost">Clear</a>
        @endif
    </form>

    <div class="space-y-4">
        @forelse ($sessions as $session)
            <article class="panel p-5">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="font-display text-sm font-semibold text-[var(--color-deep)]">{{ $session->counselingCase->title }}</p>
                        <p class="text-xs text-[var(--color-ink)]/55">{{ $session->counselingCase->student->name }} · Case #{{ $session->counseling_case_id }}</p>
                    </div>
                    <time class="text-xs font-medium text-[var(--color-copper-dim)]">{{ $session->session_at->format('M j, Y g:i A') }}</time>
                </div>
                <p class="mt-4 line-clamp-3 text-sm text-[var(--color-ink)]/80 whitespace-pre-wrap">{{ $session->notes }}</p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('counseling-cases.sessions.show', [$session->counselingCase, $session]) }}" class="text-xs font-medium text-[var(--color-copper-dim)] hover:underline">View full</a>
                    <a href="{{ route('counseling-cases.show', $session->counselingCase) }}" class="text-xs text-[var(--color-ink)]/50 hover:underline">Go to case</a>
                </div>
            </article>
        @empty
            <div class="panel p-12 text-center text-[var(--color-ink)]/50">No sessions found.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $sessions->links() }}</div>
@endsection
