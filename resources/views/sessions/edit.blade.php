@extends('layouts.app')

@section('title', 'Edit session')
@section('heading', 'Edit session')
@section('subheading', $case->title)

@section('content')
    <form method="POST" action="{{ route('counseling-cases.sessions.update', [$case, $session]) }}" class="panel mx-auto max-w-2xl space-y-6 p-8">
        @csrf
        @method('PUT')
        @include('sessions._form', ['session' => $session])
        <div class="flex flex-wrap gap-3">
            <button type="submit" class="btn-primary">Update session</button>
            <a href="{{ route('counseling-cases.show', $case) }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
