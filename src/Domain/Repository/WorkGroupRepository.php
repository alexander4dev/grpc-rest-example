<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Repository;

use Autorus\CarService\Domain\Entity\WorkGroup;
use Arus\Doctrine\Helper\ValidationInjection;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class WorkGroupRepository extends AbstractRepository
{
    use ValidationInjection {
        validate as protected _validate;
    }

    /**
     * @var ConstraintViolationListInterface|null
     */
    private $constraintViolationList;

    /**
     * @param WorkGroup $workGroup
     * @return bool
     */
    public function isUnique(WorkGroup $workGroup): bool
    {
        $queryParams = [
            'uuid' => $workGroup->getUuid(),
        ];

        $qb = $this->createQueryBuilder('g');
        $qb->select([
                'g.id',
                'g.uuid',
            ])
            ->andWhere(
                $qb->expr()->orX(
                    'g.uuid = :uuid'
                )
            )
            ->setParameters($queryParams)
        ;

        if ($workGroup->getId()) {
            $qb->andWhere('g.id != :id')
                ->setParameter('id', $workGroup->getId())
            ;
        }

        $queryResult = $qb->getQuery()->getResult();
        $isUnique = !$queryResult;

        if (!$isUnique && $this->constraintViolationList instanceof ConstraintViolationListInterface) {
            foreach ($queryResult as $existedEntity) {
                foreach ($queryParams as $searchedField => $searchedValue) {
                    if (null !== $searchedValue && $searchedValue === $existedEntity[$searchedField]) {
                        $message = sprintf('Entity already exists with same "%s": %s', $searchedField, $searchedValue);
                        $this->constraintViolationList->add(new ConstraintViolation($message, null, [], null, $searchedField, $searchedValue));
                    }
                }
            }
        }

        return $isUnique;
    }

    /**
     * @param WorkGroup $workGroup
     * @return ConstraintViolationListInterface
     */
    public function validate(WorkGroup $workGroup): ConstraintViolationListInterface
    {
        $this->constraintViolationList = $this->_validate($workGroup);

        $this->isUnique($workGroup);

        return $this->constraintViolationList;
    }
}
