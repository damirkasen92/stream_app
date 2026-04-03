<?php

namespace App\Actions\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LogoutUser
{
    public static function execute(Request $request): void
    {
        $request->user()->tokens()->delete();
        $request->user()->update([
            'refresh_token' => null,
            'refresh_token_expires_at' => null,
        ]);

        Cookie::forget('refresh_token');
    }
}
