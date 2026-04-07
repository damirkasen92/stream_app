<?php

namespace App\Actions\Stream;

use App\Data\Stream\StartStreamData;
use Illuminate\Support\Facades\Redis;

class PutStreamIntoCache
{
    public static function execute(StartStreamData $data, int $userId): void
    {
        Redis::del("stream:{$userId}");
        Redis::hmset("stream:{$userId}", [
            'stream_key' => $data->stream_key,
            'path' => $data->path,
            'vod_paths' => $data->vod_paths,
            'qualities' => $data->qualities,
            'started_at' => $data->recorded_at,
        ]);
    }
}
