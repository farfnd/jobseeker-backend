<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class CandidateLoginService
{
    public static function attemptLogin($credentials, $latitude = null, $longitude = null)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->login_date = now();
            $user->latitude = $latitude ?? $user->latitude;
            $user->longitude = $longitude ?? $user->longitude;
            $user->save();

            return $user;
        }

        return null;
    }
}
