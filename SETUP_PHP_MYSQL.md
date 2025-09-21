# PHP and MySQL Setup Guide (Without XAMPP)

This guide will help you install PHP and MySQL directly on your C: drive without using XAMPP or other bundled solutions.

## Prerequisites

- Windows 10/11
- Administrator privileges
- Internet connection for downloads

## Installation Steps

### Step 1: Run the Installation Script

1. **Right-click** on `install_php_mysql.bat` and select **"Run as administrator"**
2. The script will automatically:
   - Download PHP 8.2 Thread Safe version
   - Download MySQL 8.0
   - Extract both to C:\php and C:\mysql
   - Add them to your system PATH
   - Install MySQL as a Windows service

### Step 2: Configure PHP

1. Run `configure_php.bat` as administrator
2. This will:
   - Enable required PHP extensions (MySQL, PDO, etc.)
   - Configure upload settings
   - Enable error reporting for development

### Step 3: Setup Database

1. Run `setup_database.bat`
2. This will:
   - Start MySQL service
   - Create the `receipt_db` database
   - Create required tables (receipts, transactions)

### Step 4: Start Your Project

1. Run `quick_start.bat` to start both services and open your project
2. Or run `start_services.bat` to just start the services

## Manual Installation (Alternative)

If the automated script doesn't work, follow these manual steps:

### Install PHP

1. Download PHP 8.2 Thread Safe from: https://windows.php.net/downloads/releases/php-8.2.26-Win32-vs16-x64.zip
2. Extract to `C:\php`
3. Copy `php.ini-development` to `php.ini`
4. Add `C:\php` to your system PATH

### Install MySQL

1. Download MySQL 8.0 from: https://dev.mysql.com/get/Downloads/MySQL-8.0/mysql-8.0.35-winx64.zip
2. Extract to `C:\mysql`
3. Create `C:\mysql\my.ini` with basic configuration
4. Initialize data directory: `C:\mysql\bin\mysqld.exe --initialize-insecure --datadir=C:\mysql\data`
5. Install as service: `C:\mysql\bin\mysqld.exe --install MySQL`
6. Start service: `net start MySQL`
7. Add `C:\mysql\bin` to your system PATH

## Project Structure

Your project includes:
- **PHP Server**: `server.php` - Simple PHP development server
- **Database Setup**: `database_setup.php` - Creates database and tables
- **Receipt System**: `save_receipt.php` - Handles receipt saving
- **Transaction System**: `save_transaction.php` - Handles transaction saving
- **HTML Pages**: Various document generation pages

## Available URLs

Once running, your project will be available at:
- Main page: http://localhost:8000/index.html
- Receipt generator: http://localhost:8000/transaction.html
- Approval documents: http://localhost:8000/Approval.html
- Cheque generator: http://localhost:8000/Cheque.html
- Insurance documents: http://localhost:8000/Insurance.html
- Stamp generator: http://localhost:8000/Stamp.html

## Troubleshooting

### MySQL Won't Start
- Check if port 3306 is already in use
- Run `net stop MySQL` then `net start MySQL`
- Check Windows Event Viewer for MySQL errors

### PHP Extensions Not Working
- Verify `php.ini` exists in `C:\php\`
- Check that extension files exist in `C:\php\ext\`
- Restart command prompt after PATH changes

### Database Connection Issues
- Ensure MySQL service is running
- Check database credentials in PHP files
- Verify database exists: `mysql -u root -p -e "SHOW DATABASES;"`

### Port Already in Use
- Change port in `start_services.bat` from 8000 to another port
- Update URLs accordingly

## File Locations

- **PHP**: `C:\php\`
- **MySQL**: `C:\mysql\`
- **MySQL Data**: `C:\mysql\data\`
- **Project**: Current directory

## Security Notes

- This setup is for development only
- MySQL root user has no password by default
- Consider setting up proper authentication for production use

## Support

If you encounter issues:
1. Check Windows Event Viewer for errors
2. Verify all files downloaded correctly
3. Ensure you have administrator privileges
4. Check that ports 3306 (MySQL) and 8000 (PHP) are available
