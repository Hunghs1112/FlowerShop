<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SwooleWebSocketServer;

class SwooleServe extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'swoole:serve {action=start : start|stop|restart|status}';

    /**
     * The console command description.
     */
    protected $description = 'Manage Swoole WebSocket server (start|stop|restart|status)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $action = $this->argument('action');

        return match ($action) {
            'start' => $this->start(),
            'stop' => $this->stop(),
            'restart' => $this->restart(),
            'status' => $this->status(),
            default => $this->error("Invalid action: {$action}. Use: start|stop|restart|status"),
        };
    }

    /**
     * Start Swoole WebSocket server
     */
    protected function start(): int
    {
        $pidFile = storage_path('app/swoole.pid');

        // Check if already running
        if (file_exists($pidFile)) {
            $pid = (int) file_get_contents($pidFile);
            if ($this->isProcessRunning($pid)) {
                $this->error('Swoole WebSocket server is already running (PID: ' . $pid . ')');
                return 1;
            } else {
                // PID file exists but process not running, clean up
                unlink($pidFile);
            }
        }

        $this->info('Starting Swoole WebSocket Server...');
        $this->info('Host: ' . config('swoole.host', '0.0.0.0'));
        $this->info('Port: ' . config('swoole.port', 9501));
        $this->newLine();

        try {
            $server = new SwooleWebSocketServer();
            $server->start();
            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to start Swoole server: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Stop Swoole WebSocket server
     */
    protected function stop(): int
    {
        $pidFile = storage_path('app/swoole.pid');

        if (!file_exists($pidFile)) {
            $this->warn('Swoole WebSocket server is not running (PID file not found)');
            return 1;
        }

        $pid = (int) file_get_contents($pidFile);

        if (!$this->isProcessRunning($pid)) {
            $this->warn("Swoole server is not running (PID {$pid} not found)");
            unlink($pidFile);
            return 1;
        }

        $this->info("Stopping Swoole WebSocket server (PID: {$pid})...");

        // Send SIGTERM to gracefully stop
        if (posix_kill($pid, SIGTERM)) {
            // Wait for process to stop (max 10 seconds)
            $waited = 0;
            while ($this->isProcessRunning($pid) && $waited < 10) {
                sleep(1);
                $waited++;
            }

            if ($this->isProcessRunning($pid)) {
                // Force kill if still running
                $this->warn('Graceful shutdown timeout. Force killing...');
                posix_kill($pid, SIGKILL);
                sleep(1);
            }

            if (file_exists($pidFile)) {
                unlink($pidFile);
            }

            $this->info('✓ Swoole WebSocket server stopped');
            return 0;
        } else {
            $this->error('Failed to send stop signal to Swoole server');
            return 1;
        }
    }

    /**
     * Restart Swoole WebSocket server
     */
    protected function restart(): int
    {
        $this->info('Restarting Swoole WebSocket server...');
        
        $this->stop();
        
        $this->newLine();
        $this->info('Waiting 2 seconds before restart...');
        sleep(2);
        $this->newLine();
        
        return $this->start();
    }

    /**
     * Show Swoole server status
     */
    protected function status(): int
    {
        $pidFile = storage_path('app/swoole.pid');

        if (!file_exists($pidFile)) {
            $this->warn('❌ Swoole WebSocket server is NOT running');
            return 1;
        }

        $pid = (int) file_get_contents($pidFile);

        if (!$this->isProcessRunning($pid)) {
            $this->warn("❌ Swoole server is NOT running (stale PID: {$pid})");
            unlink($pidFile);
            return 1;
        }

        $this->info('✓ Swoole WebSocket server is running');
        $this->table(
            ['Property', 'Value'],
            [
                ['PID', $pid],
                ['Host', config('swoole.host', '0.0.0.0')],
                ['Port', config('swoole.port', 9501)],
                ['Log File', storage_path('logs/swoole.log')],
            ]
        );

        // Show last 10 log lines
        $logFile = storage_path('logs/swoole.log');
        if (file_exists($logFile)) {
            $this->newLine();
            $this->info('Recent logs:');
            $this->line('---');
            
            $logs = file($logFile);
            $recentLogs = array_slice($logs, -10);
            foreach ($recentLogs as $log) {
                $this->line(trim($log));
            }
        }

        return 0;
    }

    /**
     * Check if process is running
     */
    protected function isProcessRunning(int $pid): bool
    {
        return posix_kill($pid, 0);
    }
}
