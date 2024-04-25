document.addEventListener('DOMContentLoaded', function() {
    // Helper function to handle fetch responses
    function handleResponse(response) {
        if (!response.ok) {
            throw Error(response.statusText);
        }
        return response.json();
    }

    // Function to check login status
    function checkLoginStatus() {
        fetch('php/session_check.php') // Relative to the root
            .then(handleResponse)
            .then(data => {
                // Redirect to login if not logged in and not on the login page
                if (!data.isLoggedIn && !window.location.pathname.endsWith('/login.html')) {
                    window.location.href = 'login.html';
                }
            })
            .catch(error => console.error('Error checking session:', error));
    }

    // Function to submit forms
    function submitForm(form, url) {
        event.preventDefault();  
        const data = new FormData(form);
        console.log("Form data ready to send to", url); 

        fetch(url, { // url is relative to the root
            method: 'POST',
            body: data
        })
        .then(handleResponse)
        .then(data => {
            console.log("Received data:", data);
            if (data.success) {
                console.log("Redirecting to profile.php");
                window.location.href = 'profile.php';
            } else {
                alert(data.message || 'An error occurred.');
            }
        })
        .catch(error => {
            console.error('Form submission error:', error);
            alert('Error submitting form: ' + error.message);
        });
    }

    // Function to update profile
    function updateProfile(event) {
    //    event.preventDefault(); // Prevent form submission from reloading the page
        var formData = new FormData(document.getElementById('profileForm'));
       // Logging FormData contents
    for (var pair of formData.entries()) {
        console.log(pair[0]+ ', ' + pair[1]); 
    }

    console.log('Form Data:', formData);
        fetch('php/update_profiles.php', { // Relative to the root
           method: 'POST',
            body: formData
        })
        .then(handleResponse)
       .then(data => {
        console.log("Received response:", data);
           if (data.success) {
    //            window.location.reload(); // Reload page to see updates
           } else {
                alert(data.message || 'An error occurred.');
            }
        })
        .catch(error => {
            console.error('Error updating profile:', error);
            alert('Error updating profile: ' + error.message);
        });
    }

    // Add event listeners for form submissions
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const profileForm = document.getElementById('profileForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            console.log("Login form submission intercepted.");
            event.preventDefault();
            submitForm(this, 'php/login.php');
        });
    }
    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            console.log("Register form submission intercepted.");
            event.preventDefault();
            submitForm(this, 'php/register.php');
        });
    }

    if (profileForm) {
        profileForm.addEventListener('submit', updateProfile); // Profile update is handled by updateProfile function
    }

    // Add event listener for logout button
    const logoutButton = document.getElementById('logout');
if (logoutButton) {
    logoutButton.addEventListener('click', function(event) {
        event.preventDefault(); // Stop the button from causing a page reload
        fetch('php/logout.php', { method: 'POST', credentials: 'include' })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = 'login.html'; // Redirect to login page
                } else {
                    alert('Logout failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error during logout:', error);
                alert('Error logging out: ' + error.toString());
            });
    });
}
    // Load profiles if we're on the index page where the profiles should be displayed
    if (window.location.pathname.endsWith('/index.php') || window.location.pathname === '/') {
        loadProfiles();
    }

    // Check login status when the DOM is fully loaded
    checkLoginStatus();
});
