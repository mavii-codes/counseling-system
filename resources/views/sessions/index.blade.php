@extends('layouts.app')

@section('title', 'Case sessions')
@section('heading', 'Sessions')
@section('subheading', $case->title)

@section('toolbar')
    <a href="{{ route('counseling-cases.sessions.create', $case) }}" class="btn-primary text-xs lg:text-sm">Log session</a>
    <a href="{{ route('counseling-cases.show', $case) }}" class="btn-secondary text-xs lg:text-sm">Back to case</a>
@endsection

@section('content')
    <div class="space-y-4">
        @foreach ($sessions as $session)
            <article class="panel p-5">
                <div class="flex flex-wrap justify-between gap-2">
                    <time class="text-sm font-semibold text-[var(--color-copper-dim)]">{{ $session->session_at->format('M j, Y g:i A') }}</time>
                    <a href="{{ route('counseling-cases.sessions.show', [$case, $session]) }}" class="text-xs text-[var(--color-copper-dim)] hover:underline">View</a>
                </div>
                <p class="mt-2 line-clamp-2 text-sm">{{ str(strip_tags($session->notes))->limit(180) }}</p>
            </article>
        @endforeach
    </div>
    <div class="mt-6">{{ $sessions->links() }}</div>
@endsection
