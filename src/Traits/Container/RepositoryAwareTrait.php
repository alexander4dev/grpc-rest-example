<?php

declare(strict_types=1);

namespace Autorus\CarService\Traits\Container;

use Autorus\CarService\Domain\Entity\CarBrand;
use Autorus\CarService\Domain\Entity\CarClass;
use Autorus\CarService\Domain\Entity\CarModel;
use Autorus\CarService\Domain\Entity\Work;
use Autorus\CarService\Domain\Entity\WorkGroup;
use Autorus\CarService\Domain\Repository\CarBrandRepository;
use Autorus\CarService\Domain\Repository\CarClassRepository;
use Autorus\CarService\Domain\Repository\CarModelRepository;
use Autorus\CarService\Domain\Repository\WorkRepository;
use Autorus\CarService\Domain\Repository\WorkGroupRepository;
use Doctrine\Common\Persistence\ObjectRepository;

trait RepositoryAwareTrait
{
    use DoctrineAwareTrait;

    /**
     * @return CarBrandRepository
     */
    public function getCarBrandRepository(): CarBrandRepository
    {
        return $this->getRepository(CarBrand::class);
    }

    /**
     * @return CarClassRepository
     */
    public function getCarClassRepository(): CarClassRepository
    {
        return $this->getRepository(CarClass::class);
    }

    /**
     * @return CarModelRepository
     */
    public function getCarModelRepository(): CarModelRepository
    {
        return $this->getRepository(CarModel::class);
    }

    /**
     * @param string $className
     * @return ObjectRepository
     */
    protected function getRepository(string $className): ObjectRepository
    {
        return $this->getEntityManager()->getRepository($className);
    }

    /**
     * @return WorkRepository
     */
    public function getWorkRepository(): WorkRepository
    {
        return $this->getRepository(Work::class);
    }

    /**
     * @return WorkGroupRepository
     */
    public function getWorkGroupRepository(): WorkGroupRepository
    {
        return $this->getRepository(WorkGroup::class);
    }
}
