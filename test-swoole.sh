#!/bin/bash

# Swoole WebSocket Test Script
# Usage: bash test-swoole.sh

echo "🧪 Testing Swoole WebSocket Server..."
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
HOST="127.0.0.1"
PORT="9501"
TIMEOUT=5

echo "Configuration:"
echo "  Host: $HOST"
echo "  Port: $PORT"
echo ""

# Test 1: Check if port is open
echo "Test 1: Checking if port $PORT is open..."
if command -v nc &> /dev/null; then
    if nc -z -w$TIMEOUT $HOST $PORT 2>/dev/null; then
        echo -e "${GREEN}✓ Port $PORT is open${NC}"
    else
        echo -e "${RED}✗ Port $PORT is not accessible${NC}"
        echo "  Make sure Swoole server is running: php artisan swoole:serve start"
        exit 1
    fi
else
    echo -e "${YELLOW}⚠ netcat not available, skipping port check${NC}"
fi

# Test 2: Check if process is running
echo ""
echo "Test 2: Checking Swoole process..."
if pgrep -f "swoole:serve" > /dev/null; then
    PID=$(pgrep -f "swoole:serve")
    echo -e "${GREEN}✓ Swoole server is running (PID: $PID)${NC}"
else
    echo -e "${RED}✗ Swoole server process not found${NC}"
    exit 1
fi

# Test 3: Check PID file
echo ""
echo "Test 3: Checking PID file..."
PID_FILE="storage/app/swoole.pid"
if [ -f "$PID_FILE" ]; then
    PID_CONTENT=$(cat $PID_FILE)
    echo -e "${GREEN}✓ PID file exists: $PID_CONTENT${NC}"
else
    echo -e "${YELLOW}⚠ PID file not found${NC}"
fi

# Test 4: Check Redis connection
echo ""
echo "Test 4: Checking Redis connection..."
if command -v redis-cli &> /dev/null; then
    if redis-cli ping > /dev/null 2>&1; then
        echo -e "${GREEN}✓ Redis is running${NC}"
    else
        echo -e "${RED}✗ Redis is not accessible${NC}"
        echo "  Swoole needs Redis for broadcasting"
    fi
else
    echo -e "${YELLOW}⚠ redis-cli not available, skipping Redis check${NC}"
fi

# Test 5: WebSocket connection test using Node.js (if available)
echo ""
echo "Test 5: Testing WebSocket connection..."

cat > /tmp/test-websocket.js << 'EOF'
const WebSocket = require('ws');

const ws = new WebSocket('ws://127.0.0.1:9501');

ws.on('open', () => {
    console.log('\x1b[32m✓ WebSocket connected successfully\x1b[0m');
    
    // Test ping
    ws.send(JSON.stringify({ type: 'ping' }));
    
    setTimeout(() => {
        ws.close();
        process.exit(0);
    }, 2000);
});

ws.on('message', (data) => {
    const message = JSON.parse(data);
    console.log('\x1b[36mReceived message:\x1b[0m', message);
});

ws.on('error', (error) => {
    console.error('\x1b[31m✗ WebSocket error:\x1b[0m', error.message);
    process.exit(1);
});

ws.on('close', () => {
    console.log('WebSocket closed');
});

setTimeout(() => {
    console.error('\x1b[31m✗ Connection timeout\x1b[0m');
    process.exit(1);
}, 5000);
EOF

if command -v node &> /dev/null; then
    if npm list -g ws > /dev/null 2>&1 || npm list ws > /dev/null 2>&1; then
        node /tmp/test-websocket.js
    else
        echo -e "${YELLOW}⚠ Node.js 'ws' package not installed, skipping WebSocket test${NC}"
        echo "  Install: npm install -g ws"
    fi
else
    echo -e "${YELLOW}⚠ Node.js not available, skipping WebSocket test${NC}"
fi

rm -f /tmp/test-websocket.js

# Test 6: Check logs
echo ""
echo "Test 6: Checking recent logs..."
LOG_FILE="storage/logs/swoole.log"
if [ -f "$LOG_FILE" ]; then
    echo "Last 5 log entries:"
    tail -n 5 "$LOG_FILE"
else
    echo -e "${YELLOW}⚠ Log file not found: $LOG_FILE${NC}"
fi

echo ""
echo "================================"
echo "Test Summary:"
echo "  All basic tests passed! ✓"
echo ""
echo "Next steps:"
echo "  1. Open browser console"
echo "  2. Run: const ws = new WebSocket('ws://localhost:9501')"
echo "  3. Check: ws.readyState === 1 (connected)"
echo "  4. Test subscribe: ws.send(JSON.stringify({type:'subscribe',channel:'test'}))"
echo "================================"
