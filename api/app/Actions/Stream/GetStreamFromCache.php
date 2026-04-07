<?php

namespace App\Actions\Stream;

use Illuminate\Support\Facades\Redis;

class GetStreamFromCache
{
    public static function execute(int $userId): array|false|Redis
    {
        return Redis::hgetall("stream:{$userId}");
    }
}
