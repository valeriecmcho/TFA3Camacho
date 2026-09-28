<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - POS System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .setup-info {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Database Setup</h1>

        <div class="setup-info">
            <h3>Setup Instructions</h3>
            <p>This application requires a database to function. Please follow these steps:</p>
            <ol>
                <li><strong>For Railway Deployment:</strong> Add a PostgreSQL service to your Railway project and connect it to this web service.</li>
                <li><strong>For Local Development:</strong> Ensure your MySQL database is running and configured in the .env file.</li>
                <li>Click the "Setup Database" button below to create the required tables and sample data.</li>
            </ol>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error">
                <strong>Error:</strong> <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="success">
                <strong>Success:</strong> <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('customer-accounts/setup') ?>" method="post">
            <button type="submit" class="btn btn-primary">Setup Database</button>
        </form>

        <div style="margin-top: 20px;">
            <p><strong>Database Status:</strong></p>
            <?php
            try {
                $db = \Config\Database::connect();
                $db->query("SELECT 1");
                echo '<span style="color: green;">✓ Database connection successful</span>';

                // Check if tables exist
                try {
                    $db->query("SELECT * FROM customers LIMIT 1");
                    echo '<br><span style="color: green;">✓ Customers table exists</span>';
                } catch (\Exception $e) {
                    echo '<br><span style="color: orange;">⚠ Customers table not found (needs setup)</span>';
                }

                try {
                    $db->query("SELECT * FROM users LIMIT 1");
                    echo '<br><span style="color: green;">✓ Users table exists</span>';
                } catch (\Exception $e) {
                    echo '<br><span style="color: orange;">⚠ Users table not found (needs setup)</span>';
                }
            } catch (\Exception $e) {
                echo '<span style="color: red;">✗ Database connection failed: ' . esc($e->getMessage()) . '</span>';
            }
            ?>
        </div>

        <div style="margin-top: 20px;">
            <a href="<?= base_url() ?>">Back to Home</a>
        </div>
    </div>
</body>
</html>
