@extends('layouts.app')

@section('title', 'Edit case')
@section('heading', 'Edit case')
@section('subheading', $case->title)

@section('content')
    <form method="POST" action="{{ route('counseling-cases.update', $case) }}" class="panel mx-auto max-w-2xl space-y-6 p-8">
        @csrf
        @method('PUT')
        @include('counseling-cases._form', ['students' => $students, 'case' => $case, 'selectedStudentId' => null])
        <div class="flex flex-wrap gap-3">
            <button type="submit" class="btn-primary">Save changes</button>
            <a href="{{ route('counseling-cases.show', $case) }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
