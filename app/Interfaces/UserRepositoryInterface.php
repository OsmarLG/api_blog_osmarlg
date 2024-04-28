<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    //
    public function all();
    public function find($id) : ?User;
    public function create(array $data) : User;
    public function update(User $user, array $data): ?User;
    public function patch(User $user, array $data): ?User;
    public function delete($id): bool;
}
