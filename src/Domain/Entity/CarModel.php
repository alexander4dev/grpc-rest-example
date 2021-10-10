<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Autorus\CarService\Domain\Repository\CarModelRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(
 *   name="car_model",
 *   uniqueConstraints={
 *   },
 * )
 */
class CarModel
{
    use Traits\Timestampable;

    /**
     * @var int|null
     * 
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(
     *   type="integer",
     *   options={
     *     "unsigned": true,
     *   },
     * )
     */
    protected $id;

    /**
     * @var string|null
     * 
     * @ORM\Column(
     *   type="string",
     *   length=36,
     *   nullable=false,
     *   unique=true
     * )
     *
     * @Assert\Uuid
     * @Assert\NotNull
     */
    protected $uuid;

    /**
     * @var string|null
     * 
     * @ORM\Column(
     *   type="string",
     *   nullable=false,
     * )
     *
     * @Assert\Type("string")
     * @Assert\Length(min=1, max=255)
     * @Assert\NotNull
     */
    protected $title;

    /**
     * @var CarClass|null
     *
     * @ORM\ManyToOne(
     *   targetEntity="CarClass",
     *   inversedBy="models",
     * )
     */
    protected $car_class;

    /**
     * @var CarBrand|null
     *
     * @ORM\ManyToOne(
     *   targetEntity="CarBrand",
     *   inversedBy="models",
     * )
     */
    protected $car_brand;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return self
     */
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return CarClass|null
     */
    public function getCarClass(): ?CarClass
    {
        return $this->car_class;
    }

    /**
     * @param CarClass $carClass
     * @return self
     */
    public function setCarClass(CarClass $carClass): self
    {
        $carClass->addCarModel($this);
        $this->car_class = $carClass;

        return $this;
    }

    /**
     * @return CarBrand|null
     */
    public function getCarBrand(): ?CarBrand
    {
        return $this->car_brand;
    }

    /**
     * @param CarBrand $carBrand
     * @return self
     */
    public function setCarBrand(CarBrand $carBrand): self
    {
        $carBrand->addCarModel($this);
        $this->car_brand = $carBrand;

        return $this;
    }
}
