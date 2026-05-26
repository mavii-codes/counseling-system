@php
    $c = $case ?? null;
@endphp
<div class="space-y-5">
    <div>
        <label class="label" for="student_id">Student</label>
        <select class="input" name="student_id" id="student_id" required>
            <option value="">Select student</option>
            @foreach ($students as $stu)
                <option value="{{ $stu->id }}" @selected(old('student_id', $selectedStudentId ?? $c?->student_id) == $stu->id)>
                    {{ $stu->name }} ({{ $stu->student_number }})
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label" for="title">Case title</label>
        <input class="input" type="text" name="title" id="title" value="{{ old('title', $c->title ?? '') }}" required maxlength="255" placeholder="e.g. Grade slip & study plan">
    </div>
    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label class="label" for="category">Category</label>
            <select class="input" name="category" id="category" required>
                @foreach (\App\Models\CounselingCase::categories() as $val => $label)
                    <option value="{{ $val }}" @selected(old('category', $c->category ?? '') === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label" for="status">Status</label>
            <select class="input" name="status" id="status" required>
                @foreach (\App\Models\CounselingCase::statuses() as $val => $label)
                    <option value="{{ $val }}" @selected(old('status', $c->status ?? \App\Models\CounselingCase::STATUS_OPEN) === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div>
        <label class="label" for="summary">Summary / presenting concern</label>
        <textarea class="input min-h-[120px]" name="summary" id="summary" rows="4" maxlength="10000">{{ old('summary', $c->summary ?? '') }}</textarea>
    </div>
    <div>
        <label class="label" for="opened_at">Opened at</label>
        <input class="input" type="datetime-local" name="opened_at" id="opened_at" value="{{ old('opened_at', isset($c->opened_at) ? $c->opened_at->format('Y-m-d\TH:i') : '') }}">
    </div>
    @if ($c)
        <div>
            <label class="label" for="closed_at">Closed at</label>
            <input class="input" type="datetime-local" name="closed_at" id="closed_at" value="{{ old('closed_at', $c->closed_at ? $c->closed_at->format('Y-m-d\TH:i') : '') }}">
        </div>
    @endif
</div>
