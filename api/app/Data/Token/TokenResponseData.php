<?php

namespace App\Data\Token;

use Spatie\LaravelData\Data;

class TokenResponseData extends Data {
    public function __construct(
        public string $access_token,
        public string $refresh_token,
        public int $expires_in,
    )
    {
    }
}
