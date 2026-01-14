<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (!$token = auth('api')->attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            return $this->responseWithError(
            null,
            __('login.login_failed'),
            401
            );
        }

        $user = auth('api')->setToken($token)->user();

        $userData = collect($user->toArray())->except([
            'email_verified_at', 'is_admin', 'status', 'created_at', 'updated_at'
        ])->toArray();

        return $this->responseWithSuccess(
            [
                'user' => $userData,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => 60 * 60 * 24 * 30,
            ],
            __('login.login_success'),
            200
        );
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
