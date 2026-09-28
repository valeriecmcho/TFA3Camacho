<?php
// Add avatar column to users table
$host = 'localhost';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=tfa3camacho", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if column already exists
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'avatar'");
    if ($stmt->rowCount() > 0) {
        echo "Column 'avatar' already exists in users table.<br>";
    } else {
        // Add avatar column
        $pdo->exec("ALTER TABLE users ADD COLUMN avatar VARCHAR(255) DEFAULT NULL AFTER full_name");
        echo "Column 'avatar' added to users table successfully.<br>";
    }

    echo "<br><strong>Migration completed successfully!</strong>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
