<?php

namespace Tests\Unit\Services\ModelService\ResumeServiceTest;

use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Models\Resume;
use App\Models\User;
use App\Services\ModelServices\ResumeService;
use Tests\Unit\BaseTest;

class ShowTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccess()
    {
        $user = User::create([
            'email' => 'email2',
            'password' => '123',
            'role' => UserRole::RECRUITER,
            'status' => UserStatus::ACTIVE,
        ]);

        $resume = Resume::create([
            'user_id' => $user->id,
        ]);

        $resumeServiceMock = $this->getMockService(ResumeService::class, [], [
            new Resume(),
        ]);
        $this->be($user);
        $response = $resumeServiceMock->show($resume->id);
        $this->assertIsObject($response);
    }

    public function testResumeNotFound()
    {
        $user = User::create([
            'email' => 'email2',
            'password' => '123',
            'role' => UserRole::RECRUITER,
            'status' => UserStatus::ACTIVE,
        ]);

        $resumeServiceMock = $this->getMockService(ResumeService::class, [], [
            new Resume(),
        ]);
        $this->be($user);
        $response = $resumeServiceMock->show(1);
        $this->assertNull($response);
    }
}
