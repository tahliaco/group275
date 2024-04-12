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
            <?php
            session_start();
            if(isset($_SESSION['user'])) {
                echo '<li><a href="profile.php" class="icon profile-icon">My Profile</a></li>';
            } else {
                echo '<li><a href="login.html" class="icon profile-icon">Login/Register</a></li>';
            }
            ?>
        </ul>
    </nav>
    <h1>Profile Feed</h1>
    <button id="loadProfiles">Load Profiles</button>
    <main class="profile-feed">
        <?php foreach ($profiles as $profile): ?>
            <div class="profile-card">
                <img src="<?php echo htmlspecialchars($profile['image_url']); ?>" alt="Profile picture">
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
