<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Autorus\CarService\Domain\Repository\WorkRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(
 *   name="work",
 *   uniqueConstraints={
 *   },
 * )
 */
class Work
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
     *   inversedBy="works",
     * )
     */
    protected $work_group;

    /**
     * @var string|null
     *
     * @ORM\Column(
     *   type="decimal",
     *   scale=2,
     *   nullable=false,
     * )
     *
     * @Assert\Type("string")
     * @Assert\Length(min=1, max=13)
     * @Assert\NotNull
     */
    protected $time;

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
     * @return WorkGroup
     */
    public function getWorkGroup(): WorkGroup
    {
        return $this->work_group;
    }

    /**
     * @param self $workGroup
     * @return self
     */
    public function setWorkGroup(WorkGroup $workGroup): self
    {
        $this->work_group = $workGroup;
        $workGroup->addWork($this);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * @param string $time
     * @return self
     */
    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }
}
