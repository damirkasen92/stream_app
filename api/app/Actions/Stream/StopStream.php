<?php

namespace App\Actions\Stream;

use App\Enums\StreamStatuses;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

class StopStream
{
    public static function execute(string $streamKey): void
    {
        $userId = User::where('stream_key', $streamKey)->value('id');

        Stream::where([
            'user_id' => $userId,
            'status' => StreamStatuses::live
        ])
            ->first()
            ?->update([
                'status' => StreamStatuses::ended,
                'ended_at' => now()
            ]);

        Redis::del("stream:{$userId}");
    }
}
