<?php

namespace Tests\Unit\Services\BusinessService\AuthenServiceTest;

use App\Constants\AuthenConstant\StatusResponse;
use App\Services\BusinessServices\AuthenService;
use Illuminate\Http\Response;

class ThrowAuthenErrorTest extends BaseAuthenServiceTest
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccess()
    {
        $authenServiceMock = $this->getMockService(AuthenService::class, ['createVerify', 'response']);

        $authenServiceMock->expects($this->once())
            ->method('response')
            ->willReturn(new Response(['message' => 'fail'], StatusResponse::UNAUTHORIZED));

        $response = $authenServiceMock->throwAuthenError();
        $this->assertEquals(StatusResponse::UNAUTHORIZED, $response->getStatusCode());
    }
}
