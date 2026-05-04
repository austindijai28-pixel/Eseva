<?php
// ============================================
// config.php - Database Connection Settings
// Support for Cloud Environment Variables
// ============================================

// Database credentials - Use getenv() for cloud deployment (e.g. Railway)
// Falls back to local XAMPP defaults if environment variables are not set
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_NAME', getenv('DB_NAME') ?: 'cop_seva');

// Create a MySQLi connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check if connection failed
if ($conn->connect_error) {
    header('Content-Type: application/json');
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed. Please check your DB credentials.'
    ]));
}

// Set character encoding to UTF-8
$conn->set_charset("utf8");
?>
