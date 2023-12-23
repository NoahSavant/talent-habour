<?php

namespace Tests\Unit\Services\BusinessService\AuthenServiceTest;

use App\Constants\AuthenConstant\StatusResponse;
use App\Constants\UserConstant\UserStatus;
use App\Models\AccountVerify;
use App\Models\User;
use App\Services\BusinessServices\AuthenService;
use App\Services\ModelServices\AccountVerifyService;
use App\Services\ModelServices\CompanyInformationService;
use App\Services\ModelServices\UserService;
use Illuminate\Http\Response;

class CheckVerifyAccountTest extends BaseAuthenServiceTest
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
            'role' => 0,
            'status' => UserStatus::DEACTIVE,
        ]);

        AccountVerify::create([
            'user_id' => $user->id,
            'overtimed_at' => now()->addDay(),
            'verify_code' => '123',
        ]);

        $userServiceMock = $this->getMockService(UserService::class);
        $accountVerifyServiceMock = $this->getMockService(AccountVerifyService::class);
        $companyInformationServiceMock = $this->getMockService(CompanyInformationService::class);

        $authenServiceMock = $this->getMockService(AuthenService::class, [], [
            $userServiceMock,
            $accountVerifyServiceMock,
            $companyInformationServiceMock,
        ]);

        $response = $authenServiceMock->checkVerifyAccount($user, '123');
        $this->assertNull($response);
    }

    public function testNotFoundUser()
    {
        $userServiceMock = $this->getMockService(UserService::class);
        $accountVerifyServiceMock = $this->getMockService(AccountVerifyService::class);
        $companyInformationServiceMock = $this->getMockService(CompanyInformationService::class);

        $authenServiceMock = $this->getMockService(AuthenService::class, ['response'], [
            $userServiceMock,
            $accountVerifyServiceMock,
            $companyInformationServiceMock,
        ]);

        $authenServiceMock->expects($this->once())
            ->method('response')
            ->willReturn(new Response(['message' => ''], StatusResponse::ERROR));

        $response = $authenServiceMock->checkVerifyAccount(null, '123');
        $this->assertEquals(StatusResponse::ERROR, $response->getStatusCode());
    }

    public function testVerifyCodeNotValid()
    {
        $user = User::create([
            'email' => 'email',
            'password' => '123',
            'role' => 0,
            'status' => UserStatus::DEACTIVE,
        ]);

        AccountVerify::create([
            'user_id' => $user->id,
            'overtimed_at' => now()->addDay(),
            'verify_code' => '123',
        ]);

        $userServiceMock = $this->getMockService(UserService::class);
        $accountVerifyServiceMock = $this->getMockService(AccountVerifyService::class);
        $companyInformationServiceMock = $this->getMockService(CompanyInformationService::class);

        $authenServiceMock = $this->getMockService(AuthenService::class, ['response'], [
            $userServiceMock,
            $accountVerifyServiceMock,
            $companyInformationServiceMock,
        ]);

        $authenServiceMock->expects($this->once())
            ->method('response')
            ->willReturn(new Response(['message' => ''], StatusResponse::ERROR));

        $response = $authenServiceMock->checkVerifyAccount($user, '1234');
        $this->assertEquals(StatusResponse::ERROR, $response->getStatusCode());
    }
}
