<?php

namespace App\Actions\Mercure;

use App\Factories\Mercure\MercureTokenFactoryInterface;

class SubscribeJwt
{
    public static function execute(array $topics = ['*']): string
    {
        $factory = app(MercureTokenFactoryInterface::class);
        return $factory->createSubscriberToken($topics);
    }
}
