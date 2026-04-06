<?php

namespace App\Actions\Stream;

use App\Actions\Mercure\PublishJwt;
use App\Data\Stream\StartStreamData;
use App\DTOs\MercurePublishDto;
use App\Enums\StreamStatuses;
use App\Exceptions\StreamException;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;

class StartStream
{
    /**
     * @throws StreamException
     */
    public static function execute(StartStreamData $data): Stream
    {
        $user = User::where('stream_key', $data->stream_key)->first();

        if (!$user) {
            throw new StreamException("Invalid stream key");
        }

        self::saveStreamInCache($data, $user->id);
        $stream = self::getLiveStream($user->id);
        $stream->update([
            'started_at' => $data->recorded_at,
        ]);

        PublishJwt::execute(
            MercurePublishDto::make($stream->title, "$stream->title has been started"),
        );

        return $stream;
    }

    private static function saveStreamInCache(StartStreamData $data, int $userId): void
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

    /**
     * @throws StreamException
     */
    private static function getLiveStream(int $userId): Stream
    {
        $stream = Stream::where([
            'user_id' => $userId,
            'status' => StreamStatuses::live
        ])
            ->orderBy('id', 'desc')
            ->first();

        if (!$stream || $stream->status !== StreamStatuses::live) {
            throw new StreamException("There is no an any live stream");
        }

        return $stream;
    }
}
