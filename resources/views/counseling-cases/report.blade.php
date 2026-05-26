<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Case report — {{ $case->title }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="bg-[var(--color-paper)] p-8 text-[var(--color-ink)]">
    <p class="no-print mb-6">
        <a href="{{ route('counseling-cases.show', $case) }}" class="text-[var(--color-copper-dim)] hover:underline">← Back to case</a>
        <button type="button" onclick="window.print()" class="btn-primary ml-4">Print / Save PDF</button>
    </p>

    <header class="border-b border-[var(--color-mist)] pb-6">
        <p class="font-display text-xs font-semibold uppercase tracking-widest text-[var(--color-copper-dim)]">Confidential case summary</p>
        <h1 class="font-serif-display mt-2 text-3xl text-[var(--color-deep)]">{{ $case->title }}</h1>
        <p class="mt-2 text-sm">{{ $case->student->name }} · #{{ $case->student->student_number }}
            @if ($case->student->program) · {{ $case->student->program }} @endif
        </p>
        <div class="mt-4 flex flex-wrap gap-3 text-sm">
            <span>Category: <strong>{{ \App\Models\CounselingCase::categories()[$case->category] ?? $case->category }}</strong></span>
            <span>·</span>
            <span>Status: <strong>{{ \App\Models\CounselingCase::statuses()[$case->status] ?? $case->status }}</strong></span>
            <span>·</span>
            <span>Counselor: <strong>{{ $case->counselor->name }}</strong></span>
        </div>
    </header>

    @if ($case->summary)
        <section class="mt-8">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-[var(--color-ink)]/45">Presenting summary</h2>
            <p class="mt-2 whitespace-pre-wrap text-sm leading-relaxed">{{ $case->summary }}</p>
        </section>
    @endif

    <section class="mt-10">
        <h2 class="font-display text-lg text-[var(--color-deep)]">Session chronology</h2>
        <div class="mt-4 space-y-6">
            @foreach ($case->counselingSessions as $session)
                <div class="rounded-xl border border-[var(--color-mist)] bg-white p-5">
                    <p class="text-sm font-semibold text-[var(--color-deep)]">{{ $session->session_at->format('F j, Y — g:i A') }} · {{ $session->duration_minutes }} min</p>
                    <p class="mt-3 whitespace-pre-wrap text-sm">{{ $session->notes }}</p>
                    @if ($session->next_steps)
                        <p class="mt-3 border-t border-[var(--color-mist)] pt-3 text-sm"><span class="font-semibold">Next steps:</span> {{ $session->next_steps }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <footer class="mt-12 border-t border-[var(--color-mist)] pt-6 text-xs text-[var(--color-ink)]/45">
        Generated {{ now()->format('Y-m-d H:i') }} · {{ config('app.name') }}
    </footer>
</body>
</html>
