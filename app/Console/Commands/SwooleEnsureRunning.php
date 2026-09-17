<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwooleEnsureRunning extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'swoole:ensure-running';

    /**
     * The console command description.
     */
    protected $description = 'Ensure Swoole WebSocket server is running (for cron monitoring)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $pidFile = storage_path('app/swoole.pid');
        
        // Check if PID file exists and process is running
        if (file_exists($pidFile)) {
            $pid = (int) file_get_contents($pidFile);
            
            if (posix_kill($pid, 0)) {
                // Server is running
                return 0;
            } else {
                // PID file exists but process is dead
                $this->warn("Swoole server PID {$pid} not running. Cleaning up...");
                unlink($pidFile);
            }
        }

        // Server is not running, start it
        $this->info('Starting Swoole WebSocket server...');
        
        $basePath = base_path();
        $logFile = storage_path('logs/swoole-cron.log');
        
        // Start server in background
        $command = "cd {$basePath} && php artisan swoole:serve start >> {$logFile} 2>&1 &";
        exec($command);
        
        // Wait 2 seconds and verify it started
        sleep(2);
        
        if (file_exists($pidFile)) {
            $pid = (int) file_get_contents($pidFile);
            if (posix_kill($pid, 0)) {
                $this->info("✓ Swoole server started successfully (PID: {$pid})");
                return 0;
            }
        }
        
        $this->error('Failed to start Swoole server. Check ' . $logFile);
        return 1;
    }
}
