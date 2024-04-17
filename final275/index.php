<?php
session_start();

$file_path = 'data/users.json';
$profiles = json_decode(file_get_contents($file_path), true) ?: [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Feed</title>
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
    
    <h1>Profile Feed</h1>
    <main class="profile-feed">
        <?php foreach ($profiles as $profile): ?>
            <div class="profile-card">
                <img src="<?php echo htmlspecialchars($profile['image_url'] ?? 'path/to/default/image.png'); ?>" alt="Profile picture">
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($profile['name']); ?></h2>
                    <p><?php echo htmlspecialchars($profile['bio']); ?></p>
                    <ul class="skills-list">
                        <?php foreach ($profile['skills'] as $skill): ?>
                            <li><?php echo htmlspecialchars($skill); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </main>
    
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
