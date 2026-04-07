<?php

namespace App\Actions\Stream;

use App\Data\Stream\CreateStreamData;
use App\Enums\StreamStatuses;
use App\Exceptions\StreamException;
use App\Models\Stream;

class CreateStream
{
    /**
     * @throws StreamException
     */
    public static function execute(CreateStreamData $data): Stream {
        $liveStream = Stream::where([
            'user_id' => $data->user_id,
            'status' => StreamStatuses::live,
        ])->first();

        if ($liveStream) {
            throw new StreamException("Stream already exists");
        }

        return Stream::create([
            'user_id' => $data->user_id,
            'title' => $data->title,
            'description' => $data->description,
            'created_at' => now()
        ]);
    }
}
