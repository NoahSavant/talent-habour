<?php

namespace Tests\Unit\Services\ModelService\ApplicationServiceTest;

use App\Models\Application;
use App\Services\ModelServices\ApplicationService;
use Tests\Unit\BaseTest;

class GetByPostTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccess()
    {
        $applicationServiceMock = $this->getMockService(ApplicationService::class, [], [
            new Application(),
        ]);

        $response = $applicationServiceMock->getByPost(1, []);
        $this->assertIsArray($response);
    }
}
