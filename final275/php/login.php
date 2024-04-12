<?php
session_start();
header('Content-Type: application/json');

$file_path = '../data/users.json';
$users = json_decode(file_get_contents($file_path), true);

$username = $_POST['username'];
$password = $_POST['password'];

foreach ($users as $user) {
    if ($user['username'] === $username && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        echo json_encode(['success' => true, 'message' => 'Login successful!']);
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
?>