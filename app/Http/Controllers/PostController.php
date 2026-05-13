<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Str;
use App\Events\PostPublished;
use App\Models\PostRevision;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostController extends Controller
{
    use AuthorizesRequests;
    // Create a new post

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', compact('categories', 'tags'));
    }


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

        AuditLog::create([
            'auditable_id' => $post->id,
            'auditable_type' => Post::class,
            'user_id' => $user->id,
            'action' => 'create',
            'old_values' => null,
            'new_values' => json_encode($post->toArray()),
        ]);


        $post->categories()->sync($validated['category_ids']);
        $post->tags()->sync($validated['tag_ids']);

        // return response()->json([
        //     'post' => $post->load(['user', 'categories', 'tags'])
        // ], 201); API

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully');
    }

    // Get all posts
    public function index(Request $request)
    {
        $posts = Post::query()
            ->with(['user', 'categories', 'tags'])
            ->latest()
            ->when(
                $request->category,
                fn($q) =>
                $q->inCategory($request->category)
            )
            ->when(
                $request->tag,
                fn($q) =>
                $q->withTag($request->tag)
            )
            ->paginate(5);

        // return response()->json($posts); API

        return view('posts.index', compact('posts'));
    }

    //
    public function show($slug)
    {
        $post = Post::with(['user', 'categories', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        // return response()->json($post); API

        return view('posts.show', compact('post'));
    }



    public function edit(UpdatePostRequest $request, $slug)
    {
        $post = Post::with(['categories', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        $this->authorize('update', $post);

        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }



    // Update an existing post
    public function update(UpdatePostRequest $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $user = $request->user();

        $this->authorize('update', $post);

        PostRevision::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'title' => $post->title,
            'content' => $post->content,
        ]);

        AuditLog::create([
            'auditable_id' => $post->id,
            'auditable_type' => Post::class,
            'user_id' => $user->id,
            'action' => 'update',
            'old_values' => json_encode($post->toArray()),
            'new_values' => json_encode($request->validated()),
        ]);

        $post->update($request->validated());

        $post->categories()->sync($request->category_ids);
        $post->tags()->sync($request->tag_ids);
        //return response()->json($post); API

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    // Delete a post
    public function destroy(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $user = $request->user();

        $this->authorize('delete', $post);

        AuditLog::create([
            'auditable_id' => $post->id,
            'auditable_type' => Post::class,
            'user_id' => $user->id,
            'action' => 'delete',
            'old_values' => json_encode($post->toArray()),
        ]);

        $post->delete();

        // return response()->json([
        //     'message' => 'Post deleted successfully'
        // ]); API

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully');
    }

    public function publish(Request $request, $slug)
    {
        $post = Post::Where('slug', $slug)->firstOrFail();
        
        $this->authorize('publish', $post);

        PostPublished::dispatch($post);
        // return  response()->json(['message' => 'Post published successfully']); API
        return redirect()
        ->route('posts.index')
        ->with('success', 'Post published successfully');
    }
}
