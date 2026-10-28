@echo off
title Servidor Localhost - Calculadora Estequiometrica
cls
echo ===================================================================
echo     SIMULADOR LOCALHOST - CALCULADORA ESTEQUIOMETRICA
echo ===================================================================
echo.
echo  [+] Iniciando servidor local em: http://localhost:8080
echo  [+] Abrindo o navegador automaticamente...
echo.
echo  Mantenha esta janela aberta enquanto estiver navegando no site.
echo  Para fechar o servidor, basta fechar esta janela ou teclar Ctrl+C.
echo ===================================================================
echo.

timeout /t 1 /nobreak >nul
start http://localhost:8080

powershell.exe -NoProfile -ExecutionPolicy Bypass -File "%~dp0server.ps1"

pause
