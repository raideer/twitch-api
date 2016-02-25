<?php

class VideosTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource('Raideer\TwitchApi\Resources\Videos');
    }

    public function test_getName_returnsVideos()
    {
        $this->assertSame('videos', $this->resource->getName());
    }

    public function test_getVideo()
    {
        $this->mockRequest(
            'GET',
            'videos/videoid'
        );

        $this->resource->getVideo('videoid');
    }

    public function test_getTopVideos()
    {
        $expect = [
            'limit'  => 15,
            'offset' => 0,
            'game'   => null,
            'period' => 'all',
        ];

        $this->mockRequest(
            'GET',
            'videos/top',
            $expect
        );

        $this->resource->getTopVideos(['limit' => 15, 'period' => 'all']);
    }

    public function test_getChannelVideos()
    {
        $expect = [
            'limit'      => 15,
            'offset'     => 0,
            'broadcasts' => true,
            'hls'        => false,
        ];

        $this->mockRequest(
            'GET',
            'channels/testchannel/videos',
            $expect
        );

        $this->resource->getChannelVideos('testchannel', ['limit' => 15, 'broadcasts' => true]);
    }
}
