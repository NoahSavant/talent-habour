<?php

namespace Tests\Unit\Services\ModelService\ApplicationServiceTest;

use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Models\Application;
use App\Models\User;
use App\Services\ModelServices\ApplicationService;
use Tests\Unit\BaseTest;

class GetTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccess()
    {
        $user = User::create([
            'email' => 'email',
            'password' => '123',
            'role' => UserRole::EMPLOYEE,
            'status' => UserStatus::ACTIVE,
        ]);

        $applicationServiceMock = $this->getMockService(ApplicationService::class, [], [
            new Application(),
        ]);

        $this->be($user);
        $response = $applicationServiceMock->get([]);
        $this->assertIsArray($response);
    }
}
