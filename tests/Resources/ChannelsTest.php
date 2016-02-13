<?php

use Mockery as m;
use Raideer\TwitchApi\Resources\Channels;

class ChannelsTest extends PHPUnit_Framework_TestCase
{
    protected $wrapper;
    protected $resource;

    protected function setUp()
    {
        $this->wrapper = m::mock("Raideer\TwitchApi\Wrapper");
        $this->wrapper->shouldReceive('registerResource')->with('Raideer\TwitchApi\Resources\Resource');
        $this->resource = new Channels($this->wrapper);
    }

    public function test_getName_returnsChannels()
    {
        $resource = $this->resource;

        $this->assertSame('channels', $resource->getName());
    }

    public function test_getChannel()
    {
        $this->wrapper->shouldReceive('checkScope')->with('channel_read');
        $this->wrapper->shouldReceive('request')->withArgs([
          'GET',
          'channel',
          [],
          true,
        ]);

        $resource = $this->resource;
        $resource->getChannel();
    }

    public function test_getChannelName()
    {
        $this->wrapper->shouldReceive('checkScope')->with('channel_read');
        $this->wrapper->shouldReceive('request')->withArgs([
          'GET',
          'channel/testchannel',
          [],
          true,
        ]);

        $resource = $this->resource;
        $resource->getChannel('testchannel');
    }

    public function test_getEditors()
    {
        $this->wrapper->shouldReceive('checkScope')->with('channel_read');
        $this->wrapper->shouldReceive('request')->withArgs([
          'GET',
          'channels/testchannel/editors',
          [],
          true,
        ]);

        $resource = $this->resource;
        $resource->getEditors('testchannel');
    }

    public function test_updateChannel()
    {
        $this->wrapper->shouldReceive('checkScope')->with('channel_editor');
        $this->wrapper->shouldReceive('request')->withArgs([
          'PUT',
          'channels/testchannel',
          ['form_params' => ['status' => 'hello', 'game' => 'Rust']],
          true,
        ]);

        $resource = $this->resource;
        $resource->updateChannel('testchannel', ['status' => 'hello', 'game' => 'Rust']);
    }
}
