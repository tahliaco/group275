<?php
session_start();
header('Content-Type: application/json');

$response = ['isLoggedIn' => isset($_SESSION['user'])];

echo json_encode($response);
?>