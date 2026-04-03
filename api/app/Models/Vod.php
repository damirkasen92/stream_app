<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vod extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'path',
        'quality',
        'recorded_at',
        'stream_id',
    ];

    public $timestamps = false;

    public function stream(): BelongsTo
    {
        return $this->belongsTo(Stream::class);
    }
}
