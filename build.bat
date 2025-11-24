@echo off
REM Script de compilacion para Windows

echo Compilando Sistema de Gestion de Empleados...
echo.

REM Crear directorios si no existen
if not exist bin mkdir bin
if not exist data mkdir data

REM Compilar el proyecto
g++ -std=c++17 -Iinclude src\Employee.cpp src\Developer.cpp src\Manager.cpp src\EmployeeManager.cpp src\main.cpp -o bin\employee_system.exe -Wall -Wextra

if %errorlevel% equ 0 (
    echo.
    echo [32mCompilacion exitosa![0m
    echo Ejecutable creado en: bin\employee_system.exe
    echo.
    echo Para ejecutar: bin\employee_system.exe
    echo.
) else (
    echo.
    echo [31mError en la compilacion[0m
    exit /b 1
)
