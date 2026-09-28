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
            // If database is not available, show setup page
            return redirect()->to('/customer-accounts/setup');
        }
    }
}
