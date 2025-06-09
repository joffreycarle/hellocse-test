<?php

namespace App\Services;

use App\DTOs\StoreTokenDTO;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

class TokenService
{
    public function store(StoreTokenDTO $storeTokenDTO): string|bool
    {
        $user = Administrator::where('email', $storeTokenDTO->email)->first();

        if (! $user || ! Hash::check($storeTokenDTO->password, $user->password)) {
            return false;
        }

        return $user->createToken('API Token')->plainTextToken;
    }
}
