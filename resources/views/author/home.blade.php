@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="w-full max-w-7xl mx-auto mt-5">
    <h3 class="mb-5 font-bold text-gray-800 text-2xl text-center">Home</h3>
    
    <!-- Tabs -->
    <div class="mb-4">
        <ul class="flex border-b justify-center">
            <li class="mr-1">
                <a id="postsTab" class="tab-link bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" href="#">Posts</a>
            </li>
            <li class="mr-1" id="myPostsTabContainer">
                <a id="myPostsTab" class="tab-link bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" href="#">My Posts</a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <button id="createPostBtn" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Create Post</button>
    <div id="postsContent" class="tab-content">
        <div id="postsPaginationTop" class="mb-4"></div>
        <div id="postsList" class="space-y-4">
            <!-- Posts will be dynamically inserted here -->
        </div>
        <div id="postsPagination" class="mt-4"></div>
    </div>

    <div id="myPostsContent" class="tab-content hidden">
        <div id="myPostsPaginationTop" class="mb-4"></div>
        <div id="myPostsList" class="space-y-4">
            <!-- My Posts will be dynamically inserted here -->
        </div>
        <div id="myPostsPagination" class="mt-4"></div>
    </div>

    <!-- Modal for creating/editing a post -->
    <div id="createPostModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden overflow-auto">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">
            <div class="sticky top-0 bg-white p-4 z-10 flex justify-between items-center mb-4">
                <h4 id="postModalTitle" class="text-xl">Create Post</h4>
                <button id="closePostModal" class="text-red-500"><span>X</span></button>
            </div>
            <form id="createPostForm" class="grid grid-cols-1 gap-4">
                <div class="mb-4">
                    <label for="postTitle" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="postTitle" name="postTitle" placeholder="Enter post title" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                    <p id="postTitleError" class="text-red-500 text-sm mt-1 hidden"></p>
                </div><br>
                <div class="mb-4">
                    <label for="postBody" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea id="postBody" style="height: 300px;" name="postBody" placeholder="Enter post content" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm"></textarea>
                    <p id="postBodyError" class="text-red-500 text-sm mt-1 hidden"></p>
                </div>
                <div class="flex justify-end col-span-2">
                    <button type="button" id="submitPostBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
                    <button type="button" id="updatePostBtn" class="bg-blue-500 text-white px-4 py-2 rounded hidden">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for viewing a post -->
    <div id="viewPostModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden overflow-auto">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">
            <div class="sticky top-0 bg-white p-4 z-10 flex justify-between items-center mb-4">
                <h4 id="viewPostTitle" class="text-xl">View Post</h4>
                <button id="closeViewPostModal" class="text-red-500"><span>X</span></button>
            </div>
            <div class="p-4">
                <p id="viewPostBody" class="text-gray-700 mb-2"></p>
                <p id="viewPostAuthor" class="text-gray-500 text-sm"></p>
                <p id="viewPostDate" class="text-gray-500 text-sm"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@vite(['resources/js/home.js'])
@endsection
