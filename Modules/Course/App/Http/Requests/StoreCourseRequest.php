<?php

namespace Modules\Course\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guarantor_id' => ['nullable', 'exists:users,id'],
            'code' => ['required', 'string', 'max:3', 'min:1', 'unique:courses,code'],
            'name' => ['required', 'string', 'max:128'],
            'academic_year' => ['required', 'string', 'max:32'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:mandatory,optional,Mandatory,Optional'],
            'credits' => ['required', 'integer', 'min:0', 'max:255'],
            'capacity' => ['required', 'integer', 'min:0', 'max:65535'],
            'auto_enroll_confirm' => ['nullable', 'in:0,1'],
            'is_approved' => ['nullable', 'in:0,1'],
        ];
    }
}


