<?php
session_start();
header('Content-Type: application/json');

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

// Check if username exists in the database
$stmt = $pdo->prepare("SELECT COUNT(*) FROM profiles WHERE username = ?");
$stmt->execute([$username]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    echo json_encode(['success' => false, 'message' => 'Username already exists.']);
    exit;
}

// Insert new user into the database
$stmt = $pdo->prepare("INSERT INTO profiles (username, password, email) VALUES (?, ?, ?)");
$success = $stmt->execute([$username, $password, $email]);

if ($success) {
    $userId = $pdo->lastInsertId(); // Get the ID of the newly inserted user
    $_SESSION['user'] = $userId; // Use the user's ID for the session
    echo json_encode(['success' => true, 'message' => 'Registration successful!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Registration failed.']);
}
?>
