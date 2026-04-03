<?php

namespace App\Factories\Mercure;

interface MercureTokenFactoryInterface
{
    public function createPublisherToken(): string;
    public function createSubscriberToken(array $topics = ['*']): string;
}
