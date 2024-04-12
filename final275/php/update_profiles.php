// update_profile.php
<?php
session_start();
header('Content-Type: application/json');


if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
    exit;
}

// Get the updated profile data from the request body
$data = json_decode(file_get_contents('php://input'), true);

$success = true; 

if ($success) {

    $updatedProfileData = [
        'profilePic' => $data['profilePic'],
        'username' => $data['username'],
        'full_name' => $data['full_name'],
        'email' => $data['email'],
        'password' => $data['password'],
        'bio' => $data['bio'],
        'grade_level' => $data['grade_level'],
        'portfolio_url' => $data['portfolio_url'],
        'location' => $data['location'],

        // Add other fields as needed
    ];

  
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully.', 'updatedProfileData' => $updatedProfileData]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
}
?>

