<?php

namespace Tests\Unit;

use App\Service\CompanyMatcherService;
use App\Repository\CompanyMatcherRepository;
use PHPUnit\Framework\TestCase;

class CompanyMatcherServiceTest extends TestCase
{
    private $service;
    private $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(CompanyMatcherRepository::class);
        $this->service = new CompanyMatcherService($this->repositoryMock);
    }

    public function testMatchSetsResults()
    {
        $mockResults = [
            ['id' => 1, 'name' => 'Company A', 'credits' => 5],
            ['id' => 2, 'name' => 'Company B', 'credits' => 3],
        ];

        $this->repositoryMock->method('findMatchedCompanies')
            ->willReturn($mockResults);

        $this->service->match('AB', '3', 'residential');

        $this->assertEquals($mockResults, $this->service->results());
    }

    public function testDeductCredits()
    {
        $this->repositoryMock->method('getCompanyCredits')
            ->willReturn(5);

        $this->repositoryMock->expects($this->once())
            ->method('updateCompanyCredits')
            ->with(1, 4);

        $updatedCredits = $this->service->deductCredits(1);

        $this->assertEquals(4, $updatedCredits);
    }

    public function testDeductCreditsWhenZero()
    {
        $this->repositoryMock->method('getCompanyCredits')
            ->willReturn(0);

        $this->repositoryMock->expects($this->never())
            ->method('updateCompanyCredits');

        $updatedCredits = $this->service->deductCredits(1);

        $this->assertEquals(0, $updatedCredits);
    }
}
