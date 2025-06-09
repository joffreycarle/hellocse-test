<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

final readonly class UpdateProfileDTO
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $status,
        public ?UploadedFile $image = null,
    ) {}
}
