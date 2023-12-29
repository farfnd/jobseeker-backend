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

    private $loginValidator;

    private $loginService;

    public function __construct(CandidateLoginValidator $loginValidator, CandidateLoginService $loginService)
    {
        $this->loginValidator = $loginValidator;
        $this->loginService = $loginService;
    }

    public function login(Request $request)
    {
        $validator = $this->loginValidator->validate($request->all());

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 422);
        }

        $credentials = $this->getCredentials($request);

        $user = $this->loginService->attemptLogin(
            $credentials,
            $request->latitude,
            $request->longitude
        );

        return $this->handleLoginResponse($user);
    }

    private function getCredentials(Request $request): array
    {
        $loginField = $request->input('login');

        return [
            filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone' => $loginField,
            'password' => $request->password,
        ];
    }

    private function handleLoginResponse($user)
    {
        if ($user) {
            $token = $user->createToken('authToken')->plainTextToken;
            return $this->sendSuccess(['token' => $token], 'Login successful', 200);
        }

        return $this->sendError('Wrong credentials or user does not exist', 401);
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
