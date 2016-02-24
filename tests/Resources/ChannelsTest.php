<?php

use Mockery as m;

class ChannelsTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource("Raideer\TwitchApi\Resources\Channels");
    }

    public function test_getName_returnsChannels()
    {
        $resource = $this->resource;

        $this->assertSame('channels', $resource->getName());
    }

    public function test_getChannel()
    {
        $this->checkForScope('channel_read');

        $this->mockRequest(
            $this->wrapper,
            'GET',
            'channel',
            [],
            true
        );

        $resource = $this->resource;
        $resource->getChannel();
    }

    public function test_getChannelName()
    {
        $this->mockRequest(
            $this->wrapper,
            'GET',
            'channels/testchannel'
        );

        $resource = $this->resource;
        $resource->getChannel('testchannel');
    }

    public function test_getEditors()
    {
        $this->checkForScope('channel_read');

        $this->mockRequest(
            $this->wrapper,
            'GET',
            'channels/testchannel/editors',
            [],
            true
        );

        $resource = $this->resource;
        $resource->getEditors('testchannel');
    }

    public function test_updateChannel()
    {
        $this->checkForScope('channel_editor');

        $this->mockRequest(
            $this->wrapper,
            'PUT',
            'channels/testchannel',
            ['channel' => ['status' => 'hello', 'game' => 'Rust']],
            true
        );

        $resource = $this->resource;
        $resource->updateChannel('testchannel', ['status' => 'hello', 'game' => 'Rust']);
    }
}
