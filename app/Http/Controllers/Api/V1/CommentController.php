<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCommentRequest;
use App\Http\Resources\Api\V1\CommentResource;
use App\Models\Profile;

class CommentController extends Controller
{
    public function store(Profile $profile, StoreCommentRequest $request): CommentResource
    {
        $comment = $profile->comments()->create([
            'content' => $request->string('content'),
            'administrator_id' => auth()->id(),
        ]);

        return new CommentResource($comment);
    }
}
