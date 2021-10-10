<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Service;

use Autorus\CarService\Domain\Entity\Work;
use Autorus\CarService\Domain\Entity\WorkGroup;
use Autorus\CarService\Exception\ServiceException;
use Autorus\CarService\Exception\ServiceViolationsException;
use Autorus\CarService\Validator\IsString;
use Zend\Filter\StringTrim;
use Zend\Validator\Uuid;

class WorkService extends AbstractService
{
    /**
     * @param string $uuid
     * @param string $title
     * @param string $workGroupUuid
     * @param string $time
     * @return void
     * @throws ServiceViolationsException
     */
    public function create(string $uuid, string $title, string $workGroupUuid, string $time): void
    {
        $inputFilter = $this->getInputFilter([
            'uuid' => $uuid,
            'title' => $title,
            'work_group' => $workGroupUuid,
            'time' => $time,
        ]);

        if (!$inputFilter->isValid()) {
            throw (new ServiceViolationsException())->setViolations($this->createViolationList($inputFilter));
        }

        $entityData = $inputFilter->getValues();

        /* @var $workGroup WorkGroup */
        $workGroup = $this->getWorkGroupRepository()->findOneBy([
            'uuid' => $entityData['work_group'],
        ]);

        if (null === $workGroup) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $entityData['work_group']));
        }

        $work = new Work();
        $work->setUuid($entityData['uuid']);
        $work->setTitle($entityData['title']);
        $work->setWorkGroup($workGroup);
        $work->setTime($entityData['time']);

        $entityViolations = $this->getWorkRepository()->validate($work);

        if ($entityViolations->count()) {
            throw (new ServiceViolationsException())->setViolations($entityViolations);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($work);
        $entityManager->flush();
    }

    /**
     * @param string $uuid
     * @return array
     * @throws ServiceException
     */
    public function read(string $uuid): array
    {
        /* @var $work Work */
        $work = $this->getWorkRepository()->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $work) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        return [
            'uuid' => $work->getUuid(),
            'title' => $work->getTitle(),
            'work_group' => $work->getWorkGroup()->getUuid(),
            'time' => $work->getTime(),
        ];
    }

    /**
     * @param string $uuid
     * @param string $title
     * @param string $workGroupUuid
     * @param string $time
     * @return void
     * @throws ServiceViolationsException
     */
    public function update(string $uuid, string $title, string $workGroupUuid, string $time): void
    {
        $workRepository = $this->getWorkRepository();
        /* @var $work Work */
        $work = $workRepository->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $work) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        $inputFilter = $this->getInputFilter([
            'uuid' => $uuid,
            'title' => $title,
            'work_group' => $workGroupUuid,
            'time' => $time,
        ]);

        if (!$inputFilter->isValid()) {
            throw (new ServiceViolationsException())->setViolations($this->createViolationList($inputFilter));
        }

        $entityData = $inputFilter->getValues();

        /* @var $workGroup WorkGroup */
        $workGroup = $this->getWorkGroupRepository()->findOneBy([
            'uuid' => $entityData['work_group'],
        ]);

        if (null === $workGroup) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $entityData['work_group']));
        }

        $work->setUuid($entityData['uuid']);
        $work->setTitle($entityData['title']);
        $work->setWorkGroup($workGroup);
        $work->setTime($entityData['time']);

        $entityViolations = $workRepository->validate($work);

        if ($entityViolations->count()) {
            throw (new ServiceViolationsException())->setViolations($entityViolations);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($work);
        $entityManager->flush();
    }

    /**
     * @param string $uuid
     * @return void
     * @throws ServiceException
     */
    public function delete(string $uuid): void
    {
        /* @var $work Work */
        $work = $this->getWorkRepository()->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $work) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        $entityManager = $this->getEntityManager();
        $entityManager->remove($work);
        $entityManager->flush();
    }

    /**
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getList(int $page, int $limit): array
    {
        $workRepository = $this->getWorkRepository();

        $items = $workRepository->getList([
            'select' => [
                'uuid',
                'title',
                'work_group' => [
                    'uuid AS work_group',
                ],
                'time',
            ],
            'orderBy' => [
                'id' => 'desc',
            ],
            'limit' => $limit,
            'page' => $page,
        ]);

        return [
            'items' => $items,
            'totalCount' => $workRepository->count([]),
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
            'work_group' => [
                'name' => 'work_group',
                'required' => true,
                'validators' => [
                    [
                        'name' => Uuid::class,
                    ],
                ],
            ],
            'time' => [
                'name' => 'time',
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
