<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.html'); // Redirect to login page if not logged in
    exit;
}

// Load user details from JSON
$file_path = 'data/users.json';
$users = json_decode(file_get_contents($file_path), true);
$userDetails = [];

// Find the user details for the logged-in user
foreach ($users as $user) {
    if ($user['username'] === $_SESSION['user']) {
        $userDetails = $user;
        break;
    }
}

// If user details not found, destroy session and redirect to login page
if (!$userDetails) {
    session_destroy();
    header('Location: login.html');
    exit;
}

// Function to display error message
function displayErrorMessage($message) {
    echo "<div class='error-message'>$message</div>";
}

// Function to display success message
function displaySuccessMessage($message) {
    echo "<div class='success-message'>$message</div>";
}

// Function to validate and sanitize user input
function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Check if form is submitted for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user input
    $fullName = validateInput($_POST['full_name']);
    $bio = validateInput($_POST['bio']);
    $gradeLevel = validateInput($_POST['grade_level']);
    $portfolioUrl = validateInput($_POST['portfolio_url']);
    $location = validateInput($_POST['location']);
    $email = validateInput($_POST['email']);
    $major = validateInput($_POST['major']);
    $minor = validateInput($_POST['minor']);

    // Handle profile picture upload
    $profilePic = $_FILES['profile_pic']['name'];
    $profilePicTmp = $_FILES['profile_pic']['tmp_name'];

    // Check if a file is uploaded
    if (!empty($profilePic)) {
        $uploadDir = 'profile_pictures/';
        $uploadPath = $uploadDir . basename($profilePic);
        if (move_uploaded_file($profilePicTmp, $uploadPath)) {
            $userDetails['profilePic'] = $uploadPath;
        } else {
            displayErrorMessage('Failed to upload profile picture.');
        }
    }

    // Update user details in the users JSON file
    foreach ($users as &$user) {
        if ($user['username'] === $_SESSION['user']) {
            $user['full_name'] = $fullName;
            $user['bio'] = $bio;
            $user['grade_level'] = $gradeLevel;
            $user['portfolio_url'] = $portfolioUrl;
            $user['location'] = $location;
            $user['email'] = $email;
            $user['major'] = $major;
            $user['minor'] = $minor;
            if (!empty($profilePic)) {
                $user['profilePic'] = $uploadPath; // Update profile picture path
            }
            break;
        }
    }

    // Save updated user details back to JSON file
    if (file_put_contents($file_path, json_encode($users, JSON_PRETTY_PRINT))) {
        displaySuccessMessage('Profile updated successfully.');
    } else {
        displayErrorMessage('Failed to update profile.');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="../css/main.css">
    <!-- Add additional CSS or JS files here -->
</head>

<nav class="bottom-nav">
        <ul class="nav-list">
            <li>
                <a href="index.php" class="icon">
                    <div class="icon-container">
                        <img src="../final275/img/logo.svg" alt="Home">
                    </div>
                </a>
            </li>
            <li>
                <a href="about.html" class="icon">
                    <div class="icon-container">
                        <img src="../final275/img/abouticon.png" alt="About">
                    </div>
                </a>
            </li>
            <li>
                <a href="profile.php" id="profileLink" class="icon">
                    <div class="icon-container">
                        <img src="../final275/img/portalicon.png" alt="Profile">
                    </div>
                </a>
            </li>
        </ul>
    </nav>
<body>
    <div class="block-top">
    <?php if (!empty($userDetails['profilePic'])): ?>
            <img src="<?php echo htmlspecialchars($userDetails['profilePic']); ?>" alt="Profile picture" class="profile-picture-corner">
        <?php endif; ?>
    </div>
    <div class="profile-info">
        <div class="logo">
            <img src="img/logo.svg">
        </div>
        <h1 class="Freelance">Freelance Portal</h1>
        <!-- Display error or success messages here -->
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($errorMessage)) {
                displayErrorMessage($errorMessage);
            }
            if (isset($successMessage)) {
                displaySuccessMessage($successMessage);
            }
        } ?>
        <form id="profileForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
        <label for="profilePic">Profile Picture:</label>
        <input type="file" id="profilePic" name="profile_pic">
            <br><br>    
        
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($userDetails['username']); ?>" readonly>
            <br><br>

            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($userDetails['full_name'] ?? ''); ?>">
            <br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userDetails['email']); ?>" readonly>
            <br><br>

            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" rows="4" cols="50"><?php echo htmlspecialchars($userDetails['bio'] ?? ''); ?></textarea>
            <br><br>

            <label for="grade_level">Grade Level:</label>
            <input type="text" id="grade_level" name="grade_level" value="<?php echo htmlspecialchars($userDetails['grade_level'] ?? ''); ?>">
            <br><br>

            <label for="major">Major:</label>
            <input type="text" id="major" name="major" value="<?php echo htmlspecialchars($userDetails['major'] ?? ''); ?>">
            <br><br>

            <label for="minor">Minor:</label>
            <input type="text" id="minor" name="minor" value="<?php echo htmlspecialchars($userDetails['minor'] ?? ''); ?>">
            <br><br>

            <label for="portfolio_url">Portfolio URL:</label>
            <input type="url" id="portfolio_url" name="portfolio_url" value="<?php echo htmlspecialchars($userDetails['portfolio_url'] ?? ''); ?>">
            <br><br>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($userDetails['location'] ?? ''); ?>">
            <br><br>

            <button type="submit">Update Profile</button>
    </br>
    </br>
            <button id="logout">Logout</button>
        </form>
    </div>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
    <!-- Add additional scripts here -->
</body>
</html>
