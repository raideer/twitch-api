<?php

use Mockery as m;

class BlocksTest extends Raideer\TwitchApi\TestCase
{
    protected $wrapper;
    protected $resource;

    public function __construct()
    {
        $this->setResource("Raideer\TwitchApi\Resources\Blocks");
    }

    public function test_getName_returnsBlocks()
    {
        $this->assertSame('blocks', $this->resource->getName());
    }

    public function test_getBlockedUsers()
    {
        $this->checkForScope('user_blocks_read');

        $this->mockRequest(
            $this->wrapper,
            'GET',
            'users/testUser/blocks',
            ['limit' => 10, 'offset' => 0],
            true
        );

        $resource = $this->resource;
        $resource->getBlockedUsers('testUser', ['limit' => 10]);
    }

    public function test_blockUser()
    {
        $this->checkForScope('user_blocks_edit');

        $this->mockRequest(
            $this->wrapper,
            'PUT',
            'users/testChannel/blocks/testUser',
            [],
            true
        );

        $resource = $this->resource;
        $resource->blockUser('testChannel', 'testUser');
    }

    public function test_unblockUser()
    {
        $this->checkForScope('user_blocks_edit');

        $this->mockRequest(
            $this->wrapper,
            'DELETE',
            'users/testChannel/blocks/testUser',
            [],
            true
        );

        $resource = $this->resource;
        $resource->unblockUser('testChannel', 'testUser');
    }
}
