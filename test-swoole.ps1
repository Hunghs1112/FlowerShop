# PowerShell Test Script for Swoole WebSocket
# Usage: powershell test-swoole.ps1

Write-Host "🧪 Testing Swoole WebSocket Server..." -ForegroundColor Cyan
Write-Host ""

$Host = "127.0.0.1"
$Port = 9501
$Green = "Green"
$Red = "Red"
$Yellow = "Yellow"

Write-Host "Configuration:"
Write-Host "  Host: $Host"
Write-Host "  Port: $Port"
Write-Host ""

# Test 1: Check if port is open
Write-Host "Test 1: Checking if port $Port is open..."
try {
    $connection = New-Object System.Net.Sockets.TcpClient($Host, $Port)
    if ($connection.Connected) {
        Write-Host "✓ Port $Port is open" -ForegroundColor $Green
        $connection.Close()
    }
} catch {
    Write-Host "✗ Port $Port is not accessible" -ForegroundColor $Red
    Write-Host "  Make sure Swoole server is running: php artisan swoole:serve start" -ForegroundColor $Yellow
    exit 1
}

# Test 2: Check if PHP process is running
Write-Host ""
Write-Host "Test 2: Checking Swoole PHP process..."
$process = Get-Process -Name php -ErrorAction SilentlyContinue | Where-Object {
    $_.CommandLine -like "*swoole:serve*"
}

if ($process) {
    Write-Host "✓ Swoole server is running (PID: $($process.Id))" -ForegroundColor $Green
} else {
    Write-Host "⚠ Swoole server process not found" -ForegroundColor $Yellow
    Write-Host "  Checking artisan process..." -ForegroundColor $Yellow
}

# Test 3: Check PID file
Write-Host ""
Write-Host "Test 3: Checking PID file..."
$PidFile = "storage\app\swoole.pid"
if (Test-Path $PidFile) {
    $PidContent = Get-Content $PidFile
    Write-Host "✓ PID file exists: $PidContent" -ForegroundColor $Green
} else {
    Write-Host "⚠ PID file not found" -ForegroundColor $Yellow
}

# Test 4: Check Redis connection (Windows)
Write-Host ""
Write-Host "Test 4: Checking Redis connection..."
try {
    $redis = New-Object System.Net.Sockets.TcpClient("127.0.0.1", 6379)
    if ($redis.Connected) {
        Write-Host "✓ Redis is accessible" -ForegroundColor $Green
        $redis.Close()
    }
} catch {
    Write-Host "⚠ Redis is not accessible" -ForegroundColor $Yellow
    Write-Host "  Swoole needs Redis for broadcasting" -ForegroundColor $Yellow
}

# Test 5: Check logs
Write-Host ""
Write-Host "Test 5: Checking recent logs..."
$LogFile = "storage\logs\swoole.log"
if (Test-Path $LogFile) {
    Write-Host "Last 5 log entries:" -ForegroundColor Cyan
    Get-Content $LogFile -Tail 5 | ForEach-Object {
        Write-Host "  $_" -ForegroundColor Gray
    }
} else {
    Write-Host "⚠ Log file not found: $LogFile" -ForegroundColor $Yellow
}

# Test 6: WebSocket connection test (PowerShell native)
Write-Host ""
Write-Host "Test 6: Testing WebSocket connection..."
Write-Host "Creating WebSocket client..." -ForegroundColor Cyan

$code = @"
using System;
using System.Net.WebSockets;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

public class WebSocketClient {
    public static async Task<bool> TestConnection(string uri) {
        using (var ws = new ClientWebSocket()) {
            try {
                await ws.ConnectAsync(new Uri(uri), CancellationToken.None);
                Console.WriteLine("✓ WebSocket connected successfully");
                
                // Send ping
                var pingMsg = Encoding.UTF8.GetBytes("{\"type\":\"ping\"}");
                await ws.SendAsync(new ArraySegment<byte>(pingMsg), 
                    WebSocketMessageType.Text, true, CancellationToken.None);
                
                // Wait for response
                var buffer = new byte[1024];
                var result = await ws.ReceiveAsync(new ArraySegment<byte>(buffer), CancellationToken.None);
                var response = Encoding.UTF8.GetString(buffer, 0, result.Count);
                Console.WriteLine("Received: " + response);
                
                await ws.CloseAsync(WebSocketCloseStatus.NormalClosure, "", CancellationToken.None);
                return true;
            } catch (Exception ex) {
                Console.WriteLine("✗ WebSocket error: " + ex.Message);
                return false;
            }
        }
    }
}
"@

try {
    Add-Type -TypeDefinition $code -Language CSharp
    $result = [WebSocketClient]::TestConnection("ws://$Host:$Port").GetAwaiter().GetResult()
    
    if ($result) {
        Write-Host "✓ WebSocket test passed" -ForegroundColor $Green
    } else {
        Write-Host "✗ WebSocket test failed" -ForegroundColor $Red
    }
} catch {
    Write-Host "⚠ WebSocket test skipped (requires .NET 4.5+)" -ForegroundColor $Yellow
}

# Summary
Write-Host ""
Write-Host "================================" -ForegroundColor Cyan
Write-Host "Test Summary:" -ForegroundColor Cyan
Write-Host "  Basic tests completed" -ForegroundColor $Green
Write-Host ""
Write-Host "Browser test:" -ForegroundColor Cyan
Write-Host "  1. Open browser console (F12)"
Write-Host "  2. Run: const ws = new WebSocket('ws://localhost:9501')"
Write-Host "  3. Check: ws.readyState === 1 (connected)"
Write-Host "  4. Test: ws.send(JSON.stringify({type:'subscribe',channel:'test'}))"
Write-Host "================================" -ForegroundColor Cyan
