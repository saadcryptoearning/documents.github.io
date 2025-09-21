@echo off
echo ========================================
echo Starting PHP and MySQL Services
echo ========================================
echo.

REM Check if MySQL is running
sc query MySQL | find "RUNNING" >nul
if %errorLevel% neq 0 (
    echo Starting MySQL service...
    net start MySQL
    if %errorLevel% == 0 (
        echo MySQL started successfully!
    ) else (
        echo Failed to start MySQL service.
        echo Please check if MySQL is properly installed.
        pause
        exit /b 1
    )
) else (
    echo MySQL is already running.
)

echo.
echo Starting PHP development server...
echo Server will be available at: http://localhost:8000
echo Press Ctrl+C to stop the server
echo.

REM Start PHP server
php -S localhost:8000

pause
