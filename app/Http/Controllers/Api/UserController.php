<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Requests\Users\PatchUserRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\ActivityLog;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        $users = $this->users->all();

        ActivityLog::create([
            'user_id' => 11,
            'action' => 'Get Users',
            'method' => 'GET',
            'description' => 'Get All Users',
            'slug' => '/api/users',
        ]);

        return response()->json([
            'data'    => [
                "users" => UserResource::collection($users)
            ],
            'status'  => 'success',
            'errors'  => null,
        ], 200);
    }

    public function show($id)
    {
        $user = $this->users->find($id);

        ActivityLog::create([
            'user_id' => 11,
            'action' => 'Get User',
            'method' => 'GET',
            'description' => 'Get User with Id: ' . $id,
            'slug' => '/api/user/' . $id,
        ]);

        if ($user) {
            return response()->json([
                'data'    => [
                    "user" => new UserResource($user)
                ],
                'status'  => 'success',
                'errors'  => null,
            ], 200);
        } else {
            return response()->json([
                'data' => [
                    "userID" => $id,
                ],
                'status' => 'error',
                'errors' => "User with ID {$id} not found."
            ], 404);
        }
    }

    public function store(StoreUserRequest $request) {
        $validatedData = $request->validated();
        $user = $this->users->create($validatedData);

        ActivityLog::create([
            'user_id' => 11,
            'action' => 'Create User',
            'method' => 'POST',
            'description' => 'Create User',
            'slug' => '/api/users',
        ]);
        
        return response()->json([
            'data'    => [
                "user" => new UserResource($user)
            ],
            'status'  => 'success',
        ], 201);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->users->find($id);
            if (!$user) {
                return response()->json([
                    'data' => [
                        "userID" => $id,
                    ],
                    'status'  => 'error',
                    'errors'  => "User with ID {$id} not found.",
                ], 404);
            }

            $validatedData = $request->validated();
            $updatedUser = $this->users->update($user, $validatedData);

            ActivityLog::create([
                'user_id' => 11,
                'action' => 'Update User',
                'method' => 'PUT',
                'description' => 'Update User with Id: ' . $id,
                'slug' => '/api/user/' . $id,
            ]);
        
            return response()->json([
                'data'    => [
                    "user" => new UserResource($updatedUser )
                ],
                'status'  => 'success',
                'errors'  => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'data' => [
                    "userID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "User with ID {$id} not found.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    "userID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "An error occurred while updating the user.",
            ], 500);
        }
    }

    public function patch(PatchUserRequest $request, $id)
    {
        try {
            $user = $this->users->find($id);
            if (!$user) {
                return response()->json([
                    'data' => [
                        "userID" => $id,
                    ],
                    'status'  => 'error',
                    'errors'  => "User with ID {$id} not found.",
                ], 404);
            }

            $validatedData = $request->validated();            
            $updatedUser = $this->users->patch($user, $validatedData);

            ActivityLog::create([
                'user_id' => 11,
                'action' => 'Patch User',
                'method' => 'PATCH',
                'description' => 'Patch User with Id: ' . $id,
                'slug' => '/api/user/' . $id,
            ]);

            return response()->json([
                'data'    => new UserResource($updatedUser),
                'status'  => 'success',
                'errors'  => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'data' => [
                    "userID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "User with ID {$id} not found.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    "userID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "An error occurred while patching the user.",
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->users->delete($id);

            ActivityLog::create([
                'user_id' => 11,
                'action' => 'Delete User',
                'method' => 'DESTROY',
                'description' => 'Delete User with Id: ' . $id,
                'slug' => '/api/user/' . $id,
            ]);
    
            return response()->json([
                'data'    => "User with ID: {$id} has been deleted.",
                'status'  => 'success',
                'errors'  => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'data' => [
                    "userID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "User with ID {$id} not found.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    "userID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "Failed to delete the user.",
            ], 500);
        }
    }
}
