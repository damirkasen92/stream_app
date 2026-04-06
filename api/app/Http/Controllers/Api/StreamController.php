<?php

namespace App\Http\Controllers\Api;

use App\Actions\Stream\CreateStream;
use App\Actions\Stream\GenerateMasterFile;
use App\Actions\Stream\StartStream;
use App\Actions\Stream\StopStream;
use App\Data\Stream\CreateStreamData;
use App\Data\Stream\StartStreamData;
use App\Enums\StreamStatuses;
use App\Exceptions\StreamException;
use App\Http\Controllers\Controller;
use App\Jobs\CreateVodJob;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamController extends Controller
{
    public function index()
    {
        return Stream::with('user')
            ->where('streams.status', StreamStatuses::live)
            ->get();
    }

    public function master(int $userId)
    {
        return response(GenerateMasterFile::execute($userId), Response::HTTP_OK)
            ->header('Content-Type', 'application/vnd.apple.mpegurl')
            ->header('Cache-Control', 'no-cache');
    }

    public function serve(int $userId, string $quality, ?string $segment = null)
    {
        $stream = Redis::hgetall("stream:{$userId}");
        $realKey = $stream['stream_key'];
        $date = $stream['started_at'];
        $basePath = "/recordings/{$realKey}/{$date}_{$quality}";

        if (!$realKey) abort(Response::HTTP_NOT_FOUND);

        if ($segment === null) {
            $path = public_path("$basePath/index.m3u8");
        } else {
            $path = public_path("$basePath/{$segment}");
        }

        if (!file_exists($path)) abort(Response::HTTP_NOT_FOUND);

        return new StreamedResponse(function () use ($path) {
            $handle = fopen($path, 'rb');
            fpassthru($handle);
            fclose($handle);
        }, Response::HTTP_OK, [
            'Content-Type' => 'application/vnd.apple.mpegurl',
            'Cache-Control' => 'no-cache'
        ]);
    }

    /**
     * @throws StreamException
     */
    public function create(Request $request)
    {
        $data = CreateStreamData::fromRequest($request);
        $stream = CreateStream::execute($data);

        return response()->json([
            'title' => $stream->title,
            'description' => $stream->description,
            'stream_key' => $request->user()->stream_key,
            'user_id' => $request->user()->id,
        ]);
    }

    /**
     * @throws StreamException
     */
    public function start(Request $request)
    {
        $data = StartStreamData::fromRequest($request);
        $stream = StartStream::execute($data);

        CreateVodJob::dispatch(
            $data,
            $stream
        );

        return response()->json([]);
    }

    public function stop(Request $request)
    {
        $streamKey = $request->input('stream');

        StopStream::execute($streamKey);

        return response()->json([]);
    }

    public function info(Request $request)
    {
        $streamKey = $request->query('stream');

        if ($streamKey === null) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $userId = User::where('stream_key', $streamKey)->firstOrFail()->value('id');
        return Redis::hgetall("stream:{$userId}")['started_at'];
    }
}
