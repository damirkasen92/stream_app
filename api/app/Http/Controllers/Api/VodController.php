<?php

namespace App\Http\Controllers\Api;

use App\Actions\Shared\GetPathType;
use App\Actions\Vod\GenerateMasterFile;
use App\Actions\Vod\GenerateVodPath;
use App\Exceptions\StreamException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vod;
use App\Repositories\Vod\VodRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VodController extends Controller
{
    public function index()
    {
        $vods = VodRepository::getGroupedVods();

        return response()->json($vods);
    }

    /**
     * @throws StreamException
     */
    public function master(int $userId, string $recordedAt)
    {
        $masterFile = GenerateMasterFile::execute($userId, $recordedAt);
        $realKey = User::where('id', $userId)->value('stream_key');

        Redis::hmset("vod:{$userId}", [
            'user_id' => $userId,
            'real_key' => $realKey,
        ]);

        return response($masterFile, Response::HTTP_OK)
            ->header('Content-Type', 'application/vnd.apple.mpegurl')
            ->header('Cache-Control', 'no-cache');
    }

    public function serve(int $userId, string $path, ?string $segment = null)
    {
        $vod = Redis::hgetall("vod:{$userId}");
        // TODO $vod dto
        $vodPath = GenerateVodPath::execute($vod, $path, $segment);
        $type = GetPathType::execute($vodPath);

        return new StreamedResponse(function () use ($vodPath) {
            $handle = fopen($vodPath, 'rb');
            fpassthru($handle);
            fclose($handle);
        }, Response::HTTP_OK, [
            'Content-Type' => $type,
            'Cache-Control' => 'no-cache',
        ]);
    }
}
