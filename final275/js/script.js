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
        const data = new FormData(form);
        fetch(url, { // url is relative to the root
            method: 'POST',
            body: data
        })
        .then(handleResponse)
        .then(data => {
            if (data.success) {
                window.location.href = 'profile.php'; // Redirect to profile page on success
            } else {
                alert(data.message || 'An error occurred.');
            }
        })
        .catch(error => {
            console.error('Form submission error:', error);
            alert('Error submitting form: ' + error.message);
        });
    }

    // Function to load profiles
    function loadProfiles() {
        fetch('php/fetch_profiles.php') // Relative to the root
            .then(handleResponse)
            .then(profiles => {
                const container = document.querySelector('.profile-feed');
                container.innerHTML = ''; // Clear existing content
                profiles.forEach(profile => {
                    // Build the profile card HTML and append to the container
                    // Note: Ensure profile data structure matches your actual data
                    container.innerHTML += `
                        <div class="profile-card">
                            <img src="${profile.image_url}" alt="Profile picture">
                            <div class="profile-info">
                                <h2>${profile.name}</h2>
                                <p>${profile.bio}</p>
                                <ul class="skills-list">
                                    ${profile.skills.map(skill => `<li>${skill}</li>`).join('')}
                                </ul>
                            </div>
                        </div>
                    `;
                });
            })
            .catch(error => console.error('Error loading profiles:', error));
    }

    // Function to update profile
    function updateProfile(event) {
        event.preventDefault(); // Prevent form submission from reloading the page
        var formData = new FormData(document.getElementById('profileForm'));
        fetch('php/update_profile.php', { // Relative to the root
            method: 'POST',
            body: formData
        })
        .then(handleResponse)
        .then(data => {
            if (data.success) {
                window.location.reload(); // Reload page to see updates
            } else {
                alert(data.message || 'An error occurred.');
            }
        })
        .catch(error => console.error('Error updating profile:', error));
    }

    // Add event listeners for form submissions
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const profileForm = document.getElementById('profileForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            submitForm(loginForm, 'php/login.php'); // Relative to the root
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            event.preventDefault();
            submitForm(registerForm, 'php/register.php'); // Relative to the root
        });
    }

    if (profileForm) {
        profileForm.addEventListener('submit', updateProfile); // Profile update is handled by updateProfile function
    }

    // Add event listener for logout button
    const logoutButton = document.getElementById('logout');
    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            fetch('php/logout.php') // Relative to the root
                .then(handleResponse)
                .then(data => {
                    if (data.success) {
                        window.location.href = 'index.php'; // Redirect to home on logout
                    }
                })
                .catch(error => console.error('Error logging out:', error));
        });
    }

    // Load profiles if we're on the index page where the profiles should be displayed
    if (window.location.pathname.endsWith('/index.php') || window.location.pathname === '/') {
        loadProfiles();
    }

    // Check login status when the DOM is fully loaded
    checkLoginStatus();
});
