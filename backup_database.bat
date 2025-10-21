@echo off
echo ===============================
echo   Database Backup
echo ===============================
echo.

set timestamp=%date:~10,4%%date:~4,2%%date:~7,2%_%time:~0,2%%time:~3,2%
set timestamp=%timestamp: =0%

echo Creating database backup...
"C:\xampp\mysql\bin\mysqldump" -u root kad_kahwin > "backups\kad_kahwin_%timestamp%.sql" 2>nul

if %ERRORLEVEL% EQU 0 (
    echo ✅ Database backed up to: backups\kad_kahwin_%timestamp%.sql
) else (
    echo ❌ Backup failed - make sure MySQL is running and database exists
)

echo.
pause