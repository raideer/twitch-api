<?php

class SubscriptionTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource('Raideer\TwitchApi\Resources\Subscriptions');
    }

    public function test_getName_returnsSubscriptions()
    {
        $this->assertSame('subscriptions', $this->resource->getName());
    }

    public function test_getSubscribtions()
    {
        $this->checkForScope('channel_subscriptions');

        $expect = [
            'limit'     => 10,
            'offset'    => 0,
            'direction' => 'desc',
        ];

        $this->mockRequest(
            'GET',
            'channels/testchannel/subscriptions',
            $expect,
            true
        );

        $this->resource->getSubscribtions('testchannel', ['limit' => 10, 'direction' => 'desc']);
    }

    public function test_getSubscribtion()
    {
        $this->checkForScope('channel_check_subscription');

        $this->mockRequest(
            'GET',
            'channels/testchannel/subscriptions/testuser',
            [],
            true
        );

        $this->resource->getSubscribtion('testchannel', 'testuser');
    }

    public function test_getUserSubscribtion()
    {
        $this->checkForScope('user_subscriptions');

        $this->mockRequest(
            'GET',
            'users/testuser/subscriptions/testchannel',
            [],
            true
        );

        $this->resource->getUserSubscribtion('testuser', 'testchannel');
    }
}
