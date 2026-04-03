<?php

namespace App\Http\Controllers\Api;

use App\Actions\Stream\CreateStream;
use App\Actions\Stream\StartStream;
use App\Actions\Stream\StopStream;
use App\Actions\Vod\CreateVod;
use App\Data\Stream\StreamData;
use App\Data\Vod\VodData;
use App\Enums\StreamStatuses;
use App\Exceptions\StreamException;
use App\Http\Controllers\Controller;
use App\Jobs\CreateVodJob;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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
        $variants = [
            [
                'bandwidth' => 1200000,
                'resolution' => '854x480',
                'url' => url("/api/streams/{$userId}/480p/main_stream.m3u8"),
            ],
            [
                'bandwidth' => 2500000,
                'resolution' => '1280x720',
                'url' => url("/api/streams/{$userId}/720p/main_stream.m3u8"),
            ],
        ];

        $lines = ["#EXTM3U"];
        foreach ($variants as $v) {
            $lines[] = "#EXT-X-STREAM-INF:BANDWIDTH={$v['bandwidth']},RESOLUTION={$v['resolution']}";
            $lines[] = $v['url'];
        }

        return response(implode("\n", $lines), Response::HTTP_OK)
            ->header('Content-Type', 'application/vnd.apple.mpegurl')
            ->header('Cache-Control', 'no-cache');
    }

    public function serve(string $alias, string $quality, string $file = null)
    {
        $streamKey = Cache::remember("stream_key_{$alias}", 3600, function () use ($alias) {
            return User::where('id', $alias)->value('stream_key');
        });

        if ($file === null) {
            $url = "http://mediamtx:8888/live{$quality}/{$streamKey}/main_stream.m3u8";
            $contentType = 'application/vnd.apple.mpegurl';
        } else {
            $url = "http://mediamtx:8888/live{$quality}/{$streamKey}/{$file}";
            $contentType = str_ends_with($file, '.m3u8')
                ? 'application/vnd.apple.mpegurl'
                : 'video/mp2t';
        }

        return response()->stream(function () use ($url) {
            echo Http::get($url)->body();
        }, Response::HTTP_OK, ['Content-Type' => $contentType]);
    }

    /**
     * @throws StreamException
     */
    public function create(Request $request)
    {
        $data = StreamData::fromRequest($request);
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
        $streamKey = $request->input('stream');
        $stream = StartStream::execute($streamKey);

        CreateVodJob::dispatch(
            VodData::make($request->user()->id, $stream, $request)
        );

        return response()->json([]);
    }

    public function stop(Request $request)
    {
        $streamKey = $request->input('stream');

        StopStream::execute($streamKey);

        return response()->json([]);
    }


}
