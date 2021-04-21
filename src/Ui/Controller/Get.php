<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Ui\Controller;

use Abramowicz\Tidio\Application\GenerateReport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Get extends AbstractController
{
    /**
     * @var GenerateReport
     */
    private $useCase;

    public function __construct(
        GenerateReport $useCase
    ) {
        $this->useCase = $useCase;
    }

    /**
     * Generate the employees' salary report for the current month.
     *
     * @Route(
     *     methods={"GET"},
     *     name="get",
     *     path="/"
     * )
     */
    public function __invoke(Request $request): Response
    {
        $filters = array_filter(
            $request->query->all(),
            fn ($value, $key) => in_array($key, ['firstName', 'lastName', 'department']) && !empty($value),
            ARRAY_FILTER_USE_BOTH
        );

        $orderedBy = $request->query->all('_orderBy') ?: ['lastName' => 'ASC'];
        $employees = ($this->useCase)($filters, $orderedBy);

        $departments = [];

        array_walk($employees, function (array &$row) use (&$departments) {
            $row['baseSalary'] = sprintf('$%.2f', $row['baseSalary'] / 100);
            $row['bonus'] = sprintf('$%.2f', $row['bonus'] / 100);
            $row['totalSalary'] = sprintf('$%.2f', $row['totalSalary'] / 100);
            $row['employedSince'] = $row['employedSince'] ? $row['employedSince']->format('Y-m-d') : '-';

            if (!isset($departments[$row['department']->getId()])) {
                $departments[$row['department']->getId()] = $row['department'];
            }
        });

        return $this->render('report.html.twig', [
            'employees' => $employees,
            'departments' => $departments,
            'orderedBy' => $orderedBy,
        ]);
    }
}
