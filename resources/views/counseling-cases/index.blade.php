@extends('layouts.app')

@section('title', 'Cases')
@section('heading', 'Counseling cases')
@section('subheading', 'Filter by category, status, or title / student.')

@section('toolbar')
    <a href="{{ route('counseling-cases.export', request()->query()) }}" class="btn-secondary text-xs lg:text-sm">Export CSV</a>
    <a href="{{ route('counseling-cases.create') }}" class="btn-primary text-xs lg:text-sm">New case</a>
@endsection

@section('content')
    <form method="GET" class="panel mb-6 grid gap-4 p-4 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <label class="label" for="q">Search</label>
            <input class="input" type="search" name="q" id="q" value="{{ request('q') }}" placeholder="Title or student…">
        </div>
        <div>
            <label class="label" for="category">Category</label>
            <select class="input" name="category" id="category">
                <option value="">All</option>
                @foreach (\App\Models\CounselingCase::categories() as $val => $label)
                    <option value="{{ $val }}" @selected(request('category') === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label" for="status">Status</label>
            <select class="input" name="status" id="status">
                <option value="">All</option>
                @foreach (\App\Models\CounselingCase::statuses() as $val => $label)
                    <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="btn-primary w-full sm:w-auto">Apply</button>
            <a href="{{ route('counseling-cases.index') }}" class="btn-ghost">Reset</a>
        </div>
    </form>

    <div class="space-y-4">
        @forelse ($cases as $case)
            <article class="session-card flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        @if ($case->category === \App\Models\CounselingCase::CATEGORY_ACADEMIC)
                            <span class="tag-academic">Academic</span>
                        @else
                            <span class="tag-personal">Personal</span>
                        @endif
                        <span class="tag-status">
                            {{ \App\Models\CounselingCase::statuses()[$case->status] ?? $case->status }}
                        </span>
                    </div>
                    <h2 class="mt-2 font-display text-lg font-semibold text-[var(--color-deep)]">{{ $case->title }}</h2>
                    <p class="mt-1 text-sm text-[var(--color-ink)]/60">
                        {{ $case->student->name }} · #{{ $case->student->student_number }}
                        · Counselor: {{ $case->counselor->name }}
                    </p>
                </div>
                <div class="flex shrink-0 flex-wrap gap-2">
                    <a href="{{ route('counseling-cases.show', $case) }}" class="btn-primary text-xs">Open</a>
                    <a href="{{ route('counseling-cases.report', $case) }}" class="btn-secondary text-xs" target="_blank">Print report</a>
                </div>
            </article>
        @empty
            <div class="panel p-12 text-center text-[var(--color-ink)]/50">No cases match your filters.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $cases->links() }}</div>
@endsection
