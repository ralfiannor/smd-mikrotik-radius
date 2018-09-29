set PHP=D:\laragon\bin\php\php-5.6.16\php.exe
set DAEMON=D:\laragon\www\pkl_mikrotik\proses_gammu.php

:: Execute
@echo off
:TOP
%PHP% %DAEMON%
ping 127.0.0.1 -n 3 > nul
CLS
ECHO ---------------------------------
ECHO --- Layanan Cek SMS By StrLen ---
ECHO ---------------------------------
ECHO.
ECHO Service running...
ECHO.
ECHO.
ECHO ----------------------------------
ECHO Tekan CTRL+C untuk berhenti
ECHO ----------------------------------
goto :TOP
