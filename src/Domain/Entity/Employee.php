<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Domain\Entity;

use Abramowicz\Tidio\Domain\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
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
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $lastName;

    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="employees")
     */
    protected $department;

    /**
     * @ORM\Column(type="integer")
     */
    protected $baseSalary;

    /**
     * @ORM\Column(type="date")
     */
    protected $employedSince;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBaseSalary(): ?int
    {
        return $this->baseSalary;
    }

    public function setBaseSalary(int $baseSalary): self
    {
        $this->baseSalary = $baseSalary;

        return $this;
    }

    public function getEmployedSince(): ?\DateTimeInterface
    {
        return $this->employedSince;
    }

    public function setEmployedSince(\DateTimeInterface $employedSince): self
    {
        $this->employedSince = $employedSince;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(Department $department): void
    {
        $this->department = $department;
    }

    public function toArray(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'department' => $this->department,
            'baseSalary' => $this->baseSalary,
            'employedSince' => $this->employedSince,
        ];
    }
}
