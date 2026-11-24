<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostReqeust;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request): AnonymousResourceCollection
    {
       $searchTerm = $request->input('search');

       $posts = Post::query();

        if ($searchTerm) {
            $posts->where(function ($query) use ($searchTerm){
              $query->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('category', function ($q) use ($searchTerm){
                        $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });  
        }
        
        $posts = $posts->get();

        // Load the related relationships.
        $posts->load('category', 'user', 'tags');

        return PostResource::collection($posts);
    }

    // Store a newly created resource in storage.
    public function store(StorePostRequest $request): PostResource
    {
        $payload = $request->validated();

        // Get tags from the payload (if provided)
        $tags = $payload['tags'] ?? [];

        // Find or create tags and collect their IDs
        $tagIds = [];

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        
        unset($payload['tags']);

        // Create the post
        $post = Post::create($payload);

        // Link the post and tags in the pivot table using their IDs (Many-to-Many relationship).
        $post->tags()->sync($tagIds);

        return new PostResource($post);
    }

    // Display the specified resource.
    public function show($id): PostResource
    {
        $post = Post::findOrFail($id);

        $post->load('category', 'user', 'tags');

        return new PostResource($post);
    }

    // Update the specified resource in storage.
    public function update(UpdatePostReqeust $request, $id): PostResource
    {
        $post = Post::findOrFail($id);

        $payload = $request->validated();

        if(array_key_exists('tags', $payload)){

         $tags = $payload['tags'];

        // Find or create tags and collect their IDs
        $tagIds = [];

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        // Link the post and tags in the pivot table using their IDs (Many-to-Many relationship).
        $post->tags()->sync($tagIds);

        unset($payload['tags']);
    }
        $post->update($payload);
        
        return new PostResource($post);
    }
    
    // Remove the specified resource from storage.
    public function destroy($id): JsonResponse
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return response()->json(null, 204);    
    }
}
