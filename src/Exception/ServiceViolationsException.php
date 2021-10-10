<?php

declare(strict_types=1);

namespace Autorus\CarService\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ServiceViolationsException extends ServiceException
{
    /**
     * @var ConstraintViolationListInterface|null
     */
    private $violations;

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }

    /**
     * @param ConstraintViolationListInterface $violations
     * @return self
     */
    public function setViolations(ConstraintViolationListInterface $violations): self
    {
        $this->violations = $violations;

        return $this;
    }
}
