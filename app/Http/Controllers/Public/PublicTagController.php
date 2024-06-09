<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PublicTagController extends Controller
{
    private TagService $tagService;

    /**
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->tagService->getTags();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): TagResource
    {
        return $this->tagService->getTagById($id);
    }
}
