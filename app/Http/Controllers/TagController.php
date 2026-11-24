<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    // Display a listing of the resource.
    public function index(): AnonymousResourceCollection
    {
        $tags = Tag::all();

        return TagResource::collection($tags);
    }
    
    // Store a newly created resource in storage.
    public function store(StoreTagRequest $request): TagResource
    {
        $tag = Tag::create($request->validated());

        return new TagResource($tag);
    }

    // Display the specified resource.
    public function show($id): TagResource
    {
        $tag = Tag::findOrFail($id);

        return new TagResource($tag);
    }

    // Update the specified resource in storage.
    public function update(UpdateTagRequest $request, $id): TagResource
    {
        $tag = Tag::findOrFail($id);

        $tag->update($request->validated());

        return new TagResource($tag);
    }

    // Remove the specified resource from storage.
    public function destroy($id): JsonResponse
    {
        $tag = Tag::findOrFail($id);

        $tag->delete();

        return response()->json(null, 204);
    }
}
