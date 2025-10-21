@echo off
echo ===============================
echo   Wedding Invitation Dev Setup
echo ===============================
echo.

echo 1. Stopping any running services...
taskkill /f /im "mysqld.exe" >nul 2>&1
taskkill /f /im "httpd.exe" >nul 2>&1
timeout /t 2 >nul

echo 2. Starting XAMPP Control Panel...
start "" "C:\xampp\xampp-control.exe"

echo 3. Syncing project files to XAMPP...
robocopy "C:\Users\uadrian\Documents\My-Projects-Local\Kad-Jemputan-Kahwin" "C:\xampp\htdocs\kad-kahwin" /MIR /NFL /NDL /NJH /NJS

echo.
echo ✅ Setup Complete!
echo 📂 Project URL: http://localhost/kad-kahwin
echo 🔧 phpMyAdmin: http://localhost/phpmyadmin
echo.
echo ⚠️  Manual Steps:
echo    1. In XAMPP Control Panel: Start Apache
echo    2. In XAMPP Control Panel: Start MySQL
echo    3. Wait 5 seconds between starting each service
echo.
pause