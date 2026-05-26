@extends('layouts.app')

@section('title', 'New case')
@section('heading', 'Open a case')
@section('subheading', 'Academic or personal — both stay organized here.')

@section('content')
    @php
        $case = null;
        $selectedStudentId = $selectedStudentId ?? null;
    @endphp
    <form method="POST" action="{{ route('counseling-cases.store') }}" class="panel mx-auto max-w-2xl space-y-6 p-8">
        @csrf
        @include('counseling-cases._form', ['students' => $students, 'case' => null, 'selectedStudentId' => $selectedStudentId])
        <div class="flex flex-wrap gap-3">
            <button type="submit" class="btn-primary">Create case</button>
            <a href="{{ route('counseling-cases.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
