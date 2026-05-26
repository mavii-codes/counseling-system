<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCounselingSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'session_at' => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:10', 'max:480'],
            'notes' => ['required', 'string', 'max:10000'],
            'next_steps' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
