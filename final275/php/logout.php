<?php
session_start();
header('Content-Type: application/json');

// Clear the session
session_destroy();

echo json_encode(['success' => true, 'message' => 'Logout successful.']);
?>