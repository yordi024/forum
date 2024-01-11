<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $posts = Post::factory(200)->recycle($users)->create();

        $comments = Comment::factory(100)->recycle($users)->recycle($posts)->create();

        $admin = User::factory()
            ->has(Post::factory(45))
            ->has(Comment::factory(10)->recycle($posts))
            ->create([
                'name' => 'Jhon Doe',
                'email' => 'test@example.com'
            ]);
    }
}
