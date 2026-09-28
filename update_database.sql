-- ================================================================
-- TFA3Camacho Database Setup for XAMPP
-- Run this file in phpMyAdmin or MySQL command line
-- ================================================================

-- Drop existing database if exists (fresh start)
DROP DATABASE IF EXISTS tfa3camacho;

-- Create the database
CREATE DATABASE tfa3camacho CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE tfa3camacho;

-- ================================================================
-- Create customers table
-- ================================================================
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_full_name (full_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ================================================================
-- Create users table (with avatar column)
-- ================================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_full_name (full_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ================================================================
-- Insert sample data into customers table
-- ================================================================
INSERT INTO customers (full_name, email, phone, created_at) VALUES
('Juan Dela Cruz', 'juan@example.com', '09171234567', NOW()),
('Maria Santos', 'maria@example.com', '09181234567', NOW()),
('Pedro Reyes', 'pedro@example.com', '09191234567', NOW()),
('Ana Garcia', 'ana@example.com', '09201234567', NOW()),
('Mark Flores', 'mark@example.com', '09211234567', NOW());

-- ================================================================
-- Insert sample data into users table
-- ================================================================
INSERT INTO users (username, full_name, avatar, created_at) VALUES
('admin', 'Administrator', NULL, NOW()),
('cashier1', 'John Smith', NULL, NOW()),
('cashier2', 'Jane Doe', NULL, NOW()),
('manager', 'Robert Johnson', NULL, NOW()),
('supervisor', 'Emily Brown', NULL, NOW());

-- ================================================================
-- Verify data
-- ================================================================
SELECT 'Database setup completed successfully!' AS Status;
SELECT COUNT(*) AS customer_count FROM customers;
SELECT COUNT(*) AS user_count FROM users;
