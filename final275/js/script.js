document.addEventListener('DOMContentLoaded', function() {
    // Functions declaration
    function checkLoginStatus() {
        fetch('php/sessions_check.php')
            .then(response => response.json())
            .then(data => {
                if (!data.isLoggedIn && !window.location.pathname.endsWith('/login.html') && !window.location.pathname.endsWith('/index.php')) {
                    window.location.href = 'login.html';
                }
            })
            .catch(error => console.error('Error checking session:', error));
    }

    function submitForm(form, url) {
        const data = new FormData(form);
        fetch(url, {
            method: 'POST',
            body: data
        })
        .then(response => response.json()) // This will fail if the response is empty or not proper JSON
        .then(data => {
            console.log("Form submission response:", data);
            if (data.success) {
                window.location.href = 'profile.php'; // Redirect to profile page on success
            } else {
                throw new Error(data.message); // Assuming the server sends back an error message
            }
        })
        .catch(error => {
            console.error('Form submission error:', error);
            alert('Error submitting form: ' + error.message);
        });
    } 

    function loadProfiles() {
        fetch('php/fetch_profiles.php')
            .then(response => response.json())
            .then(profiles => {
                const container = document.querySelector('.profile-feed');
                container.innerHTML = ''; // Clear existing content
                profiles.forEach(profile => {
                    container.innerHTML += `
                        <div class="profile-card">
                            <img src="${profile.image_url}" alt="Profile picture">
                            <div class="profile-info">
                                <h2>${profile.name}</h2>
                                <p>${profile.bio}</p>
                                <ul class="skills-list">${profile.skills.map(skill => `<li>${skill}</li>`).join('')}</ul>
                            </div>
                        </div>
                    `;
                });
            })
            .catch(error => console.error('Error loading profiles:', error));
    }

    function updateProfile(event) {
        event.preventDefault(); // Prevent form submission from reloading the page
        var formData = new FormData(document.getElementById('profileForm'));

        fetch('php/update_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                window.location.reload(); // Reload page to see updates
            }
        })
        .catch(error => console.error('Error updating profile:', error));
    }

    // Check login status when the DOM is fully loaded
    checkLoginStatus();

    // Load profiles when 'Load Profiles' button is clicked
    const loadProfilesButton = document.getElementById('loadProfiles');
    if (loadProfilesButton) {
        loadProfilesButton.addEventListener('click', loadProfiles);
    }

    // Add event listeners for form submissions
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const profileForm = document.getElementById('profileForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            submitForm(loginForm, 'php/login.php');
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            event.preventDefault();
            submitForm(registerForm, 'php/register.php');
        });
    }

    if (profileForm) {
        profileForm.addEventListener('submit', updateProfile);
    }

    // Add event listener for logout button
    const logoutButton = document.getElementById('logout');
    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            fetch('php/logout.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'index.php'; // Redirect to home on logout
                    }
                })
                .catch(error => console.error('Error logging out:', error));
        });
    }
});
