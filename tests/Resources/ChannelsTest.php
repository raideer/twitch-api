<?php
use Raideer\TwitchApi\Resources\Channels;
use Mockery as m;

class ChannelsTest extends PHPUnit_Framework_TestCase{

  protected $wrapper;
  protected $resource;

  protected function setUp(){
    $this->wrapper = m::mock("Raideer\TwitchApi\Wrapper");
    $this->wrapper->shouldReceive('registerResource')->with('Raideer\TwitchApi\Resources\Resource');
    $this->resource = new Channels($this->wrapper);
  }

  public function test_getName_returnsChannels(){
    $resource = $this->resource;

    $this->assertSame("channels", $resource->getName());
  }


}
