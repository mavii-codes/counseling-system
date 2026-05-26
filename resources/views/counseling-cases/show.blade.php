@extends('layouts.app')

@section('title', $case->title)
@section('heading', $case->title)
@section('subheading', $case->student->name.' · #'.$case->student->student_number)

@section('toolbar')
    <a href="{{ route('counseling-cases.report', $case) }}" class="btn-secondary text-xs lg:text-sm" target="_blank">Print report</a>
    <a href="{{ route('counseling-cases.sessions.create', $case) }}" class="btn-primary text-xs lg:text-sm">Log session</a>
    <a href="{{ route('counseling-cases.edit', $case) }}" class="btn-secondary text-xs lg:text-sm">Edit case</a>
@endsection

@section('content')
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="panel space-y-4 p-6 lg:col-span-2">
            <div class="flex flex-wrap items-center gap-2">
                @if ($case->category === \App\Models\CounselingCase::CATEGORY_ACADEMIC)
                    <span class="tag-academic">Academic</span>
                @else
                    <span class="tag-personal">Personal</span>
                @endif
                <span class="rounded-full bg-[var(--color-mist)] px-2.5 py-0.5 text-xs font-medium text-[var(--color-deep)]">
                    {{ \App\Models\CounselingCase::statuses()[$case->status] ?? $case->status }}
                </span>
            </div>
            @if ($case->summary)
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/45">Summary</h2>
                    <p class="mt-2 whitespace-pre-wrap text-sm text-[var(--color-ink)]/85">{{ $case->summary }}</p>
                </div>
            @endif
            <dl class="grid gap-3 text-sm sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/45">Opened</dt>
                    <dd class="mt-1">{{ $case->opened_at->format('M j, Y g:i A') }}</dd>
                </div>
                @if ($case->closed_at)
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/45">Closed</dt>
                        <dd class="mt-1">{{ $case->closed_at->format('M j, Y g:i A') }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/45">Counselor</dt>
                    <dd class="mt-1">{{ $case->counselor->name }}</dd>
                </div>
            </dl>
        </div>
        <div class="panel flex flex-col p-6">
            <h2 class="font-display text-lg font-semibold text-[var(--color-deep)]">Case actions</h2>
            <p class="mt-2 text-sm text-[var(--color-ink)]/55">Remove this file if it was created in error (sessions go with it).</p>
            <form method="POST" action="{{ route('counseling-cases.destroy', $case) }}" class="mt-auto pt-6" onsubmit="return confirm('Delete this case and all sessions?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger w-full">Delete case</button>
            </form>
        </div>
    </div>

    <div class="mt-10">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="font-display text-lg font-semibold text-[var(--color-deep)]">Session history</h2>
            <a href="{{ route('counseling-cases.sessions.index', $case) }}" class="text-sm text-[var(--color-copper-dim)] hover:underline">Paged list</a>
        </div>
        <div class="space-y-3">
            @forelse ($case->counselingSessions as $session)
                <article class="panel p-5">
                    <div class="flex flex-wrap items-start justify-between gap-2">
                        <div>
                            <time class="text-sm font-semibold text-[var(--color-copper-dim)]">{{ $session->session_at->format('M j, Y · g:i A') }}</time>
                            <p class="mt-1 text-xs text-[var(--color-ink)]/50">{{ $session->duration_minutes }} minutes</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('counseling-cases.sessions.edit', [$case, $session]) }}" class="btn-ghost text-xs">Edit</a>
                            <form method="POST" action="{{ route('counseling-cases.sessions.destroy', [$case, $session]) }}" class="inline" onsubmit="return confirm('Remove this session entry?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>
                    <p class="mt-4 whitespace-pre-wrap text-sm text-[var(--color-ink)]/85">{{ $session->notes }}</p>
                    @if ($session->next_steps)
                        <div class="mt-4 rounded-lg border border-dashed border-[var(--color-copper)]/40 bg-amber-50/50 px-3 py-2 text-sm text-[var(--color-ink)]/80">
                            <span class="font-semibold text-[var(--color-copper-dim)]">Next steps:</span>
                            <span class="whitespace-pre-wrap">{{ $session->next_steps }}</span>
                        </div>
                    @endif
                </article>
            @empty
                <div class="panel p-10 text-center text-sm text-[var(--color-ink)]/50">No sessions logged yet.</div>
            @endforelse
        </div>
    </div>
@endsection
