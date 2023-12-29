<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class CandidateLoginValidator
{
    public static function validate(array $data)
    {
        return Validator::make($data, [
            'login' => 'required',
            'password' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ])->sometimes('login', 'email', function ($input) {
            return filter_var($input->login, FILTER_VALIDATE_EMAIL);
        })->sometimes('login', 'numeric', function ($input) {
            return is_numeric($input->login);
        });
    }
}
