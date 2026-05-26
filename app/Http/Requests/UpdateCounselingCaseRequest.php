<?php

namespace App\Http\Requests;

use App\Models\CounselingCase;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCounselingCaseRequest extends FormRequest
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
            'student_id' => ['required', 'exists:students,id'],
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(array_keys(CounselingCase::categories()))],
            'status' => ['required', Rule::in(array_keys(CounselingCase::statuses()))],
            'summary' => ['nullable', 'string', 'max:10000'],
            'opened_at' => ['nullable', 'date'],
            'closed_at' => ['nullable', 'date'],
        ];
    }
}
