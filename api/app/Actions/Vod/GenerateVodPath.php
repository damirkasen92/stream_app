<?php

namespace App\Actions\Vod;

use Illuminate\Http\Response;

class GenerateVodPath
{
    public static function execute(array $vod, string $path, ?string $segment = null): string
    {
        $basePath = "/recordings/{$vod['real_key']}/{$path}";

        if ($segment === null) {
            $path = public_path("{$basePath}/index.m3u8");
        } else {
            $path = public_path("{$basePath}/{$segment}");
        }

        if (!is_file($path)) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return $path;
    }
}
