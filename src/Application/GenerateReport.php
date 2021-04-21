<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Application;

use Abramowicz\Tidio\Domain\Repository\EmployeeRepository;
use Abramowicz\Tidio\Domain\Strategy\SalaryStrategy;

class GenerateReport
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var SalaryStrategy[]
     */
    private $salaryStrategies;

    /**
     * @param SalaryStrategy[] $salaryStrategies
     */
    public function __construct(
        EmployeeRepository $employeeRepository,
        iterable $salaryStrategies
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->salaryStrategies = $salaryStrategies;
    }

    /**
     * @psalm-return list<array{firstName: string, lastName: string, department: Department, baseSalary: int, employedSince: \DateTimeInterface, bonus: list<int>, bonusType: list<string>}>
     */
    public function __invoke(array $criteria = [], ?array $sort = null): array
    {
        $employees = $this->employeeRepository->findBy($criteria, $sort ?? ['lastName' => 'ASC']);

        $result = [];
        foreach ($employees as $employee) {
            $employeeData = $employee->toArray();
            $employeeData['totalSalary'] = $employee->getBaseSalary();

            foreach ($this->salaryStrategies as $salaryStrategy) {
                if ($salaryStrategy->supports($employee)) {
                    $employeeData['bonus'] = $salaryStrategy->getBonus($employee);
                    $employeeData['bonusType'] = $salaryStrategy->getReadableBonusType();
                    $employeeData['totalSalary'] += $employeeData['bonus'];

                    break;
                }
            }

            $result[] = $employeeData;
        }

        return $result;
    }
}
