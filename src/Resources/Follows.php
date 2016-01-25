<?php
namespace Raideer\TwitchApi\Resources;

/**
 * Status of follow relationships between users and channels.
 */
class Follows extends Resource{

  /**
   * Returns resource name
   * @return string
   */
  public function getName(){
    return "follows";
  }

  /**
   * Returns a list of follow objects
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#get-channelschannelfollows
   *
   * @param  string $channel Target channel
   * @param  array  $params List of parameters
   * @return object
   */
  public function getFollowers($channel, $params = []){

    $defaults = [
      "limit" => 25,
      "offset" => 0,
      "direction" => "desc",
      "cursor" => null
    ];

    return $this->wrapper->request("GET","channels/$channel/follows", ['query' => $this->resolveOptions($params, $defaults)]);
  }

  /**
   * Returns a list of follows objects
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#get-usersuserfollowschannels
   *
   * @param  string $user    Target user
   * @param  array  $params List of parameters
   * @return object
   */
  public function getFollows($user, $params = []){

    $defaults = [
      "limit" => 25,
      "offset" => 0,
      "direction" => "desc",
      "sortby" => "created_at"
    ];

    return $this->wrapper->request("GET","users/$user/follows/channels", ['query' => $this->resolveOptions($params, $defaults)]);
  }

  /**
   * Returns the relationship between target user and channel
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#get-usersuserfollowschannelstarget
   *
   * @param  string $user   Target user
   * @param  string $target Target channel
   * @return array
   */
  public function getRelationship($user, $channel){

    return $this->wrapper->request("GET","users/$user/follows/channels/$channel");
  }

  /**
   * Adds $user to $target's followers. $user is authenticated user's name and $target is
   * the name of the channel to be followed
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#put-usersuserfollowschannelstarget
   *
   * @param  string $user          Authenticated user
   * @param  string $target        Target channel
   * @param  boolean $notifications Wether $user wants to receive notifications when $target goes live
   * @return array
   */
  public function followChannel($user, $target, $notifications = false){
    $this->wrapper->checkScope("user_follows_edit");

    return $this->wrapper->request("PUT","users/$user/follows/channels/$target", ['form_params' => ['notifications' => $notifications]], true);
  }

  /**
   * Removes $user from $target's followers. $user is authenticated user's name and $target is
   * the name of the channel to be unfollowed
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#delete-usersuserfollowschannelstarget
   *
   * @param  string $user   Authenticated user
   * @param  string $target Target channel
   * @return array
   */
  public function unfollowChannel($user, $target){
    $this->wrapper->checkScope("user_follows_edit");

    return $this->wrapper->request("DELETE","users/$user/follows/channels/$target", [], true);
  }

}
