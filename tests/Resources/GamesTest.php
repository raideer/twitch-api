<?php

class GamesTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource('Raideer\TwitchApi\Resources\Games');
    }

    public function test_getName_returnsGames()
    {
        $this->assertSame('games', $this->resource->getName());
    }

    public function test_getTopGames()
    {
        $params = [
            'limit'  => 20,
            'offset' => 5,
        ];

        $this->mockRequest(
            'GET',
            'games/top',
            $params
        );

        $this->resource->getTopGames($params);
    }
}
