@echo off
echo ========================================
echo PHP and MySQL Installation Script
echo ========================================
echo.

REM Check if running as administrator
net session >nul 2>&1
if %errorLevel% == 0 (
    echo Running as Administrator - Good!
) else (
    echo Please run this script as Administrator
    echo Right-click and select "Run as administrator"
    pause
    exit /b 1
)

echo.
echo Creating directories on C: drive...
if not exist "C:\php" mkdir "C:\php"
if not exist "C:\mysql" mkdir "C:\mysql"
if not exist "C:\mysql\data" mkdir "C:\mysql\data"
if not exist "C:\mysql\bin" mkdir "C:\mysql\bin"

echo.
echo ========================================
echo Step 1: Downloading PHP
echo ========================================
echo.

REM Download PHP 8.2 Thread Safe version
echo Downloading PHP 8.2 Thread Safe...
powershell -Command "& {[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12; Invoke-WebRequest -Uri 'https://windows.php.net/downloads/releases/php-8.2.26-Win32-vs16-x64.zip' -OutFile 'C:\php.zip'}"

if exist "C:\php.zip" (
    echo Extracting PHP...
    powershell -Command "Expand-Archive -Path 'C:\php.zip' -DestinationPath 'C:\php' -Force"
    del "C:\php.zip"
    echo PHP extracted successfully!
) else (
    echo Failed to download PHP. Please check your internet connection.
    pause
    exit /b 1
)

echo.
echo ========================================
echo Step 2: Downloading MySQL
echo ========================================
echo.

REM Download MySQL 8.0
echo Downloading MySQL 8.0...
powershell -Command "& {[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12; Invoke-WebRequest -Uri 'https://dev.mysql.com/get/Downloads/MySQL-8.0/mysql-8.0.35-winx64.zip' -OutFile 'C:\mysql.zip'}"

if exist "C:\mysql.zip" (
    echo Extracting MySQL...
    powershell -Command "Expand-Archive -Path 'C:\mysql.zip' -DestinationPath 'C:\mysql' -Force"
    del "C:\mysql.zip"
    echo MySQL extracted successfully!
) else (
    echo Failed to download MySQL. Please check your internet connection.
    pause
    exit /b 1
)

echo.
echo ========================================
echo Step 3: Configuring PHP
echo ========================================
echo.

REM Copy php.ini-development to php.ini
if exist "C:\php\php.ini-development" (
    copy "C:\php\php.ini-development" "C:\php\php.ini"
    echo PHP configuration file created.
) else (
    echo Warning: php.ini-development not found. You may need to create php.ini manually.
)

echo.
echo ========================================
echo Step 4: Adding to PATH
echo ========================================
echo.

REM Add PHP and MySQL to PATH
setx PATH "%PATH%;C:\php;C:\mysql\bin" /M
echo Added PHP and MySQL to system PATH.

echo.
echo ========================================
echo Step 5: Installing MySQL as Service
echo ========================================
echo.

REM Initialize MySQL data directory
echo Initializing MySQL data directory...
C:\mysql\bin\mysqld.exe --initialize-insecure --datadir=C:\mysql\data

REM Install MySQL as Windows service
echo Installing MySQL as Windows service...
C:\mysql\bin\mysqld.exe --install MySQL --defaults-file=C:\mysql\my.ini

REM Start MySQL service
echo Starting MySQL service...
net start MySQL

echo.
echo ========================================
echo Installation Complete!
echo ========================================
echo.
echo PHP is installed at: C:\php
echo MySQL is installed at: C:\mysql
echo.
echo Next steps:
echo 1. Run setup_database.bat to create your database
echo 2. Run start_services.bat to start PHP and MySQL
echo 3. Run your PHP project
echo.
pause
