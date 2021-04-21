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
        // Inelegant; maybe find another solution?
        if (!empty($sort)) {
            foreach (['totalSalary', 'bonus', 'bonusType'] as $key) {
                if (isset($sort[$key])) {
                    $afterSort[$key] = $sort[$key];
                    unset($sort[$key]);
                }
            }
        }

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

        // Sort by columns unavailable in Doctrine
        if (!empty($afterSort)) {
            // The following will be a nice match expression in PHP 8.0
            $sorter = function ($column, $order) {
                switch ($order) {
                    case 'desc': return fn ($a, $b) => $b[$column] <=> $a[$column];
                    case 'asc': default: return fn ($a, $b) => $a[$column] <=> $b[$column];
                }
            };

            foreach ($afterSort as $column => $order) {
                usort($result, $sorter($column, $order));
            }
        }

        return $result;
    }
}
