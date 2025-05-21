<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Symfony\Component\Process\Process;

class SmartControllerTest extends TestCase
{
    /**
     * Test the smart process endpoint without UI.
     *
     * @return void
     */
    public function testSmartProcess()
    {
        $postData = [
            'alternatives' => [
                [3, 4, 5],
                [2, 3, 4],
            ],
            'weights' => [0.5, 0.3, 0.2],
            'types' => [1, 0, 1],
        ];

        // Mock the Process class
        $mockProcess = Mockery::mock(Process::class);
        $mockProcess->shouldReceive('run')->once()->andReturnNull();
        $mockProcess->shouldReceive('isSuccessful')->once()->andReturn(true);
        $mockProcess->shouldReceive('getOutput')->once()->andReturn(json_encode(['scores' => [0.8, 0.6]]));

        // Bind the mock to the container
        $this->app->instance(Process::class, $mockProcess);

        $response = $this->post(route('smart.process'), $postData);

        $response->assertStatus(200);
        $response->assertViewIs('smart.result');
        $response->assertViewHas('result');
    }
}