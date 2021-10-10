<?php declare(strict_types=1);

/**
 * @link https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/configuration.html#setting-up-the-commandline-tool
 */

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = require __DIR__ . '/container.php';
$entityManager = $container->get(EntityManagerInterface::class);

return ConsoleRunner::createHelperSet($entityManager);
