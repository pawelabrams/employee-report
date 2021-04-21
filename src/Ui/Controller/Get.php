<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Ui\Controller;

use Abramowicz\Tidio\Application\GenerateReport;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Get
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
    public function __invoke(): Response
    {
        $result = ($this->useCase)([], ['lastName' => 'ASC']);

        array_walk($result, function (array &$row) {
            $row['baseSalary'] = sprintf('$%.2f', $row['baseSalary'] / 100);
            $row['bonus'] = sprintf('$%.2f', $row['bonus'] / 100);
            $row['totalSalary'] = sprintf('$%.2f', $row['totalSalary'] / 100);
            $row['department'] = $row['department']->getName();
            $row['employedSince'] = $row['employedSince'] ? $row['employedSince']->format('Y-m-d') : '-';
        });

        return new JsonResponse($result);
    }
}
