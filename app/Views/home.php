<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .nav {
            margin-bottom: 20px;
        }
        .nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .nav a:hover {
            text-decoration: underline;
        }
        .card-container {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }
        .card {
            flex: 1;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            transition: box-shadow 0.3s;
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card h2 {
            color: #007bff;
            margin-top: 0;
        }
        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            transition: background-color 0.3s;
        }
        .card a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="<?= base_url() ?>">Home</a>
            <a href="<?= base_url('customer-accounts') ?>">Customer Accounts</a>
            <a href="<?= base_url('user-accounts') ?>">User Accounts</a>
        </div>

        <h1>POS System - TFA2</h1>
        <p>Welcome to the Point of Sale System. Select an option below to manage accounts.</p>

        <div class="card-container">
            <div class="card">
                <h2>Customer Accounts</h2>
                <p>View and manage customer information</p>
                <a href="<?= base_url('customer-accounts') ?>">View Customers</a>
            </div>
            <div class="card">
                <h2>User Accounts</h2>
                <p>View and manage system users</p>
                <a href="<?= base_url('user-accounts') ?>">View Users</a>
            </div>
        </div>
    </div>
</body>
</html>
