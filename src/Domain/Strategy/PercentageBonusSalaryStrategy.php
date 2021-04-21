<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Domain\Strategy;

use Abramowicz\Tidio\Domain\Entity\Employee;

class PercentageBonusSalaryStrategy implements SalaryStrategy
{
    public function getBonus(Employee $employee): int
    {
        return (int) ($employee->getDepartment()->getPercentBonus() / 100.0 * $employee->getBaseSalary());
    }

    public function supports(Employee $employee): bool
    {
        return null !== $employee->getDepartment()->getPercentBonus();
    }

    public function getReadableBonusType(): string
    {
        return 'percent';
    }
}
