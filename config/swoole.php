<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Swoole WebSocket Server Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Swoole WebSocket server used for real-time broadcasting
    |
    */

    'host' => env('SWOOLE_HOST', '0.0.0.0'),
    
    'port' => env('SWOOLE_PORT', 9501),
    
    // Use integer values for compatibility when Swoole extension is not loaded
    'mode' => defined('SWOOLE_PROCESS') ? SWOOLE_PROCESS : 3,
    
    'sock_type' => defined('SWOOLE_SOCK_TCP') ? SWOOLE_SOCK_TCP : 1,

    /*
    |--------------------------------------------------------------------------
    | Server Options
    |--------------------------------------------------------------------------
    */

    'options' => [
        'worker_num' => env('SWOOLE_WORKER_NUM', 4),
        'task_worker_num' => env('SWOOLE_TASK_WORKER_NUM', 4),
        'max_connection' => env('SWOOLE_MAX_CONNECTION', 10000),
        'heartbeat_check_interval' => 60,
        'heartbeat_idle_time' => 600,
    ],
];
