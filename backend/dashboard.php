<?php
// ============================================
// dashboard.php - Police Dashboard Data
// Returns complaints + criminals as JSON
// Requires active police session
// ============================================

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

session_start();
require_once 'config.php';

// Security check: only logged-in police can access
if (!isset($_SESSION['police_logged_in']) || $_SESSION['police_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized. Please login first.']);
    exit;
}

// Fetch all complaints
$complaintsResult = $conn->query("SELECT * FROM complaints ORDER BY submitted_at DESC");
$complaints = [];
while ($row = $complaintsResult->fetch_assoc()) {
    $complaints[] = $row;
}

// Fetch all criminal records
$criminalsResult = $conn->query("SELECT * FROM criminals ORDER BY created_at DESC");
$criminals = [];
while ($row = $criminalsResult->fetch_assoc()) {
    $criminals[] = $row;
}

echo json_encode([
    'success'    => true,
    'username'   => $_SESSION['police_username'],
    'complaints' => $complaints,
    'criminals'  => $criminals
]);

$conn->close();
?>
