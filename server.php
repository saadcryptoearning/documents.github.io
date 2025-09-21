<?php
// Simple PHP development server
// Run with: php server.php

$host = 'localhost';
$port = 8000;

echo "Starting server at http://{$host}:{$port}\n";
echo "Press Ctrl+C to stop the server\n\n";

// Start the built-in PHP server
$command = "php -S {$host}:{$port}";
passthru($command);
?>
