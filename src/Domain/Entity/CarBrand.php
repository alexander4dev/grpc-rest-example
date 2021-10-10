<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Autorus\CarService\Domain\Repository\CarBrandRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(
 *   name="car_brand",
 *   uniqueConstraints={
 *   },
 * )
 */
class CarBrand
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
     * @var Collection
     *
     * @ORM\OneToMany(
     *   targetEntity="CarModel",
     *   mappedBy="car_class",
     *   cascade={"remove"},
     * )
     */
    protected $carModels;

    public function __construct()
    {
        $this->carModels = new ArrayCollection();
    }

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
     * @return Collection
     */
    public function getCarModels(): Collection
    {
        return $this->carModels;
    }

    /**
     * @param CarModel $carModel
     * @return self
     */
    public function addCarModel(CarModel $carModel): self
    {
        $this->carModels->add($carModel);

        return $this;
    }
}
