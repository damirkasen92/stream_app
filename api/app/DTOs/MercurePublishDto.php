<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class MercurePublishDto
{
    public function __construct(public string $topic, public string $message)
    {
    }

    public static function make(string $topic, string $message): self
    {
        return new self($topic, $message);
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->topic, $request->message
        );
    }
}
