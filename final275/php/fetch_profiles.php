<?php
header('Content-Type: application/json');
session_start();

$file_path = '../data/profiles.json';
$jsonData = file_get_contents($file_path);
$profiles = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Error decoding JSON']);
    exit;
}

if (!is_array($profiles)) {
    echo json_encode(['success' => false, 'message' => 'Invalid profile data']);
    exit;
}

shuffle($profiles); // Randomize the order of profiles if needed

echo json_encode($profiles);
?>
