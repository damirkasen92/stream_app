<?php

namespace App\Actions\Token;

use App\Data\Token\TokenResponseData;
use App\Models\User;
use Illuminate\Support\Carbon;

class IssueTokens
{
    public static function execute(User $user): TokenResponseData
    {
        $accessToken = $user->createToken('access_token')->plainTextToken;
        $refreshTokenPlain = base64_encode(random_bytes(40));
        $refreshTokenHash = hash('sha256', $refreshTokenPlain);
        $refreshTokenExpiresIn = Carbon::now()->addDays(7);

        $user->update([
            'refresh_token' => $refreshTokenHash,
            'refresh_token_expires_at' => $refreshTokenExpiresIn,
        ]);

        return TokenResponseData::from([
            'access_token' => $accessToken,
            'refresh_token' => $refreshTokenPlain,
            'refresh_token_expires_at' => $refreshTokenExpiresIn,
            'expires_in' => 3600,
        ]);
    }
}
