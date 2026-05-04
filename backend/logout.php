<?php
// ============================================
// logout.php - Police Logout
// Destroys session and redirects to login
// ============================================

session_start();
session_destroy(); // Clear all session data

// Redirect to login page
header('Location: ../frontend/login.html');
exit;
?>
