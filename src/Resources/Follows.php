<?php
namespace Raideer\Tweech\TwitchApi\Resources;

class Follows extends Resource{

  public function getName(){
    return "follows";
  }

  /**
   * Returns a list of follow objects
   *
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#get-channelschannelfollows
   *
   * @param  string $channel Channel name
   * @param  array  $options List of parameters
   * @return object
   */
  public function getFollowers($channel, $options = []){

    $defaults = [
      "limit" => 25,
      "offset" => 0,
      "direction" => "desc",
      "cursor" => null
    ];

    return $this->wrapper->get("channels/$channel/follows", ['query' => $this->resolveOptions($options, $defaults)]);
  }

  /**
   * Returns a list of follows objects
   *
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#get-usersuserfollowschannels
   *
   * @param  string $user    User
   * @param  array  $options List of parameters
   * @return object
   */
  public function getFollows($user, $options = []){

    $defaults = [
      "limit" => 25,
      "offset" => 0,
      "direction" => "desc",
      "sortby" => "created_at"
    ];

    return $this->wrapper->get("users/$user/follows/channels", ['query' => $this->resolveOptions($options, $defaults)]);
  }

  public function getRelationship($user, $target){

    return $this->wrapper->get("users/$user/follows/channels/$target");
  }

}
