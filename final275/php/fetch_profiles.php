<?php
header('Content-Type: application/json');
session_start();

$file_path = '../data/profiles.json';
$profiles = json_decode(file_get_contents($file_path), true) ?: [];
shuffle($profiles); // Randomize the order of profiles

echo json_encode($profiles);
?>
