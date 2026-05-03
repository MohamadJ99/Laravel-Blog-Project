<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Posts
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
     
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @auth
        <div class="mb-6">
            <a href="{{ route('posts.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded">
                Create Post
            </a>
        </div>
        @endauth

        @forelse($posts as $post)
            <div class="bg-white shadow rounded p-6 mb-4">

                <h3 class="text-lg font-bold">
                    {{ $post->title }}
                </h3>

                <p class="text-gray-700 mt-2">
                    {{ $post->content }}
                </p>

                <p class="text-sm text-gray-500 mt-2">
                    By: {{ $post->user->name }}
                </p>

                <div class="mt-4 flex gap-3">

                  
                    <a href="{{ route('posts.show', $post->slug) }}"
                       class="text-blue-600">
                        View
                    </a>

                   
                    @auth
                        @if(auth()->id() == $post->user_id)

                            <a href="{{ route('posts.edit', $post->slug) }}"
                               class="text-yellow-600">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('posts.publish', $post->slug) }}">
                                @csrf

                                <button type="submit"
                                        class="text-green-600">
                                    Publish
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('posts.destroy', $post->slug) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600"
                                        onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>

                        @endif
                    @endauth

                </div>
            </div>

        @empty
            <div class="bg-white shadow rounded p-6">
                No posts found.
            </div>
        @endforelse

    </div>

</x-app-layout>