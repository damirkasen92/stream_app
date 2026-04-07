<?php

namespace App\Actions\Stream;

use App\Actions\Mercure\PublishJwt;
use App\Data\Stream\StartStreamData;
use App\DTOs\MercurePublishDto;
use App\Exceptions\StreamException;
use App\Models\Stream;
use App\Models\User;
use App\Repositories\Stream\StreamRepository;

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

        PutStreamIntoCache::execute($data, $user->id);
        // DI and Interface?
        $stream = StreamRepository::getActiveStreamForUser($user->id);
        $stream->update([
            'started_at' => $data->recorded_at,
        ]);

        PublishJwt::execute(
            MercurePublishDto::make($stream->title, "$stream->title has been started"),
        );

        return $stream;
    }
}
