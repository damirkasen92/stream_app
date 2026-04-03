<?php

namespace App\Actions\Vod;

use App\Data\Vod\VodData;
use App\Models\Vod;

class CreateVod
{
    public static function execute(VodData $dto): void
    {
        foreach ($dto->vod_paths as $index => $path) {
            Vod::create([
                'user_id' => $dto->user_id,
                'stream_id' => $dto->stream_id,
                'title' => $dto->title,
                'path' => $path,
                'quality' => $dto->qualities[$index],
                'recorded_at' => $dto->recorded_at ?? now(),
            ]);
        }
    }
}