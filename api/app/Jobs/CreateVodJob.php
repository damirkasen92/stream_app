<?php

namespace App\Jobs;

use App\Actions\Vod\CreateVod;
use App\Data\Stream\StartStreamData;
use App\Models\Stream;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreateVodJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly StartStreamData $data,
        private readonly Stream $stream,
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        CreateVod::execute($this->data, $this->stream);
    }
}
