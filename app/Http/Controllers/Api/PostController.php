<?php

namespace App\Http\Controllers\Api;

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

    public function index()
    {
        $posts = $this->posts->all();

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
