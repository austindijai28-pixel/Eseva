<?php
// ============================================
// search.php - Search Criminal Records
// Called via AJAX from the search page
// Returns JSON response
// ============================================

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow frontend to call this

// Include database connection
require_once 'config.php';

// Get the search query from GET parameter
$query = isset($_GET['name']) ? trim($_GET['name']) : '';

// Validate: must not be empty
if (empty($query)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a name to search.']);
    exit;
}

// Use prepared statement to prevent SQL Injection
// The % signs allow partial matching (e.g., "raj" finds "Rajan")
$stmt = $conn->prepare("SELECT * FROM criminals WHERE name LIKE ?");
$searchTerm = '%' . $query . '%';
$stmt->bind_param("s", $searchTerm);
$stmt->execute();

// Get results
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Records found - collect all into an array
    $criminals = [];
    while ($row = $result->fetch_assoc()) {
        $criminals[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $criminals]);
} else {
    // No records found
    echo json_encode(['success' => false, 'message' => 'No criminal records found for "' . htmlspecialchars($query) . '".']);
}

$stmt->close();
$conn->close();
?>
