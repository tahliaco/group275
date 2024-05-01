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
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>

<nav class="bottom-nav">
    <ul class="nav-list">
        <li>
            <a href="index.php" class="icon">
                <div class="icon-container">
                    <img src="../final275/img/logo.svg" alt="Home">
                    <span><?php echo isset($_SESSION['user']) ? 'Home' : 'Login/Register'; ?></span>
                </div>
            </a>
        </li>
        <li>
            <a href="about.html" class="icon">
                <div class="icon-container">
                    <img src="../final275/img/abouticon.png" alt="About">
                    <span>About</span>
                </div>
            </a>
        </li>
        <li>
            <a href="profile.php" id="profileLink" class="icon">
                <div class="icon-container">
                    <img src="../final275/img/portalicon.png" alt="Profile">
                    <span><?php echo isset($_SESSION['user']) ? 'Portal' : 'Login/Register'; ?></span>
                </div>
            </a>
        </li>
    </ul>
</nav>


    <main class="profile-feed">
    <h1>Profile Feed</h1>
        <?php foreach ($profiles as $profile): ?>
            <div class="profile-card">
            <?php if (!empty($profile['profilePic'])): ?>
                <img src="<?php echo htmlspecialchars($profile['profilePic']); ?>" alt="Profile picture">
            <?php endif; ?>
            <div class="profile-info">
                    <h2><?php echo htmlspecialchars($profile['username']); ?></h2>
                    <?php if (!empty($profile['full_name'])): ?>
                        <h2><?php echo htmlspecialchars($profile['full_name']); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($profile['bio'])): ?>
                        <p><?php echo htmlspecialchars($profile['bio']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($profile['grade_level'])): ?>
                        <p><b>Grade Level:</b> <?php echo htmlspecialchars($profile['grade_level']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($profile['major'])): ?>
                        <p><b>Major:</b> <?php echo htmlspecialchars($profile['major']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($profile['minor'])): ?>
                        <p><b>Minor:</b> <?php echo htmlspecialchars($profile['minor']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($profile['email'])): ?>
                        <p><b>Contact:</b> <?php echo htmlspecialchars($profile['email']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
                    </br>

        <?php endforeach; ?>
    </main>
    
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>


</body>
</html>
