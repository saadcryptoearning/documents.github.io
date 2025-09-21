<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data) {
        throw new Exception('Invalid JSON input');
    }
    
    $imageData = $data['imageData'] ?? '';
    $transactionData = $data['transactionData'] ?? [];
    
    if (empty($imageData)) {
        throw new Exception('No image data provided');
    }
    
    // Extract base64 image data
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = base64_decode($imageData);
    
    if ($imageData === false) {
        throw new Exception('Invalid image data');
    }
    
    // Generate filename
    $filename = 'transaction_' . time() . '_' . uniqid() . '.png';
    $filepath = 'uploads/' . $filename;
    
    // Ensure uploads directory exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }
    
    // Save image
    if (file_put_contents($filepath, $imageData) === false) {
        throw new Exception('Failed to save image');
    }
    
    // Database connection
    $host = 'localhost';
    $dbname = 'receipt_db';
    $username = 'root';
    $password = '';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create transactions table if it doesn't exist
        $createTable = "
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
        
        $pdo->exec($createTable);
        
        // Insert transaction data
        $stmt = $pdo->prepare("
            INSERT INTO transactions (
                filename, transaction_type, transaction_id, transaction_date, 
                from_bank, to_bank, from_account, to_account, account_name, 
                mobile_banking, transaction_amount, depositor_name, generated_time, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([
            $filename,
            $transactionData['transaction_type'] ?? '',
            $transactionData['transaction_id'] ?? '',
            $transactionData['transaction_date'] ?? '',
            $transactionData['from_bank'] ?? '',
            $transactionData['to_bank'] ?? '',
            $transactionData['from_account'] ?? '',
            $transactionData['to_account'] ?? '',
            $transactionData['account_name'] ?? '',
            $transactionData['mobile_banking'] ?? '',
            $transactionData['transaction_amount'] ?? '',
            $transactionData['depositor_name'] ?? '',
            $transactionData['generated_time'] ?? ''
        ]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Transaction saved successfully',
            'filename' => $filename
        ]);
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
    
} catch (Exception $e) {
    error_log("Transaction save error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
