<?php

namespace App\Interfaces;

use App\Models\Post;

interface PostRepositoryInterface
{
    //
    public function all($status = null);
    public function allForUser($id);
    public function find($id) : ?Post;
    public function create(array $data) : Post;
    public function update($id, array $data): ?Post;
    public function patch($id, array $data): ?Post;
    public function delete($id): bool;
}
