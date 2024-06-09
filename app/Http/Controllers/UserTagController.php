<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserTagController extends Controller
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
     * Get all Tag objects.
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->tagService->getTags();
    }

    /**
     * Insert a new Tag object.
     */
    public function store(TagRequest $request): TagResource
    {
        return $this->tagService->addTag($request->validated(), $request->user());
    }

    /**
     * Get a Tag object by id
     */
    public function show(string $id): TagResource
    {
        return $this->tagService->getTagById($id);
    }

    /**
     * Update the specified Tag object
     */
    public function update(TagRequest $request, string $id): TagResource
    {
        return $this->tagService->updateTag($id, $request->validated());
    }

    /**
     * Remove the specified Tag object
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        if ($this->tagService->deleteTag($id))
            return response()->json(['message' => 'Product Variation deleted successfully']);
        return response(status: ResponseAlias::HTTP_NOT_FOUND)->json(['message' => 'Deletion failed']);
    }
}
