@extends('layouts.app')

@section('title', 'Log session')
@section('heading', 'Log session')
@section('subheading', $case->title)

@section('content')
    <form method="POST" action="{{ route('counseling-cases.sessions.store', $case) }}" class="panel mx-auto max-w-2xl space-y-6 p-8">
        @csrf
        @include('sessions._form', ['session' => null])
        <div class="flex flex-wrap gap-3">
            <button type="submit" class="btn-primary">Save session</button>
            <a href="{{ route('counseling-cases.show', $case) }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
