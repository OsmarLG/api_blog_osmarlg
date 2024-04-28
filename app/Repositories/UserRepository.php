<?php

namespace App\Repositories;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
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
        return User::with('roles')->get();
    }

    public function find($id) : ?User
    {
        return User::with('roles')->find($id);
    }

    public function create(array $data) : User
    {
        $user = User::create($data);
        
        $roleName = $data['role'] ?? 'Author';
        $role = Role::findByName($roleName, 'web');
        $user->assignRole($role);

        return $user;
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);

        if (isset($data['role'])) {
            $user->syncRoles($data['role']);
        }

        return $user;
    }

    public function patch(User $user, array $data) : ?User
    {
        $user->update(array_filter($data));
        return $user;
    }

    public function delete($id) : bool
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }
}
