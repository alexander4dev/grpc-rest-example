<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Service;

use Autorus\CarService\Domain\Entity\CarBrand;
use Autorus\CarService\Exception\ServiceException;
use Autorus\CarService\Exception\ServiceViolationsException;
use Autorus\CarService\Validator\IsString;
use Zend\Filter\StringTrim;
use Zend\Validator\Uuid;

class CarBrandService extends AbstractService
{
    /**
     * @param string $uuid
     * @param string $title
     * @return void
     * @throws ServiceViolationsException
     */
    public function create(string $uuid, string $title): void
    {
        $inputFilter = $this->getInputFilter([
            'uuid' => $uuid,
            'title' => $title,
        ]);

        if (!$inputFilter->isValid()) {
            throw (new ServiceViolationsException())->setViolations($this->createViolationList($inputFilter));
        }

        $entityData = $inputFilter->getValues();

        $carBrand = new CarBrand();
        $carBrand->setUuid($entityData['uuid']);
        $carBrand->setTitle($entityData['title']);

        $entityViolations = $this->getCarBrandRepository()->validate($carBrand);

        if ($entityViolations->count()) {
            throw (new ServiceViolationsException())->setViolations($entityViolations);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($carBrand);
        $entityManager->flush();
    }

    /**
     * @param string $uuid
     * @return array
     * @throws ServiceException
     */
    public function read(string $uuid): array
    {
        /* @var $carBrand CarBrand */
        $carBrand = $this->getCarBrandRepository()->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $carBrand) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        return [
            'uuid' => $carBrand->getUuid(),
            'title' => $carBrand->getTitle(),
        ];
    }

    /**
     * @param string $uuid
     * @param string $title
     * @return void
     * @throws ServiceViolationsException
     */
    public function update(string $uuid, string $title): void
    {
        $carBrandRepository = $this->getCarBrandRepository();
        /* @var $carBrand CarBrand */
        $carBrand = $carBrandRepository->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $carBrand) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        $inputFilter = $this->getInputFilter([
            'uuid' => $uuid,
            'title' => $title,
        ]);

        if (!$inputFilter->isValid()) {
            throw (new ServiceViolationsException())->setViolations($this->createViolationList($inputFilter));
        }

        $entityData = $inputFilter->getValues();

        $carBrand->setUuid($entityData['uuid']);
        $carBrand->setTitle($entityData['title']);

        $entityViolations = $carBrandRepository->validate($carBrand);

        if ($entityViolations->count()) {
            throw (new ServiceViolationsException())->setViolations($entityViolations);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($carBrand);
        $entityManager->flush();
    }

    /**
     * @param string $uuid
     * @return void
     * @throws ServiceException
     */
    public function delete(string $uuid): void
    {
        /* @var $carBrand CarBrand */
        $carBrand = $this->getCarBrandRepository()->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $carBrand) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        $entityManager = $this->getEntityManager();
        $entityManager->remove($carBrand);
        $entityManager->flush();
    }

    /**
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getList(int $page, int $limit): array
    {
        $carBrandRepository = $this->getCarBrandRepository();

        $items = $carBrandRepository->getList([
            'select' => [
                'uuid',
                'title',
            ],
            'orderBy' => [
                'id' => 'desc',
            ],
            'limit' => $limit,
            'page' => $page,
        ]);

        return [
            'items' => $items,
            'totalCount' => $carBrandRepository->count([]),
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
        ];
    }
}
