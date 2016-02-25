<?php

class SearchTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource('Raideer\TwitchApi\Resources\Search');
    }

    public function test_getName_returnsSearch()
    {
        $this->assertSame('search', $this->resource->getName());
    }

    public function test_searchChannels()
    {
        $query = 'this is a test query';
        $this->mockRequest(
            'GET',
            'search/channels',
            [
                'query' => urlencode($query),
                'limit' => 10,
                'offset' => 0
            ]
        );

        $this->resource->searchChannels($query, ['limit' => 10]);
    }

    public function test_searchStreams()
    {
        $query = 'this is a test query';
        $this->mockRequest(
            'GET',
            'search/streams',
            [
                'query' => urlencode($query),
                'limit' => 10,
                'offset' => 0,
                'hls' => null
            ]
        );

        $this->resource->searchStreams($query, ['limit' => 10]);
    }

    public function test_searchGames()
    {
        $query = 'this is a test query';
        $this->mockRequest(
            'GET',
            'search/games',
            [
                'query' => urlencode($query),
                'limit' => 10,
                'type' => 'suggest',
                'live' => true
            ]
        );

        $this->resource->searchGames($query, ['limit' => 10, 'live' => true]);
    }
}
