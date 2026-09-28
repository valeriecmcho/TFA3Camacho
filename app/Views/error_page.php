<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8d7da;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 5px;
            border-left: 5px solid #dc3545;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            color: #dc3545;
            margin-top: 0;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 3px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
        }
        .debug-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 3px;
            margin: 20px 0;
            border: 1px solid #dee2e6;
        }
        .debug-info h3 {
            margin-top: 0;
            color: #495057;
        }
        .debug-info pre {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 3px;
            overflow-x: auto;
        }
        .actions {
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚠️ Application Error</h1>

        <div class="error-message">
            <strong>Error:</strong> <?= esc($error) ?>
        </div>

        <?php if (isset($debug_info)): ?>
        <div class="debug-info">
            <h3>Debug Information</h3>
            <pre><?= print_r($debug_info, true) ?></pre>
        </div>
        <?php endif; ?>

        <div class="actions">
            <a href="/debug" class="btn">Run Debug Check</a>
            <a href="/setup-database" class="btn btn-warning">Setup Database</a>
            <a href="/customer-accounts/setup" class="btn btn-warning">Database Setup Page</a>
        </div>

        <div style="margin-top: 30px; padding: 15px; background-color: #d1ecf1; border-radius: 3px; border: 1px solid #bee5eb;">
            <h3 style="color: #0c5460; margin-top: 0;">Troubleshooting Steps:</h3>
            <ol style="color: #0c5460;">
                <li>Click "Run Debug Check" to see detailed system information</li>
                <li>Check if PostgreSQL service is running in Railway</li>
                <li>Verify DATABASE_URL environment variable is set</li>
                <li>Run database setup using the buttons above</li>
                <li>Check Railway logs for additional error details</li>
            </ol>
        </div>
    </div>
</body>
</html>
