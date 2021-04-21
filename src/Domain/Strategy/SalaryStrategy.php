<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Domain\Strategy;

use Abramowicz\Tidio\Domain\Entity\Employee;

interface SalaryStrategy
{
    public function getBonus(Employee $employee): int;

    public function supports(Employee $employee): bool;

    public function getReadableBonusType(): string;
}
