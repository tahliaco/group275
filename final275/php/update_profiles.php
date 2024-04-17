<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
    exit;
}

// Fetch existing profiles
$file_path = '../data/users.json';
$users = json_decode(file_get_contents($file_path), true);

$data = json_decode(file_get_contents('php://input'), true);

// Find and update the user's profile
$updated = false;
foreach ($users as $key => $user) {
    if ($user['username'] === $_SESSION['user']) {
        foreach ($data as $field => $value) {
            if (isset($user[$field])) {
                $users[$key][$field] = $value;
            }
        }
        $updated = true;
        break;
    }
}

if ($updated && file_put_contents($file_path, json_encode($users))) {
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully.', 'updatedProfileData' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
}
?>
