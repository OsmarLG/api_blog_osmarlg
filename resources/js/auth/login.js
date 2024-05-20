$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        var username = $('#username').val().trim();
        var password = $('#password').val().trim();

        if (!username) {
            Swal.fire({
                title: 'Error!',
                text: 'Username field required.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        if (!password) {
            Swal.fire({
                title: 'Error!',
                text: 'Password field required.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        $.ajax({
            url: 'http://api_blog_osmarlg.test/auth/login',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                username: username,
                password: password
            }),
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Login Successful:', response);
                localStorage.setItem('token', response.token);
                localStorage.setItem('role', response.role);
                localStorage.setItem('userId', response.userId);
                routeUserBasedOnRole(response.role);
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).message;
                console.log('Error:', errorMessage);
                Swal.fire({
                    title: 'Failed to login!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});

function routeUserBasedOnRole(role) {
    if (role === 'Admin') {
        window.location.href = 'http://api_blog_osmarlg.test/admin/dashboard';
    } else if (role === 'Author') {
        window.location.href = '/home';
    }
}

$.ajaxSetup({
    beforeSend: function(xhr) {
        var token = localStorage.getItem('token');
        if (token) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
    }
});