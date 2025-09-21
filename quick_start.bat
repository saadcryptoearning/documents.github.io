@echo off
echo ========================================
echo Quick Start - PHP + MySQL Project
echo ========================================
echo.

echo This script will:
echo 1. Start MySQL service
echo 2. Start PHP development server
echo 3. Open your project in browser
echo.

REM Start MySQL
echo Starting MySQL...
net start MySQL >nul 2>&1
if %errorLevel% == 0 (
    echo MySQL started successfully!
) else (
    echo MySQL is already running or failed to start.
)

echo.
echo Starting PHP server at http://localhost:8000
echo.
echo Your project files are available at:
echo - http://localhost:8000/index.html
echo - http://localhost:8000/transaction.html
echo - http://localhost:8000/Approval.html
echo - http://localhost:8000/Cheque.html
echo - http://localhost:8000/Insurance.html
echo - http://localhost:8000/Stamp.html
echo.
echo Press Ctrl+C to stop the server
echo.

REM Open browser
start http://localhost:8000

REM Start PHP server
php -S localhost:8000
