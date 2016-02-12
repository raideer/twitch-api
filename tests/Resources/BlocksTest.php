<?php

use Mockery as m;
use Raideer\TwitchApi\Resources\Blocks;

class BlocksTest extends PHPUnit_Framework_TestCase
{
    protected $wrapper;
    protected $resource;

    protected function setUp()
    {
        $this->wrapper = m::mock("Raideer\TwitchApi\Wrapper");
        $this->wrapper->shouldReceive('registerResource')->with('Raideer\TwitchApi\Resources\Resource');
        $this->resource = new Blocks($this->wrapper);
    }

    public function test_getName_returnsBlocks()
    {
        $resource = $this->resource;

        $this->assertSame('blocks', $resource->getName());
    }

    public function test_getBlockedUsers()
    {
        $this->wrapper->shouldReceive('checkScope')->with('user_blocks_read');
        $this->wrapper->shouldReceive('request')->withArgs([
      'GET',
      'users/testUser/blocks',
      ['query' => ['limit' => 10, 'offset' => 0]],
      true,
    ]);

        $resource = $this->resource;
        $resource->getBlockedUsers('testUser', ['limit' => 10]);
    }

    public function test_blockUser()
    {
        $this->wrapper->shouldReceive('checkScope')->once()->with('user_blocks_edit');

        $this->wrapper->shouldReceive('request')->once()->withArgs([
      'PUT',
      'users/testChannel/blocks/testUser',
      [],
      true,
    ]);

        $resource = $this->resource;
        $resource->blockUser('testChannel', 'testUser');
    }

    public function test_unblockUser()
    {
        $this->wrapper->shouldReceive('checkScope')->once()->with('user_blocks_edit');

        $this->wrapper->shouldReceive('request')->once()->withArgs([
      'DELETE',
      'users/testChannel/blocks/testUser',
      [],
      true,
    ]);

        $resource = $this->resource;
        $resource->unblockUser('testChannel', 'testUser');
    }
}
