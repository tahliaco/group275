<?php
session_start();
header('Content-Type: application/json');

// Path to the JSON file where users are stored
$file_path = '../data/users.json';

// Attempt to read the existing users from the file
$users = json_decode(file_get_contents($file_path), true) ?: [];

// Collect user input from the form
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$email = $_POST['email'] ?? '';

// Simple validation to ensure no fields are empty
if (empty($username) || empty($password) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Check if the username already exists
foreach ($users['users'] as $user) { // Ensure we are checking within the 'users' array
    if ($user['username'] === $username) {
        echo json_encode(['success' => false, 'message' => 'Username already exists.']);
        exit;
    }
}

// Hash the password for security reasons
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Create a new user array with all fields
$new_user = [
    'username' => $username,
    'password' => $hashedPassword,
    'email' => $email,
    'full_name' => '', // Default value
    'bio' => '', // Default value
    'grade_level' => '', // Default value
    'major' => '', // Default value
    'portfolio_url' => '', // Default value
    'location' => '', // Default value
    'profilePic' => '' // Default value
];

// Add the new user to the array of users within the 'users' array
$users[] = $new_user;

// Write the updated users back to the file
if (file_put_contents($file_path, json_encode($users, JSON_PRETTY_PRINT))) {
    // Set session variable for the new user
    $_SESSION['user'] = $username; // Use the username for user session management
    echo json_encode(['success' => true, 'message' => 'Registration successful!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to write user data.']);
}
?>
