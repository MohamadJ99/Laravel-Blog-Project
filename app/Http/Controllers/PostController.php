<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

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
            "user_id" => $user->id
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post
        ], 201);
    }

    // Get all posts
    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(5);

        return response()->json([
            'message' => 'Posts retrieved successfully',
            'data' => $posts
        ]);
    }

    // Get a single post by ID
    public function show($id)
    {
        $post = Post::with('user')->find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Post retrieved successfully',
            'data' => $post
        ]);
    }

    // Update an existing post
    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $user = $request->user();

        if ($post->user_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validated();

        $post->update($validated);

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post
        ]);
    }

    // Delete a post
    public function destroy(Request $request,$id)
    {
        $post = Post::findOrFail($id);
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