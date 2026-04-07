<?php

namespace App\Actions\Shared;

use Illuminate\Support\Str;

class GetPathType
{
    public static function execute(string $path): string
    {
        $ext = Str::lower(pathinfo($path, PATHINFO_EXTENSION));

        return match ($ext) {
            'm3u8' => 'application/vnd.apple.mpegurl',
            'ts' => 'video/mp2t',
            default => 'application/octet-stream',
        };
    }
}
