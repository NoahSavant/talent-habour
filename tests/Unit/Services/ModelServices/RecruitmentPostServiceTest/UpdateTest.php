<?php

namespace Tests\Unit\Services\ModelService\RescruitmentPostServiceTest;

use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Models\RecruitmentPost;
use App\Models\User;
use App\Services\ModelServices\ApplicationService;
use App\Services\ModelServices\RecruitmentPostService;
use Tests\Unit\BaseTest;

class UpdateTest extends BaseTest
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

        $recruitmentPost = RecruitmentPost::create([
            'user_id' => $user->id,
        ]);

        $applicationServiceMock = $this->getMockService(ApplicationService::class);

        $recruitmentPostServiceMock = $this->getMockService(RecruitmentPostService::class, [], [
            new RecruitmentPost(),
            $applicationServiceMock,
        ]);

        $this->be($user);
        $response = $recruitmentPostServiceMock->update($recruitmentPost->id, []);
        $this->assertIsObject($response);
    }

    public function testPostNotFound()
    {
        $user = User::create([
            'email' => 'email',
            'password' => '123',
            'role' => UserRole::EMPLOYEE,
            'status' => UserStatus::ACTIVE,
        ]);

        $applicationServiceMock = $this->getMockService(ApplicationService::class);

        $recruitmentPostServiceMock = $this->getMockService(RecruitmentPostService::class, [], [
            new RecruitmentPost(),
            $applicationServiceMock,
        ]);

        $this->be($user);
        $response = $recruitmentPostServiceMock->update(1, []);
        $this->assertFalse($response);
    }
}
