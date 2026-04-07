<?php

namespace App\Models;

use App\Enums\StreamStatuses;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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

    protected function startedAt(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Carbon::createFromFormat('Y-m-d_H-i-s', $value)->toDateTimeString(),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vods(): HasMany
    {
        return $this->hasMany(Vod::class);
    }

    public function scopeLiveByUser(Builder $query, int $userId): Builder
    {
        return $query->where([
            'user_id' => $userId,
            'status' => StreamStatuses::live,
        ])->orderBy('id', 'desc');
    }
}
