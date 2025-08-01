@echo off
title BlueCafe Development Server
color 0A

echo ========================================
echo    BlueCafe Development Server
echo ========================================
echo.
echo Starting Vite development server...
echo This will automatically rebuild when files change
echo.
echo To stop the server, press Ctrl+C
echo.
echo ========================================
echo.

cd /d "%~dp0"

REM Check if node_modules exists
if not exist "node_modules" (
    echo Installing dependencies...
    npm install
    echo.
)

echo Starting development server...
npm run dev

pause
