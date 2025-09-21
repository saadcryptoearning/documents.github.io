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
    
    // Save transaction data to JSON file (since database is not available)
    $transactionData['filename'] = $filename;
    $transactionData['created_at'] = date('Y-m-d H:i:s');
    
    // Append to JSON file
    $jsonFile = 'transactions_data.json';
    $existingData = [];
    if (file_exists($jsonFile)) {
        $existingData = json_decode(file_get_contents($jsonFile), true) ?: [];
    }
    $existingData[] = $transactionData;
    file_put_contents($jsonFile, json_encode($existingData, JSON_PRETTY_PRINT));
    
    echo json_encode([
        'success' => true,
        'message' => 'Transaction saved successfully (without database)',
        'filename' => $filename
    ]);
    
} catch (Exception $e) {
    error_log("Transaction save error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>


