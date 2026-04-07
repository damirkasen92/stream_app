<?php

namespace App\Actions\Stream;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;

class GenerateStreamPath
{
    public static function execute(int $userId, string $quality, ?string $segment = null): string
    {
        $stream = GetStreamFromCache::execute($userId);
        $realKey = $stream['stream_key'];
        $date = $stream['started_at'];
        $basePath = "/recordings/{$realKey}/{$date}_{$quality}";

        if (!$realKey) {
            abort(Response::HTTP_NOT_FOUND);
        }

        if ($segment === null) {
            $path = public_path("$basePath/index.m3u8");
        } else {
            $path = public_path("$basePath/{$segment}");
        }

        return $path;
    }
}
