<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Service;

use Autorus\CarService\Domain\Entity\CarClass;
use Autorus\CarService\Exception\ServiceException;
use Autorus\CarService\Exception\ServiceViolationsException;
use Autorus\CarService\Validator\IsString;
use Zend\Filter\StringTrim;
use Zend\Validator\Uuid;

class CarClassService extends AbstractService
{
    /**
     * @param string $uuid
     * @param string $title
     * @param string $hourCost
     * @return void
     * @throws ServiceViolationsException
     */
    public function create(string $uuid, string $title, string $hourCost): void
    {
        $inputFilter = $this->getInputFilter([
            'uuid' => $uuid,
            'title' => $title,
            'hour_cost' => $hourCost,
        ]);

        if (!$inputFilter->isValid()) {
            throw (new ServiceViolationsException())->setViolations($this->createViolationList($inputFilter));
        }

        $entityData = $inputFilter->getValues();

        $carClass = new CarClass();
        $carClass->setUuid($entityData['uuid']);
        $carClass->setTitle($entityData['title']);
        $carClass->setHourCost($entityData['hour_cost']);

        $entityViolations = $this->getCarClassRepository()->validate($carClass);

        if ($entityViolations->count()) {
            throw (new ServiceViolationsException())->setViolations($entityViolations);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($carClass);
        $entityManager->flush();
    }

    /**
     * @param string $uuid
     * @return array
     * @throws ServiceException
     */
    public function read(string $uuid): array
    {
        /* @var $carClass CarClass */
        $carClass = $this->getCarClassRepository()->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $carClass) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        return [
            'uuid' => $carClass->getUuid(),
            'title' => $carClass->getTitle(),
            'hour_cost' => $carClass->getHourCost(),
        ];
    }

    /**
     * @param string $uuid
     * @param string $title
     * @param string $hourCost
     * @return void
     * @throws ServiceViolationsException
     */
    public function update(string $uuid, string $title, string $hourCost): void
    {
        $carClassRepository = $this->getCarClassRepository();
        /* @var $carClass CarClass */
        $carClass = $carClassRepository->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $carClass) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        $inputFilter = $this->getInputFilter([
            'uuid' => $uuid,
            'title' => $title,
            'hour_cost' => $hourCost,
        ]);

        if (!$inputFilter->isValid()) {
            throw (new ServiceViolationsException())->setViolations($this->createViolationList($inputFilter));
        }

        $entityData = $inputFilter->getValues();

        $carClass->setUuid($entityData['uuid']);
        $carClass->setTitle($entityData['title']);
        $carClass->setHourCost($entityData['hour_cost']);

        $entityViolations = $carClassRepository->validate($carClass);

        if ($entityViolations->count()) {
            throw (new ServiceViolationsException())->setViolations($entityViolations);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($carClass);
        $entityManager->flush();
    }

    /**
     * @param string $uuid
     * @return void
     * @throws ServiceException
     */
    public function delete(string $uuid): void
    {
        /* @var $carClass CarClass */
        $carClass = $this->getCarClassRepository()->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $carClass) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        $entityManager = $this->getEntityManager();
        $entityManager->remove($carClass);
        $entityManager->flush();
    }

    /**
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getList(int $page, int $limit): array
    {
        $carClassRepository = $this->getCarClassRepository();

        $items = $carClassRepository->getList([
            'select' => [
                'uuid',
                'title',
                'hour_cost',
            ],
            'orderBy' => [
                'id' => 'desc',
            ],
            'limit' => $limit,
            'page' => $page,
        ]);

        return [
            'items' => $items,
            'totalCount' => $carClassRepository->count([]),
        ];
    }

    /**
     * @return array
     */
    protected function getInputFilterSpecification(): array
    {
        return [
            'uuid' => [
                'name' => 'uuid',
                'required' => true,
                'validators' => [
                    [
                        'name' => Uuid::class,
                    ],
                ],
            ],
            'title' => [
                'name' => 'title',
                'required' => true,
                'validators' => [
                    [
                        'name' => IsString::class,
                    ],
                ],
                'filters' => [
                    [
                        'name' => StringTrim::class,
                    ],
                ],
            ],
            'hour_cost' => [
                'name' => 'hour_cost',
                'required' => true,
                'validators' => [
                    [
                        'name' => IsString::class,
                    ],
                ],
                'filters' => [
                    [
                        'name' => StringTrim::class,
                    ],
                ],
            ],
        ];
    }
}
