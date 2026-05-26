@extends('layouts.app')

@section('title', $student->name)
@section('heading', $student->name)
@section('subheading', 'Student #'.$student->student_number)

@section('toolbar')
    <a href="{{ route('counseling-cases.create', ['student_id' => $student->id]) }}" class="btn-primary text-xs lg:text-sm">Open case</a>
    <a href="{{ route('students.edit', $student) }}" class="btn-secondary text-xs lg:text-sm">Edit</a>
@endsection

@section('content')
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="panel space-y-4 p-6 lg:col-span-2">
            <h2 class="font-display text-lg font-semibold text-[var(--color-deep)]">Profile</h2>
            <dl class="grid gap-3 text-sm sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/45">Email</dt>
                    <dd class="mt-1 text-[var(--color-ink)]">{{ $student->email ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/45">Phone</dt>
                    <dd class="mt-1 text-[var(--color-ink)]">{{ $student->phone ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/45">Program</dt>
                    <dd class="mt-1 text-[var(--color-ink)]">{{ $student->program ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/45">Year</dt>
                    <dd class="mt-1 text-[var(--color-ink)]">{{ $student->year_level ?? '—' }}</dd>
                </div>
                @if ($student->notes)
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/45">Notes</dt>
                        <dd class="mt-1 whitespace-pre-wrap text-[var(--color-ink)]/85">{{ $student->notes }}</dd>
                    </div>
                @endif
            </dl>
        </div>
        <div class="panel flex flex-col p-6">
            <h2 class="font-display text-lg font-semibold text-[var(--color-deep)]">Danger zone</h2>
            <p class="mt-2 text-sm text-[var(--color-ink)]/55">Deleting removes the student record. Cases must be removed first if blocking.</p>
            <form method="POST" action="{{ route('students.destroy', $student) }}" class="mt-auto pt-6" onsubmit="return confirm('Delete this student permanently?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger w-full">Delete student</button>
            </form>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="font-display text-lg font-semibold text-[var(--color-deep)]">Counseling cases</h2>
        <div class="mt-4 overflow-hidden rounded-2xl border border-[var(--color-mist)] bg-white/80">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[var(--color-mist)] bg-[var(--color-linen)] text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/55">
                    <tr>
                        <th class="px-4 py-3">Case</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--color-mist)]">
                    @forelse ($student->counselingCases as $case)
                        <tr>
                            <td class="px-4 py-3 font-medium text-[var(--color-deep)]">{{ $case->title }}</td>
                            <td class="px-4 py-3">
                                @if ($case->category === \App\Models\CounselingCase::CATEGORY_ACADEMIC)
                                    <span class="tag-academic">Academic</span>
                                @else
                                    <span class="tag-personal">Personal</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-[var(--color-ink)]/70">{{ \App\Models\CounselingCase::statuses()[$case->status] ?? $case->status }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('counseling-cases.show', $case) }}" class="text-[var(--color-copper-dim)] hover:underline">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-[var(--color-ink)]/50">No cases yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
