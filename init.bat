@ECHO OFF
for /f "tokens=1 delims=:" %%j in ('ping %computername% -4 -n 1 ^| findstr Reply') do (
    set localip=%%j
)
ECHO ==============================================================
ECHO ==============================================================
ECHO ====KITAME IRENGINYJE ATIDARYKITE: HTTP://%localip:~11%====
ECHO ==============================================================
ECHO ==============================================================
PAUSE
php -S %localip:~11%:80 -t site

PAUSE