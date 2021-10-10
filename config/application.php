<?php

declare(strict_types=1);

use Autorus\CarService\Console\Command\GenerateSystemdUnitFileCommand;
use Doctrine\Common\Cache\ArrayCache;

return
[
    /**
     * The application CWD (current working directory)
     */
    'cwd' => realpath(__DIR__ . '/..'),

    /**
     * The application env name
     */
    'env' => 'dev',

    /**
     * The application host name
     */
    'host' => 'car-service',

    /**
     * The application name
     */
    'name' => 'car-service',

    /**
     * The application commands
     *
     * @var array
     */
    'commands' => [
        GenerateSystemdUnitFileCommand::class,
    ],

    /**
     * The application logging configuration
     */
    'logging' => [
        'default' => [
            'name' => DI\string('{host}.{env}'),
            'handlers' => [
                DI\create(Monolog\Handler\ErrorLogHandler::class),
            ],
        ],
    ],

    /**
     * The application database configuration
     *
     * @link https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/configuration.html
     */
    'database' => [
        'default' => [
            'metadata' => [
                'paths' => [
                    DI\string('{cwd}/src/Domain/Entity'),
                ],
            ],
            'debug_mode' => DI\get('database.debug_mode'),
            'cache_driver' => DI\get('database.cache_driver'),
            'connection' => DI\get('database.connection'),
        ],
    ],

    /**
     * The application database debug mode
     */
    'database.debug_mode' => false,

    /**
     * The application database cache driver
     */
    'database.cache_driver' => new ArrayCache(),

    /**
     * The application database connection parameters
     */
    'database.connection' => [
        'driver' => 'pdo_mysql',
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'arus',
        'password' => 'secret',
        'dbname' => 'car_service',
        'charset' => 'utf8mb4',
    ],
];
