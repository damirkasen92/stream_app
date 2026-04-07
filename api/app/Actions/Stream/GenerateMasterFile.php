<?php

namespace App\Actions\Stream;

class GenerateMasterFile
{
    public static function execute(int $userId): string
    {
        $baseUrl = '/api/streams/' . $userId;
        $variants = [
            [
                'bandwidth' => 1200000,
                'resolution' => '854x480',
                'url' => url($baseUrl . '/480p/index.m3u8'),
            ],
            [
                'bandwidth' => 2500000,
                'resolution' => '1280x720',
                'url' => url($baseUrl . '/720p/index.m3u8'),
            ],
        ];

        $lines = ["#EXTM3U"];
        foreach ($variants as $v) {
            $lines[] = "#EXT-X-STREAM-INF:BANDWIDTH={$v['bandwidth']},RESOLUTION={$v['resolution']}";
            $lines[] = $v['url'];
        }

        return implode("\n", $lines);
    }
}
