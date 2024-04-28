<?php

namespace App\Repositories;

use App\Models\Post;
use App\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function all()
    {
        return Post::with('user')->get();
    }

    public function find($id) : ?Post
    {
        return Post::with('user')->find($id);
    }

    public function create(array $data) : Post
    {
        return Post::create($data);
    }

    public function update($id, array $data) : ?Post
    {
        $post = Post::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function patch($id, array $data) : ?Post
    {
        $post = Post::findOrFail($id);
        $post->update(array_filter($data));
        return $post;
    }

    public function delete($id) : bool
    {
        $post = Post::findOrFail($id);
        return $post->delete();
    }
}
