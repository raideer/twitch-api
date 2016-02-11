<?php

namespace Raideer\TwitchApi\Resources;

/**
 * Chat is where Twitch users can interact with each other while watching a stream.
 */
class Chat extends Resource
{
    /**
   * Returns the resource name.
   *
   * @return string
   */
  public function getName()
  {
      return 'chat';
  }

  /**
   * Returns a links object to all other chat enpoints.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/chat.md#get-chatchannel
   *
   * @param  string $channel Target channel
   *
   * @return array
   */
  public function getChat($channel)
  {
      return $this->wrapper->request('GET', "chat/$channel");
  }

  /**
   * Returns a list of all emoticon objects for Twitch.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/chat.md#get-chatemoticons
   *
   * @return array
   */
  public function getEmoticons()
  {
      return $this->wrapper->request('GET', 'chat/emoticons');
  }

  /**
   * Returns a list of emoticons.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/chat.md#get-chatemoticon_images
   *
   * @param  array $params Optional parameters
   *
   * @return array
   */
  public function getEmoticonImages($params = [])
  {
      $defaults = [
      'emotesets' => null,
    ];

      return $this->wrapper->request('GET', 'chat/emoticon_images', ['query' => $this->resolveOptions($params, $defaults)]);
  }

  /**
   * Returns a list of chat badges that can be used in $channel's chat.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/chat.md#get-chatchannelbadges
   *
   * @param  string $channel Target channel
   *
   * @return array
   */
  public function getBadges($channel)
  {
      return $this->wrapper->request('GET', "chat/$channel/badges");
  }
}
