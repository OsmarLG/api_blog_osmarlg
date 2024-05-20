$(document).ready(function() {
    $('#formRegister').on('submit', function(e) {
        e.preventDefault();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var name = $('#name').val().trim();
        var username = $('#username').val().trim();
        var email = $('#email').val().trim();
        var password = $('#password').val().trim();
        var password_confirmation = $('#password_confirmation').val().trim();
        var phone = $('#phone').val().trim();

        if (!name || !username || !email || !password || !phone) {
            Swal.fire({
                title: 'Error!',
                text: 'All fields are required.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        var userData = {
            "name": name,
            "username": username,
            "email": email,
            "password": password,
            "password_confirmation": password_confirmation,
            "phone": phone
        };

        $.ajax({
            url: 'http://api_blog_osmarlg.test/auth/register',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(userData),
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Register Successful:', response);
                Swal.fire({
                    title: 'User Registered successfully!',
                    text: 'Wait for Activation',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'http://api_blog_osmarlg.test/home';
                });
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                var errorMessage = response.message;

                if (response.errors) {
                    errorMessage = '';
                    for (var key in response.errors) {
                        errorMessage += response.errors[key].join(' ') + ' ';
                    }
                }

                console.log('Error:', xhr.responseText);
                Swal.fire({
                    title: 'Failed to Register!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });            
            }
        });
    });
});