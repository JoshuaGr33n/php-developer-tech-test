<?php

namespace App\Controller;


use App\Service\CompanyMatcherService;

class FormController extends Controller
{

    private $matcherService;

    public function __construct(CompanyMatcherService $matcherService)
    {

        $this->matcherService = $matcherService;
    }
    public function index()
    {
        $this->render('form.twig');
    }

    public function results()
    {
        $this->render('results.twig');
    }

    public function submit()
    {
        // Retrieve the form data
        $postcode = $_POST['postcode'];
        $bedrooms = $_POST['bedrooms'];
        $propertyType = $_POST['type'];

        // Instantiate the CompanyMatcherService
        $this->matcherService->match($postcode, $bedrooms, $propertyType);

        // Get the matched companies
        $matchedCompanies = $this->matcherService->results();

        // Deduct credits for each matched company
        foreach ($matchedCompanies as &$company) {
            $company['credits'] =  $this->matcherService->deductCredits($company['id']);
        }

        // Set the response header to JSON
        header('Content-Type: application/json');

        // Return the matched companies as a JSON response
        echo json_encode([
            'matchedCompanies' => $matchedCompanies
        ]);

        exit;
    }
}
