<?php

use Mockery as m;
use Raideer\TwitchApi\Resources\Resource;

class ResourceTest
{
    public function test_selfRegistering()
    {
        $mock = m::mock('Raideer\TwitchApi\Wrapper');
        $mock->shouldReceive('registerResource');

        $resource = new MockResource($mock);
    }
}

class MockResource extends Resource
{
    public function getName()
    {
        return 'test';
    }
}
