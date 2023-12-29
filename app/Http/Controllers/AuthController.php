<?php

namespace App\Http\Controllers;

use App\Http\Validators\CandidateLoginValidator;
use App\Services\CandidateLoginService;
use App\Http\Responses\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function login(Request $request)
    {
        $validator = CandidateLoginValidator::validate($request->all());

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 422);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = CandidateLoginService::attemptLogin(
            $credentials,
            $request->latitude,
            $request->longitude
        );

        if ($user) {
            $token = $user->createToken('authToken')->plainTextToken;
            return $this->sendSuccess(['token' => $token], 'Login successful', 200);
        }

        return $this->sendError('Wrong credentials', 401);
    }

    public function logout(Request $request)
    {
        if (Auth::user()) {
            $request->user()->tokens()->delete();
            return $this->sendSuccess([], 'Successfully logged out', 200);
        }

        return $this->sendError('Unauthenticated', 401);
    }
}
