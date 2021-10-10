<?php

declare(strict_types=1);

namespace Autorus\CarService\Traits\Container;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

trait DoctrineAwareTrait
{
    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        /* @var $container ContainerInterface */
        $container = $this->getContainer();

        return $container->get(EntityManagerInterface::class);
    }
}
