<?php

namespace Raideer\TwitchApi\Resources;

/**
 * These are members of the Twitch community who have a Twitch account.
 * If broadcasting, they can own a stream that they can broadcast on their channel.
 * If mainly viewing, they might follow or subscribe to channels.
 */
class Users extends Resource
{
    /**
   * Returns the Resource name.
   *
   * @return string
   */
  public function getName()
  {
      return 'users';
  }

  /**
   * Returns a user object
   * If $name not set, will return authenticated user_read.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/users.md#get-usersuser
   *
   * @param  string $name Target user
   *
   * @return array
   */
  public function getUser($name = null)
  {
      if (!$name) {
          $this->wrapper->checkScope('user_read');

          return $this->wrapper->request('GET', 'user', [], true);
      }

      return $this->wrapper->request('GET', "users/$name");
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
      return $this->wrapper->resource('streams')->getFollowed($params);
  }

  /**
   * Returns a list of video objects from channels that the authenticated user is following.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/users.md#get-videosfollowed
   *
   * @param  array $params Optional params
   *
   * @return array
   */
  public function getFollowedVideos($params = [])
  {
      $this->wrapper->checkScope('user_read');

      $defaults = [
          'limit'  => 10,
          'offset' => 0,
      ];

      return $this->wrapper->request('GET', 'videos/followed', ['query' => $this->resolveOptions($params, $defaults)], true);
  }
}
