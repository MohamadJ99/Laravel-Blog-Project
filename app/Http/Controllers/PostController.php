<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // Create a new post
    function store(StorePostRequest $request)
{
    $user = $request->user();
    $validated = $request->validated();

    $post = Post::create([
        "title" => $validated['title'],
        "content" => $validated['content'],
        "slug" => Str::slug($validated['title']), 
        "user_id" => $user->id
    ]);

    
    $post->categories()->sync($validated['category_ids']);
    $post->tags()->sync($validated['tag_ids']);

    return response()->json([
        'post' => $post->load(['user', 'categories', 'tags'])
    ], 201);
}

    // Get all posts
  public function index(Request $request)
{
    $posts = Post::query()
        ->with(['user', 'categories', 'tags'])
        ->latest()
        ->when($request->category, fn($q) =>
            $q->inCategory($request->category)
        )
        ->when($request->tag, fn($q) =>
            $q->withTag($request->tag)
        )
        ->paginate(5);

    return response()->json($posts);
}

    //
   public function show($slug)
{
    $post = Post::with(['user', 'categories', 'tags'])
        ->where('slug', $slug)
        ->firstOrFail();

    return response()->json($post);
}

    // Update an existing post
    public function update(UpdatePostRequest $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $user = $request->user();

        if ($post->user_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

         $post->update($request->validated());
         
         $post->categories()->sync($request->category_ids);
         $post->tags()->sync($request->tag_ids);
        return response()->json($post);
    }

    // Delete a post
    public function destroy(Request $request,$slug)
    {
        $post=Post::where('slug',$slug)->firstOrFail();
        $user = $request->user();

        if ($post->user_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }
}