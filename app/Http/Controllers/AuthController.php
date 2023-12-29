<?php

namespace App\Http\Controllers;

use App\Http\Validators\CandidateLoginValidator;
use App\Services\CandidateLoginService;
use App\Http\Responses\ApiResponseTrait;
use App\Services\GeolocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;

    private $loginValidator;

    private $loginService;

    private $geolocationService;

    public function __construct(
        CandidateLoginValidator $loginValidator,
        CandidateLoginService $loginService,
        GeolocationService $geolocationService
    ) {
        $this->loginValidator = $loginValidator;
        $this->loginService = $loginService;
        $this->geolocationService = $geolocationService;
    }

    public function login(Request $request)
    {
        $validator = $this->loginValidator->validate($request->all());

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 422);
        }

        $credentials = $this->getCredentials($request);
        $latitude = $request->latitude ?? $this->geolocationService->getLatitudeFromIP($request->ip());
        $longitude = $request->longitude ?? $this->geolocationService->getLongitudeFromIP($request->ip());

        $user = $this->loginService->attemptLogin(
            $credentials,
            $latitude,
            $longitude
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
