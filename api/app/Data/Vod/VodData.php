<?php

namespace App\Data\Vod;

use App\Models\Stream;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class VodData extends Data
{
    public function __construct(
        public int    $user_id,
        public int    $stream_id,
        public string $title,
        public array  $vod_paths,
        public array  $qualities,
        public string $recorded_at
    )
    {
    }

    public static function make(Stream $stream, Request $request): self
    {
        return self::validateAndCreate([
            'user_id' => $stream->user_id,
            'stream_id' => $stream->id,
            'title' => $stream->title,
            'vod_paths' => $request->input('vod_paths'),
            'qualities' => $request->input('qualities'),
            'recorded_at' => $request->input('recorded_at')
        ]);
    }
}
