@extends('layouts.app')

@section('title', 'New student')
@section('heading', 'New student')
@section('subheading', 'Register a student for counseling intake.')

@section('content')
    <form method="POST" action="{{ route('students.store') }}" class="panel mx-auto max-w-2xl space-y-5 p-8">
        @csrf
        @include('students._form', ['student' => null])
        <div class="flex flex-wrap gap-3 pt-4">
            <button type="submit" class="btn-primary">Save student</button>
            <a href="{{ route('students.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
