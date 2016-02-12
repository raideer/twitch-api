<?php
namespace Raideer\TwitchApi\Resources;

/**
 * Videos are broadcasts or chapters owned by a channel.
 * Broadcasts are unedited videos that are saved after a streaming session.
 * Chapters are videos edited from broadcasts by the channel's owner.
 */
class Videos extends Resource{

  /**
   * Returns the Resource name
   * @return string
   */
  public function getName(){
    return 'videos';
  }

  /**
   * Returns a video object
   *
   * @param  string $id Video ID
   * @return array
   */
  public function getVideo($id){

    return $this->wrapper->request("GET","videos/$id");
  }

  /**
   * Returns a list of videos created in a given time period sorted by
   * number of views, most popular first
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/videos.md#get-videostop
   *
   * @param  array $params Optional params
   * @return array
   */
  public function getTopVideos($params = []){

    $defaults = [
      "limit" => 10,
      "offset" => 0,
      "game" => null,
      "period" => "week"
    ];

    $values = [
      "period" => ["week", "month", "all"]
    ];

    return $this->wrapper->request("GET","videos/top", ['query' => $this->resolveOptions($params, $defaults, [], $values)]);
  }

  /**
   * Returns a list of videos ordered by time of creation,
   * starting with the most recent from $channel
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/videos.md#get-channelschannelvideos
   *
   * @param  string $channel Target channel
   * @param  array $params Optional params
   * @return array
   */
  public function getChannelVideos($channel, $params = []){

    $defaults = [
      "limit" => 10,
      "offset" => 0,
      "broadcasts" => false,
      "hls" => false
    ];

    $values = [
      "hls" => [true, false],
      "broadcasts" => [true, false]
    ];

    return $this->wrapper->request("GET","channels/$channel/videos", ['query' => $this->resolveOptions($params, $defaults, [], $values)]);
  }

  /**
   * Returns a list of video objects from channels that the authenticated user is following
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/users.md#get-videosfollowed
   *
   * @param  array $params Optional params
   * @return array
   */
  public function getFollowedVideos($params = []){

    return $this->wrapper->resource('users')->getFollowedVideos($params);
  }

}
