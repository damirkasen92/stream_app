<?php

namespace App\Repositories\Stream;

use App\Enums\StreamStatuses;
use App\Exceptions\StreamException;
use App\Models\Stream;

class StreamRepository
{
    /**
     * @throws StreamException
     */
    public static function getActiveStreamForUser(int $id): Stream
    {
        $stream = Stream::liveByUser($id)->first();

        if (!$stream || $stream->status !== StreamStatuses::live) {
            throw new StreamException("There is no an any live stream");
        }

        return $stream;
    }
}
