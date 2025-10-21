@echo off
echo ===============================
echo   Safe XAMPP Shutdown
echo ===============================
echo.

echo 1. Stopping Apache gracefully...
taskkill /f /im "httpd.exe" >nul 2>&1

echo 2. Stopping MySQL gracefully...
"C:\xampp\mysql\bin\mysqladmin" -u root shutdown >nul 2>&1
timeout /t 3 >nul
taskkill /f /im "mysqld.exe" >nul 2>&1

echo 3. Closing XAMPP Control Panel...
taskkill /f /im "xampp-control.exe" >nul 2>&1

echo.
echo ✅ All services stopped safely!
echo.
pause