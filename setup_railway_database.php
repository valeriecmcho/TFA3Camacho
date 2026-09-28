<?php
// Database setup script for Railway deployment
// This script will create tables and insert sample data

// Try to get database connection from Railway environment variables first
$dbHost = getenv('RAILWAY_PRIVATE_DOMAIN') ?: getenv('PGHOST') ?: 'localhost';
$dbPort = getenv('PGPORT') ?: '5432';
$dbName = getenv('PGDATABASE') ?: 'tfa3camacho';
$dbUser = getenv('PGUSER') ?: 'root';
$dbPass = getenv('PGPASSWORD') ?: '';

// For Railway PostgreSQL
if (getenv('DATABASE_URL')) {
    $dbUrl = parse_url(getenv('DATABASE_URL'));
    $dbHost = $dbUrl['host'];
    $dbPort = $dbUrl['port'] ?? '5432';
    $dbName = ltrim($dbUrl['path'], '/');
    $dbUser = $dbUrl['user'];
    $dbPass = $dbUrl['pass'];
}

// Check if we should use MySQL or PostgreSQL
$usePostgres = (getenv('DATABASE_URL') !== null) || (getenv('PGDATABASE') !== null);

try {
    if ($usePostgres) {
        // PostgreSQL connection for Railway
        $pdo = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create customers table for PostgreSQL
        $pdo->exec("CREATE TABLE IF NOT EXISTS customers (
            id SERIAL PRIMARY KEY,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            phone VARCHAR(20),
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        )");
        echo "Table 'customers' created or already exists (PostgreSQL).<br>";

        // Create users table for PostgreSQL
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            full_name VARCHAR(100) NOT NULL,
            avatar VARCHAR(255) DEFAULT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        )");
        echo "Table 'users' created or already exists (PostgreSQL).<br>";

        // Insert sample data into customers table
        $pdo->exec("INSERT INTO customers (full_name, email, phone, created_at) VALUES
            ('Juan Dela Cruz', 'juan@example.com', '09171234567', NOW()),
            ('Maria Santos', 'maria@example.com', '09181234567', NOW()),
            ('Pedro Reyes', 'pedro@example.com', '09191234567', NOW()),
            ('Ana Garcia', 'ana@example.com', '09201234567', NOW()),
            ('Mark Flores', 'mark@example.com', '09211234567', NOW())
            ON CONFLICT DO NOTHING");
        echo "Sample data inserted into 'customers' table (PostgreSQL).<br>";

        // Insert sample data into users table
        $pdo->exec("INSERT INTO users (username, full_name, created_at) VALUES
            ('admin', 'Administrator', NOW()),
            ('cashier1', 'John Smith', NOW()),
            ('cashier2', 'Jane Doe', NOW()),
            ('manager', 'Robert Johnson', NOW()),
            ('supervisor', 'Emily Brown', NOW())
            ON CONFLICT DO NOTHING");
        echo "Sample data inserted into 'users' table (PostgreSQL).<br>";

    } else {
        // MySQL connection for local development
        $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create database
        $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbName");
        echo "Database '$dbName' created or already exists.<br>";

        // Select the database
        $pdo->exec("USE $dbName");

        // Create customers table
        $pdo->exec("CREATE TABLE IF NOT EXISTS customers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            phone VARCHAR(20),
            created_at DATETIME NOT NULL
        )");
        echo "Table 'customers' created or already exists (MySQL).<br>";

        // Create users table
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            full_name VARCHAR(100) NOT NULL,
            avatar VARCHAR(255) DEFAULT NULL,
            created_at DATETIME NOT NULL
        )");
        echo "Table 'users' created or already exists (MySQL).<br>";

        // Insert sample data into customers table
        $pdo->exec("INSERT INTO customers (full_name, email, phone, created_at) VALUES
            ('Juan Dela Cruz', 'juan@example.com', '09171234567', NOW()),
            ('Maria Santos', 'maria@example.com', '09181234567', NOW()),
            ('Pedro Reyes', 'pedro@example.com', '09191234567', NOW()),
            ('Ana Garcia', 'ana@example.com', '09201234567', NOW()),
            ('Mark Flores', 'mark@example.com', '09211234567', NOW())");
        echo "Sample data inserted into 'customers' table (MySQL).<br>";

        // Insert sample data into users table
        $pdo->exec("INSERT INTO users (username, full_name, created_at) VALUES
            ('admin', 'Administrator', NOW()),
            ('cashier1', 'John Smith', NOW()),
            ('cashier2', 'Jane Doe', NOW()),
            ('manager', 'Robert Johnson', NOW()),
            ('supervisor', 'Emily Brown', NOW())");
        echo "Sample data inserted into 'users' table (MySQL).<br>";
    }

    echo "<br><strong>Database setup completed successfully!</strong>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
