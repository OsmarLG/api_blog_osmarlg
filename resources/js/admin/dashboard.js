import $ from 'jquery';
window.$ = window.jQuery = $;

$(document).ready(function() {
    let allUsers = [];
    let filteredUsers = [];
    let allPosts = [];
    let filteredPosts = [];
    let allActivityLogs = [];
    const itemsPerPage = 10;

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

    function sortDataByDate(data) {
        return data.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
    }

    function fetchUsers() {
        $.ajax({
            url: 'http://api_blog_osmarlg.test/api/users',
            method: 'GET',
            success: function(response) {
                allUsers = response.data.users || response;
                filteredUsers = allUsers;
                renderPagination('#usersPagination', filteredUsers.length, itemsPerPage);
                displayUsers(1);
            },
            error: function(error) {
                console.error('Error fetching users:', error);
            }
        });
    }

    function fetchPosts() {
        $.ajax({
            url: 'http://api_blog_osmarlg.test/api/posts',
            method: 'GET',
            success: function(response) {
                allPosts = sortDataByDate(response.data.posts || response);
                filteredPosts = allPosts;
                renderPagination('#postsPagination', filteredPosts.length, itemsPerPage);
                displayPosts(1);
            },
            error: function(error) {
                console.error('Error fetching posts:', error);
            }
        });
    }

    function fetchActivityLogs() {
        $.ajax({
            url: 'http://api_blog_osmarlg.test/api/activities',
            method: 'GET',
            success: function(response) {
                allActivityLogs = sortDataByDate(response);
                renderPagination('#activityLogsPagination', allActivityLogs.length, itemsPerPage);
                displayActivityLogs(1);
            },
            error: function(error) {
                console.error('Error fetching activity logs:', error);
            }
        });
    }

    function displayUsers(page) {
        const users = paginateData(filteredUsers, page, itemsPerPage);
        let usersTableBody = $('#usersTableBody');
        usersTableBody.empty();
        users.forEach(user => {
            usersTableBody.append(`
                <tr>
                    <td class="border px-4 py-2">${user.id}</td>
                    <td class="border px-4 py-2">${user.name}</td>
                    <td class="border px-4 py-2">${user.username}</td>
                    <td class="border px-4 py-2">${user.email}</td>
                    <td class="border px-4 py-2">${user.status}</td>
                    <td class="border px-4 py-2">
                        <button class="bg-blue-500 text-white px-2 py-1 viewUserBtn" data-id="${user.id}">View</button>
                        <button class="bg-yellow-500 text-white px-2 py-1 editUserBtn" data-id="${user.id}">Edit</button>
                        <button class="bg-red-500 text-white px-2 py-1 deleteUserBtn" data-id="${user.id}">Delete</button>
                    </td>
                </tr>
            `);
        });
    }

    function displayPosts(page) {
        const posts = paginateData(filteredPosts, page, itemsPerPage);
        let postsTableBody = $('#postsTableBody');
        postsTableBody.empty();
        posts.forEach(post => {
            postsTableBody.append(`
                <tr>
                    <td class="border px-4 py-2">${post.id}</td>
                    <td class="border px-4 py-2">${post.title}</td>
                    <td class="border px-4 py-2">${post.body}</td>
                    <td class="border px-4 py-2">${post.author.name}</td>
                    <td class="border px-4 py-2">${post.status}</td>
                    <td class="border px-4 py-2">
                        <button class="bg-blue-500 text-white px-2 py-1 viewPostBtn" data-id="${post.id}">View</button>
                        <button class="bg-yellow-500 text-white px-2 py-1 editPostBtn" data-id="${post.id}">Edit</button>
                        <button class="bg-red-500 text-white px-2 py-1 deletePostBtn" data-id="${post.id}">Delete</button>
                    </td>
                </tr>
            `);
        });
    }

    function displayActivityLogs(page) {
        const logs = paginateData(allActivityLogs, page, itemsPerPage);
        let activityLogsTableBody = $('#activityLogsTableBody');
        activityLogsTableBody.empty();
        logs.forEach(log => {
            activityLogsTableBody.append(`
                <tr>
                    <td class="border px-4 py-2">${log.action}</td>
                    <td class="border px-4 py-2">${log.user_id || 'Guest'}</td>
                    <td class="border px-4 py-2">${log.description}</td>
                    <td class="border px-4 py-2">${new Date(log.created_at).toLocaleString()}</td>
                </tr>
            `);
        });
    }

    function filterUsers(status) {
        if (status === 'all') {
            filteredUsers = allUsers;
        } else {
            filteredUsers = allUsers.filter(user => user.status === status);
        }
        renderPagination('#usersPagination', filteredUsers.length, itemsPerPage);
        displayUsers(1);
    }

    function filterPosts(status) {
        if (status === 'all') {
            filteredPosts = allPosts;
        } else {
            filteredPosts = allPosts.filter(post => post.status === status);
        }
        renderPagination('#postsPagination', filteredPosts.length, itemsPerPage);
        displayPosts(1);
    }

    $(document).on('click', '#usersPagination button', function() {
        let page = $(this).data('page');
        displayUsers(page);
    });

    $(document).on('click', '#postsPagination button', function() {
        let page = $(this).data('page');
        displayPosts(page);
    });

    $(document).on('click', '#activityLogsPagination button', function() {
        let page = $(this).data('page');
        displayActivityLogs(page);
    });

    $('#userStatusFilter').on('change', function() {
        const selectedStatus = $(this).val();
        filterUsers(selectedStatus);
    });

    $('#postStatusFilter').on('change', function() {
        const selectedStatus = $(this).val();
        filterPosts(selectedStatus);
    });

    fetchUsers();
    fetchPosts();
    fetchActivityLogs();

    $('.tab-link').on('click', function(e) {
        e.preventDefault();
        const tabId = $(this).attr('id');
        
        $('.tab-link').removeClass('active');
        $(this).addClass('active');

        $('.tab-content').hide();
        if (tabId === 'usersTab') {
            $('#usersContent').show();
        } else if (tabId === 'postsTab') {
            $('#postsContent').show();
        } else if (tabId === 'activityLogsTab') {
            $('#activityLogsContent').show();
        }
    });

    $('#createUserBtn').on('click', function() {
        $('#modalTitle').text('Create User');
        $('#submitUserBtn').removeClass('hidden');
        $('#updateUserBtn').addClass('hidden');
        $('#deleteUserBtn').addClass('hidden');
        $('#createUserForm')[0].reset();
        $('#createUserForm input, #createUserForm select').prop('disabled', false);
        $('#createUserModal').removeClass('hidden');
        $('#closeUserModal').removeClass('hidden').text('X');
    });

    $('#createPostBtn').on('click', function() {
        $('#postModalTitle').text('Create Post');
        $('#submitPostBtn').removeClass('hidden');
        $('#updatePostBtn').addClass('hidden');
        $('#deletePostBtn').addClass('hidden');
        $('#createPostForm')[0].reset();
        $('#createPostForm input, #createPostForm textarea').prop('disabled', false);
        $('#postAuthor').prop('disabled', false);
        $('#statusPost').prop('disabled', false);
        $('#createPostModal').removeClass('hidden');
        $('#closePostModal').removeClass('hidden').text('X');
        fetchAuthors();
        resetStatusPost();
    });

    $('#closeUserModal').on('click', function() {
        $('#createUserModal').addClass('hidden');
    });

    $('#closePostModal').on('click', function() {
        $('#createPostModal').addClass('hidden');
    });

    function showErrorMessages(errors) {
        for (let key in errors) {
            $(`#${key}Error`).removeClass('hidden').text(errors[key][0]);
        }
    }

    function resetUserModal() {
        $('#modalTitle').text('');
        $('#submitUserBtn').addClass('hidden');
        $('#updateUserBtn').addClass('hidden');
        $('#deleteUserBtn').addClass('hidden');
        $('#createUserForm')[0].reset();
        $('#createUserForm input, #createUserForm select').prop('disabled', false);
        $('.text-red-500').addClass('hidden').text('');
        $('#closeUserModal').removeClass('hidden').text('X');
    }

    function resetPostModal() {
        $('#postModalTitle').text('');
        $('#submitPostBtn').addClass('hidden');
        $('#updatePostBtn').addClass('hidden');
        $('#deletePostBtn').addClass('hidden');
        $('#createPostForm')[0].reset();
        $('#createPostForm input, #createPostForm textarea').prop('disabled', false);
        $('.text-red-500').addClass('hidden').text('');
        $('#closePostModal').removeClass('hidden').text('X');
        resetStatusPost();
    }

    function resetStatusPost() {
        $('#statusPost').html(`
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        `);
    }

    $('#submitUserBtn').on('click', function() {
        $('.text-red-500').addClass('hidden').text('');

        const formData = {
            name: $('#name').val(),
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
            address: JSON.stringify({
                street: $('#street').val(),
                suite: $('#suite').val(),
                city: $('#city').val(),
                zipcode: $('#zipcode').val(),
                geo: {
                    lat: $('#lat').val(),
                    lng: $('#lng').val()
                }
            }),
            phone: $('#phone').val(),
            website: $('#website').val(),
            company: JSON.stringify({
                name: $('#companyName').val(),
                catchPhrase: $('#catchPhrase').val(),
                bs: $('#bs').val()
            }),
            status: $('#status').val()
        };

        $.ajax({
            url: 'http://api_blog_osmarlg.test/api/users',
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'User created successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                $('#createUserModal').addClass('hidden');
                fetchUsers();
            },
            error: function(error) {
                const errors = error.responseJSON.errors;
                if (errors) {
                    showErrorMessages(errors);
                } else {
                    console.error('Error creating user:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error creating the user.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
        $('#closeUserModal').removeClass('hidden').text('X');
    });

    $('#submitPostBtn').on('click', function() {
        $('.text-red-500').addClass('hidden').text('');

        const formData = {
            title: $('#postTitle').val(),
            body: $('#postBody').val(),
            user_id: $('#postAuthor').val(),
            status: $('#statusPost').val()
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

    $(document).on('click', '.editUserBtn', function() {
        const userId = $(this).data('id');
        fillUserInputs(userId, 'edit');
    });

    $(document).on('click', '.editPostBtn', function() {
        const postId = $(this).data('id');
        fillPostInputs(postId, 'edit');
    });

    $('#updateUserBtn').on('click', function() {
        const userId = $(this).data('id');
        $('.text-red-500').addClass('hidden').text('');

        const formData = {
            name: $('#name').val(),
            username: $('#username').val(),
            email: $('#email').val(),
            address: JSON.stringify({
                street: $('#street').val(),
                suite: $('#suite').val(),
                city: $('#city').val(),
                zipcode: $('#zipcode').val(),
                geo: {
                    lat: $('#lat').val(),
                    lng: $('#lng').val()
                }
            }),
            phone: $('#phone').val(),
            website: $('#website').val(),
            company: JSON.stringify({
                name: $('#companyName').val(),
                catchPhrase: $('#catchPhrase').val(),
                bs: $('#bs').val()
            }),
            status: $('#status').val()
        };

        $.ajax({
            url: `http://api_blog_osmarlg.test/api/user/${userId}`,
            method: 'PATCH',
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'User updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                $('#createUserModal').addClass('hidden');
                fetchUsers();
            },
            error: function(error) {
                const errors = error.responseJSON.errors;
                if (errors) {
                    showErrorMessages(errors);
                } else {
                    console.error('Error updating user:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error updating the user.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
        $('#closeUserModal').removeClass('hidden').text('X');
    });

    $('#updatePostBtn').on('click', function() {
        const postId = $(this).data('id');
        $('.text-red-500').addClass('hidden').text('');

        const formData = {
            title: $('#postTitle').val(),
            body: $('#postBody').val(),
            user_id: $('#postAuthor').val(),
            status: $('#statusPost').val()
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
                fetchPosts();
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

    $(document).on('click', '.viewUserBtn', function() {
        const userId = $(this).data('id');
        fillUserInputs(userId, 'view');
    });

    $(document).on('click', '.viewPostBtn', function() {
        const postId = $(this).data('id');
        fillPostInputs(postId, 'view');
    });

    $(document).on('click', '.deleteUserBtn', function() {
        const userId = $(this).data('id');
        fillUserInputs(userId, 'delete');
    });

    $(document).on('click', '.deletePostBtn', function() {
        const postId = $(this).data('id');
        fillPostInputs(postId, 'delete');
    });

    $('#deleteUserBtn').on('click', function() {
        const userId = $(this).data('id');
        $.ajax({
            url: `http://api_blog_osmarlg.test/api/user/${userId}`,
            method: 'DELETE',
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'User deleted successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                $('#createUserModal').addClass('hidden');
                fetchUsers();
            },
            error: function(error) {
                console.error('Error deleting user:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error deleting the user.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
        $('#closeUserModal').removeClass('hidden').text('X');
    });

    $('#deletePostBtn').on('click', function() {
        const postId = $(this).data('id');
        $.ajax({
            url: `http://api_blog_osmarlg.test/api/post/${postId}`,
            method: 'DELETE',
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Post deleted successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                $('#createPostModal').addClass('hidden');
                fetchPosts();
            },
            error: function(error) {
                console.error('Error deleting post:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error deleting the post.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
        $('#closePostModal').removeClass('hidden').text('X');
    });
});

function fillUserInputs(userId, action) {
    $.ajax({
        url: `http://api_blog_osmarlg.test/api/user/${userId}`,
        method: 'GET',
        success: function(response) {
            const user = response.data.user;
            $('#name').val(user.name);
            $('#username').val(user.username);
            $('#email').val(user.email);
            $('#phone').val(user.phone);
            $('#website').val(user.website);
            const address = user.address || {};
            const geo = address.geo || {};
            $('#street').val(address.street || '');
            $('#suite').val(address.suite || '');
            $('#city').val(address.city || '');
            $('#zipcode').val(address.zipcode || '');
            $('#lat').val(geo.lat || '');
            $('#lng').val(geo.lng || '');
            const company = user.company || {};
            $('#companyName').val(company.name || '');
            $('#catchPhrase').val(company.catchPhrase || '');
            $('#bs').val(company.bs || '');
            $('#status').val(user.status || '');
            $('#createUserForm input, #createUserForm select').prop('disabled', action === 'view');

            if (action === 'edit') {
                $('#modalTitle').text('Edit User');
                $('#submitUserBtn').addClass('hidden');
                $('#updateUserBtn').removeClass('hidden').data('id', user.id);
                $('#deleteUserBtn').addClass('hidden');
            } else if (action === 'view') {
                $('#modalTitle').text('View User');
                $('#submitUserBtn').addClass('hidden');
                $('#updateUserBtn').addClass('hidden');
                $('#deleteUserBtn').addClass('hidden');
            } else if (action === 'delete') {
                $('#modalTitle').text('Delete User');
                $('#submitUserBtn').addClass('hidden');
                $('#updateUserBtn').addClass('hidden');
                $('#deleteUserBtn').removeClass('hidden').data('id', user.id);
            }

            $('#createUserModal').removeClass('hidden');
            $('#closeUserModal').removeClass('hidden').text('X');
        },
        error: function(error) {
            console.error('Error fetching user:', error);
            Swal.fire({
                title: 'Error!',
                text: 'There was an error fetching the user data.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            $('#closeUserModal').removeClass('hidden').text('X');
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
            $('#statusPost').val(post.status || '');
            
            if (action === 'edit') {
                fetchAuthors(post.author.id).then(() => {
                    $('#postModalTitle').text('Edit Post');
                    $('#submitPostBtn').addClass('hidden');
                    $('#updatePostBtn').removeClass('hidden').data('id', post.id);
                    $('#deletePostBtn').addClass('hidden');
                    $('#createPostForm input, #createPostForm textarea').prop('disabled', false);
                    $('#statusPost').prop('disabled', false);
                    $('#postAuthor').prop('disabled', false);
                });
            } else if (action === 'view') {
                $('#postModalTitle').text('View Post');
                $('#submitPostBtn').addClass('hidden');
                $('#updatePostBtn').addClass('hidden');
                $('#deletePostBtn').addClass('hidden');
                $('#postAuthor').html(`<option value="${post.author.id}">${post.author.name}</option>`);
                $('#statusPost').html(`
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                `);
                $('#statusPost').val(post.status || '');
                $('#statusPost').prop('disabled', true);
                $('#postAuthor').prop('disabled', true);
                $('#createPostForm input, #createPostForm textarea').prop('disabled', true);
            } else if (action === 'delete') {
                fetchAuthors(post.author.id).then(() => {
                    $('#postModalTitle').text('Delete Post');
                    $('#submitPostBtn').addClass('hidden');
                    $('#updatePostBtn').addClass('hidden');
                    $('#deletePostBtn').removeClass('hidden').data('id', post.id);
                    $('#createPostForm input, #createPostForm textarea').prop('disabled', false);
                });
                $('#statusPost').prop('disabled', true);
                $('#postAuthor').prop('disabled', true);
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
            $('#closePostModal').removeClass('hidden').text('X');
        }
    });
}

function fetchAuthors(selectedAuthorId = null) {
    return $.ajax({
        url: 'http://api_blog_osmarlg.test/api/users',
        method: 'GET',
        success: function(response) {
            const users = response.data.users || response;
            let options = '<option value="">Select Author</option>';
            users.forEach(user => {
                options += `<option value="${user.id}">${user.name}</option>`;
            });
            $('#postAuthor').html(options);
            if (selectedAuthorId) {
                $('#postAuthor').val(selectedAuthorId);
            }
        },
        error: function(error) {
            console.error('Error fetching authors:', error);
        }
    });
}
