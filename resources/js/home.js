import $ from 'jquery';
window.$ = window.jQuery = $;

$(document).ready(function() {
    const userId = localStorage.getItem('userId');
    let allPosts = [];
    let myPosts = [];
    const itemsPerPage = 10;
    const colors = [
        'bg-blue-500', 'bg-green-500', 'bg-red-500', 'bg-yellow-500',
        'bg-purple-500', 'bg-indigo-500', 'bg-pink-500', 'bg-teal-500',
        'bg-orange-500', 'bg-gray-500'
    ];

    function renderPagination(paginationSelector, totalItems, itemsPerPage) {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        let pagination = $(paginationSelector);
        pagination.empty();
        for (let i = 1; i <= totalPages; i++) {
            pagination.append(`<button class="px-3 py-1 bg-gray-300 rounded mx-1" data-page="${i}">${i}</button>`);
        }
    }

    function paginateData(data, page, itemsPerPage) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        return data.slice(start, end);
    }

    function sortPostsByDate(posts) {
        return posts.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
    }

    function fetchPosts() {
        $.ajax({
            url: `http://api_blog_osmarlg.test/api/posts/Active/`,
            method: 'GET',
            success: function(response) {
                allPosts = sortPostsByDate(response.data.posts || response);
                renderPagination('#postsPagination', allPosts.length, itemsPerPage);
                renderPagination('#postsPaginationTop', allPosts.length, itemsPerPage)
                displayPosts(1);
            },
            error: function(error) {
                console.error('Error fetching posts:', error);
            }
        });
    }

    function fetchMyPosts() {
        $.ajax({
            url: `http://api_blog_osmarlg.test/api/myposts/user/${userId}`,
            method: 'GET',
            success: function(response) {
                myPosts = sortPostsByDate(response.data.posts || response);
                renderPagination('#myPostsPagination', myPosts.length, itemsPerPage);
                renderPagination('#myPostsPaginationTop', myPosts.length, itemsPerPage)
                displayMyPosts(1);
            },
            error: function(error) {
                console.error('Error fetching my posts:', error);
            }
        });
    }

    function displayPosts(page) {
        const posts = paginateData(allPosts, page, itemsPerPage);
        let postsList = $('#postsList');
        postsList.empty();
        posts.forEach((post, index) => {
            const color = colors[index % colors.length];
            postsList.append(`
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="${color} h-32"></div>
                    <div class="p-4">
                        <h4 class="text-lg font-bold mb-2">${post.title}</h4>
                        <p class="text-gray-700 mb-2">${post.body}</p>
                        <p class="text-gray-500 text-sm">Author: ${post.author.name}</p>
                        <p class="text-gray-500 text-sm">Created on: ${new Date(post.created_at).toLocaleDateString()}</p>
                        <button class="bg-blue-500 text-white px-2 py-1 mt-2 viewPostBtn" data-id="${post.id}">View</button>
                    </div>
                </div>
            `);
        });
    }

    function displayMyPosts(page) {
        const posts = paginateData(myPosts, page, itemsPerPage);
        let myPostsList = $('#myPostsList');
        myPostsList.empty();
        posts.forEach((post, index) => {
            const color = colors[index % colors.length];
            myPostsList.append(`
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="${color} h-32"></div>
                    <div class="p-4">
                        <h4 class="text-lg font-bold mb-2">${post.title}</h4>
                        <p class="text-gray-700 mb-2">${post.body}</p>
                        <p class="text-gray-700 mb-2">Status: ${post.status}</p>
                        <p class="text-gray-500 text-sm">Created on: ${new Date(post.created_at).toLocaleDateString()}</p>
                        <button class="bg-blue-500 text-white px-2 py-1 mt-2 viewPostBtn" data-id="${post.id}">View</button>
                        <button class="bg-yellow-500 text-white px-2 py-1 mt-2 editPostBtn" data-id="${post.id}">Edit</button>
                        <button class="bg-red-500 text-white px-2 py-1 mt-2 deletePostBtn" data-id="${post.id}">Delete</button>
                    </div>
                </div>
            `);
        });
    }

    function viewPost(postId) {
        $.ajax({
            url: `http://api_blog_osmarlg.test/api/post/${postId}`,
            method: 'GET',
            success: function(response) {
                const post = response.data.post;
                $('#viewPostTitle').text(post.title);
                $('#viewPostBody').text(post.body);
                $('#viewPostAuthor').text(post.author.name);
                $('#viewPostDate').text(`Created on: ${new Date(post.created_at).toLocaleDateString()}`);
                $('#viewPostModal').removeClass('hidden');
                $('#closeViewPostModal').removeClass('hidden').text('X');
            },
            error: function(error) {
                console.error('Error fetching post:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error fetching the post data.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    function fillPostInputs(postId, action) {
        $.ajax({
            url: `http://api_blog_osmarlg.test/api/post/${postId}`,
            method: 'GET',
            success: function(response) {
                const post = response.data.post;
                $('#postTitle').val(post.title);
                $('#postBody').val(post.body);
                if (action === 'edit') {
                    $('#postModalTitle').text('Edit Post');
                    $('#submitPostBtn').addClass('hidden');
                    $('#updatePostBtn').removeClass('hidden').data('id', post.id);
                }
                $('#createPostModal').removeClass('hidden');
                $('#closePostModal').removeClass('hidden').text('X');
            },
            error: function(error) {
                console.error('Error fetching post:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error fetching the post data.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    function deletePost(postId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this post!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `http://api_blog_osmarlg.test/api/post/${postId}`,
                    method: 'DELETE',
                    success: function(response) {
                        Swal.fire('Deleted!', 'Your post has been deleted.', 'success');
                        fetchMyPosts();
                    },
                    error: function(error) {
                        console.error('Error deleting post:', error);
                        Swal.fire('Error!', 'There was an error deleting the post.', 'error');
                    }
                });
            }
        });
    }

    $(document).on('click', '#postsPagination button', function() {
        let page = $(this).data('page');
        displayPosts(page);
    });

    $(document).on('click', '#postsPaginationTop button', function() {
        let page = $(this).data('page');
        displayPosts(page);
    });

    $(document).on('click', '#myPostsPagination button', function() {
        let page = $(this).data('page');
        displayMyPosts(page);
    });

    $(document).on('click', '#myPostsPaginationTop button', function() {
        let page = $(this).data('page');
        displayMyPosts(page);
    });

    $(document).on('click', '.viewPostBtn', function() {
        const postId = $(this).data('id');
        viewPost(postId);
    });

    $(document).on('click', '.editPostBtn', function() {
        const postId = $(this).data('id');
        fillPostInputs(postId, 'edit');
    });

    $(document).on('click', '.deletePostBtn', function() {
        const postId = $(this).data('id');
        deletePost(postId);
    });

    $('#closeViewPostModal').on('click', function() {
        $('#viewPostModal').addClass('hidden');
    });

    fetchPosts();
    if (userId) {
        fetchMyPosts();
    } else {
        $('#createPostBtn').hide();
        $('#myPostsTabContainer').hide();
    }

    $('.tab-link').on('click', function(e) {
        e.preventDefault();
        const tabId = $(this).attr('id');
        
        $('.tab-link').removeClass('active');
        $(this).addClass('active');

        $('.tab-content').hide();
        if (tabId === 'postsTab') {
            $('#postsContent').show();
        } else if (tabId === 'myPostsTab') {
            $('#myPostsContent').show();
        }
    });

    $('#createPostBtn').on('click', function() {
        $('#postModalTitle').text('Create Post');
        $('#submitPostBtn').removeClass('hidden');
        $('#updatePostBtn').addClass('hidden');
        $('#createPostForm')[0].reset();
        $('#createPostModal').removeClass('hidden');
        $('#closePostModal').removeClass('hidden').text('X');
    });

    $('#closePostModal').on('click', function() {
        $('#createPostModal').addClass('hidden');
    });

    $('#submitPostBtn').on('click', function() {
        $('.text-red-500').addClass('hidden').text('');

        const formData = {
            title: $('#postTitle').val(),
            body: $('#postBody').val(),
            user_id: userId
        };

        $.ajax({
            url: 'http://api_blog_osmarlg.test/api/posts',
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Post created successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                $('#createPostModal').addClass('hidden');
                fetchPosts();
                if (userId) {
                    fetchMyPosts();
                }
            },
            error: function(error) {
                const errors = error.responseJSON.errors;
                if (errors) {
                    showErrorMessages(errors);
                } else {
                    console.error('Error creating post:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error creating the post.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
        $('#closePostModal').removeClass('hidden').text('X');
    });

    $('#updatePostBtn').on('click', function() {
        const postId = $(this).data('id');
        $('.text-red-500').addClass('hidden').text('');

        const formData = {
            title: $('#postTitle').val(),
            body: $('#postBody').val(),
            user_id: userId
        };

        $.ajax({
            url: `http://api_blog_osmarlg.test/api/post/${postId}`,
            method: 'PATCH',
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Post updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                $('#createPostModal').addClass('hidden');
                fetchMyPosts();
            },
            error: function(error) {
                const errors = error.responseJSON.errors;
                if (errors) {
                    showErrorMessages(errors);
                } else {
                    console.error('Error updating post:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error updating the post.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
        $('#closePostModal').removeClass('hidden').text('X');
    });

    function showErrorMessages(errors) {
        for (let key in errors) {
            $(`#${key}Error`).removeClass('hidden').text(errors[key][0]);
        }
    }

    $('#postsTab').click();
});
