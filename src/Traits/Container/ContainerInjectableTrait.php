<?php

declare(strict_types=1);

namespace Autorus\CarService\Traits\Container;

use Psr\Container\ContainerInterface;

trait ContainerInjectableTrait
{
    /**
     * @Inject
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * @return ContainerInterface
     */
    protected function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
