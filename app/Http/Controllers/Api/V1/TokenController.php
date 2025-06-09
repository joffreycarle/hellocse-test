<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreTokenRequest;
use App\Models\Administrator;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class TokenController extends Controller
{
    public function store(StoreTokenRequest $request, TokenService $tokenService): JsonResponse
    {
        $token = $tokenService->store($request->toDto());

        if (! $token) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json(['token' => $token], BaseResponse::HTTP_CREATED);
    }

    public function destroy(): Response
    {
        /** @var Administrator $administrator */
        $administrator = auth()->user();

        $administrator->currentAccessToken()->delete();

        return response()->noContent();
    }
}
