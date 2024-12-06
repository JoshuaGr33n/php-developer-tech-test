<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use App\Controller\FormController;
use App\Service\CompanyMatcherService;

class FormControllerTest extends TestCase
{
    private $controller;
    private $serviceMock;

    protected function setUp(): void
    {
        $this->serviceMock = $this->createMock(CompanyMatcherService::class);
        $this->controller = new FormController($this->serviceMock);
    }

    public function testSubmitReturnsMatchedCompaniesAsJson()
    {
        // Mock data
        $mockResults = [
            ['id' => 1, 'name' => 'Company A', 'credits' => 5],
            ['id' => 2, 'name' => 'Company B', 'credits' => 3],
        ];

        $_POST = [
            'postcode' => 'AB1',
            'bedrooms' => '3',
            'type' => 'residential',
        ];

        $this->serviceMock->method('results')
            ->willReturn($mockResults);

        $this->serviceMock->method('deductCredits')
            ->willReturnCallback(fn ($id) => 4);

        // Capture output
        ob_start();
        $this->controller->submit();
        $output = ob_get_clean();

        // Assert response
        $response = json_decode($output, true);
        $this->assertArrayHasKey('matchedCompanies', $response);
        $this->assertCount(2, $response['matchedCompanies']);
    }
}
