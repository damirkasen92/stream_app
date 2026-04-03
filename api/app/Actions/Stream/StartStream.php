<?php

namespace App\Actions\Stream;

use App\Actions\Mercure\PublishJwt;
use App\DTOs\MercurePublishDto;
use App\Enums\StreamStatuses;
use App\Exceptions\StreamException;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Http\Response;

class StartStream
{
    /**
     * @throws StreamException
     */
    public static function execute(string $streamKey): Stream
    {
        $user = User::where('stream_key', $streamKey)->first();

        if (!$user) {
            throw new StreamException("Invalid stream key");
        }

        $stream = self::getStream($user->id);

        $stream->update([
            'started_at' => now(),
        ]);

        PublishJwt::execute(
            MercurePublishDto::make($stream->title, "$stream->title has been started"),
        );

        return $stream;
    }

    /**
     * @throws StreamException
     */
    private static function getStream(int $userId): Stream
    {
        $stream = Stream::where([
            'user_id' => $userId,
            'status' => StreamStatuses::live
        ])
            ->orderBy('id', 'desc')
            ->first();

        \Illuminate\Log\log($stream);

        if (!$stream) {
            throw new StreamException("Invalid stream");
        }

        if ($stream->status !== StreamStatuses::live) {
            throw new StreamException("There is no any live stream");
        }

        return $stream;
    }
}
