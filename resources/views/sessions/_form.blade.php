@php
    $sess = $session ?? null;
@endphp
<div class="space-y-5">
    <div>
        <label class="label" for="session_at">Session date & time</label>
        <input class="input" type="datetime-local" name="session_at" id="session_at" required
            value="{{ old('session_at', isset($sess->session_at) ? $sess->session_at->format('Y-m-d\TH:i') : '') }}">
    </div>
    <div>
        <label class="label" for="duration_minutes">Duration (minutes)</label>
        <input class="input" type="number" name="duration_minutes" id="duration_minutes" min="10" max="480" required
            value="{{ old('duration_minutes', $sess->duration_minutes ?? 45) }}">
    </div>
    <div>
        <label class="label" for="notes">Session notes</label>
        <textarea class="input min-h-[160px]" name="notes" id="notes" rows="6" required maxlength="10000">{{ old('notes', $sess->notes ?? '') }}</textarea>
    </div>
    <div>
        <label class="label" for="next_steps">Next steps (optional)</label>
        <textarea class="input min-h-[80px]" name="next_steps" id="next_steps" rows="3" maxlength="5000">{{ old('next_steps', $sess->next_steps ?? '') }}</textarea>
    </div>
</div>
