<?php

class StreamsTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource('Raideer\TwitchApi\Resources\Streams');
    }

    public function test_getName_returnsIngests()
    {
        $this->assertSame('streams', $this->resource->getName());
    }

    public function test_getStream()
    {
        $this->mockRequest(
            'GET',
            'streams/testchannel'
        );

        $this->resource->getStream('testchannel');
    }

    public function test_getStreams()
    {
        $expect = [
            'game'        => 'Rust',
            'channel'     => null,
            'limit'       => 10,
            'offset'      => 0,
            'client_id'   => null,
            'stream_type' => 'all',
        ];

        $this->mockRequest(
            'GET',
            'streams',
            $expect
        );

        $this->resource->getStreams(['game' => 'Rust', 'limit' => 10]);
    }

    public function test_getFeatured()
    {
        $this->mockRequest(
            'GET',
            'streams/featured',
            [
                'limit'  => 10,
                'offset' => 1,
            ]
        );

        $this->resource->getFeatured(['limit' => 10, 'offset' => 1]);
    }

    public function test_getSummary()
    {
        $this->mockRequest(
            'GET',
            'streams/summary',
            [
                'game' => 'Rust'
            ]
        );

        $this->resource->getSummary('Rust');
    }

    public function test_getFollowed()
    {
        $this->checkForScope('user_read');

        $expect = [
            'limit'       => 10,
            'offset'      => 0,
            'stream_type' => 'live',
        ];

        $this->mockRequest(
            'GET',
            'streams/followed',
            $expect,
            true
        );

        $this->resource->getFollowed(['limit' => 10, 'stream_type' => 'live']);
    }
}
