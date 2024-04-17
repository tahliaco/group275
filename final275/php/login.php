<?php
session_start();
header('Content-Type: application/json');

$file_path = '../data/users.json';
$jsonData = file_get_contents($file_path);
$users = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Error decoding JSON']);
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];

$loginSuccessful = false;
foreach ($users as $user) {
    if ($user['username'] === $username && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username']; // Store username in session
        $loginSuccessful = true;
        break;
    }
}

if ($loginSuccessful) {
    echo json_encode(['success' => true, 'message' => 'Login successful!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
}
?>
