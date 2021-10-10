<?php

declare(strict_types=1);

use Autorus\CarService\Grpc\CarServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Spiral\Goridge\StreamRelay;
use Spiral\GRPC\Server;
use Spiral\RoadRunner\Worker;

ini_set('display_errors', 'stderr');
error_reporting(E_ALL);
set_error_handler(function (int $severity, string $message, string $file, int $line): void {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

chdir(__DIR__);
require 'vendor/autoload.php';

$container = require 'config/container.php';

$server = new Server();
$server->registerService(CarServiceInterface::class, $container->get(CarServiceInterface::class));
$worker = new Worker(new StreamRelay(STDIN, STDOUT));

$server->serve($worker, function (?Throwable $t) use ($container) {
    $entityManager = $container->get(EntityManagerInterface::class);
    $entityManager->clear();
    $entityManager->getConnection()->close();
    gc_collect_cycles();

    if ($t) {
        $container->get(LoggerInterface::class)->error($t->getMessage(), ['exception' => $t]);
    }
});
