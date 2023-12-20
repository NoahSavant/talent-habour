<?php

namespace Tests\Unit\Services\BusinessService\AuthenServiceTest;

use App\Constants\AuthenConstant\StatusResponse;
use App\Services\BusinessServices\AuthenService;
use App\Services\ModelServices\ConnectionService;
use App\Services\ModelServices\EnterpriseService;
use App\Services\ModelServices\GmailTokenService;
use App\Services\ModelServices\UserService;
use Illuminate\Http\Response;

class SignUpEmployeeTest extends BaseAuthenServiceTest
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccess()
    {
        $input = [
            'gmail_token' => ['id_token' => 'data', 'expires_in' => 123],
            'enterprise' => 'new enterprise',
            'name' => 'name',
            'password' => 'password',
            'token' => ['token' => 'new token'],
        ];

        $gmailTokenServiceMock = $this->getMockService(GmailTokenService::class, ['getEmailInforFromToken', 'create']);
        $userServiceMock = $this->getMockService(UserService::class, ['isEmailExist', 'create']);
        $enterpriseServiceMock = $this->getMockService(EnterpriseService::class, ['create', 'isExisted']);
        $connectionServiceMock = $this->getMockService(ConnectionService::class);
        $authenServiceMock = $this->getMockService(AuthenService::class, ['response', 'hash', 'setUpUser', 'getEnterpriseId'], [
            $enterpriseServiceMock,
            $userServiceMock,
            $gmailTokenServiceMock,
            $connectionServiceMock,
        ]);

        $authenServiceMock->expects($this->once())
            ->method('response')
            ->willReturn(new Response(['message' => 'fail'], StatusResponse::SUCCESS));

        $authenServiceMock->expects($this->once())
            ->method('hash')
            ->willReturn('123456');

        $authenServiceMock->expects($this->once())
            ->method('getEnterpriseId')
            ->willReturn(1);

        $authenServiceMock->expects($this->once())
            ->method('setUpUser')
            ->willReturn('123456');

        $gmailTokenServiceMock->expects($this->once())
            ->method('getEmailInforFromToken')
            ->willReturn(['email' => 'newemail', 'picture' => 'newPicture']);

        $gmailTokenServiceMock->expects($this->once())
            ->method('create')
            ->willReturn($this->getObject(['id' => 'newemail', 'picture' => 'newPicture']));

        $userServiceMock->expects($this->once())
            ->method('create')
            ->willReturn($this->getObject(['id' => 'newemail', 'picture' => 'newPicture']));

        $userServiceMock->expects($this->once())
            ->method('isEmailExist')
            ->willReturn(false);

        $response = $authenServiceMock->signupEmployee($input);
        $this->assertEquals(StatusResponse::SUCCESS, $response->getStatusCode());
    }

    public function testNotFoundEnterprise()
    {
        $input = [
            'gmail_token' => ['id_token' => 'data', 'expires_in' => 123],
            'enterprise' => 'new enterprise',
            'name' => 'name',
            'password' => 'password',
            'token' => ['token' => 'new token'],
        ];

        $gmailTokenServiceMock = $this->getMockService(GmailTokenService::class, ['getEmailInforFromToken', 'create']);
        $userServiceMock = $this->getMockService(UserService::class, ['isEmailExist', 'create']);
        $enterpriseServiceMock = $this->getMockService(EnterpriseService::class, ['create', 'isExisted']);
        $connectionServiceMock = $this->getMockService(ConnectionService::class);
        $authenServiceMock = $this->getMockService(AuthenService::class, ['response', 'hash', 'setUpUser', 'getEnterpriseId'], [
            $enterpriseServiceMock,
            $userServiceMock,
            $gmailTokenServiceMock,
            $connectionServiceMock,
        ]);

        $authenServiceMock->expects($this->once())
            ->method('response')
            ->willReturn(new Response(['message' => 'fail'], StatusResponse::UNAUTHORIZED));

        $authenServiceMock->expects($this->once())
            ->method('getEnterpriseId')
            ->willReturn(false);

        $response = $authenServiceMock->signupEmployee($input);
        $this->assertEquals(StatusResponse::UNAUTHORIZED, $response->getStatusCode());
    }

    public function testExistMail()
    {
        $input = [
            'gmail_token' => ['id_token' => 'data', 'expires_in' => 123],
            'enterprise' => 'new enterprise',
            'name' => 'name',
            'password' => 'password',
            'token' => ['token' => 'new token'],
        ];

        $gmailTokenServiceMock = $this->getMockService(GmailTokenService::class, ['getEmailInforFromToken', 'create']);
        $userServiceMock = $this->getMockService(UserService::class, ['isEmailExist', 'create']);
        $enterpriseServiceMock = $this->getMockService(EnterpriseService::class, ['create', 'isExisted']);
        $connectionServiceMock = $this->getMockService(ConnectionService::class);
        $authenServiceMock = $this->getMockService(AuthenService::class, ['response', 'hash', 'setUpUser', 'getEnterpriseId'], [
            $enterpriseServiceMock,
            $userServiceMock,
            $gmailTokenServiceMock,
            $connectionServiceMock,
        ]);

        $authenServiceMock->expects($this->once())
            ->method('response')
            ->willReturn(new Response(['message' => 'fail'], StatusResponse::UNAUTHORIZED));

        $authenServiceMock->expects($this->once())
            ->method('getEnterpriseId')
            ->willReturn(1);

        $gmailTokenServiceMock->expects($this->once())
            ->method('getEmailInforFromToken')
            ->willReturn(['email' => 'newemail', 'picture' => 'newPicture']);

        $userServiceMock->expects($this->once())
            ->method('isEmailExist')
            ->willReturn(true);

        $response = $authenServiceMock->signupEmployee($input);
        $this->assertEquals(StatusResponse::UNAUTHORIZED, $response->getStatusCode());
    }
}
