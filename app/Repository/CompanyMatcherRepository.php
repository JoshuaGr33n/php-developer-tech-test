<?php

namespace App\Repository;

class CompanyMatcherRepository extends BaseRepository
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function findMatchedCompanies(string $postcodePrefix, string $bedrooms, string $propertyType): array
    {
        $random = $this->db->getAttribute(\PDO::ATTR_DRIVER_NAME) === 'sqlite' ? 'RANDOM()' : 'RAND()'; // For integration testing purposes
        $stmt = $this->db->prepare("
            SELECT c.*
            FROM companies c
            JOIN company_matching_settings cms ON c.id = cms.company_id
            WHERE
                cms.postcodes LIKE :postcode AND
                cms.bedrooms LIKE :bedrooms AND
                cms.type = :propertyType
            ORDER BY $random  -- Randomize the results
            LIMIT 3  -- Limit to a maximum of 3 companies
        ");
        $stmt->execute([
            ':postcode' => '%' . $postcodePrefix . '%',
            ':bedrooms' => '%' . $bedrooms . '%',
            ':propertyType' => $propertyType,
        ]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCompanyCredits(int $companyId): int
    {
        $stmt = $this->db->prepare("SELECT credits FROM companies WHERE id = :companyId");
        $stmt->execute([':companyId' => $companyId]);
        $company = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $company ? $company['credits'] : 0; // Return 0 if no company found
    }

    public function updateCompanyCredits(int $companyId, int $credits): void
    {
        $stmt = $this->db->prepare("
            UPDATE companies
            SET credits = :credits
            WHERE id = :companyId
        ");
        $stmt->execute([
            ':companyId' => $companyId,
            ':credits' => $credits
        ]);
    }
}
