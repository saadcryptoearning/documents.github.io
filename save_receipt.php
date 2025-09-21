<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get the POST data
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['imageData']) || !isset($input['receiptData'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required data']);
    exit;
}

try {
    // Decode the base64 image data
    $imageData = $input['imageData'];
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = base64_decode($imageData);
    
    // Generate unique filename
    $filename = 'receipt_' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.png';
    $filepath = 'uploads/' . $filename;
    
    // Save the image
    if (file_put_contents($filepath, $imageData)) {
        // Save receipt data to database (optional)
        $receiptData = $input['receiptData'];
        
        // Create database connection (you'll need to configure this)
        $dbConfig = [
            'host' => 'localhost',
            'dbname' => 'receipt_db',
            'username' => 'root',
            'password' => ''
        ];
        
        try {
            $pdo = new PDO("mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}", 
                          $dbConfig['username'], $dbConfig['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Insert receipt data
            $stmt = $pdo->prepare("INSERT INTO receipts (filename, receipt_no, date, received_from, amount, in_word, purpose, account, paid, center_date, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([
                $filename,
                $receiptData['no'] ?? '',
                $receiptData['date'] ?? '',
                $receiptData['from'] ?? '',
                $receiptData['amount'] ?? '',
                $receiptData['inword'] ?? '',
                $receiptData['for'] ?? '',
                $receiptData['acct'] ?? '',
                $receiptData['paid'] ?? '',
                $receiptData['center_date'] ?? ''
            ]);
            
        } catch (PDOException $e) {
            // Database error, but still save the file
            error_log("Database error: " . $e->getMessage());
        }
        
        echo json_encode([
            'success' => true,
            'filename' => $filename,
            'filepath' => $filepath,
            'message' => 'Receipt saved successfully'
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save file']);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
