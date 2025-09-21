<?php
// Database setup script
// This will create the database and tables if they don't exist

$host = 'localhost';
$username = 'root';
$password = ''; // Try empty password first
$dbname = 'receipt_db';

// Try different password combinations
$passwords = ['', 'root', 'password', 'admin', '123456'];

$pdo = null;
$error = '';

foreach ($passwords as $pwd) {
    try {
        $pdo = new PDO("mysql:host=$host", $username, $pwd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected to MySQL successfully!\n";
        break;
    } catch (PDOException $e) {
        $error = $e->getMessage();
        continue;
    }
}

if (!$pdo) {
    echo "Could not connect to MySQL. Error: $error\n";
    echo "Please check your MySQL installation and credentials.\n";
    exit(1);
}

try {
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "Database '$dbname' created or already exists.\n";
    
    // Use the database
    $pdo->exec("USE $dbname");
    
    // Create receipts table
    $createReceiptsTable = "
    CREATE TABLE IF NOT EXISTS receipts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        filename VARCHAR(255) NOT NULL,
        receipt_no VARCHAR(100),
        date VARCHAR(100),
        received_from TEXT,
        amount VARCHAR(100),
        in_word TEXT,
        purpose TEXT,
        account VARCHAR(255),
        paid VARCHAR(255),
        center_date VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($createReceiptsTable);
    echo "Receipts table created or already exists.\n";
    
    // Create transactions table
    $createTransactionsTable = "
    CREATE TABLE IF NOT EXISTS transactions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        filename VARCHAR(255) NOT NULL,
        transaction_type VARCHAR(100),
        transaction_id VARCHAR(100),
        transaction_date VARCHAR(100),
        from_bank VARCHAR(255),
        to_bank VARCHAR(255),
        from_account VARCHAR(255),
        to_account VARCHAR(255),
        account_name VARCHAR(255),
        mobile_banking VARCHAR(255),
        transaction_amount VARCHAR(100),
        depositor_name VARCHAR(255),
        generated_time VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($createTransactionsTable);
    echo "Transactions table created or already exists.\n";
    
    // Create indexes
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_created_at ON receipts(created_at)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_receipt_no ON receipts(receipt_no)");
    echo "Indexes created.\n";
    
    echo "\nDatabase setup completed successfully!\n";
    echo "You can now run your PHP server.\n";
    
} catch (PDOException $e) {
    echo "Database setup failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>


