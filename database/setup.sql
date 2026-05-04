-- ============================================
-- Cop-Friendly e-Seva Website - Database Setup
-- Run this in phpMyAdmin or MySQL CLI
-- ============================================

-- Step 1: Create the database
CREATE DATABASE IF NOT EXISTS cop_seva;
USE cop_seva;

-- ============================================
-- Table 1: criminals
-- Stores criminal records added by police
-- ============================================
CREATE TABLE IF NOT EXISTS criminals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    crime VARCHAR(255) NOT NULL,
    status ENUM('Wanted', 'Arrested') NOT NULL DEFAULT 'Wanted',
    location VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table 2: complaints
-- Stores public complaints submitted online
-- ============================================
CREATE TABLE IF NOT EXISTS complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    complaint TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table 3: police_users
-- Stores police login credentials
-- ============================================
CREATE TABLE IF NOT EXISTS police_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL  -- stored as MD5 hash
);

-- ============================================
-- Sample Data: Insert a default police user
-- Username: admin | Password: admin123
-- ============================================
INSERT INTO police_users (username, password)
VALUES ('admin', MD5('admin123'));

-- ============================================
-- Sample Data: Insert some criminal records
-- ============================================
INSERT INTO criminals (name, age, crime, status, location) VALUES
('Rajan Kumar', 35, 'Armed Robbery', 'Wanted', 'Chennai, Tamil Nadu'),
('Suresh Babu', 42, 'Drug Trafficking', 'Arrested', 'Coimbatore, Tamil Nadu'),
('Mohan Das', 28, 'Vehicle Theft', 'Wanted', 'Tiruppur, Tamil Nadu'),
('Vikram Singh', 50, 'Fraud & Cheating', 'Arrested', 'Mumbai, Maharashtra');

-- ============================================
-- Sample Data: Insert a sample complaint
-- ============================================
INSERT INTO complaints (name, phone, address, complaint) VALUES
('Priya Sharma', '9876543210', '12, MG Road, Tiruppur', 'My mobile phone was snatched near the bus stand at 7pm.');
