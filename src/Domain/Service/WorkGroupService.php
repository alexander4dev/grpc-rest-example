<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Service;

use Autorus\CarService\Domain\Entity\WorkGroup;
use Autorus\CarService\Exception\ServiceException;
use Autorus\CarService\Exception\ServiceViolationsException;
use Autorus\CarService\Validator\IsString;
use Zend\Filter\StringTrim;
use Zend\Validator\Uuid;

class WorkGroupService extends AbstractService
{
    /**
     * @param string $uuid
     * @param string $title
     * @param string $parentWorkGroupUuid
     * @return void
     * @throws ServiceViolationsException
     */
    public function create(string $uuid, string $title, string $parentWorkGroupUuid): void
    {
        $inputFilter = $this->getInputFilter([
            'uuid' => $uuid,
            'title' => $title,
            'parent_work_group' => $parentWorkGroupUuid,
        ]);

        if (!$inputFilter->isValid()) {
            throw (new ServiceViolationsException())->setViolations($this->createViolationList($inputFilter));
        }

        $entityData = $inputFilter->getValues();

        $workGroupRepository = $this->getWorkGroupRepository();

        $workGroup = new WorkGroup();
        $workGroup->setUuid($entityData['uuid']);
        $workGroup->setTitle($entityData['title']);

        if ('' !== $entityData['parent_work_group']) {
            /* @var $parentWorkGroup WorkGroup */
            $parentWorkGroup = $workGroupRepository->findOneBy([
                'uuid' => $entityData['parent_work_group'],
            ]);

            if (null === $parentWorkGroup) {
                throw new ServiceException(sprintf('An entity "%s" was not found.', $entityData['parent_work_group']));
            }

            $workGroup->setParentWorkGroup($parentWorkGroup);
        }

        $entityViolations = $workGroupRepository->validate($workGroup);

        if ($entityViolations->count()) {
            throw (new ServiceViolationsException())->setViolations($entityViolations);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($workGroup);
        $entityManager->flush();
    }

    /**
     * @param string $uuid
     * @return array
     * @throws ServiceException
     */
    public function read(string $uuid): array
    {
        /* @var $workGroup WorkGroup */
        $workGroup = $this->getWorkGroupRepository()->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $workGroup) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        return [
            'uuid' => $workGroup->getUuid(),
            'title' => $workGroup->getTitle(),
            'parent_work_group' => null !== $workGroup->getParentWorkGroup() ? $workGroup->getParentWorkGroup()->getUuid() : '',
        ];
    }

    /**
     * @param string $uuid
     * @param string $title
     * @param string $parentWorkGroupUuid
     * @return void
     * @throws ServiceViolationsException
     */
    public function update(string $uuid, string $title, string $parentWorkGroupUuid): void
    {
        $workGroupRepository = $this->getWorkGroupRepository();
        /* @var $workGroup WorkGroup */
        $workGroup = $workGroupRepository->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $workGroup) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        $inputFilter = $this->getInputFilter([
            'uuid' => $uuid,
            'title' => $title,
            'parent_work_group' => $parentWorkGroupUuid,
        ]);

        if (!$inputFilter->isValid()) {
            throw (new ServiceViolationsException())->setViolations($this->createViolationList($inputFilter));
        }

        $entityData = $inputFilter->getValues();

        $workGroup->setUuid($entityData['uuid']);
        $workGroup->setTitle($entityData['title']);

        if ('' !== $entityData['parent_work_group']) {
            /* @var $parentWorkGroup WorkGroup */
            $parentWorkGroup = $workGroupRepository->findOneBy([
                'uuid' => $entityData['parent_work_group'],
            ]);

            if (null === $parentWorkGroup) {
                throw new ServiceException(sprintf('An entity "%s" was not found.', $entityData['work_group']));
            }

            $workGroup->setParentWorkGroup($parentWorkGroup);
        } else {
            $workGroup->setParentWorkGroup(null);
        }

        $entityViolations = $workGroupRepository->validate($workGroup);

        if ($entityViolations->count()) {
            throw (new ServiceViolationsException())->setViolations($entityViolations);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($workGroup);
        $entityManager->flush();
    }

    /**
     * @param string $uuid
     * @return void
     * @throws ServiceException
     */
    public function delete(string $uuid): void
    {
        /* @var $workGroup WorkGroup */
        $workGroup = $this->getWorkGroupRepository()->findOneBy([
            'uuid' => $uuid,
        ]);

        if (null === $workGroup) {
            throw new ServiceException(sprintf('An entity "%s" was not found.', $uuid));
        }

        $entityManager = $this->getEntityManager();
        $entityManager->remove($workGroup);
        $entityManager->flush();
    }

    /**
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getList(int $page, int $limit): array
    {
        $workGroupRepository = $this->getWorkGroupRepository();

        $items = $workGroupRepository->getList([
            'select' => [
                'uuid',
                'title',
                'parent_work_group' => [
                    'uuid AS parent_work_group',
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
            'totalCount' => $workGroupRepository->count([]),
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
            'parent_work_group' => [
                'name' => 'parent_work_group',
                'required' => true,
                'allow_empty' => true,
                'validators' => [
                    [
                        'name' => Uuid::class,
                    ],
                ],
            ],
        ];
    }
}
