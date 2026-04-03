<?php

namespace App\Jobs;

use App\Actions\Vod\CreateVod;
use App\Data\Vod\VodData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreateVodJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly VodData $dto)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        CreateVod::execute($this->dto);
    }
}
