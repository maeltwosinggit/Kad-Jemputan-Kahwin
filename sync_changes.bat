@echo off
echo ===============================
echo   Syncing Project Changes
echo ===============================
echo.

echo Copying updated files to XAMPP...
robocopy "C:\Users\uadrian\Documents\My-Projects-Local\Kad-Jemputan-Kahwin" "C:\xampp\htdocs\kad-kahwin" /MIR /NFL /NDL /NJH /NJS

if %ERRORLEVEL% LEQ 1 (
    echo ✅ Files synced successfully!
    echo 🌐 Refresh http://localhost/kad-kahwin to see changes
) else (
    echo ❌ Error syncing files
)

echo.
pause