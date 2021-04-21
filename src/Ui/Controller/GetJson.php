<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Ui\Controller;

use Abramowicz\Tidio\Application\GenerateReport;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetJson
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
     * Generate the employees' salary report for the current month in JSON.
     *
     * @Route(
     *     methods={"GET"},
     *     name="json.get",
     *     path="/json"
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

        array_walk($employees, function (array &$row) {
            $row['baseSalary'] /= 100;
            $row['bonus'] /= 100;
            $row['totalSalary'] /= 100;
            $row['department'] = $row['department']->getName();
            $row['employedSince'] = $row['employedSince'] ? $row['employedSince']->format('Y-m-d') : null;
        });

        return new JsonResponse($employees);
    }
}
