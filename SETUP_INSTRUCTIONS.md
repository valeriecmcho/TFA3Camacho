# TFA3 POS System - MySQL Database Integration Setup Instructions

## Overview
This document provides step-by-step instructions for setting up and testing the TFA3 POS System with MySQL database integration.

## Prerequisites
- XAMPP installed (includes Apache, MySQL, PHP)
- CodeIgniter 4 project structure

## Step 1: Start XAMPP Services
1. Open XAMPP Control Panel
2. Start Apache service
3. Start MySQL service
4. Ensure both services are running (green indicators)

## Step 2: Create Database and Tables
### Option A: Using the PHP Setup Script (Recommended)
1. Open your web browser
2. Navigate to: `http://localhost/TFA3Camacho/setup_database.php`
3. The script will automatically:
   - Create the `pos_db` database
   - Create `customers` and `users` tables
   - Insert sample data (5 records each)

### Option B: Using phpMyAdmin
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click "New" to create a new database
3. Name it: `tfa3camacho`
4. Click "Create"
5. Run the SQL from `database_setup.sql` file:
   ```sql
   CREATE TABLE IF NOT EXISTS customers (
       id INT AUTO_INCREMENT PRIMARY KEY,
       full_name VARCHAR(100) NOT NULL,
       email VARCHAR(100) NOT NULL,
       phone VARCHAR(20),
       created_at DATETIME NOT NULL
   );

   CREATE TABLE IF NOT EXISTS users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL UNIQUE,
       full_name VARCHAR(100) NOT NULL,
       created_at DATETIME NOT NULL
   );

   INSERT INTO customers (full_name, email, phone, created_at) VALUES
   ('Juan Dela Cruz', 'juan@example.com', '09171234567', NOW()),
   ('Maria Santos', 'maria@example.com', '09181234567', NOW()),
   ('Pedro Reyes', 'pedro@example.com', '09191234567', NOW()),
   ('Ana Garcia', 'ana@example.com', '09201234567', NOW()),
   ('Mark Flores', 'mark@example.com', '09211234567', NOW());

   INSERT INTO users (username, full_name, created_at) VALUES
   ('admin', 'Administrator', NOW()),
   ('cashier1', 'John Smith', NOW()),
   ('cashier2', 'Jane Doe', NOW()),
   ('manager', 'Robert Johnson', NOW()),
   ('supervisor', 'Emily Brown', NOW());
   ```

## Step 3: Verify Database Configuration
The `.env` file is already configured with:
```
database.default.hostname = localhost
database.default.database = tfa3camacho
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

## Step 4: Test the Application
1. Open your web browser
2. Navigate to: `http://localhost/TFA3Camacho/`
3. You should see the POS System home page with navigation options

### Test Customer Accounts
1. Click "Customer Accounts" or navigate to: `http://localhost/TFA3Camacho/customer-accounts`
2. Verify that 5 customer records are displayed in a table
3. Check that all fields (ID, Full Name, Email, Phone, Created At) are visible

### Test User Accounts
1. Click "User Accounts" or navigate to: `http://localhost/TFA3Camacho/user-accounts`
2. Verify that 5 user records are displayed in a table
3. Check that all fields (ID, Username, Full Name, Created At) are visible

## Files Created/Modified

### New Files Created:
1. `app/Models/CustomerModel.php` - Model for customer data
2. `app/Models/UserModel.php` - Model for user data
3. `app/Controllers/CustomerAccounts.php` - Controller for customer accounts
4. `app/Controllers/UserAccounts.php` - Controller for user accounts
5. `app/Views/customer_accounts.php` - View for customer accounts page
6. `app/Views/user_accounts.php` - View for user accounts page
7. `app/Views/home.php` - Home page with navigation
8. `database_setup.sql` - SQL script for database setup
9. `setup_database.php` - PHP script for automated database setup
10. `.env` - Environment configuration file (copied from env)
11. `SETUP_INSTRUCTIONS.md` - This file

### Modified Files:
1. `app/Config/Routes.php` - Added routes for customer and user accounts
2. `app/Controllers/Home.php` - Updated to use home view

## Architecture Overview

```
MySQL Database (tfa3camacho)
├── customers table
└── users table
        │
        ▼
CodeIgniter Models
├── CustomerModel (app/Models/CustomerModel.php)
└── UserModel (app/Models/UserModel.php)
        │
        ▼
Controllers
├── CustomerAccounts (app/Controllers/CustomerAccounts.php)
└── UserAccounts (app/Controllers/UserAccounts.php)
        │
        ▼
Views
├── customer_accounts.php (app/Views/customer_accounts.php)
└── user_accounts.php (app/Views/user_accounts.php)
```

## Database Schema

### Customers Table
- `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `full_name` (VARCHAR(100), NOT NULL)
- `email` (VARCHAR(100), NOT NULL)
- `phone` (VARCHAR(20), NULLABLE)
- `created_at` (DATETIME, NOT NULL)

### Users Table
- `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `username` (VARCHAR(50), NOT NULL, UNIQUE)
- `full_name` (VARCHAR(100), NOT NULL)
- `created_at` (DATETIME, NOT NULL)

## Routes
- `/` - Home page
- `/customer-accounts` - Customer accounts listing
- `/user-accounts` - User accounts listing
- `/operations` - Original operations page (preserved)
- `/operations/displayinfo/...` - Original displayinfo route (preserved)
- `/operations/compute/...` - Original compute route (preserved)

## Troubleshooting

### Database Connection Issues
1. Ensure MySQL service is running in XAMPP
2. Check that `.env` file exists and has correct database settings
3. Verify database name is `tfa3camacho`
4. Check MySQL username is `root` with no password (default XAMPP setting)

### Blank Pages or Errors
1. Check PHP error logs in XAMPP
2. Ensure CodeIgniter write permissions for `writable` directory
3. Verify all files are in correct locations

### No Data Displayed
1. Verify database tables have data using phpMyAdmin
2. Check that Models are correctly configured
3. Ensure database connection is working

## Verification Checklist
- [ ] XAMPP Apache and MySQL services are running
- [ ] Database `tfa3camacho` exists
- [ ] Table `customers` exists with 5+ records
- [ ] Table `users` exists with 5+ records
- [ ] `.env` file is configured correctly
- [ ] Home page loads at `http://localhost/TFA3Camacho/`
- [ ] Customer accounts page displays data correctly
- [ ] User accounts page displays data correctly
- [ ] Navigation between pages works
- [ ] No PHP errors in logs

## Summary
The TFA3 POS System has been successfully extended with MySQL database integration. The application now:
- Uses real MySQL database instead of static arrays
- Follows CodeIgniter 4 MVC conventions
- Maintains the original UI/UX design
- Preserves existing functionality
- Provides scalable data management through Models
