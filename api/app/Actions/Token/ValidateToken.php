<?php

namespace App\Actions\Token;

use App\Models\User;

class ValidateToken
{
    public static function execute(string $plainToken): ?User
    {
        $hash = hash('sha256', $plainToken);

        return User::where('refresh_token', $hash)
            ->where('refresh_token_expires_at', '>', now())
            ->first();
    }
}
