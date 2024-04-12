document.addEventListener('DOMContentLoaded', function () {
    // Check login status when the DOM is fully loaded
    checkLoginStatus();

    // Add event listeners for login and register forms
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();
            submitForm(loginForm, 'php/login.php');
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function (event) {
            event.preventDefault();
            submitForm(registerForm, 'php/register.php');
        });
    }

    // Add event listener for logout button
    const logoutButton = document.getElementById('logout');
    if (logoutButton) {
        logoutButton.addEventListener('click', function () {
            fetch('php/logout.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'index.php'; // Redirect to index.php on successful logout
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }

    // Function to handle form submissions
    function submitForm(form, url) {
        const data = new FormData(form);
        fetch(url, {
            method: 'POST',
            body: data
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    window.location.href = 'profile.php'; // Redirect to profile page on success
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Function to check login status
    function checkLoginStatus() {
        fetch('php/session_check.php')
            .then(response => response.json())
            .then(data => {
                // Redirect to login page if not logged in and not already on the login page
                if (!data.isLoggedIn && !window.location.pathname.endsWith('/login.html') && !window.location.pathname.endsWith('/index.php')) {
                    window.location.href = 'login.html';
                }
            })
            .catch(error => console.error('Error:', error));
    }
});
