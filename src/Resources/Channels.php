<?php

namespace Raideer\TwitchApi\Resources;

/**
 * Channels serve as the home location for a user's content.
 * Channels have a stream, can run commercials, store videos, display information and status,
 * and have a customized page including banners and backgrounds.
 */
class Channels extends Resource
{
    /**
   * Returns the resource name.
   *
   * @return string
   */
  public function getName()
  {
      return 'channels';
  }

  /**
   * Returns a channel object
   * If channel name not provided, wrapper will assume it's an authenticated request and return
   * authenticated channel (scope: channel_read).
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#get-channelschannel
   *
   * @param  string $name Target channel
   *
   * @return array
   */
  public function getChannel($name = null)
  {
      if (!$name) {
          $this->wrapper->checkScope('channel_read');

          return $this->wrapper->request('GET', 'channel', [], true);
      }

      return $this->wrapper->request('GET', "channels/$name");
  }

  /**
   * AUTHENTICATED REQUEST.
   *
   * Returns a list of user objects who are editors of $channel
   *
   * Required scope: channel_read
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#get-channelschanneleditors
   *
   * @param  string $channel Target channel
   *
   * @return array
   */
  public function getEditors($channel)
  {
      $this->wrapper->checkScope('channel_read');

      return $this->wrapper->request('GET', "channels/$channel/editors", [], true);
  }

  /**
   * AUTHENTICATED REQUEST.
   *
   * Updates channel's status, game and/or delay
   *
   * Required scope: channel_editor
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#put-channelschannel
   *
   * @param  string $channel  Target channel. If null - uses authenticated username
   * @param  array  $params   Parameters
   *
   * @return array
   */
  public function updateChannel($channel, $params = [])
  {
      $this->wrapper->checkScope('channel_editor');

      return $this->wrapper->request('PUT', "channels/$channel", ['form_params' => ['channel' => $params]], true);
  }

  /**
   * AUTHENTICATED REQUEST.
   *
   * Resets channel's stream key
   *
   * Required scope: channel_stream
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#delete-channelschannelstream_key
   *
   * @param string $channel Target channel
   *
   * @return array
   */
  public function resetStreamKey($channel)
  {
      $this->wrapper->checkScope('channel_stream');

      return $this->wrapper->request('DELETE', "channels/$channel/stream_key", [], true);
  }

  /**
   * AUTHENTICATED REQUEST.
   *
   * Starts a commercial
   *
   * Required scope: channel_commercial
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#post-channelschannelcommercial
   *
   * @param  string  $channel Target channel
   * @param  int $length  Length in seconds (30,60,90,120,150,180)
   *
   * @return array
   */
  public function startCommercial($channel, $length = 30)
  {
      $this->wrapper->checkScope('channel_commercial');

      $values = [
      'length' => [30, 60, 90, 120, 150, 180],
    ];

      $resolved = $this->resolveOptions(['length' => $length], [], ['length'], $values);

      return $this->wrapper->request('POST', "channels/$channel/commercial", ['form_params' => $resolved], true);
  }

  /**
   * Returns a list of videos ordered by time of creation, starting with the most recent from $channel.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/videos.md#get-channelschannelvideos
   *
   * @param  string $name Target channel
   *
   * @return array
   */
  public function getVideos($channel, $params = [])
  {
      $defaults = [
      'limit'      => 10,
      'offset'     => 0,
      'broadcasts' => false,
      'hls'        => false,
    ];

      $values = [
      'broadcasts' => [true, false],
      'hls'        => [true, false],
    ];

      $resolved = $this->resolveOptions($params, $defaults, [], $values);

      return $this->wrapper->request('GET', "channels/$channel/videos", ['query' => $resolved]);
  }

  /**
   * Returns a list of team object $channel belongs to.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#get-channelschannelteams
   *
   * @param  string $channel Target channel
   *
   * @return array
   */
  public function getTeams($channel)
  {
      return $this->wrapper->request('GET', "channels/$channel/teams");
  }

  /**
   * Returns a list of follow objects for $channel.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#get-channelschannelfollows
   *
   * @param  string $channel Target channel name
   * @param  array  $params  Optional Parameters
   *
   * @return array
   */
  public function getFollows($channel, $params = [])
  {
      $defaults = [
      'limit'     => 25,
      'offset'    => 0,
      'cursor'    => null,
      'direction' => 'desc',
    ];

      $values = [
      'direction' => ['asc', 'desc'],
    ];

      $resolved = $this->resolveOptions($params, $defaults, [], $values);

      return $this->wrapper->request('GET', "channels/$channel/follows", ['query' => $resolved]);
  }
}
