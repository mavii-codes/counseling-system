@extends('layouts.app')

@section('title', 'Students')
@section('heading', 'Students')
@section('subheading', 'Search records by name, ID, email, or program.')

@section('toolbar')
    <a href="{{ route('students.export') }}" class="btn-secondary text-xs lg:text-sm">Export CSV</a>
    <a href="{{ route('students.create') }}" class="btn-primary text-xs lg:text-sm">Add student</a>
@endsection

@section('content')
    <form method="GET" action="{{ route('students.index') }}" class="panel mb-6 flex flex-wrap items-end gap-4 p-4">
        <div class="min-w-[200px] flex-1">
            <label class="label" for="q">Search</label>
            <input class="input" type="search" name="q" id="q" value="{{ request('q') }}" placeholder="Name, student #, email…">
        </div>
        <button type="submit" class="btn-primary">Search</button>
        @if (request('q'))
            <a href="{{ route('students.index') }}" class="btn-ghost">Clear</a>
        @endif
    </form>

    <div class="data-table-wrap">
        <table class="data-table w-full text-left text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-3">Student #</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3 hidden md:table-cell">Program</th>
                    <th class="px-4 py-3 hidden sm:table-cell">Email</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td class="font-mono text-xs font-semibold text-[var(--color-care-teal-mid)]">{{ $student->student_number }}</td>
                        <td class="font-semibold text-[var(--color-care-ink)]">{{ $student->name }}</td>
                        <td class="px-4 py-3 text-[var(--color-ink)]/70 hidden md:table-cell">{{ $student->program ?? '—' }}</td>
                        <td class="px-4 py-3 text-[var(--color-ink)]/60 hidden sm:table-cell">{{ $student->email ?? '—' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('students.show', $student) }}" class="font-semibold text-[var(--color-care-teal)] hover:underline">View →</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-[var(--color-ink)]/50">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $students->links() }}
    </div>
@endsection
