<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        try {
            // Test database connection
            $db = \Config\Database::connect();
            $db->query("SELECT 1");

            return view('home');
        } catch (\Exception $e) {
            // If database is not available, show error page with details
            $data = [
                'error' => 'Database connection failed: ' . $e->getMessage(),
                'debug_info' => [
                    'driver' => env('database.default.DBDriver', 'MySQLi'),
                    'host' => env('database.default.hostname', 'localhost'),
                    'database' => env('database.default.database', 'tfa3camacho'),
                    'database_url_set' => getenv('DATABASE_URL') !== false,
                ]
            ];

            return view('error_page', $data);
        }
    }
}
