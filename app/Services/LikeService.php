<?php

namespace App\Services;

use App\Http\Resources\LikeResource;
use App\Models\Like;
use App\Services\API\Likable;

class LikeService
{
    public function likeObject(Likable $object, $user, bool $liked)
    {
        $like = new Like();
        $like->liked = $liked;
        $like->user_id = $user->user_id;

        $object->likes()->save($like);

        return new LikeResource($like);
    }
    public function updateLikedObject($like_id, bool $liked): LikeResource
    {
        $like = Like::findorfail($like_id);
        $like->liked = $liked;
        $like->save();

        return new LikeResource($like);
    }

    public function removeLikeOnObject($like_id): int
    {
        return Like::destroy($like_id);
    }
}
