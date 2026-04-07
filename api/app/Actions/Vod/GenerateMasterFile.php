<?php

namespace App\Actions\Vod;

use App\Exceptions\StreamException;
use App\Models\User;
use App\Models\Vod;
use App\Repositories\Vod\VodRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;

class GenerateMasterFile
{
    /**
     * @throws StreamException
     */
    public static function execute(int $userId, string $recordedAt): string
    {
        $variants = VodRepository::getVodByUserIdAndRecordedAt($userId, $recordedAt);

        if ($variants->isEmpty()) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $folder = Carbon::parse($recordedAt)->format('Y-m-d_H-i-s');

        $lines = ["#EXTM3U"];
        foreach ($variants as $v) {
            $quality = $v->quality;
            $lines[] = "#EXT-X-STREAM-INF:BANDWIDTH=1";
            $lines[] = url("/api/vods/{$userId}/{$folder}_{$quality}/index.m3u8");
        }

        return implode("\n", $lines);
    }
}
