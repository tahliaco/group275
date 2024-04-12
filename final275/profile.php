<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

// Simulated user data, fetch from your database in production
$username = $_SESSION['user']; // Placeholder, replace with actual user data fetching logic
$email = $_SESSION['email'] ?? 'your-email@example.com'; // Placeholder

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <nav class="bottom-nav">
        <ul class="nav-list">
            <li><a href="index.php" class="icon home-icon">Home</a></li>
            <li><a href="about.html" class="icon about-icon">About</a></li>
            <li><a href="profile.php" class="icon profile-icon">My Profile</a></li>
        </ul>
    </nav>
    <h1>Edit Profile</h1>
    <div class="profile-info">
        <form id="profileForm">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
            <br><br>

            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>">
            <br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            <br><br>

            <label for="password">Email:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" readonly>
            <br><br>

            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" rows="4" cols="50"><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
            <br><br>

            <label for="grade_level">Grade Level:</label>
            <input type="text" id="grade_level" name="grade_level" value="<?php echo htmlspecialchars($user['grade_level'] ?? ''); ?>">
            <br><br>

            <label for="portfolio_url">Portfolio URL:</label>
            <input type="url" id="portfolio_url" name="portfolio_url" value="<?php echo htmlspecialchars($user['portfolio_url'] ?? ''); ?>">
            <br><br>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($user['location'] ?? ''); ?>">
            <br><br>


            <button type="button" onclick="updateProfile()">Update Profile</button>
        </form>
    </div>
    <br><br>
    <button id="logout">Logout</button>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
