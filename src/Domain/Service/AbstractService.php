<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Service;

use Autorus\CarService\Domain\Service\ServiceInterface;
use Autorus\CarService\Traits\Container\ContainerInjectableTrait;
use Autorus\CarService\Traits\Container\RepositoryAwareTrait;
use Autorus\CarService\Traits\Container\ServiceAwareTrait;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFilterFactory;

abstract class AbstractService implements ServiceInterface
{
    use ContainerInjectableTrait;

    use RepositoryAwareTrait;

    use ServiceAwareTrait;

    /**
     * @param array $inputData
     * @return InputFilterInterface
     */
    protected function getInputFilter(array $inputData = [], array $specification = null): InputFilterInterface
    {
        return (new InputFilterFactory())
                ->createInputFilter($specification ?? $this->getInputFilterSpecification())
                ->setData($inputData);
    }

    /**
     * @return array
     */
    protected function getInputFilterSpecification(): array
    {
        return [];
    }

    /**
     * @param InputFilterInterface $inputFilter
     * @return ConstraintViolationListInterface
     */
    protected function createViolationList(InputFilterInterface $inputFilter): ConstraintViolationListInterface
    {
        $violationList = new ConstraintViolationList();

        foreach ($inputFilter->getMessages() as $inputName => $inputMessages) {
            foreach ($inputMessages as $inputMessage) {
                $violation = new ConstraintViolation($inputMessage, null, [], null, $inputName, $inputFilter->getValue($inputName));
                $violationList->add($violation);
            }
        }

        return $violationList;
    }
}
