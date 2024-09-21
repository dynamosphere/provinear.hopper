<?php

namespace App\Services;

use App\Http\Resources\TagResource;
use App\Models\Enums\TaggableObject;
use App\Models\Tag;
use App\Services\API\Taggable;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class TagService
{

    public function addTag($data, $user): TagResource
    {
        if ($user != null) {
            $data['owner_id'] = $user->user_id;
        }

        return new TagResource(Tag::create($data));
    }

    public function getTags(): AnonymousResourceCollection
    {
        return TagResource::collection(Tag::all());
    }

    public function getTagById($tag_id): TagResource
    {
        return new TagResource(Tag::findorfail($tag_id));
    }

    public function updateTag($tag_id, array $data): TagResource
    {

        $tag = Tag::findorfail($tag_id);
        return new TagResource($tag->update($data));
    }

    public function deleteTag($tag_id): int
    {
        return Tag::destroy($tag_id);
    }

    public function tagObjectById($tag_id, $object_id, TaggableObject $object_type): bool
    {
        return DB::table('object_tag')->insert([
            'object_type' => $object_type->name,
            'object_id' => $object_id,
            'tag_id' => $tag_id
        ]);
    }

    public function tagObject(Taggable $object, array $tag_ids): true
    {
        $tags = array_map(function($id) {return Tag::findorfail($id);}, $tag_ids);
        $object->tags()->saveMany($tags);
        return true;
    }

    public function untagObjectById($tag_id, $object_id, TaggableObject $object_type): int
    {
        return DB::table('object_tag')->delete([
            'object_type' => $object_type->name,
            'object_id'     => $object_id,
            'tag_id'        => $tag_id
        ]);
    }

    public function untagObject(Taggable $object, $tag_id): true
    {
        $tag = Tag::findorfail($tag_id);
        $object->tags()->detach($tag);
        return true;
    }
}
