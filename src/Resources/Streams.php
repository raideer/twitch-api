<?php

namespace Raideer\TwitchApi\Resources;

/**
 * Streams are video broadcasts that are currently live
 * They have a broadcaster and are part of a channel.
 */
class Streams extends Resource
{
    /**
   * Returns the Resource name.
   *
   * @return string
   */
  public function getName()
  {
      return 'streams';
  }

  /**
   * Returns a stream object if live.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/streams.md#get-streamschannel
   *
   * @param  string $channel Target channel
   *
   * @return array
   */
  public function getStream($channel)
  {
      return $this->wrapper->request('GET', "streams/$channel");
  }

  /**
   * Returns a list of stream objects that are queried by a number
   * of parameters sorted by number of viewers descending.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/streams.md#get-streams
   *
   * @param  array $params Optional params
   *
   * @return array
   */
  public function getStreams($params = [])
  {
      $defaults = [
          'game'        => null,
          'channel'     => null,
          'limit'       => 25,
          'offset'      => 0,
          'client_id'   => null,
          'stream_type' => 'all',
      ];

      $types = [
          'stream_type' => ['all', 'playlist', 'live'],
      ];

      return $this->wrapper->request('GET', 'streams', ['query' => $this->resolveOptions($params, $defaults, [], $types)]);
  }

  /**
   * Returns a list of featured (promoted) stream objects.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/streams.md#get-streamsfeatured
   *
   * @param  array $params Optional params
   *
   * @return array
   */
  public function getFeatured($params = [])
  {
      $defaults = [
          'limit'  => 25,
          'offset' => 0,
      ];

      return $this->wrapper->request('GET', 'streams/featured', ['query' => $this->resolveOptions($params, $defaults)]);
  }

  /**
   * Returns a summary of current streams.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/streams.md#get-streamssummary
   *
   * @param  string $game Only show stats for set game
   *
   * @return array
   */
  public function getSummary($game = null)
  {
      return $this->wrapper->request('GET', 'streams/summary', ['query' => ['game' => $game]]);
  }

  /**
   * Returns a list of stream objects that the authenticated user is following.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/users.md#get-streamsfollowed
   *
   * @param  array $params Optional params
   *
   * @return array
   */
  public function getFollowed($params = [])
  {
      $this->wrapper->checkScope('user_read');

      $defaults = [
          'limit'       => 25,
          'offset'      => 0,
          'stream_type' => 'all',
      ];

      $values = [
          'stream_type' => ['all', 'playlist', 'live'],
      ];

      return $this->wrapper->request('GET', 'streams/followed', ['query' => $this->resolveOptions($params, $defaults, [], $values)], true);
  }
}
