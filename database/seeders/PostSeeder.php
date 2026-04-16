<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); 

        $categories = Category::all();
        $tags = Tag::all();

        $posts = [
            [
                'title' => 'Getting Started with Laravel',
                'content' => 'Laravel is a powerful PHP framework...'
            ],
            [
                'title' => 'REST API Best Practices',
                'content' => 'APIs should be clean and scalable...'
            ],
            [
                'title' => 'Frontend vs Backend Development',
                'content' => 'Understanding both sides is important...'
            ],
        ];

        foreach ($posts as $postData) {

            $post = Post::create([
                'title' => $postData['title'],
                'content' => $postData['content'],
                'slug' => Str::slug($postData['title']),
                'user_id' => $user->id,
            ]);

            
            $post->categories()->sync(
                $categories->random(2)->pluck('id')->toArray()
            );

          
            $post->tags()->sync(
                $tags->random(3)->pluck('id')->toArray()
            );
        }
    }
}