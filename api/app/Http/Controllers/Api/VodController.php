<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VodController extends Controller
{
    public function index()
    {
        $files = Storage::disk('vod')->files();

        $vods = collect($files)->map(function ($file) {
            return [
                'name' => basename($file),
                'url' => Storage::disk('vod')->url($file),
                'size' => Storage::disk('vod')->size($file),
                'last_modified' => Storage::disk('vod')->lastModified($file),
            ];
        });
        return response()->json($vods);
    }
}
