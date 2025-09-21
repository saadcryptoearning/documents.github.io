# Money Receipt Generator Setup Guide

## Prerequisites

### 1. Install PHP (without XAMPP/WAMP)
1. Download PHP from https://windows.php.net/download/
2. Extract to `C:\php`
3. Add `C:\php` to your system PATH
4. Copy `php.ini-development` to `php.ini`
5. Enable extensions in php.ini:
   - extension=pdo_mysql
   - extension=mysqli
   - extension=gd

### 2. Install MySQL (without XAMPP/WAMP)
1. Download MySQL Community Server from https://dev.mysql.com/downloads/mysql/
2. Install MySQL Server
3. Set root password during installation
4. Start MySQL service

### 3. Setup Database
1. Open MySQL Command Line Client
2. Run the SQL commands from `setup_database.sql`:
   ```sql
   CREATE DATABASE IF NOT EXISTS receipt_db;
   USE receipt_db;
   -- ... (rest of the SQL commands)
   ```

## Running the Application

### Method 1: Using Batch File
1. Double-click `start_server.bat`
2. Open browser and go to `http://localhost:8000`

### Method 2: Manual Command
1. Open Command Prompt in the project folder
2. Run: `php -S localhost:8000`
3. Open browser and go to `http://localhost:8000`

## Features

- **Download PNG**: Downloads receipt as PNG image
- **Save to Server**: Saves receipt to server and database
- **Download HTML**: Downloads receipt as HTML file

## File Structure
```
Document/
├── index.html          # Main application
├── MR.jpg             # Receipt template
├── save_receipt.php   # Backend for saving receipts
├── setup_database.sql # Database setup
├── server.php         # Server script
├── start_server.bat   # Easy start script
├── uploads/           # Folder for saved PNG files
└── SETUP_GUIDE.md     # This file
```

## Troubleshooting

1. **PHP not found**: Make sure PHP is in your PATH
2. **MySQL connection error**: Check MySQL service is running
3. **Permission denied**: Run Command Prompt as Administrator
4. **Port 8000 in use**: Change port in server.php and start_server.bat

## Database Configuration

Edit `save_receipt.php` to match your MySQL settings:
```php
$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'receipt_db',
    'username' => 'root',
    'password' => 'your_password_here'
];
```
