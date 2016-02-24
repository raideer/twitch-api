<?php

class ChatTest extends Raideer\TwitchApi\TestCase
{
    public function __construct()
    {
        $this->setResource("Raideer\TwitchApi\Resources\Chat");
    }

    public function test_getName_returnsChat()
    {
        $this->assertSame('chat', $this->resource->getName());
    }

    public function test_getChat()
    {
        $this->mockRequest(
            'GET',
            'chat/testchat'
        );

        $this->resource->getChat('testchat');
    }

    public function test_getEmoticons()
    {
        $this->mockRequest(
            'GET',
            'chat/emoticon_images',
            ['emotesets' => null]
        );

        $this->resource->getEmoticonImages(['emotesets' => null]);
    }

    public function test_getBadges()
    {
        $this->mockRequest(
            'GET',
            'chat/testchannel/badges'
        );

        $this->resource->getBadges('testchannel');
    }
}
