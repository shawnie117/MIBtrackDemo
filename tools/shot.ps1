# DEMO BUILD RIG - screenshot a demo page.
#
# Chrome's own --screenshot writer is blocked on this machine ("Access is
# denied"), so drive it over the DevTools protocol and write the PNG from
# PowerShell instead.
#
#   powershell -File tools\shot.ps1 -Url http://127.0.0.1:8765/... -Out shot.png

param(
    [Parameter(Mandatory = $true)][string]$Url,
    [Parameter(Mandatory = $true)][string]$Out,
    [int]$Width = 1500,
    [int]$Height = 1400,
    [int]$Port = 9222,
    [int]$SettleMs = 6000
)

$ErrorActionPreference = 'Stop'

$chrome = @(
    "C:\Program Files\Google\Chrome\Application\chrome.exe",
    "C:\Program Files (x86)\Google\Chrome\Application\chrome.exe",
    "C:\Program Files\Microsoft\Edge\Application\msedge.exe",
    "C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe"
) | Where-Object { Test-Path $_ } | Select-Object -First 1

if (-not $chrome) { throw "No Chrome or Edge binary found." }

$profileDir = Join-Path $env:TEMP ("mibshot_" + [guid]::NewGuid().ToString('N'))
$proc = Start-Process -FilePath $chrome -PassThru -WindowStyle Hidden -ArgumentList @(
    '--headless=new'
    '--disable-gpu'
    '--hide-scrollbars'
    '--no-first-run'
    '--no-default-browser-check'
    "--remote-debugging-port=$Port"
    "--user-data-dir=$profileDir"
    "--window-size=$Width,$Height"
    $Url
)

function Invoke-Cdp {
    param([System.Net.WebSockets.ClientWebSocket]$Socket, [int]$Id, [string]$Method, $Params)

    $msg = @{ id = $Id; method = $Method }
    if ($Params) { $msg.params = $Params }
    $json = $msg | ConvertTo-Json -Depth 10 -Compress

    $bytes = [Text.Encoding]::UTF8.GetBytes($json)
    $Socket.SendAsync(
        [ArraySegment[byte]]::new($bytes),
        [System.Net.WebSockets.WebSocketMessageType]::Text,
        $true,
        [Threading.CancellationToken]::None).Wait()

    # Read frames until the reply carrying our id shows up; CDP interleaves
    # unsolicited events on the same socket.
    while ($true) {
        $sb = New-Object Text.StringBuilder
        while ($true) {
            $buf = [ArraySegment[byte]]::new((New-Object byte[] 262144))
            $r = $Socket.ReceiveAsync($buf, [Threading.CancellationToken]::None)
            $r.Wait()
            [void]$sb.Append([Text.Encoding]::UTF8.GetString($buf.Array, 0, $r.Result.Count))
            if ($r.Result.EndOfMessage) { break }
        }
        $obj = $sb.ToString() | ConvertFrom-Json
        if ($obj.id -eq $Id) { return $obj }
    }
}

try {
    # Wait for the debugging endpoint, then find the page target.
    $wsUrl = $null
    foreach ($attempt in 1..40) {
        Start-Sleep -Milliseconds 400
        try {
            $targets = Invoke-RestMethod -Uri "http://127.0.0.1:$Port/json/list" -TimeoutSec 5
            $page = $targets | Where-Object { $_.type -eq 'page' } | Select-Object -First 1
            if ($page) { $wsUrl = $page.webSocketDebuggerUrl; break }
        } catch { }
    }
    if (-not $wsUrl) { throw "DevTools endpoint never became available on port $Port." }

    Start-Sleep -Milliseconds $SettleMs

    $socket = New-Object System.Net.WebSockets.ClientWebSocket
    $socket.ConnectAsync([Uri]$wsUrl, [Threading.CancellationToken]::None).Wait()

    $reply = Invoke-Cdp -Socket $socket -Id 1 -Method 'Page.captureScreenshot' -Params @{
        format               = 'png'
        captureBeyondViewport = $true
    }

    if (-not $reply.result.data) { throw "captureScreenshot returned no data." }

    $outPath = if ([IO.Path]::IsPathRooted($Out)) { $Out } else { Join-Path (Get-Location) $Out }
    [IO.File]::WriteAllBytes($outPath, [Convert]::FromBase64String($reply.result.data))

    $socket.CloseAsync([System.Net.WebSockets.WebSocketCloseStatus]::NormalClosure, 'done',
        [Threading.CancellationToken]::None).Wait()

    "wrote {0} ({1} bytes)" -f $outPath, (Get-Item $outPath).Length
}
finally {
    if ($proc -and -not $proc.HasExited) { $proc | Stop-Process -Force -ErrorAction SilentlyContinue }
    Remove-Item -Recurse -Force $profileDir -ErrorAction SilentlyContinue
}
