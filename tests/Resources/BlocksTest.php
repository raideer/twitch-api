<?php

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
            'GET',
            'users/testUser/blocks',
            ['limit' => 10, 'offset' => 0],
            true
        );

        $this->resource->getBlockedUsers('testUser', ['limit' => 10]);
    }

    public function test_blockUser()
    {
        $this->checkForScope('user_blocks_edit');

        $this->mockRequest(
            'PUT',
            'users/testChannel/blocks/testUser',
            [],
            true
        );

        $this->resource->blockUser('testChannel', 'testUser');
    }

    public function test_unblockUser()
    {
        $this->checkForScope('user_blocks_edit');

        $this->mockRequest(
            'DELETE',
            'users/testChannel/blocks/testUser',
            [],
            true
        );

        $this->resource->unblockUser('testChannel', 'testUser');
    }
}
