@echo off
echo ========================================
echo PHP Configuration Script
echo ========================================
echo.

if not exist "C:\php\php.ini" (
    echo Creating php.ini from template...
    copy "C:\php\php.ini-development" "C:\php\php.ini"
)

echo.
echo Configuring PHP settings for your project...
echo.

REM Enable required extensions
powershell -Command "(Get-Content 'C:\php\php.ini') -replace ';extension=pdo_mysql', 'extension=pdo_mysql' | Set-Content 'C:\php\php.ini'"
powershell -Command "(Get-Content 'C:\php\php.ini') -replace ';extension=mysqli', 'extension=mysqli' | Set-Content 'C:\php\php.ini'"
powershell -Command "(Get-Content 'C:\php\php.ini') -replace ';extension=openssl', 'extension=openssl' | Set-Content 'C:\php\php.ini'"
powershell -Command "(Get-Content 'C:\php\php.ini') -replace ';extension=curl', 'extension=curl' | Set-Content 'C:\php\php.ini'"
powershell -Command "(Get-Content 'C:\php\php.ini') -replace ';extension=fileinfo', 'extension=fileinfo' | Set-Content 'C:\php\php.ini'"
powershell -Command "(Get-Content 'C:\php\php.ini') -replace ';extension=mbstring', 'extension=mbstring' | Set-Content 'C:\php\php.ini'"
powershell -Command "(Get-Content 'C:\php\php.ini') -replace ';extension=gd', 'extension=gd' | Set-Content 'C:\php\php.ini'"

echo Extensions enabled: pdo_mysql, mysqli, openssl, curl, fileinfo, mbstring, gd

REM Configure upload settings
powershell -Command "(Get-Content 'C:\php\php.ini') -replace 'upload_max_filesize = 2M', 'upload_max_filesize = 10M' | Set-Content 'C:\php\php.ini'"
powershell -Command "(Get-Content 'C:\php\php.ini') -replace 'post_max_size = 8M', 'post_max_size = 10M' | Set-Content 'C:\php\php.ini'"
powershell -Command "(Get-Content 'C:\php\php.ini') -replace 'max_execution_time = 30', 'max_execution_time = 60' | Set-Content 'C:\php\php.ini'"

echo Upload settings configured.

REM Enable error reporting for development
powershell -Command "(Get-Content 'C:\php\php.ini') -replace 'display_errors = Off', 'display_errors = On' | Set-Content 'C:\php\php.ini'"
powershell -Command "(Get-Content 'C:\php\php.ini') -replace 'display_startup_errors = Off', 'display_startup_errors = On' | Set-Content 'C:\php\php.ini'"

echo Error reporting enabled for development.

echo.
echo ========================================
echo PHP Configuration Complete!
echo ========================================
echo.
echo PHP has been configured with:
echo - MySQL extensions enabled
echo - Upload limits increased
echo - Error reporting enabled
echo.
echo You can now run your PHP project.
echo.
pause
