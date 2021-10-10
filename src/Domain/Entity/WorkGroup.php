<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Autorus\CarService\Domain\Repository\WorkGroupRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(
 *   name="work_group",
 *   uniqueConstraints={
 *   },
 * )
 */
class WorkGroup
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
     * @var WorkGroup|null
     *
     * @ORM\ManyToOne(
     *   targetEntity="WorkGroup",
     *   inversedBy="childWorkGroups",
     * )
     */
    protected $parent_work_group;

    /**
     * @var Collection|null
     *
     * @ORM\OneToMany(
     *   targetEntity="WorkGroup",
     *   mappedBy="parent_work_group",
     *   cascade={"remove"},
     * )
     */
    protected $childWorkGroups;

    /**
     * @var Collection|null
     *
     * @ORM\OneToMany(
     *   targetEntity="Work",
     *   mappedBy="work_group",
     *   cascade={"remove"},
     * )
     */
    protected $works;

    public function __construct()
    {
        $this->childWorkGroups = new ArrayCollection();
        $this->works = new ArrayCollection();
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
     * @return self|null
     */
    public function getParentWorkGroup(): ?self
    {
        return $this->parent_work_group;
    }

    /**
     * @param ?self $parentWorkGroup
     * @return self
     */
    public function setParentWorkGroup(?self $parentWorkGroup): self
    {
        $this->parent_work_group = $parentWorkGroup;

        if (null !== $parentWorkGroup) {
            $parentWorkGroup->addChildWorkGroup($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getChildWorkGroups(): Collection
    {
        return $this->childWorkGroups;
    }

    /**
     * @param self $childWorkGroup
     * @return self
     */
    public function addChildWorkGroup(self $childWorkGroup): self
    {
        $this->childWorkGroups->add($childWorkGroup);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getWorks(): Collection
    {
        return $this->works;
    }

    /**
     * @param self $work
     * @return self
     */
    public function addWork(Work $work): self
    {
        $this->works->add($work);

        return $this;
    }
}
