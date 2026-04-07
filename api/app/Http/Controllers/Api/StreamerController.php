<?php

namespace App\Http\Controllers\Api;

use App\Enums\StreamStatuses;
use App\Http\Controllers\Controller;
use App\Models\User;

class StreamerController extends Controller
{
    public function index()
    {
        // TODO repo
        return User::query()
            ->select(['id', 'name', 'avatar_url'])
            ->withWhereHas('streams', function ($query) {
                $query->where('status', StreamStatuses::live)
                    ->orderByDesc('started_at');
            })
            ->orderBy('name')
            ->get();
    }
}
