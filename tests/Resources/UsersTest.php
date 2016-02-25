<?php

class UsersTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource('Raideer\TwitchApi\Resources\Users');
    }

    public function test_getName_returnsUsers()
    {
        $this->assertSame('users', $this->resource->getName());
    }

    public function test_getUser()
    {
        $this->checkForScope('user_read');
        $this->mockRequest(
            'GET',
            'user',
            [],
            true
        );

        $this->resource->getUser();
    }

    public function test_getUser_unauthenticated()
    {
        $this->mockRequest(
            'GET',
            'users/testuser'
        );

        $this->resource->getUser('testuser');
    }

    public function test_getFollowedVideos()
    {
        $this->checkForScope('user_read');
        $this->mockRequest(
            'GET',
            'videos/followed',
            [
                'limit'  => 15,
                'offset' => 0
            ],
            true
        );

        $this->resource->getFollowedVideos(['limit' => 15]);
    }
}
