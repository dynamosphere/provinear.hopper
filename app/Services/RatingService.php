<?php

namespace App\Services;

use App\Http\Resources\LikeResource;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use App\Services\API\Rateable;

class RatingService
{
    private LikeService $likeService;

    /**
     * @param LikeService $likeService
     */
    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function rateObject(Rateable $object, $user, array $data)
    {
        $rating = new Rating();
        $rating->comment = $data['comment'];
        $rating->rate = $data['rate'];
        $rating->user_id = $user->user_id;
        if (array_key_exists('parent_id', $data))
            $rating->parent_id = $data['parent_id'];

        $object->ratings()->save($rating);

        return new RatingResource($rating);
    }

    public function updateRating($rating_id, array $data): RatingResource
    {
        $rating = Rating::findorfail($rating_id);
        $rating->update($data);
        return new RatingResource($rating);
    }

    public function deleteRating($rating_id): int
    {
        return Rating::destroy($rating_id);
    }

    public function voteRating($rating_id, $user, $liked): LikeResource
    {
        $rating = Rating::findorfail($rating_id);
        return $this->likeService->likeObject($rating, $user, $liked);
    }

}
