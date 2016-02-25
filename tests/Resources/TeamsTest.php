<?php

class TeamsTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource('Raideer\TwitchApi\Resources\Teams');
    }

    public function test_getName_returnsTeams()
    {
        $this->assertSame('teams', $this->resource->getName());
    }

    public function test_getTeams()
    {
        $this->mockRequest(
            'GET',
            'teams',
            [
                'limit'  => 10,
                'offset' => 0,
            ]
        );

        $this->resource->getTeams(['limit' => 10]);
    }

    public function test_getTeam()
    {
        $this->mockRequest(
            'GET',
            'teams/testteam'
        );

        $this->resource->getTeam('testteam');
    }
}
