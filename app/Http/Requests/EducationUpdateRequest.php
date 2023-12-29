<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'institution_name' => 'string|min:1|max:255',
            'major' => 'string|min:1|max:255',
            'start_year' => 'integer|min:1900|max:9999',
            'end_year' => 'integer|min:1900|max:9999|required_if:until_now,0',
            'until_now' => 'boolean',
            'gpa' => 'numeric|min:0|max:4',
            'flag' => 'string|min:1|max:255',
        ];
    }
}
