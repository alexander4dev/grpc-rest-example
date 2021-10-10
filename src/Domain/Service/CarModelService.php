<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Service;

use Autorus\CarService\Domain\Entity\CarBrand;
use Autorus\CarService\Domain\Entity\CarClass;
use Autorus\CarService\Domain\Entity\CarModel;
use Autorus\CarService\Exception\ServiceException;
use Autorus\CarService\Exception\ServiceViolationsException;
use Autorus\CarService\Validator\IsString;
use Zend\Filter\StringTrim;
use Zend\Validator\Uuid;

class CarModelService extends AbstractService
{
    /**
     * @param string $uuid
     * @param string $title
     * @param string $carBrandUuid
     * @param string $carClassUuid
     * @return void
     * @throws ServiceViolationsException
     */
    public function create(string $uuid, string $title, string $carBrandUuid, string $carClassUuid): void
    {
        $inputFilter = $this->getInputFilter([
            'uuid' => $uuid,
            'title' => $title,
            'car_brand' => $carBrandUuid,
            'car_class' => $carClassUuid,
        ]);

        if (!$inputFilter->isValid()) {
            throw (new ServiceViolationsException())->setViolations($this->createViolationList($inputFilter));
        }

        $entityData = $inputFilter->getValues();

        /* @var $carBrand CarBrand */
        $carBrand = $this->getCarBrandRepository()->findOneBy([
            'uuid' => $entityData['car_brand'],
        ]);

        if (null === $carBrand) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $entityData['car_brand']));
        }

        /* @var $carClass CarClass */
        $carClass = $this->getCarClassRepository()->findOneBy([
            'uuid' => $entityData['car_class'],
        ]);

        if (null === $carClass) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $entityData['car_class']));
        }

        $carModel = new CarModel();
        $carModel->setUuid($entityData['uuid']);
        $carModel->setTitle($entityData['title']);
        $carModel->setCarBrand($carBrand);
        $carModel->setCarClass($carClass);

        $entityViolations = $this->getCarModelRepository()->validate($carModel);

        if ($entityViolations->count()) {
            throw (new ServiceViolationsException())->setViolations($entityViolations);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($carModel);
        $entityManager->flush();
    }

    /**
     * @param string $uuid
     * @return array
     * @throws ServiceException
     */
    public function read(string $uuid): array
    {
        /* @var $carModel CarModel */
        $carModel = $this->getCarModelRepository()->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $carModel) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        return [
            'uuid' => $carModel->getUuid(),
            'title' => $carModel->getTitle(),
            'car_brand' => $carModel->getCarBrand()->getUuid(),
            'car_class' => $carModel->getCarClass()->getUuid(),
        ];
    }

    /**
     * @param string $uuid
     * @param string $title
     * @param string $carBrandUuid
     * @param string $carClassUuid
     * @return void
     * @throws ServiceViolationsException
     */
    public function update(string $uuid, string $title, string $carBrandUuid, string $carClassUuid): void
    {
        $carModelRepository = $this->getCarModelRepository();
        /* @var $carModel CarModel */
        $carModel = $carModelRepository->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $carModel) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        $inputFilter = $this->getInputFilter([
            'uuid' => $uuid,
            'title' => $title,
            'car_brand' => $carBrandUuid,
            'car_class' => $carClassUuid,
        ]);

        if (!$inputFilter->isValid()) {
            throw (new ServiceViolationsException())->setViolations($this->createViolationList($inputFilter));
        }

        $entityData = $inputFilter->getValues();

        /* @var $carBrand CarBrand */
        $carBrand = $this->getCarBrandRepository()->findOneBy([
            'uuid' => $entityData['car_brand'],
        ]);

        if (null === $carBrand) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $entityData['car_brand']));
        }

        /* @var $carClass CarClass */
        $carClass = $this->getCarClassRepository()->findOneBy([
            'uuid' => $entityData['car_class'],
        ]);

        if (null === $carClass) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $entityData['car_class']));
        }

        $carModel->setUuid($entityData['uuid']);
        $carModel->setTitle($entityData['title']);
        $carModel->setCarBrand($carBrand);
        $carModel->setCarClass($carClass);

        $entityViolations = $carModelRepository->validate($carModel);

        if ($entityViolations->count()) {
            throw (new ServiceViolationsException())->setViolations($entityViolations);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($carModel);
        $entityManager->flush();
    }

    /**
     * @param string $uuid
     * @return void
     * @throws ServiceException
     */
    public function delete(string $uuid): void
    {
        /* @var $carModel CarModel */
        $carModel = $this->getCarModelRepository()->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $carModel) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        $entityManager = $this->getEntityManager();
        $entityManager->remove($carModel);
        $entityManager->flush();
    }

    /**
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getList(int $page, int $limit): array
    {
        $carModelRepository = $this->getCarModelRepository();

        $items = $carModelRepository->getList([
            'select' => [
                'uuid',
                'title',
                'car_brand' => [
                    'uuid AS car_brand',
                ],
                'car_class' => [
                    'uuid AS car_class',
                ],
            ],
            'orderBy' => [
                'id' => 'desc',
            ],
            'limit' => $limit,
            'page' => $page,
        ]);

        return [
            'items' => $items,
            'totalCount' => $carModelRepository->count([]),
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
            'car_brand' => [
                'name' => 'car_brand',
                'required' => true,
                'validators' => [
                    [
                        'name' => Uuid::class,
                    ],
                ],
            ],
            'car_class' => [
                'name' => 'car_class',
                'required' => true,
                'validators' => [
                    [
                        'name' => Uuid::class,
                    ],
                ],
            ],
        ];
    }
}
