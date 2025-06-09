<?php

namespace App\DTOs;

final readonly class StoreTokenDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
