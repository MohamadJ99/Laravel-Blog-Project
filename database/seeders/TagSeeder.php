<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'API Development', 'slug' => 'api-development'],
            ['name' => 'Startups', 'slug' => 'startups'],
            ['name' => 'Marketing', 'slug' => 'marketing'],
            ['name' => 'Fitness', 'slug' => 'fitness'],
            ['name' => 'Nutrition', 'slug' => 'nutrition'],
            ['name' => 'E-Learning', 'slug' => 'e-learning'],
            ['name' => 'Programming', 'slug' => 'programming'],
            ['name' => 'Football', 'slug' => 'football'],
            ['name' => 'Training', 'slug' => 'training'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}