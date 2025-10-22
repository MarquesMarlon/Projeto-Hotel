@echo off
cd /d "%~dp0"

:: Exibe título bonito
echo ============================================
echo     🚀 Subindo projeto pro GitHub...
echo ============================================
echo.

:: Adiciona todas as alterações
git add .

:: Cria commit com data e hora
set hora=%time:~0,2%:%time:~3,2%
set data=%date%
git commit -m "Atualizacao automatica em %data% %hora%"

:: Faz o push pro GitHub
git push

echo.
echo ✅ Projeto enviado com sucesso!
pause
