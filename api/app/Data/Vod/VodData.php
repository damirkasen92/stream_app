<?php

namespace App\Data\Vod;

use App\Models\Stream;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class VodData extends Data
{
    public function __construct(
        readonly int    $user_id,
        readonly int    $stream_id,
        readonly string $title,
        readonly array  $vod_paths,
        readonly array  $qualities,
        readonly string $recorded_at
    )
    {
    }

    public static function make(int $userId, Stream $stream, Request $request): self
    {
        return self::validateAndCreate([
            'user_id' => $userId,
            'stream_id' => $stream->id,
            'title' => $stream->title,
            'vod_paths' => $request->input('vod_paths'),
            'qualities' => $request->input('qualities'),
            'recorded_at' => $request->input('recorded_at')
        ]);
    }
}