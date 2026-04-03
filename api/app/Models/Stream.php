<?php

namespace App\Models;

use App\Enums\StreamStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stream extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'ended_at',
        'status',
        'started_at',
        'created_at',
    ];

    public $timestamps = false;

    public $casts = [
        'started_at' => 'datetime',
        'created_at' => 'datetime',
        'ended_at' => 'datetime',
        'status' => StreamStatuses::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vods(): HasMany
    {
        return $this->hasMany(Vod::class);
    }
}
