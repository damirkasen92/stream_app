<?php

namespace App\Actions\Token;

use App\Data\Token\TokenResponseData;
use Illuminate\Support\Facades\Cookie;

class MakeRefreshTokenCookie
{
    public static function execute(TokenResponseData $tokens)
    {
        return Cookie::make(
            'refresh_token',
            $tokens->refresh_token,
            $tokens->refresh_token_expires_at->getTimestamp(),
            '/',
            null,
            false,
            true,
            false,
            'Strict'
        );
    }
}
