$(document).ready(function() {
    $('#logoutButton').on('click', function() {
        logout();
    });
});

function logout() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: 'http://api_blog_osmarlg.test/auth/logout',
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token'),
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            console.log('Logout Successful:', response);
            localStorage.removeItem('token');
            localStorage.removeItem('role');
            localStorage.removeItem('userId');
            window.location.href = '/auth/login';
        },
        error: function(xhr, status, error) {
            var errorMessage = JSON.parse(xhr.responseText).message;
            console.log('Error:', errorMessage);
            Swal.fire({
                title: 'Failed to logout!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}