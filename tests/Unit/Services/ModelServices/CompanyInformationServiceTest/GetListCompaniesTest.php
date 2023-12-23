<?php

namespace Tests\Unit\Services\ModelService\CompanyInformationServiceTest;

use App\Models\CompanyInformation;
use App\Services\ModelServices\CompanyInformationService;
use Tests\Unit\BaseTest;

class GetListCompaniesTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccess()
    {
        $companyInformationServiceMock = $this->getMockService(CompanyInformationService::class, [], [
            new CompanyInformation(),
        ]);

        $response = $companyInformationServiceMock->getListCompanies([]);
        $this->assertIsArray($response);
    }
}
