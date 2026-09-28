<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerAccounts extends BaseController
{
    public function index()
    {
        try {
            $customerModel = new CustomerModel();
            $data['customers'] = $customerModel->findAll();

            return view('customer_accounts', $data);
        } catch (\Exception $e) {
            // If database is not available, show error message
            $data['error'] = 'Database connection failed: ' . $e->getMessage();
            $data['customers'] = [];
            return view('customer_accounts', $data);
        }
    }

    public function setupDatabase()
    {
        // Show the setup page
        return view('database_setup');
    }

    public function performSetup()
    {
        // This method will setup the database tables and sample data
        // Only run this in development or when database needs to be initialized
        try {
            $db = \Config\Database::connect();
            $dbDriver = $db->DBDriver;

            if ($dbDriver === 'Postgre') {
                // PostgreSQL syntax
                $db->query("CREATE TABLE IF NOT EXISTS customers (
                    id SERIAL PRIMARY KEY,
                    full_name VARCHAR(100) NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    phone VARCHAR(20),
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                )");

                $db->query("CREATE TABLE IF NOT EXISTS users (
                    id SERIAL PRIMARY KEY,
                    username VARCHAR(50) NOT NULL UNIQUE,
                    full_name VARCHAR(100) NOT NULL,
                    avatar VARCHAR(255) DEFAULT NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                )");

                // Insert sample data if tables are empty
                $customerCount = $db->query("SELECT COUNT(*) as count FROM customers")->getRow()->count;
                if ($customerCount == 0) {
                    $db->query("INSERT INTO customers (full_name, email, phone, created_at) VALUES
                        ('Juan Dela Cruz', 'juan@example.com', '09171234567', NOW()),
                        ('Maria Santos', 'maria@example.com', '09181234567', NOW()),
                        ('Pedro Reyes', 'pedro@example.com', '09191234567', NOW()),
                        ('Ana Garcia', 'ana@example.com', '09201234567', NOW()),
                        ('Mark Flores', 'mark@example.com', '09211234567', NOW())");
                }

                $userCount = $db->query("SELECT COUNT(*) as count FROM users")->getRow()->count;
                if ($userCount == 0) {
                    $db->query("INSERT INTO users (username, full_name, created_at) VALUES
                        ('admin', 'Administrator', NOW()),
                        ('cashier1', 'John Smith', NOW()),
                        ('cashier2', 'Jane Doe', NOW()),
                        ('manager', 'Robert Johnson', NOW()),
                        ('supervisor', 'Emily Brown', NOW())");
                }
            } else {
                // MySQL syntax
                $db->query("CREATE TABLE IF NOT EXISTS customers (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    full_name VARCHAR(100) NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    phone VARCHAR(20),
                    created_at DATETIME NOT NULL
                )");

                $db->query("CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) NOT NULL UNIQUE,
                    full_name VARCHAR(100) NOT NULL,
                    avatar VARCHAR(255) DEFAULT NULL,
                    created_at DATETIME NOT NULL
                )");

                // Insert sample data if tables are empty
                $customerCount = $db->query("SELECT COUNT(*) as count FROM customers")->getRow()->count;
                if ($customerCount == 0) {
                    $db->query("INSERT INTO customers (full_name, email, phone, created_at) VALUES
                        ('Juan Dela Cruz', 'juan@example.com', '09171234567', NOW()),
                        ('Maria Santos', 'maria@example.com', '09181234567', NOW()),
                        ('Pedro Reyes', 'pedro@example.com', '09191234567', NOW()),
                        ('Ana Garcia', 'ana@example.com', '09201234567', NOW()),
                        ('Mark Flores', 'mark@example.com', '09211234567', NOW())");
                }

                $userCount = $db->query("SELECT COUNT(*) as count FROM users")->getRow()->count;
                if ($userCount == 0) {
                    $db->query("INSERT INTO users (username, full_name, created_at) VALUES
                        ('admin', 'Administrator', NOW()),
                        ('cashier1', 'John Smith', NOW()),
                        ('cashier2', 'Jane Doe', NOW()),
                        ('manager', 'Robert Johnson', NOW()),
                        ('supervisor', 'Emily Brown', NOW())");
                }
            }

            return redirect()->to('/customer-accounts')->with('success', 'Database setup completed successfully');

        } catch (\Exception $e) {
            return redirect()->to('/customer-accounts/setup')->with('error', 'Database setup failed: ' . $e->getMessage());
        }
    }

    public function new()
    {
        return view('customer_new');
    }

    public function create()
    {
        $customerModel = new CustomerModel();

        // Check if email already exists
        $email = $this->request->getPost('email');
        $existingCustomer = $customerModel->where('email', $email)->first();
        if ($existingCustomer) {
            return redirect()->back()->withInput()->with('error', 'Email already exists');
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $email,
            'phone' => $this->request->getPost('phone'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($customerModel->insert($data)) {
            return redirect()->to('/customer-accounts')->with('success', 'Customer created successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $customerModel->errors());
        }
    }

    public function edit($id)
    {
        $customerModel = new CustomerModel();
        $data['customer'] = $customerModel->find($id);

        if (!$data['customer']) {
            return redirect()->to('/customer-accounts')->with('error', 'Customer not found');
        }

        return view('customer_edit', $data);
    }

    public function update($id)
    {
        $customerModel = new CustomerModel();

        $email = $this->request->getPost('email');

        // Check if email is unique (excluding current customer)
        $existingCustomer = $customerModel->where('email', $email)->where('id !=', $id)->first();
        if ($existingCustomer) {
            return redirect()->back()->withInput()->with('error', 'Email already exists');
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $email,
            'phone' => $this->request->getPost('phone')
        ];

        if ($customerModel->update($id, $data)) {
            return redirect()->to('/customer-accounts')->with('success', 'Customer updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $customerModel->errors());
        }
    }
}
