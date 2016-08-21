@echo off
cd /d %~dp0
netstat -o -n -a | findstr 0.0.0.0:19132 > NUL
if %ERRORLEVEL% equ 0 (
    goto :loop
) else (
    goto :StartPM
)
:loop
ping 127.0.0.1 -n 5 > NUL
netstat -o -n -a | findstr 0.0:19132 > NUL
if %ERRORLEVEL% equ 0 (
    goto :loop
) else (
    PING 127.0.0.1 -n 5 > NUL
    goto :StartPM
)
:StartPM
if exist bin\php\php.exe (
    set PHP_BINARY=bin\php\php.exe
) else (
    set PHP_BINARY=php
)

if exist Apollo*.phar (
    set POCKETMINE_FILE=Apollo*.phar
) else (
    if exist src\pocketmine\PocketMine.php (
        set POCKETMINE_FILE=src\pocketmine\PocketMine.php
    ) else (
        echo "Couldn't find a valid Apollo installation"
        pause
        exit 1
    )
)
   REM 	%PHP_BINARY% %POCKETMINE_FILE% --enable-gui %*
REM ) else (
	if exist bin\mintty.exe (
		start "" bin\mintty.exe -o Columns=88 -o Rows=32 -o AllowBlinking=0 -o FontQuality=3 -o Font="Consolas" -o FontHeight=10 -o CursorType=0 -o CursorBlinks=1 -h error -t "ClearSky" -i bin/pocketmine.ico -w max %PHP_BINARY% %POCKETMINE_FILE% --enable-ansi %*
	) else (
		%PHP_BINARY% -c bin\php %POCKETMINE_FILE% %*
	)
goto :loop
