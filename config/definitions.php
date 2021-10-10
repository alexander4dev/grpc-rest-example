<?php

declare(strict_types=1);

use Autorus\CarService\Domain\CarService;
use Autorus\CarService\Grpc\CarServiceInterface;
use DI\Container;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Psr\Log\LoggerInterface;

return [
    /**
     * Monolog
     *
     * @link https://github.com/Seldaek/monolog
     */
    LoggerInterface::class => function (Container $container): LoggerInterface {
        $config = $container->get('logging')['default'];

        $logger = new Monolog\Logger($config['name']);

        foreach ($config['handlers'] as $handler) {
            $logger->pushHandler($handler);
        }

        return $logger;
    },

    /**
     * Doctrine Entity Manager
     *
     * @link https://github.com/doctrine/orm
     */
    EntityManagerInterface::class => function (Container $container): EntityManagerInterface {
        AnnotationRegistry::registerLoader('class_exists');

        $options = $container->get('database')['default'];

        $configuration = Setup::createAnnotationMetadataConfiguration(
            $options['metadata']['paths'],
            $options['debug_mode'],
            null, // proxy dir
            $options['cache_driver'],
            false
        );

        return EntityManager::create($options['connection'], $configuration);

    },

    CarServiceInterface::class => function (Container $container): CarServiceInterface {
        $carService = new CarService();
        $container->injectOn($carService);

        return $carService;
    },
];
