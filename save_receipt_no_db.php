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
    
    // Ensure uploads directory exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }
    
    // Save the image
    if (file_put_contents($filepath, $imageData)) {
        // Save receipt data to JSON file (since database is not available)
        $receiptData = $input['receiptData'];
        $receiptData['filename'] = $filename;
        $receiptData['created_at'] = date('Y-m-d H:i:s');
        
        // Append to JSON file
        $jsonFile = 'receipts_data.json';
        $existingData = [];
        if (file_exists($jsonFile)) {
            $existingData = json_decode(file_get_contents($jsonFile), true) ?: [];
        }
        $existingData[] = $receiptData;
        file_put_contents($jsonFile, json_encode($existingData, JSON_PRETTY_PRINT));
        
        echo json_encode([
            'success' => true,
            'filename' => $filename,
            'filepath' => $filepath,
            'message' => 'Receipt saved successfully (without database)'
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


