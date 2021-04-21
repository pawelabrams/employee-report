<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Department
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $seniorityIncrementBonus;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $percentBonus;

    /**
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="department")
     *
     * @var ArrayCollection
     */
    protected $employees;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSeniorityIncrementBonus(): ?int
    {
        return $this->seniorityIncrementBonus;
    }

    public function setSeniorityIncrementBonus(?int $seniorityIncrementBonus): self
    {
        $this->seniorityIncrementBonus = $seniorityIncrementBonus;

        return $this;
    }

    public function getPercentBonus(): ?float
    {
        return $this->percentBonus;
    }

    public function setPercentBonus(?float $percentBonus): self
    {
        $this->percentBonus = $percentBonus;

        return $this;
    }

    public function addEmployee(Employee $employee): self
    {
        $this->employees->add($employee);

        return $this;
    }

    public function getEmployees(): Collection
    {
        return $this->employees;
    }
}
