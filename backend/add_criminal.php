<?php
// ============================================
// add_criminal.php - Add New Criminal Record
// Only accessible by logged-in police users
// ============================================

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

session_start();
require_once 'config.php';

// Security: only logged-in police can add
if (!isset($_SESSION['police_logged_in'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

// Get form data
$name     = isset($_POST['name'])     ? trim($_POST['name'])     : '';
$age      = isset($_POST['age'])      ? intval($_POST['age'])    : 0;
$crime    = isset($_POST['crime'])    ? trim($_POST['crime'])    : '';
$status   = isset($_POST['status'])   ? trim($_POST['status'])   : '';
$location = isset($_POST['location']) ? trim($_POST['location']) : '';

// Validate all fields
if (empty($name) || $age <= 0 || empty($crime) || empty($status) || empty($location)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required and age must be positive.']);
    exit;
}

// Validate status value
if (!in_array($status, ['Wanted', 'Arrested'])) {
    echo json_encode(['success' => false, 'message' => 'Status must be Wanted or Arrested.']);
    exit;
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO criminals (name, age, crime, status, location) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sisss", $name, $age, $crime, $status, $location);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Criminal record added successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add record.']);
}

$stmt->close();
$conn->close();
?>
