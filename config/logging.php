<?php

use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Processor\WebProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\IntrospectionProcessor;
use Illuminate\Support\Str;

return [

    'default' => env('LOG_CHANNEL', 'stack'),

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily'], // Use the 'daily' channel
            'ignore_exceptions' => false,
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'formatter' => 'Monolog\Formatter\LineFormatter',
        ],
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14, // Keep logs for 14 days
            'formatter' => 'Monolog\Formatter\LineFormatter',
        ],
        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stderr',
            ],
            'level' => env('LOG_LEVEL', 'debug'),
            'formatter' => 'Monolog\Formatter\LineFormatter',
        ],
        'syslog' => [
            'driver' => 'syslog',
            'facility' => LOG_USER,
            'level' => env('LOG_LEVEL', 'debug'),
            'formatter' => 'Monolog\Formatter\SyslogFormatter',
        ],
        'errorlog' => [
            'driver' => 'errorlog',
            'message_type' => 0,
            'level' => env('LOG_LEVEL', 'debug'),
            'formatter' => 'Monolog\Formatter\LineFormatter',
        ],
        'null' => [
            'driver' => 'monolog',
            'handler' => \Monolog\Handler\NullHandler::class,
        ],
        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
    ],

    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL'),
        'trace' => false,
    ],

];