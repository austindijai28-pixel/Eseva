<?php
// ============================================
// login.php - Police Login Authentication
// Verifies credentials from police_users table
// Uses PHP sessions to maintain login state
// ============================================

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Start session to store login state
session_start();

require_once 'config.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Validate inputs
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Username and Password are required.']);
    exit;
}

// Hash password with MD5 (matches how we stored it in the DB)
$hashedPassword = md5($password);

// Check credentials using prepared statement
$stmt = $conn->prepare("SELECT id, username FROM police_users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $hashedPassword);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Login successful - store user info in session
    $user = $result->fetch_assoc();
    $_SESSION['police_logged_in'] = true;
    $_SESSION['police_username']  = $user['username'];
    $_SESSION['police_id']        = $user['id'];

    echo json_encode(['success' => true, 'message' => 'Login successful!', 'username' => $user['username']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
}

$stmt->close();
$conn->close();
?>
