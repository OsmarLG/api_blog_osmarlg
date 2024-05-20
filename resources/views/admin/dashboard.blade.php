@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="w-full max-w-7xl mx-auto">
    <h3 class="mb-5 font-bold text-gray-800 text-2xl text-center">Dashboard</h3>

    <div class="tabs">
        <ul class="tab-links flex justify-center mb-4 border-b">
            <li class="tab-link active" id="usersTab">
                <a href="#" class="inline-block py-2 px-4">Users</a>
            </li>
            <li class="tab-link" id="postsTab">
                <a href="#" class="inline-block py-2 px-4">Posts</a>
            </li>
            <li class="tab-link" id="activityLogsTab">
                <a href="#" class="inline-block py-2 px-4">Activity Logs</a>
            </li>
        </ul>
    </div>

    <div id="usersContent" class="tab-content active">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-xl">Users</h4>
            <div>
                <select id="userStatusFilter" class="bg-gray-200 p-2 rounded">
                    <option value="all">All</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <button id="createUserBtn" class="bg-green-500 text-white px-4 py-2 rounded">Create User</button>
            </div>
        </div>
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <div id="usersPagination" class="flex justify-center mt-4"></div>
                <tr>
                    <th class="w-1/9 px-4 py-2">ID</th>
                    <th class="w-1/4 px-4 py-2">Name</th>
                    <th class="w-1/7 px-4 py-2">Username</th>
                    <th class="w-1/4 px-4 py-2">Email</th>
                    <th class="w-1/9 px-4 py-2">Status</th>
                    <th class="w-1/9 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                <!-- User rows will be appended here-->
            </tbody>
            <tfoot class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/9 px-4 py-2">ID</th>
                    <th class="w-1/4 px-4 py-2">Name</th>
                    <th class="w-1/7 px-4 py-2">Username</th>
                    <th class="w-1/4 px-4 py-2">Email</th>
                    <th class="w-1/9 px-4 py-2">Status</th>
                    <th class="w-1/9 px-4 py-2">Actions</th>
                </tr>
                <div id="usersPagination" class="flex justify-center mt-4"></div>
            </tfoot>
        </table>
    </div>

    <div id="postsContent" class="tab-content">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-xl">Posts</h4>
            <div>
                <select id="postStatusFilter" class="bg-gray-200 p-2 rounded">
                    <option value="all">All</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <button id="createPostBtn" class="bg-green-500 text-white px-4 py-2 rounded">Create Post</button>
            </div>
        </div>
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <div id="postsPagination" class="flex justify-center mt-4"></div>
                <tr>
                    <th class="w-1/9 px-4 py-2">ID</th>
                    <th class="w-1/4 px-4 py-2">Title</th>
                    <th class="w-1/3 px-4 py-2">Body</th>
                    <th class="w-1/6 px-4 py-2">Author</th>
                    <th class="w-1/9 px-4 py-2">Status</th>
                    <th class="w-1/2 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="postsTableBody">
                <!-- Post rows will be appended here -->
            </tbody>
            <tfoot class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/9 px-4 py-2">ID</th>
                    <th class="w-1/4 px-4 py-2">Title</th>
                    <th class="w-1/3 px-4 py-2">Body</th>
                    <th class="w-1/6 px-4 py-2">Author</th>
                    <th class="w-1/9 px-4 py-2">Status</th>
                    <th class="w-1/2 px-4 py-2">Actions</th>
                </tr>
                <div id="postsPagination" class="flex justify-center mt-4"></div>
            </tfoot>
        </table>
    </div>

    <div id="activityLogsContent" class="tab-content hidden">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-xl">Activity Logs</h4>
        </div>
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <div id="activityLogsPagination" class="flex justify-center mt-4"></div>
                <tr>
                    <th class="w-1/6 px-4 py-2">Action</th>
                    <th class="w-1/4 px-4 py-2">User</th>
                    <th class="w-1/3 px-4 py-2">Description</th>
                    <th class="w-1/6 px-4 py-2">Timestamp</th>
                </tr>
            </thead>
            <tbody id="activityLogsTableBody">
                <!-- Activity log rows will be appended here -->
            </tbody>
            <tfoot class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/6 px-4 py-2">Action</th>
                    <th class="w-1/4 px-4 py-2">User</th>
                    <th class="w-1/3 px-4 py-2">Description</th>
                    <th class="w-1/6 px-4 py-2">Timestamp</th>
                </tr>
                <div id="activityLogsPagination" class="flex justify-center mt-4"></div>
            </tfoot>
        </table>
    </div>
