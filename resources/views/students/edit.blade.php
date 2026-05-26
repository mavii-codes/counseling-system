@extends('layouts.app')

@section('title', 'Edit student')
@section('heading', 'Edit student')
@section('subheading', $student->name)

@section('content')
    <form method="POST" action="{{ route('students.update', $student) }}" class="panel mx-auto max-w-2xl space-y-5 p-8">
        @csrf
        @method('PUT')
        @include('students._form', ['student' => $student])
        <div class="flex flex-wrap gap-3 pt-4">
            <button type="submit" class="btn-primary">Update</button>
            <a href="{{ route('students.show', $student) }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
