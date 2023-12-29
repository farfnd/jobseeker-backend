<?php

namespace App\Http\Requests;

use App\Domain\Registrations\Enums\RegistrableType;
use App\Domain\Registrations\Enums\RegistrationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class EducationGetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'include' => 'string',
            'filter.id' => 'integer|min:1|max:18446744073709551615',
            'filter.institution_name' => 'string|min:1|max:255',
            'filter.major' => 'string|min:1|max:255',
            'filter.start_year' => 'integer|min:1900|max:9999',
            'filter.end_year' => 'integer|min:1900|max:9999',
            'filter.until_now' => 'boolean',
            'filter.gpa' => 'numeric|min:0|max:4',
            'filter.flag' => 'string|min:1|max:255',
            'page.number' => 'integer|between:1,4294967295',
            'page.size' => 'integer|between:1,100',
            'search' => 'string|min:1|max:60',
        ];
    }
}
