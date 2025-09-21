@echo off
echo ========================================
echo Database Setup Script
echo ========================================
echo.

REM Check if MySQL is running
sc query MySQL | find "RUNNING" >nul
if %errorLevel% neq 0 (
    echo Starting MySQL service...
    net start MySQL
    timeout /t 3
)

echo.
echo Creating database and tables...
echo.

REM Run the PHP database setup script
php database_setup.php

if %errorLevel% == 0 (
    echo.
    echo ========================================
    echo Database setup completed successfully!
    echo ========================================
    echo.
    echo Database: receipt_db
    echo Tables: receipts, transactions
    echo.
) else (
    echo.
    echo ========================================
    echo Database setup failed!
    echo ========================================
    echo.
    echo Please check:
    echo 1. MySQL service is running
    echo 2. PHP is properly installed
    echo 3. Database credentials are correct
    echo.
)

pause
