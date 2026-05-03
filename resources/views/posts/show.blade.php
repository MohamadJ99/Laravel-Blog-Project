<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Post Details
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow rounded p-6">

            {{-- Title --}}
            <h1 class="text-2xl font-bold mb-4">
                {{ $post->title }}
            </h1>

            {{-- Content --}}
            <p class="text-gray-700 mb-6">
                {{ $post->content }}
            </p>

            {{-- Author --}}
            <div class="mb-4">
                <strong>Author:</strong>
                {{ $post->user->name }}
            </div>

            {{-- Categories --}}
            <div class="mb-4">
                <strong>Categories:</strong>

                @forelse($post->categories as $category)
                    <span class="px-2 py-1 bg-gray-200 rounded text-sm">
                        {{ $category->name }}
                    </span>
                @empty
                    <span>No categories</span>
                @endforelse
            </div>

            {{-- Tags --}}
            <div class="mb-6">
                <strong>Tags:</strong>

                @forelse($post->tags as $tag)
                    <span class="px-2 py-1 bg-blue-100 rounded text-sm">
                        {{ $tag->name }}
                    </span>
                @empty
                    <span>No tags</span>
                @endforelse
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3">

                <a
                    href="{{ route('posts.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded"
                >
                    Back
                </a>

                   
            </div>

        </div>

    </div>

</x-app-layout> 
