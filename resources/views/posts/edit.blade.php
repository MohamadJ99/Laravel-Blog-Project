<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Post
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">

            <form method="POST" action="{{ route('posts.update', $post->slug) }}">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">
                        Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $post->title) }}"
                        class="w-full border rounded px-3 py-2 mt-1"
                    >
                </div>

                {{-- Content --}}
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">
                        Content
                    </label>

                    <textarea
                        name="content"
                        rows="6"
                        class="w-full border rounded px-3 py-2 mt-1"
                    >{{ old('content', $post->content) }}</textarea>
                </div>

                {{-- Categories --}}
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">
                        Categories
                    </label>

                    <select
                        name="category_ids[]"
                        multiple
                        class="w-full border rounded px-3 py-2 mt-1"
                    >
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ $post->categories->contains($category->id) ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tags --}}
                <div class="mb-6">
                    <label class="block font-medium text-sm text-gray-700">
                        Tags
                    </label>

                    <select
                        name="tag_ids[]"
                        multiple
                        class="w-full border rounded px-3 py-2 mt-1"
                    >
                        @foreach ($tags as $tag)
                            <option
                                value="{{ $tag->id }}"
                                {{ $post->tags->contains($tag->id) ? 'selected' : '' }}
                            >
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3">

                    <button
                        type="submit"
                        class="px-4 py-2 bg-yellow-600 text-white rounded"
                    >
                        Update Post
                    </button>

                    <a
                        href="{{ route('posts.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded"
                    >
                        Cancel
                    </a>

                </div>
            </form>

        </div>
    </div>

</x-app-layout>