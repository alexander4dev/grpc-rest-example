<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Repository;

use Autorus\CarService\Domain\Entity\CarClass;
use Arus\Doctrine\Helper\ValidationInjection;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class CarClassRepository extends AbstractRepository
{
    use ValidationInjection {
        validate as protected _validate;
    }

    /**
     * @var ConstraintViolationListInterface|null
     */
    private $constraintViolationList;

    /**
     * @param CarClass $carClass
     * @return bool
     */
    public function isUnique(CarClass $carClass): bool
    {
        $queryParams = [
            'uuid' => $carClass->getUuid(),
        ];

        $qb = $this->createQueryBuilder('c');
        $qb->select([
                'c.id',
                'c.uuid',
            ])
            ->andWhere(
                $qb->expr()->orX(
                    'c.uuid = :uuid'
                )
            )
            ->setParameters($queryParams)
        ;

        if ($carClass->getId()) {
            $qb->andWhere('c.id != :id')
                ->setParameter('id', $carClass->getId())
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
     * @param CarClass $carClass
     * @return ConstraintViolationListInterface
     */
    public function validate(CarClass $carClass): ConstraintViolationListInterface
    {
        $this->constraintViolationList = $this->_validate($carClass);

        $this->isUnique($carClass);

        return $this->constraintViolationList;
    }
}
