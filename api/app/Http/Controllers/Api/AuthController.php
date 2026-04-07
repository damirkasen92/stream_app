<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\AuthUser;
use App\Actions\Auth\CreateUser;
use App\Actions\Auth\LogoutUser;
use App\Actions\Token\IssueTokens;
use App\Actions\Token\MakeRefreshTokenCookie;
use App\Actions\Token\ValidateToken;
use App\Data\Auth\UserLoginData;
use App\Data\Auth\UserRegistrationData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = UserRegistrationData::from($request);
        $user = CreateUser::execute($data);
        $tokens = IssueTokens::execute($user);

        return response()->json([
            'access_token' => $tokens->access_token,
            'expires_in' => $tokens->expires_in,
        ], Response::HTTP_CREATED)->cookie(
            MakeRefreshTokenCookie::execute($tokens)
        );
    }

    public function login(Request $request)
    {
        $dto = UserLoginData::from($request);
        $user = AuthUser::execute($dto);
        $tokens = IssueTokens::execute($user);

        return response()->json([
            'access_token' => $tokens->access_token,
            'expires_in' => $tokens->expires_in,
        ])->cookie(MakeRefreshTokenCookie::execute($tokens));
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');
        $user = ValidateToken::execute($refreshToken);

        if (!$user) {
            return response()->json([
                'error' => 'Invalid refresh token'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $tokens = IssueTokens::execute($user);

        return response()->json([
            'access_token' => $tokens->access_token,
            'expires_in' => $tokens->expires_in,
        ])->cookie(MakeRefreshTokenCookie::execute($tokens));
    }

    public function logout(Request $request)
    {
        LogoutUser::execute($request);

        return response()->json([
            'message' => 'Logged out'
        ], Response::HTTP_NO_CONTENT);
    }
}
