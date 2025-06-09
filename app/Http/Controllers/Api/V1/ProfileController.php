<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $profiles = Profile::active()->paginate(10);

        return ProfileResource::collection($profiles);
    }

    public function destroy(Profile $profile): Response
    {
        $profile->delete();

        return response()->noContent();
    }
}
