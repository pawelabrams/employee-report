<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Tests\Unit\Application;

use Abramowicz\Tidio\Application\GenerateReport;
use Abramowicz\Tidio\Domain\Repository\EmployeeRepository;
use Abramowicz\Tidio\Domain\Strategy\SalaryStrategy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Abramowicz\Tidio\Application\GenerateReport
 */
class GenerateReportTest extends TestCase
{
    public function testOrderBy(): void
    {
        $repo = $this->createRepository();
        $repo->expects($this->once())->method('findBy')->with([], ['lastName' => 'ASC'])->willReturn([]);

        $strategy = $this->createSalaryStrategy();

        $useCase = new GenerateReport($repo, [$strategy]);

        $response = ($useCase)();

        $this->assertEquals([], $response);
    }

    private function createRepository(): EmployeeRepository
    {
        /** @var EmployeeRepository&MockObject $mock */
        $repo = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()->getMock();

        return $repo;
    }

    private function createSalaryStrategy(): SalaryStrategy
    {
        /** @var SalaryStrategy&MockObject $mock */
        $mock = $this->getMockBuilder(SalaryStrategy::class)
            ->disableOriginalConstructor()->getMock();

        return $mock;
    }
}
