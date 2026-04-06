<?php

namespace App\Data\Stream;

use App\Models\Stream;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class StartStreamData extends Data
{
    public function __construct(
        public string $stream_key,
        public string $path,
        public string $conn_id,
        public array  $vod_paths,
        public array  $qualities,
        public string $recorded_at
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
        return self::validateAndCreate([
            'stream_key' => $request->input('stream'),
            'path' => $request->input('path'),
            'conn_id' => $request->input('conn_id'),
            'vod_paths' => $request->array('vod_paths'),
            'qualities' => $request->array('qualities'),
            'recorded_at' => $request->input('recorded_at')
        ]);
    }

//    public static function make(Stream $stream, Request $request): self
//    {
//        return self::validateAndCreate([
//            'user_id' => $stream->user_id,
//            'stream_id' => $stream->id,
//            'title' => $stream->title,
//            'vod_paths' => $request->input('vod_paths'),
//            'qualities' => $request->input('qualities'),
//            'recorded_at' => $request->input('recorded_at')
//        ]);
//    }
}
