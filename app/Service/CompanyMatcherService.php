<?php

namespace App\Service;

use App\Repository\CompanyMatcherRepository;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CompanyMatcherService
{
    private $companyMatcherRepository;
    private $matches = [];
    private $logger;

    public function __construct(CompanyMatcherRepository $companyMatcherRepository)
    {
        $this->companyMatcherRepository = $companyMatcherRepository;

        $this->logger = new Logger('company_matcher');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/company_logs.log', Logger::INFO)); // Log to company_logs file
    }



    public function match(string $postcode, string $bedrooms, string $propertyType)
    {
        $postcodePrefix = substr($postcode, 0, 2);
        $results = $this->companyMatcherRepository->findMatchedCompanies($postcodePrefix, $bedrooms, $propertyType);
        $this->matches = $results;
    }

    public function pick(int $count) {}

    public function results(): array
    {
        return $this->matches;
    }


    public function deductCredits(int $companyId): int
    {
        $credits = $this->companyMatcherRepository->getCompanyCredits($companyId);

        // Check if the company has credits to deduct
        if ($credits > 0) {
            // Deduct one credit and update the company credits in the database
            $this->companyMatcherRepository->updateCompanyCredits($companyId, $credits - 1);

            // Log a message if the company runs out of credits after deduction
            if ($credits - 1 <= 0) {
                $this->logger->info("Company {$companyId} has run out of credits.");
            }
        } else {
            // Log a warning if an attempt is made to deduct credits when none are available
            $this->logger->warning("Attempted to deduct credits from company {$companyId}, but they have no credits left.");
        }

        // Return the updated credits, ensuring the value is not less than zero
        return max(0, $credits - 1);
    }
}
