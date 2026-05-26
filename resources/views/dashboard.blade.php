@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Wellness overview')
@section('subheading', 'Your colorful caseload snapshot — cases, categories, and sessions.')

@section('toolbar')
    <a href="{{ route('counseling-cases.create') }}" class="btn-primary text-xs lg:text-sm">+ New case</a>
@endsection

@section('content')
@php
    $academic = $categoryCounts[\App\Models\CounselingCase::CATEGORY_ACADEMIC] ?? 0;
    $personal = $categoryCounts[\App\Models\CounselingCase::CATEGORY_PERSONAL] ?? 0;
    $maxCat = max(1, $academic + $personal);
    $statusStyles = [
        'open' => 'stat-card-open',
        'active' => 'stat-card-active',
        'resolved' => 'stat-card-resolved',
        'closed' => 'stat-card-closed',
    ];
@endphp

<div class="grid gap-6 lg:grid-cols-12">
    <div class="panel-hero relative lg:col-span-4">
        <div class="relative z-10">
            <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-white/90">
                <span class="rounded-lg bg-white/20 px-2 py-0.5">✨</span>
                Total cases
            </p>
            <p class="mt-3 font-display text-6xl font-semibold drop-shadow-sm">{{ $totalCases }}</p>
            <p class="mt-2 text-sm text-white/85">Active counseling files</p>
            <div class="mt-8 space-y-4">
                <div>
                    <div class="flex justify-between text-xs font-bold text-white/90">
                        <span class="flex items-center gap-1.5"><span class="rounded bg-violet-400/40 px-1.5">📚</span> Academic</span>
                        <span>{{ $academic }}</span>
                    </div>
                    <div class="stat-bar mt-2">
                        <div class="stat-bar-fill-academic" style="width: {{ ($academic / $maxCat) * 100 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs font-bold text-white/90">
                        <span class="flex items-center gap-1.5"><span class="rounded bg-pink-400/40 px-1.5">💗</span> Personal</span>
                        <span>{{ $personal }}</span>
                    </div>
                    <div class="stat-bar mt-2">
                        <div class="stat-bar-fill-personal" style="width: {{ ($personal / $maxCat) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel p-6 lg:col-span-8">
        <div class="flex items-center gap-3">
            <span class="icon-badge icon-badge-status">📊</span>
            <div>
                <h2 class="font-display text-lg font-semibold text-violet-700">Case status</h2>
                <p class="text-sm text-[var(--color-care-muted)]">Each stage in a different color</p>
            </div>
        </div>
        <div class="mt-6 grid gap-3 sm:grid-cols-2">
            @foreach (\App\Models\CounselingCase::statuses() as $key => $label)
                <div class="stat-card {{ $statusStyles[$key] ?? 'stat-card-open' }}">
                    <p class="stat-card-label">{{ $label }}</p>
                    <p class="stat-card-num">{{ $statusCounts[$key] ?? 0 }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="panel p-5 sm:p-6 lg:col-span-12 xl:col-span-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <span class="icon-badge icon-badge-calendar">📅</span>
                <div>
                    <h2 class="font-display text-lg font-semibold text-pink-600 sm:text-xl">Upcoming sessions</h2>
                    <p class="text-xs text-[var(--color-care-muted)]">Next 14 days · {{ $upcomingSessions->count() }} scheduled</p>
                </div>
            </div>
        </div>

        <ul class="upcoming-sessions-grid">
            @forelse ($upcomingSessions as $index => $s)
                @php $accent = $index % 4; @endphp
                <li class="session-card upcoming-session-card session-card-accent-{{ $accent }}">
                    <div class="min-w-0 flex-1">
                        <p class="break-words font-semibold leading-snug text-[var(--color-care-ink)] sm:truncate">{{ $s->counselingCase->student->name }}</p>
                        <p class="mt-1 line-clamp-2 text-xs text-[var(--color-care-muted)] sm:truncate">{{ $s->counselingCase->title }}</p>
                        @if ($s->counselingCase->category === \App\Models\CounselingCase::CATEGORY_ACADEMIC)
                            <span class="tag-academic mt-2">Academic</span>
                        @else
                            <span class="tag-personal mt-2">Personal</span>
                        @endif
                    </div>
                    <div class="upcoming-session-date date-accent-{{ $accent }}">
                        <p class="date-day">{{ $s->session_at->format('M j') }}</p>
                        <p class="date-time">{{ $s->session_at->format('g:i A') }}</p>
                    </div>
                </li>
            @empty
                <li class="empty-state">No upcoming sessions — log one from a case page.</li>
            @endforelse
        </ul>
    </div>

    <div class="panel p-5 sm:p-6 lg:col-span-12 xl:col-span-6">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div class="flex items-center gap-3">
                <span class="icon-badge icon-badge-notes">📝</span>
                <div>
                    <h2 class="font-display text-lg font-semibold text-violet-700">Recent notes</h2>
                    <p class="text-xs text-[var(--color-care-muted)]">Latest session entries</p>
                </div>
            </div>
            <a href="{{ route('sessions.timeline') }}" class="rounded-full bg-gradient-to-r from-violet-500 to-pink-500 px-3 py-1 text-xs font-bold text-white shadow-sm hover:opacity-90">View all →</a>
        </div>
        <ul class="mt-5 space-y-2">
            @foreach ($recentSessions as $index => $s)
                <li class="session-card session-card-accent-{{ $index % 4 }}">
                    <div class="flex items-start justify-between gap-2">
                        <p class="text-sm font-semibold text-[var(--color-care-ink)]">{{ $s->counselingCase->student->name }}</p>
                        <time class="shrink-0 rounded-full bg-pink-100 px-2 py-0.5 text-xs font-bold text-pink-600">{{ $s->session_at->format('M j') }}</time>
                    </div>
                    <p class="mt-2 line-clamp-2 text-xs text-[var(--color-care-muted)]">{{ str(strip_tags($s->notes))->limit(100) }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
