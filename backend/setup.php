<?php
// ============================================
// setup.php - Auto Database Setup
// Run this ONCE in browser to create all tables
// URL: http://localhost/cop-seva/backend/setup.php
// ============================================

// Your MySQL credentials - change if needed
$host = 'localhost';
$user = 'root';
$pass = '';         // Empty for XAMPP default

// Connect WITHOUT selecting a database first
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("<h2 style='color:red'>❌ Connection Failed: " . $conn->connect_error . "<br>Make sure MySQL is running in XAMPP!</h2>");
}

$errors   = [];
$success  = [];

// ── Step 1: Create Database ──────────────────
$sql = "CREATE DATABASE IF NOT EXISTS cop_seva";
if ($conn->query($sql)) {
    $success[] = "✅ Database <strong>cop_seva</strong> created (or already exists)";
} else {
    $errors[] = "❌ Failed to create database: " . $conn->error;
}

// Select the database
$conn->select_db('cop_seva');

// ── Step 2: Create criminals table ───────────
$sql = "CREATE TABLE IF NOT EXISTS criminals (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    age        INT NOT NULL,
    crime      VARCHAR(255) NOT NULL,
    status     ENUM('Wanted','Arrested') NOT NULL DEFAULT 'Wanted',
    location   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql)) {
    $success[] = "✅ Table <strong>criminals</strong> created";
} else {
    $errors[] = "❌ criminals table error: " . $conn->error;
}

// ── Step 3: Create complaints table ──────────
$sql = "CREATE TABLE IF NOT EXISTS complaints (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,
    phone        VARCHAR(15) NOT NULL,
    address      TEXT NOT NULL,
    complaint    TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql)) {
    $success[] = "✅ Table <strong>complaints</strong> created";
} else {
    $errors[] = "❌ complaints table error: " . $conn->error;
}

// ── Step 4: Create police_users table ────────
$sql = "CREATE TABLE IF NOT EXISTS police_users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sql)) {
    $success[] = "✅ Table <strong>police_users</strong> created";
} else {
    $errors[] = "❌ police_users table error: " . $conn->error;
}

// ── Step 5: Insert default admin user ────────
// Check if admin already exists first
$check = $conn->query("SELECT id FROM police_users WHERE username='admin'");
if ($check->num_rows === 0) {
    $sql = "INSERT INTO police_users (username, password) VALUES ('admin', MD5('admin123'))";
    if ($conn->query($sql)) {
        $success[] = "✅ Default admin user created → username: <strong>admin</strong> | password: <strong>admin123</strong>";
    } else {
        $errors[] = "❌ Failed to insert admin: " . $conn->error;
    }
} else {
    $success[] = "ℹ️ Admin user already exists — skipped";
}

// ── Step 6: Insert sample criminal records ────
$check = $conn->query("SELECT COUNT(*) as cnt FROM criminals");
$row = $check->fetch_assoc();
if ($row['cnt'] == 0) {
    $sql = "INSERT INTO criminals (name, age, crime, status, location) VALUES
        ('Rajan Kumar',  35, 'Armed Robbery',    'Wanted',   'Chennai, Tamil Nadu'),
        ('Suresh Babu',  42, 'Drug Trafficking', 'Arrested', 'Coimbatore, Tamil Nadu'),
        ('Mohan Das',    28, 'Vehicle Theft',    'Wanted',   'Tiruppur, Tamil Nadu'),
        ('Vikram Singh', 50, 'Fraud & Cheating', 'Arrested', 'Mumbai, Maharashtra')";
    if ($conn->query($sql)) {
        $success[] = "✅ Sample criminal records inserted (4 records)";
    } else {
        $errors[] = "❌ Sample data error: " . $conn->error;
    }
} else {
    $success[] = "ℹ️ Criminal records already exist — skipped";
}

// ── Step 7: Insert sample complaint ──────────
$check = $conn->query("SELECT COUNT(*) as cnt FROM complaints");
$row = $check->fetch_assoc();
if ($row['cnt'] == 0) {
    $sql = "INSERT INTO complaints (name, phone, address, complaint) VALUES
        ('Priya Sharma', '9876543210', '12 MG Road, Tiruppur', 'Mobile phone snatched near bus stand at 7pm.')";
    if ($conn->query($sql)) {
        $success[] = "✅ Sample complaint inserted";
    } else {
        $errors[] = "❌ Sample complaint error: " . $conn->error;
    }
} else {
    $success[] = "ℹ️ Complaints already exist — skipped";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Setup | e-Seva</title>
    <style>
        body { font-family: Segoe UI, sans-serif; background: #f0f2f5; margin: 0; padding: 40px 20px; }
        .box { max-width: 620px; margin: 0 auto; background: white; border-radius: 14px; padding: 36px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        h2   { color: #1a237e; margin-bottom: 6px; }
        .sub { color: #888; font-size: 14px; margin-bottom: 28px; }
        .item { padding: 11px 14px; border-radius: 8px; margin-bottom: 10px; font-size: 15px; }
        .ok  { background: #e8f5e9; color: #2e7d32; border-left: 4px solid #2e7d32; }
        .err { background: #ffebee; color: #c62828; border-left: 4px solid #c62828; }
        .cta { display:inline-block; margin-top: 24px; padding: 13px 28px; background: #1a237e; color: white; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 15px; }
        .cta:hover { background: #283593; }
        .warn { background: #fff3e0; border-left: 4px solid #f57c00; color: #e65100; padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-top: 20px; }
    </style>
</head>
<body>
<div class="box">
    <h2>🛡️ e-Seva Database Setup</h2>
    <p class="sub">Setting up MySQL database and tables for the first time...</p>

    <?php foreach ($success as $msg): ?>
        <div class="item ok"><?= $msg ?></div>
    <?php endforeach; ?>

    <?php foreach ($errors as $msg): ?>
        <div class="item err"><?= $msg ?></div>
    <?php endforeach; ?>

    <?php if (empty($errors)): ?>
        <div class="warn">
            ⚠️ <strong>Delete this file</strong> after setup is complete for security.<br>
            File to delete: <code>backend/setup.php</code>
        </div>
        <a class="cta" href="../frontend/index.html">🚀 Go to Website →</a>
    <?php else: ?>
        <div class="item err" style="margin-top:16px;">
            ❌ Setup incomplete. Fix the errors above and refresh this page.
        </div>
    <?php endif; ?>
</div>
</body>
</html>
