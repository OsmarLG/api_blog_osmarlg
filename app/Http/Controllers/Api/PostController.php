<?php

namespace App\Http\Controllers\Api;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Interfaces\PostRepositoryInterface;
use App\Http\Requests\Posts\PatchPostRequest;
use App\Http\Requests\Posts\StorePostRequest;

class PostController extends Controller
{
    //
    protected $posts;

    public function __construct(PostRepositoryInterface $posts)
    {
        $this->posts = $posts;
    }

    public function index($status = null, $userId = null)
    {
        $posts = $this->posts->all($status);

        if ($status == null && $userId != null) {
            ActivityLog::create([
                'user_id' => $userId,
                'action' => 'Get Posts',
                'method' => 'GET',
                'description' => 'Get All Posts',
                'slug' => '/api/posts',
            ]);
        }
        if ($userId != null) {
            ActivityLog::create([
                'user_id' => $userId,
                'action' => 'Get Posts',
                'method' => 'GET',
                'description' => 'Get All Posts',
                'slug' => '/api/posts',
            ]);
        } else {
            ActivityLog::create([
                'user_id' => $userId ?? 11,
                'action' => 'Get Posts',
                'method' => 'GET',
                'description' => 'Get All Posts',
                'slug' => '/api/posts',
            ]);
        }


        return response()->json([
            'data'    => [
                "posts" => PostResource::collection($posts)
            ],
            'status'  => 'success',
            'errors'  => null,
        ], 200);
    }

    public function indexUser($id)
    {
        $posts = $this->posts->allForUser($id);

        ActivityLog::create([
            'user_id' => $id,
            'action' => 'Get Posts',
            'method' => 'GET',
            'description' => 'Get All Posts for user: ' .$id,
            'slug' => '/api/myposts/user/'.$id,
        ]);

        return response()->json([
            'data'    => [
                "posts" => PostResource::collection($posts)
            ],
            'status'  => 'success',
            'errors'  => null,
        ], 200);
    }

    public function show($id)
    {
        $post = $this->posts->find($id);

        if ($post) {
            ActivityLog::create([
                'action' => 'Get Post',
                'method' => 'GET',
                'description' => 'Get Post with Id: ' .$id,
                'slug' => '/api/post/'.$id,
            ]);

            return response()->json([
                'data'    => [
                    "post" => new PostResource($post)
                ],
                'status'  => 'success',
                'errors'  => null,
            ], 200);
        } else {
            return response()->json([
                'data' => [
                    "postID" => $id,
                ],
                'status' => 'error',
                'errors' => "Post with ID {$id} not found."
            ], 404);
        }
    }

    public function store(StorePostRequest $request) {
        $validatedData = $request->validated();
        $post = $this->posts->create($validatedData);

        ActivityLog::create([
            'user_id' => $request['user_id'],
            'action' => 'Create Post',
            'method' => 'POST',
            'description' => 'Create Post',
            'slug' => '/api/post',
        ]);
        
        return response()->json([
            'data'    => [
                "post" => new PostResource($post)
            ],
            'status'  => 'success',
        ], 201);
    }

    public function update(StorePostRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $post = $this->posts->update($id, $validatedData);

            ActivityLog::create([
                'user_id' => $request['user_id'],
                'action' => 'Update Post',
                'method' => 'PUT',
                'description' => 'Update Post with id: ' . $id,
                'slug' => '/api/post/'.$id,
            ]);
        
            return response()->json([
                'data'    => [
                    "post" => new PostResource($post)
                ],
                'status'  => 'success',
                'errors'  => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'data' => [
                    "postID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "Post with ID {$id} not found.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    "postID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "An error occurred while updating the post.",
            ], 500);
        }
    }

    public function patch(PatchPostRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            
            $post = $this->posts->patch($id, $validatedData);

            if ($request['user_id']){
                ActivityLog::create([
                    'user_id' => $request['user_id'],
                    'action' => 'Patch Post',
                    'method' => 'PATCH',
                    'description' => 'Patch Post with id: ' . $id,
                    'slug' => '/api/post',
                ]);
            } else {
                ActivityLog::create([
                    'action' => 'Patch Post',
                    'method' => 'PATCH',
                    'description' => 'Patch Post with id: ' . $id,
                    'slug' => '/api/post/'.$id,
                ]);
            }

            return response()->json([
                'data'    => new PostResource($post),
                'status'  => 'success',
                'errors'  => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'data' => [
                    "postID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "Post with ID {$id} not found.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    "postID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "An error occurred while patching the post.",
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->posts->delete($id);

            ActivityLog::create([
                'action' => 'Delete Post',
                'method' => 'DESTROY',
                'description' => 'Delete Post with id: ' . $id,
                'slug' => '/api/post/'.$id,
            ]);
    
            return response()->json([
                'data'    => "Post with ID: {$id} has been deleted.",
                'status'  => 'success',
                'errors'  => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'data' => [
                    "postID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "Post with ID {$id} not found.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    "postID" => $id,
                ],
                'status'  => 'error',
                'errors'  => "Failed to delete the post.",
            ], 500);
        }
    }
}
