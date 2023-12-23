<?php

namespace Tests\Unit\Services\ModelService\CompanyInformationServiceTest;

use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Models\CompanyInformation;
use App\Models\User;
use App\Services\ModelServices\CompanyInformationService;
use Tests\Unit\BaseTest;

class GetCompanyTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccess()
    {
        $user2 = User::create([
            'email' => 'email2',
            'password' => '123',
            'role' => UserRole::RECRUITER,
            'status' => UserStatus::ACTIVE,
        ]);

        $companyInformation = CompanyInformation::create([
            'user_id' => $user2->id,
        ]);

        $companyInformationServiceMock = $this->getMockService(CompanyInformationService::class, [], [
            new CompanyInformation(),
        ]);

        $response = $companyInformationServiceMock->getCompany($companyInformation->id);
        $this->assertIsArray($response);
    }

    public function testCompanyNotFound()
    {
        $companyInformationServiceMock = $this->getMockService(CompanyInformationService::class, [], [
            new CompanyInformation(),
        ]);

        $response = $companyInformationServiceMock->getCompany(1);
        $this->assertFalse($response);
    }
}
