<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');
        $posts = $response->json();

        foreach ($posts as $post) {
            Post::create([
                'title' => $post['title'],
                'body' => $post['body'],
                'status' => 'Active',
                'user_id' => $post['userId'],
            ]);
        }
    }
}
