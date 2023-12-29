<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class CandidateLoginService
{
    public static function attemptLogin($credentials, $latitude = null, $longitude = null)
    {
        if (self::authenticateUser($credentials)) {
            $user = Auth::user();
            self::updateUserLoginDetails($user, $latitude, $longitude);
            return $user;
        }

        return null;
    }

    private static function authenticateUser($credentials)
    {
        return Auth::attempt($credentials);
    }

    private static function updateUserLoginDetails($user, $latitude, $longitude)
    {
        $user->login_date = now();
        $user->latitude = $latitude ?? $user->latitude;
        $user->longitude = $longitude ?? $user->longitude;
        $user->save();
    }
}
