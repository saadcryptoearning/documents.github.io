-- Create database
CREATE DATABASE IF NOT EXISTS receipt_db;
USE receipt_db;

-- Create receipts table
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
);

-- Create index for better performance
CREATE INDEX idx_created_at ON receipts(created_at);
CREATE INDEX idx_receipt_no ON receipts(receipt_no);
