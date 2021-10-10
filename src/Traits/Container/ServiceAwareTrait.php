<?php

declare(strict_types=1);

namespace Autorus\CarService\Traits\Container;

use Autorus\CarService\Domain\Service\CarBrandService;
use Autorus\CarService\Domain\Service\CarClassService;
use Autorus\CarService\Domain\Service\CarModelService;
use Autorus\CarService\Domain\Service\WorkService;
use Autorus\CarService\Domain\Service\WorkGroupService;
use Autorus\CarService\Domain\Service\ServiceInterface;
use Psr\Container\ContainerInterface;

trait ServiceAwareTrait
{
    /**
     * @return CarBrandService
     */
    protected function getCarBrandService(): CarBrandService
    {
        return $this->getService(CarBrandService::class);
    }

    /**
     * @return CarClassService
     */
    protected function getCarClassService(): CarClassService
    {
        return $this->getService(CarClassService::class);
    }

    /**
     * @return CarModelService
     */
    protected function getCarModelService(): CarModelService
    {
        return $this->getService(CarModelService::class);
    }

    /**
     * @return WorkService
     */
    protected function getWorkService(): WorkService
    {
        return $this->getService(WorkService::class);
    }

    /**
     * @return WorkGroupService
     */
    protected function getWorkGroupService(): WorkGroupService
    {
        return $this->getService(WorkGroupService::class);
    }

    /**
     * @param string $id
     * @return mixed
     */
    protected function getService(string $id): ServiceInterface
    {
        /* @var $container ContainerInterface */
        $container = $this->getContainer();

        return $container->get($id);
    }
}
