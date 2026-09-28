-- Create the database
CREATE DATABASE IF NOT EXISTS tfa3camacho;
USE tfa3camacho;

-- Create customers table
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    created_at DATETIME NOT NULL
);

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    created_at DATETIME NOT NULL
);

-- Insert sample data into customers table
INSERT INTO customers (full_name, email, phone, created_at) VALUES
('Juan Dela Cruz', 'juan@example.com', '09171234567', NOW()),
('Maria Santos', 'maria@example.com', '09181234567', NOW()),
('Pedro Reyes', 'pedro@example.com', '09191234567', NOW()),
('Ana Garcia', 'ana@example.com', '09201234567', NOW()),
('Mark Flores', 'mark@example.com', '09211234567', NOW());

-- Insert sample data into users table
INSERT INTO users (username, full_name, created_at) VALUES
('admin', 'Administrator', NOW()),
('cashier1', 'John Smith', NOW()),
('cashier2', 'Jane Doe', NOW()),
('manager', 'Robert Johnson', NOW()),
('supervisor', 'Emily Brown', NOW());
