import './bootstrap';
import $ from 'jquery';
const Swal = window.Swal;

window.$ = window.jQuery = $;

$(document).ready(function() {
    var token = localStorage.getItem('token');
    var role = localStorage.getItem('role');
    var $homeLink = $('#home-link');
    var $dashboardLink = $('#dashboard-link');
    var $loginLink = $('#login-link');
    var $registerLink = $('#register-link');
    var $logoutButton = $('#logoutButton');

    if (token) {
        $homeLink.show();
        $logoutButton.show();
        $loginLink.hide();
        $registerLink.hide();

        if (role === 'Admin') {
            $dashboardLink.show();
        } else {
            $dashboardLink.hide();
        }
    } else {
        $homeLink.hide();
        $dashboardLink.hide();
        $logoutButton.hide();
        $loginLink.show();
        $registerLink.show();
    }


    if (window.location.pathname === '/admin/dashboard') {
        if (role !== 'Admin') {
            Swal.fire({
                title: 'Access Denied!',
                text: 'You do not have permission to access this page.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'http://api_blog_osmarlg.test/home';
            });
        }
    }
});
