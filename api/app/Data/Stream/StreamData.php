<?php

namespace App\Data\Stream;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class StreamData extends Data
{
    public function __construct(
        #[Required]
        public int $user_id,

        #[Required, Min(1), Max(255), Unique('streams', 'title')]
        public string $title,

        public string|Optional $description,
    )
    {}

    public static function fromRequest(Request $request): self
    {
        return self::validateAndCreate([
            'user_id' => $request->user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description', ''),
        ]);
    }
}
