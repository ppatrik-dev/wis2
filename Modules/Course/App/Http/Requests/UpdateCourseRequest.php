<?php

namespace Modules\Course\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $courseId = (int) ($this->route('course') ?? $this->route('id') ?? 0);

        return [
            'guarantor_id' => ['nullable', 'exists:users,id'],
            'code' => ['sometimes', 'string', 'max:3', 'min:1', 'unique:courses,code,' . $courseId],
            'name' => ['sometimes', 'string', 'max:128'],
            'academic_year' => ['sometimes', 'string', 'max:32'],
            'description' => ['nullable', 'string'],
            'type' => ['sometimes', 'in:mandatory,optional,Mandatory,Optional'],
            'credits' => ['sometimes', 'integer', 'min:0', 'max:255'],
            'capacity' => ['sometimes', 'integer', 'min:0', 'max:65535'],
            'auto_enroll_confirm' => ['nullable', 'in:0,1'],
            'is_approved' => ['nullable', 'in:0,1'],
        ];
    }
}


