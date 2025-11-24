@echo off
REM Script para compilar y ejecutar

call build.bat

if %errorlevel% equ 0 (
    echo Ejecutando programa...
    echo ========================================
    echo.
    bin\employee_system.exe
)
