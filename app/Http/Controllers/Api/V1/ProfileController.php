<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdateProfileRequest;
use App\Http\Resources\Api\V1\ProfileResource;
use App\Models\Profile;
use App\Services\ProfileService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $profiles = Profile::active()->paginate(10);

        return ProfileResource::collection($profiles);
    }

    public function update(UpdateProfileRequest $request, Profile $profile, ProfileService $profileService): JsonResource
    {
        $profileService->updateProfile($profile, $request->toDto());

        return new ProfileResource($profile);
    }

    public function destroy(Profile $profile): Response
    {
        $profile->delete();

        return response()->noContent();
    }
}
