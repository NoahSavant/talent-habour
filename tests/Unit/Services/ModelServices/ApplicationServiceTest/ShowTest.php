<?php

namespace Tests\Unit\Services\ModelService\ApplicationServiceTest;

use App\Models\Application;
use App\Services\ModelServices\ApplicationService;
use Tests\Unit\BaseTest;

class ShowTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccess()
    {
        $application = Application::create([
            'name' => 'name',
        ]);

        $applicationServiceMock = $this->getMockService(ApplicationService::class, [], [
            new Application(),
        ]);

        $response = $applicationServiceMock->show($application->id);
        $this->assertIsObject($response);
    }
}
