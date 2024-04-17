<?php
session_start();
header('Content-Type: application/json');

// Unset session variable
unset($_SESSION['user']);

// Destroy the session
session_destroy();

// Return a JSON response, not a redirect
echo json_encode(['success' => true, 'message' => 'Logout successful.']);
?>
