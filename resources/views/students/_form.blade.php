@php
    $s = $student;
@endphp
<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label class="label" for="student_number">Student number</label>
        <input class="input" type="text" name="student_number" id="student_number" value="{{ old('student_number', $s->student_number ?? '') }}" required maxlength="32">
    </div>
    <div class="sm:col-span-2">
        <label class="label" for="name">Full name</label>
        <input class="input" type="text" name="name" id="name" value="{{ old('name', $s->name ?? '') }}" required maxlength="255">
    </div>
    <div>
        <label class="label" for="email">Email</label>
        <input class="input" type="email" name="email" id="email" value="{{ old('email', $s->email ?? '') }}" maxlength="255">
    </div>
    <div>
        <label class="label" for="phone">Phone</label>
        <input class="input" type="text" name="phone" id="phone" value="{{ old('phone', $s->phone ?? '') }}" maxlength="32">
    </div>
    <div>
        <label class="label" for="program">Program</label>
        <input class="input" type="text" name="program" id="program" value="{{ old('program', $s->program ?? '') }}" maxlength="255" placeholder="e.g. BS Psychology">
    </div>
    <div>
        <label class="label" for="year_level">Year level</label>
        <input class="input" type="text" name="year_level" id="year_level" value="{{ old('year_level', $s->year_level ?? '') }}" maxlength="32" placeholder="e.g. 2nd year">
    </div>
    <div class="sm:col-span-2">
        <label class="label" for="notes">Internal notes</label>
        <textarea class="input min-h-[100px]" name="notes" id="notes" rows="4" maxlength="5000">{{ old('notes', $s->notes ?? '') }}</textarea>
    </div>
</div>
