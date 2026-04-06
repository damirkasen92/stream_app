<?php

namespace App\Actions\Vod;

use App\Data\Stream\StartStreamData;
use App\Models\Stream;
use App\Models\Vod;

class CreateVod
{
    public static function execute(StartStreamData $data, Stream $stream): void
    {
        foreach ($data->vod_paths as $index => $path) {
            Vod::create([
                'user_id' => $stream->user_id,
                'stream_id' => $stream->id,
                'title' => $stream->title,
                'path' => $path,
                'quality' => $data->qualities[$index],
                'recorded_at' => $data->recorded_at,
            ]);
        }
    }
}
