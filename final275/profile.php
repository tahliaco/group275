<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.html');
    exit;
}

$file_path = '../data/users.json';
$users = json_decode(file_get_contents($file_path), true);
$userDetails = [];

foreach ($users as $user) {
    if ($user['username'] === $_SESSION['user']) {
        $userDetails = $user;
        break;
    }
}

if (!$userDetails) {
    header('Location: login.html');
    exit;
}
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
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="profile.php" class="icon profile-icon">My Profile</a></li>
            <?php else: ?>
                <li><a href="login.html" class="icon profile-icon">Login/Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <h1>Edit Profile</h1>
    <div class="profile-info">
        <form id="profileForm" method="post" action="update_profile.php">
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

            <label for="portfolio_url">Portfolio URL:</label>
            <input type="url" id="portfolio_url" name="portfolio_url" value="<?php echo htmlspecialchars($userDetails['portfolio_url'] ?? ''); ?>">
            <br><br>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($userDetails['location'] ?? ''); ?>">
            <br><br>

            <button type="submit">Update Profile</button>
        </form>
    </div>
    <button id="logout" onclick="window.location='php/logout.php';">Logout</button>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
