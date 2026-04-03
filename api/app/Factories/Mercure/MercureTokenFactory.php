<?php

namespace App\Factories\Mercure;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class MercureTokenFactory implements MercureTokenFactoryInterface
{
    private Configuration $config;

    public function __construct(string $mercureJwtToken)
    {
        $this->config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($mercureJwtToken)
        );
    }

    public function createPublisherToken(): string
    {
        $now = new \DateTimeImmutable();

        return $this->config->builder()
            ->issuedAt($now)
            ->withClaim('mercure', ['publish' => ['*']])
            ->getToken($this->config->signer(), $this->config->signingKey())
            ->toString();
    }

    public function createSubscriberToken(array $topics = ['*']): string
    {
        $now = new \DateTimeImmutable();

        return $this->config->builder()
            ->issuedAt($now)
            ->withClaim('mercure', ['subscribe' => $topics])
            ->getToken($this->config->signer(), $this->config->signingKey())
            ->toString();
    }

}
