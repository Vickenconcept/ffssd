<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::create([
            'post_id' => 1,
            'author' => 'John Doe',
            'content' => 'This is a comment on the first blog post.',
            'approved' => true,
        ]);
        
        Comment::create([
            'post_id' => 1,
            'author' => 'John Doe',
            'content' => 'This is a comment on the second blog post.',
            'approved' => true,
        ]);
    }
}
