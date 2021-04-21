<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Domain\Strategy;

use Abramowicz\Tidio\Domain\Entity\Employee;
use DateTime;

class SeniorityIncrementBonusSalaryStrategy implements SalaryStrategy
{
    public function getBonus(Employee $employee): int
    {
        $now = new DateTime();
        $diff = $now->diff($employee->getEmployedSince());
        $years = min(10, isset($diff) ? $diff->y : 0);

        return $years * $employee->getDepartment()->getSeniorityIncrementBonus();
    }

    public function supports(Employee $employee): bool
    {
        return null !== $employee->getDepartment()->getSeniorityIncrementBonus();
    }

    public function getReadableBonusType(): string
    {
        return 'seniority';
    }
}
