<?php

namespace App\Http\Requests;

use App\Domain\Registrations\Enums\RegistrableType;
use App\Domain\Registrations\Enums\RegistrationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ExperienceGetRequest extends FormRequest
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
            'filter.company_name' => 'string|min:1|max:255',
            'filter.company_address' => 'string|min:1|max:500',
            'filter.position' => 'string|min:1|max:255',
            'filter.job_desc' => 'string|min:1|max:255',
            'filter.start_year' => 'integer|min:1900|max:9999',
            'filter.end_year' => 'integer|min:1900|max:9999',
            'filter.until_now' => 'boolean',
            'filter.flag' => 'string|min:1|max:255',
            'page.number' => 'integer|between:1,4294967295',
            'page.size' => 'integer|between:1,100',
            'search' => 'string|min:1|max:60',
        ];
    }
}
