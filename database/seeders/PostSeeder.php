<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author =  User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Post::create([
            'title' => 'First Blog Post',
            'content' => 'This is the content of the first blog post.',
            'excerpt' => 'This is the summary of the first blog post.',
            'featured_image' => 'post1.jpg',
            'author_id' => $author->id, 
            'publish_date' => now(),
            'meta_description' => 'A short description of the first blog post.',
            'cta_text' => 'Read More',
            'cta_url' => '/blog/first-blog-post',
        ]);

        Post::create([
            'title' => 'Second Blog Post',
            'content' => 'This is the content of the second blog post.',
            'excerpt' => 'This is the summary of the second blog post.',
            'featured_image' => 'post1.jpg',
            'author_id' => $author->id, 
            'publish_date' => now(),
            'meta_description' => 'A short description of the second blog post.',
            'cta_text' => 'Read More',
            'cta_url' => '/blog/second-blog-post',
        ]);
    }
}
