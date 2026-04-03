<?php

namespace App\Actions\Mercure;

use App\DTOs\MercurePublishDto;
use App\Factories\Mercure\MercureTokenFactoryInterface;
use Illuminate\Support\Facades\Http;

class PublishJwt
{
    public static function execute(MercurePublishDTO $dto): void
    {
        $factory = app(MercureTokenFactoryInterface::class);
        $jwt = $factory->createPublisherToken();

        Http::withToken($jwt)
            ->asForm()
            ->post(config('mercure.hub_url'), [
                'topic' => $dto->topic,
                'data'  => json_encode(['message' => $dto->message]),
            ]);
    }
}