</div>

<!-- Users Modal -->
<div id="createUserModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl h-full max-h-screen overflow-y-auto">
        <div class="sticky top-0 bg-white p-4 z-10 flex justify-between items-center mb-4">
            <h4 id="modalTitle" class="text-xl">Create User</h4>
            <button id="closeUserModal" class="text-red-500"><span>X</span></button>
        </div>
        <form id="createUserForm" class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                <p id="nameError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                <p id="usernameError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                <p id="emailError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                <p id="passwordError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" id="phone" name="phone" placeholder="Enter your phone number" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                <p id="phoneError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4">
                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                <input type="text" id="website" name="website" placeholder="Enter your website URL" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                <p id="websiteError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4 col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" id="street" name="street" placeholder="Street" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                    <input type="text" id="suite" name="suite" placeholder="Suite" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                    <input type="text" id="city" name="city" placeholder="City" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                    <input type="text" id="zipcode" name="zipcode" placeholder="Zipcode" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                    <input type="text" id="lat" name="lat" placeholder="Latitude" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                    <input type="text" id="lng" name="lng" placeholder="Longitude" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                </div>
                <p id="addressError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4 col-span-2">
                <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                <div class="grid grid-cols-3 gap-4">
                    <input type="text" id="companyName" name="companyName" placeholder="Company Name" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                    <input type="text" id="catchPhrase" name="catchPhrase" placeholder="Catch Phrase" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                    <input type="text" id="bs" name="bs" placeholder="BS" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                </div>
                <p id="companyError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4 col-span-2">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <p id="statusError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="flex justify-end col-span-2">
                <button type="button" id="submitUserBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
                <button type="button" id="updateUserBtn" class="bg-blue-500 text-white px-4 py-2 rounded hidden">Update</button>
                <button type="button" id="deleteUserBtn" class="bg-red-500 text-white px-4 py-2 rounded hidden">Confirm Delete</button>
            </div>
        </form>
    </div>
</div>

<!-- Posts Modal -->
<div id="createPostModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl h-full max-h-screen overflow-y-auto">
        <div class="sticky top-0 bg-white p-4 z-10 flex justify-between items-center mb-4">
            <h4 id="postModalTitle" class="text-xl">Create Post</h4>
            <button id="closePostModal" class="text-red-500"><span>X</span></button>
        </div>
        <form id="createPostForm" class="grid grid-cols-1 gap-4">
            <div class="mb-4">
                <label for="postTitle" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="postTitle" name="postTitle" placeholder="Enter post title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p id="postTitleError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div><br>
            <div class="mb-4">
                <label for="postBody" class="block text-sm font-medium text-gray-700">Body</label>
                <textarea id="postBody" name="postBody" style="height: 300px;" placeholder="Enter post body" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                <p id="postBodyError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div><br>
            <div class="mb-4">
                <label for="postAuthor" class="block text-sm font-medium text-gray-700">Author</label>
                <select id="postAuthor" name="postAuthor" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></select>
                <p id="postAuthorError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="mb-4 col-span-2">
                <label for="statusPost" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="statusPost" name="statusPost" class="mt-1 block w-full px-2 py-1 border border-1 border-gray-300 rounded-md shadow-sm">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <p id="statusPostError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="flex justify-end col-span-2">
                <button type="button" id="submitPostBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
                <button type="button" id="updatePostBtn" class="bg-blue-500 text-white px-4 py-2 rounded hidden">Update</button>
                <button type="button" id="deletePostBtn" class="bg-red-500 text-white px-4 py-2 rounded hidden">Confirm Delete</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
@vite(['resources/js/admin/dashboard.js'])
@endsection
