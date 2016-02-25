<?php

class FollowsTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource("Raideer\TwitchApi\Resources\Follows");
    }

    public function test_getName_returnsFollows()
    {
        $this->assertSame('follows', $this->resource->getName());
    }

    public function test_getFollowers()
    {
        $params = [
            'limit'     => 10,
            'offset'    => 10,
            'direction' => 'asc',
            'cursor'    => null,
        ];

        $this->mockRequest(
            'GET',
            'channels/testchannel/follows',
            $params
        );

        $this->resource->getFollowers('testchannel', $params);
    }

    public function test_getFollows()
    {
        $params = [
            'limit'     => 10,
            'offset'    => 10,
            'direction' => 'asc',
            'sortby'    => 'created_at',
        ];

        $this->mockRequest(
            'GET',
            'users/testuser/follows/channels',
            $params
        );

        $this->resource->getFollows('testuser', $params);
    }

    public function test_getRelationship()
    {
        $this->mockRequest(
            'GET',
            'users/testuser/follows/channels/testchannel'
        );

        $this->resource->getRelationship('testuser', 'testchannel');
    }

    public function test_followChannel()
    {
        $this->checkForScope('user_follows_edit');

        $this->mockRequest(
            'PUT',
            'users/testuser/follows/channels/testchannel',
            ['notifications' => true],
            true
        );

        $this->resource->followChannel('testuser', 'testchannel', true);
    }

    public function test_unfollowChannel()
    {
        $this->checkForScope('user_follows_edit');

        $this->mockRequest(
            'DELETE',
            'users/testuser/follows/channels/testchannel',
            [],
            true
        );

        $this->resource->unfollowChannel('testuser', 'testchannel', true);
    }
}
