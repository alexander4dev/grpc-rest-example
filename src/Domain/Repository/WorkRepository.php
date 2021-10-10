<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Repository;

use Autorus\CarService\Domain\Entity\Work;
use Arus\Doctrine\Helper\ValidationInjection;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class WorkRepository extends AbstractRepository
{
    use ValidationInjection {
        validate as protected _validate;
    }

    /**
     * @var ConstraintViolationListInterface|null
     */
    private $constraintViolationList;

    /**
     * @param Work $work
     * @return bool
     */
    public function isUnique(Work $work): bool
    {
        $queryParams = [
            'uuid' => $work->getUuid(),
        ];

        $qb = $this->createQueryBuilder('w');
        $qb->select([
                'w.id',
                'w.uuid',
            ])
            ->andWhere(
                $qb->expr()->orX(
                    'w.uuid = :uuid'
                )
            )
            ->setParameters($queryParams)
        ;

        if ($work->getId()) {
            $qb->andWhere('w.id != :id')
                ->setParameter('id', $work->getId())
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
     * @param Work $work
     * @return ConstraintViolationListInterface
     */
    public function validate(Work $work): ConstraintViolationListInterface
    {
        $this->constraintViolationList = $this->_validate($work);

        $this->isUnique($work);

        return $this->constraintViolationList;
    }
}
