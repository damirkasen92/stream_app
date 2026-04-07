<?php

namespace App\Repositories\Vod;

use App\Exceptions\StreamException;
use App\Models\Vod;
use Illuminate\Support\Collection;

class VodRepository
{
    /**
     * @return Collection<Vod>
     * @throws StreamException
     */
    public static function getVodByUserIdAndRecordedAt(int $userId, string $recordedAt): Collection
    {
        return Vod::query()
            ->select(['quality'])
            ->where([
                'user_id' => $userId,
                'recorded_at' => $recordedAt,
            ])
            ->orderBy('quality')
            ->get();
    }

    /**
     * @return Collection<Vod>
     */
    public static function getGroupedVods(): Collection
    {
        return Vod::query()
            ->select([
                'user_id',
                'stream_id',
                'title',
                'recorded_at',
            ])
            ->groupBy('user_id', 'stream_id', 'title', 'recorded_at')
            ->orderByDesc('recorded_at')
            ->limit(50)
            ->get();
    }
}
