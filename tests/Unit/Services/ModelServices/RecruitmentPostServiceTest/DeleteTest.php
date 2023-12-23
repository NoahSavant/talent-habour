<?php

namespace Tests\Unit\Services\ModelService\RescruitmentPostServiceTest;

use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Models\CompanyInformation;
use App\Models\RecruitmentPost;
use App\Models\User;
use App\Services\ModelServices\ApplicationService;
use App\Services\ModelServices\RecruitmentPostService;
use Tests\Unit\BaseTest;

class DeleteTest extends BaseTest
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
            'role' => UserRole::RECRUITER,
            'status' => UserStatus::ACTIVE,
        ]);

        $companyInformation = CompanyInformation::create([
            'user_id' => $user->id,
        ]);

        $recruitmentPost = RecruitmentPost::create([
            'user_id' => $user->id,
        ]);

        $applicationServiceMock = $this->getMockService(ApplicationService::class, ['delete']);

        $recruitmentPostServiceMock = $this->getMockService(RecruitmentPostService::class, [], [
            new RecruitmentPost(),
            $applicationServiceMock,
        ]);

        $applicationServiceMock->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $this->be($user);
        $response = $recruitmentPostServiceMock->delete([$recruitmentPost->id]);
        $this->assertEquals(1, $response);
    }
}
