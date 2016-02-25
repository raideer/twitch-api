<?php

class IngestsTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource('Raideer\TwitchApi\Resources\Ingests');
    }

    public function test_getName_returnsIngests()
    {
        $this->assertSame('ingests', $this->resource->getName());
    }

    public function test_getIngests()
    {
        $this->mockRequest(
            'GET',
            'ingests'
        );

        $this->resource->getIngests();
    }
}
