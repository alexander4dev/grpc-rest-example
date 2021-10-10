<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Repository;

use Autorus\CarService\Domain\Entity\CarBrand;
use Arus\Doctrine\Helper\ValidationInjection;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class CarBrandRepository extends AbstractRepository
{
    use ValidationInjection {
        validate as protected _validate;
    }

    /**
     * @var ConstraintViolationListInterface|null
     */
    private $constraintViolationList;

    /**
     * @param CarBrand $carBrand
     * @return bool
     */
    public function isUnique(CarBrand $carBrand): bool
    {
        $queryParams = [
            'uuid' => $carBrand->getUuid(),
        ];

        $qb = $this->createQueryBuilder('b');
        $qb->select([
                'b.id',
                'b.uuid',
            ])
            ->andWhere(
                $qb->expr()->orX(
                    'b.uuid = :uuid'
                )
            )
            ->setParameters($queryParams)
        ;

        if ($carBrand->getId()) {
            $qb->andWhere('b.id != :id')
                ->setParameter('id', $carBrand->getId())
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
     * @param CarBrand $carBrand
     * @return ConstraintViolationListInterface
     */
    public function validate(CarBrand $carBrand): ConstraintViolationListInterface
    {
        $this->constraintViolationList = $this->_validate($carBrand);

        $this->isUnique($carBrand);

        return $this->constraintViolationList;
    }
}
