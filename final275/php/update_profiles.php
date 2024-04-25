<?php
session_start();
header('Content-Type: application/json');

// Log POST and FILES arrays for debugging
error_log("POST: " . print_r($_POST, true));
error_log("FILES: " . print_r($_FILES, true));

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
    exit;
}

// Function to validate and sanitize user input
function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Fetch existing profiles
$file_path = '../data/users.json';
$users = json_decode(file_get_contents($file_path), true);

// Log the current state of users before updating
error_log("Before update: " . print_r($users, true));

// Check if POST data is received
if (empty($_POST)) {
    echo json_encode(['success' => false, 'message' => 'No data received.']);
    exit;
}

// Update logic here
$updated = false;
foreach ($users as &$user) {
    if ($user['username'] === $_SESSION['user']) {
        // Update fields from POST, if they exist in $user
        foreach ($_POST as $field => $value) {
            if (isset($user[$field])) {
                $user[$field] = validateInput($value);
            }
        }

        // Handle profile picture if uploaded
        if (!empty($_FILES['profile_pic']['name'])) {
            $uploadDir = 'profile_pictures/';
            $uploadPath = $uploadDir . basename($_FILES['profile_pic']['name']);
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadPath)) {
                $user['profilePic'] = $uploadPath;
            } else {
                error_log("Failed to move uploaded file.");
            }
        }

        $updated = true;
        break; // Once the user is found and updated, break out of the loop
    }
}

// Log the updated state of users
error_log("After update: " . print_r($users, true));

// Save the updated users back to the JSON file
$result = file_put_contents($file_path, json_encode($users, JSON_PRETTY_PRINT));
if ($result === false) {
    error_log("Failed to write to file");
    echo json_encode(['success' => false, 'message' => 'Failed to write to file.']);
} else {
    error_log("Write successful, bytes written: $result");
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
}
?>
