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
