@echo off
title PasteBin Clone - Development Server
cls

echo.
echo ================================
echo  PasteBin Clone Development
echo ================================
echo.
echo Starting application...
echo.

REM Check if node_modules exists
if not exist "node_modules\" (
    echo Installing npm dependencies...
    call npm install --legacy-peer-deps
    echo.
)

REM Check if .env exists and has APP_KEY
findstr /M "APP_KEY=" .env > nul
if errorlevel 1 (
    echo Generating application key...
    call php artisan key:generate
    echo.
)

REM Run migrations silently if needed
echo.
echo Running database migrations...
php artisan migrate --quiet
echo.

REM Start the servers
echo.
echo ================================
echo  Starting servers...
echo ================================
echo.
echo Open two PowerShell/CMD windows:
echo.
echo Window 1: php artisan serve
echo Window 2: npm run dev
echo.
echo Or run this command in two separate terminals:
echo.
echo Terminal 1:
echo   php artisan serve
echo.
echo Terminal 2:
echo   npm run dev
echo.
echo Then open: http://localhost:8000
echo.
echo Press any key to open Laravel in default terminal...
pause

start cmd /k "php artisan serve"
start cmd /k "npm run dev"
