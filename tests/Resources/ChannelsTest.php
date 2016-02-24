<?php

class ChannelsTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource("Raideer\TwitchApi\Resources\Channels");
    }

    public function test_getName_returnsChannels()
    {
        $this->assertSame('channels', $this->resource->getName());
    }

    public function test_getChannel()
    {
        $this->checkForScope('channel_read');

        $this->mockRequest(
            'GET',
            'channel',
            [],
            true
        );

        $this->resource->getChannel();
    }

    public function test_getChannelName()
    {
        $this->mockRequest(
            'GET',
            'channels/testchannel'
        );

        $this->resource->getChannel('testchannel');
    }

    public function test_getEditors()
    {
        $this->checkForScope('channel_read');

        $this->mockRequest(
            'GET',
            'channels/testchannel/editors',
            [],
            true
        );

        $this->resource->getEditors('testchannel');
    }

    public function test_updateChannel()
    {
        $this->checkForScope('channel_editor');

        $this->mockRequest(
            'PUT',
            'channels/testchannel',
            ['channel' => ['status' => 'hello', 'game' => 'Rust']],
            true
        );

        $this->resource->updateChannel('testchannel', ['status' => 'hello', 'game' => 'Rust']);
    }
}
