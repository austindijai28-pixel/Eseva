<?php
// ============================================
// complaint.php - Register Public Complaint
// Accepts POST data from the complaint form
// Returns JSON response
// ============================================

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Include database connection
require_once 'config.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Get and sanitize form inputs
$name      = isset($_POST['name'])      ? trim($_POST['name'])      : '';
$phone     = isset($_POST['phone'])     ? trim($_POST['phone'])     : '';
$address   = isset($_POST['address'])   ? trim($_POST['address'])   : '';
$complaint = isset($_POST['complaint']) ? trim($_POST['complaint']) : '';

// --- Basic Validation ---
if (empty($name) || empty($phone) || empty($address) || empty($complaint)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Validate phone: must be 10 digits
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    echo json_encode(['success' => false, 'message' => 'Phone number must be exactly 10 digits.']);
    exit;
}

// Insert complaint into database using prepared statement
$stmt = $conn->prepare("INSERT INTO complaints (name, phone, address, complaint) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $phone, $address, $complaint);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true, 
        'message' => 'Your complaint has been registered successfully!',
        'ref_id'  => 'TN' . str_pad($conn->insert_id, 6, '0', STR_PAD_LEFT)
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit complaint. Please try again.']);
}

$stmt->close();
$conn->close();
?>
