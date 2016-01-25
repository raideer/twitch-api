<?php
namespace Raideer\TwitchApi\Resources;

/**
 * Stores and updates information about a user's block list.
 */
class Blocks extends Resource{

  /**
   * Returns the resource name
   * @return string
   */
  public function getName(){
    return "blocks";
  }

  /**
   * AUTHENTICATED REQUEST
   *
   * Returns a list of blocks objects on authenticated user's block list.
   * Sorted by recency, newest first.
   *
   * Required scope: user_blocks_read
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md#get-usersuserblocks
   * @param  string $channel Target Channel name
   * @param  array $params
   * @return array
   */
  public function getBlockedUsers($channel, $params = []){
    $this->wrapper->checkScope("user_blocks_read");

    $defaults = [
      'limit' => 25,
      'offset' => 0
    ];

    return $this->wrapper->request("GET","users/$channel/blocks", ['query' => $this->resolveOptions($params, $defaults)], true);
  }

  /**
   * AUTHENTICATED REQUEST
   *
   * Adds $target to authenticated user's block list. Returns a blocks object.
   *
   * Required scope: user_blocks_edit
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md#put-usersuserblockstarget
   *
   * @param  string $channel Target Channel name
   * @param  string $target Target username
   * @return array
   */
  public function blockUser($channel, $target){
    $this->wrapper->checkScope("user_blocks_edit");

    return $this->wrapper->request("PUT", "users/$channel/blocks/$target", [], true);
  }

  /**
   * AUTHENTICATED REQUEST
   *
   * Removes $target from $user's block list.
   *
   * Required scope: user_blocks_edit
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md#delete-usersuserblockstarget
   *
   * @param  string $user  Target Channel name
   * @param  string $target Target username
   * @return array
   */
  public function unblockUser($user, $target){
    $this->wrapper->checkScope("user_blocks_edit");

    return $this->wrapper->request("DELETE", "users/$user/blocks/$target", [], true);
  }


}
