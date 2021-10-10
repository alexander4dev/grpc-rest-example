<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Repository;

use Autorus\CarService\Domain\Entity\CarModel;
use Arus\Doctrine\Helper\ValidationInjection;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class CarModelRepository extends AbstractRepository
{
    use ValidationInjection {
        validate as protected _validate;
    }

    /**
     * @var ConstraintViolationListInterface|null
     */
    private $constraintViolationList;

    /**
     * @param CarModel $carModel
     * @return bool
     */
    public function isUnique(CarModel $carModel): bool
    {
        $queryParams = [
            'uuid' => $carModel->getUuid(),
        ];

        $qb = $this->createQueryBuilder('m');
        $qb->select([
                'm.id',
                'm.uuid',
            ])
            ->andWhere(
                $qb->expr()->orX(
                    'm.uuid = :uuid'
                )
            )
            ->setParameters($queryParams)
        ;

        if ($carModel->getId()) {
            $qb->andWhere('m.id != :id')
                ->setParameter('id', $carModel->getId())
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
     * @param CarModel $carModel
     * @return ConstraintViolationListInterface
     */
    public function validate(CarModel $carModel): ConstraintViolationListInterface
    {
        $this->constraintViolationList = $this->_validate($carModel);

        $this->isUnique($carModel);

        return $this->constraintViolationList;
    }
}
