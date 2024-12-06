<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use App\Repository\CompanyMatcherRepository;

class CompanyMatcherRepositoryTest extends TestCase
{
    private $repository;
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = new \PDO('sqlite::memory:'); // Use in-memory SQLite for testing
        $this->pdo->exec("
            CREATE TABLE companies (
                id INTEGER PRIMARY KEY,
                name TEXT,
                credits INTEGER,
                postcodes TEXT,
                bedrooms TEXT,
                type TEXT
            );

            CREATE TABLE company_matching_settings (
                id INTEGER PRIMARY KEY,
                company_id INTEGER,
                postcodes TEXT,
                bedrooms TEXT,
                type TEXT
            );
        ");

        $this->pdo->exec("
            INSERT INTO companies (id, name, credits, postcodes, bedrooms, type)
            VALUES (1, 'Company A', 5, 'AB', '3', 'residential');
        ");

        $this->pdo->exec("
            INSERT INTO company_matching_settings (id, company_id, postcodes, bedrooms, type)
            VALUES (1, 1, 'AB', '3', 'residential');
        ");

        $this->repository = new CompanyMatcherRepository($this->pdo);
    }

    public function testFindMatchedCompanies()
    {
        $results = $this->repository->findMatchedCompanies('AB', '3', 'residential');

        $this->assertCount(1, $results);
        $this->assertEquals('Company A', $results[0]['name']);
    }

    public function testGetCompanyCredits()
    {
        $credits = $this->repository->getCompanyCredits(1);

        $this->assertEquals(5, $credits);
    }

    public function testUpdateCompanyCredits()
    {
        $this->repository->updateCompanyCredits(1, 4);

        $credits = $this->repository->getCompanyCredits(1);
        $this->assertEquals(4, $credits);
    }
}
