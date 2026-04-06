<?php

namespace App\Data\Token;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class TokenResponseData extends Data {
    public function __construct(
        public string $access_token,
        public string $refresh_token,
        public Carbon $refresh_token_expires_at,
        public int $expires_in,
    )
    {
    }
}
