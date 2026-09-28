<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('operations', 'Operations::index');
$routes->get('operations/displayinfo/(:segment)/(:segment)/(:segment)/(:segment)/(:segment)', 'Operations::displayinfo/$1/$2/$3/$4/$5');
$routes->get('operations/compute/(:num)/(:num)', 'Operations::compute/$1/$2');
$routes->get('operations/compute', 'Operations::compute');

// POS System Routes
$routes->get('customer-accounts', 'CustomerAccounts::index');
$routes->get('customer-accounts/setup', 'CustomerAccounts::setupDatabase');
$routes->post('customer-accounts/setup', 'CustomerAccounts::performSetup');

// Standalone database setup script for Railway
$routes->get('setup-database', function() {
    include ROOTPATH . 'setup_railway_database.php';
});

// Debug endpoint for Railway troubleshooting
$routes->get('debug', function() {
    echo "<h1>Railway Debug Information</h1>";

    echo "<h2>Environment Variables:</h2>";
    echo "<pre>";
    echo "DATABASE_URL: " . (getenv('DATABASE_URL') ? 'SET' : 'NOT SET') . "\n";
    echo "CI_ENVIRONMENT: " . getenv('CI_ENVIRONMENT') . "\n";
    echo "PHP_VERSION: " . getenv('PHP_VERSION') . "\n";
    echo "PORT: " . getenv('PORT') . "\n";
    echo "</pre>";

    echo "<h2>PHP Configuration:</h2>";
    echo "<pre>";
    echo "PHP Version: " . PHP_VERSION . "\n";
    echo "Loaded Extensions: " . implode(', ', get_loaded_extensions()) . "\n";
    echo "PostgreSQL Extension: " . (extension_loaded('pgsql') ? 'LOADED' : 'NOT LOADED') . "\n";
    echo "PDO PostgreSQL: " . (extension_loaded('pdo_pgsql') ? 'LOADED' : 'NOT LOADED') . "\n";
    echo "</pre>";

    echo "<h2>Database Connection Test:</h2>";
    try {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT 1");
        echo "<p style='color: green;'>✓ Database connection successful!</p>";
        echo "<pre>";
        echo "Driver: " . $db->DBDriver . "\n";
        echo "Database: " . $db->database . "\n";
        echo "Host: " . $db->hostname . "\n";
        echo "</pre>";
    } catch (\Exception $e) {
        echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
    }

    echo "<h2>File Permissions:</h2>";
    echo "<pre>";
    echo "Writable directory exists: " . (is_dir(WRITEPATH) ? 'YES' : 'NO') . "\n";
    echo "Writable directory writable: " . (is_writable(WRITEPATH) ? 'YES' : 'NO') . "\n";
    echo "Session directory exists: " . (is_dir(WRITEPATH . 'session') ? 'YES' : 'NO') . "\n";
    echo "Session directory writable: " . (is_writable(WRITEPATH . 'session') ? 'YES' : 'NO') . "\n";
    echo "</pre>";

    echo "<h2>Base URL:</h2>";
    echo "<pre>";
    $appConfig = new \Config\App();
    echo "Base URL: " . $appConfig->baseURL . "\n";
    echo "</pre>";

    echo "<h2>Request Information:</h2>";
    echo "<pre>";
    echo "Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'NOT SET') . "\n";
    echo "HTTP Host: " . ($_SERVER['HTTP_HOST'] ?? 'NOT SET') . "\n";
    echo "HTTPS: " . (isset($_SERVER['HTTPS']) ? 'ON' : 'OFF') . "\n";
    echo "</pre>";
});

// Health check endpoint for Railway
$routes->get('health', function() {
    http_response_code(200);
    echo json_encode([
        'status' => 'healthy',
        'timestamp' => date('Y-m-d H:i:s'),
        'php_version' => PHP_VERSION,
        'database_url_set' => getenv('DATABASE_URL') !== false
    ]);
});
$routes->get('customers/new', 'CustomerAccounts::new');
$routes->post('customers/create', 'CustomerAccounts::create');
$routes->get('customers/edit/(:num)', 'CustomerAccounts::edit/$1');
$routes->post('customers/update/(:num)', 'CustomerAccounts::update/$1');
$routes->get('user-accounts', 'UserAccounts::index');
$routes->get('users/new', 'UserAccounts::new');
$routes->post('users/create', 'UserAccounts::create');
$routes->get('users/edit/(:num)', 'UserAccounts::edit/$1');
$routes->post('users/update/(:num)', 'UserAccounts::update/$1');
