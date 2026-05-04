<?php
// ============================================
// manage_criminal.php - Delete or Update Record
// Handles both DELETE and UPDATE operations
// Only accessible by logged-in police users
// ============================================

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

session_start();
require_once 'config.php';

// Security check
if (!isset($_SESSION['police_logged_in'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

// Determine action: 'delete' or 'update'
$action = isset($_POST['action']) ? $_POST['action'] : '';
$id     = isset($_POST['id'])     ? intval($_POST['id']) : 0;

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid record ID.']);
    exit;
}

// --- DELETE Operation ---
if ($action === 'delete') {
    $stmt = $conn->prepare("DELETE FROM criminals WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Record deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete record.']);
    }
    $stmt->close();

// --- UPDATE Operation ---
} elseif ($action === 'update') {
    $name     = isset($_POST['name'])     ? trim($_POST['name'])     : '';
    $age      = isset($_POST['age'])      ? intval($_POST['age'])    : 0;
    $crime    = isset($_POST['crime'])    ? trim($_POST['crime'])    : '';
    $status   = isset($_POST['status'])   ? trim($_POST['status'])   : '';
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';

    if (empty($name) || $age <= 0 || empty($crime) || empty($status) || empty($location)) {
        echo json_encode(['success' => false, 'message' => 'All fields required.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE criminals SET name=?, age=?, crime=?, status=?, location=? WHERE id=?");
    $stmt->bind_param("sisssi", $name, $age, $crime, $status, $location, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Record updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update record.']);
    }
    $stmt->close();

} else {
    echo json_encode(['success' => false, 'message' => 'Unknown action.']);
}

$conn->close();
?>
