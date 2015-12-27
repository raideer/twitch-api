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
   * @param  array $options
   * @return array
   */
  public function getBlockedUsers($parameters = []){
    $this->wrapper->checkScope("user_blocks_read", true);

    $user = $this->wrapper->getAuthorizedUser();

    $defaults = [
      'limit' => 25,
      'offset' => 0
    ];

    return $this->wrapper->request("GET","users/$user/blocks", ['query' => $this->resolveOptions($parameters, $defaults)], true);
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
   * @param  string $target Target username
   * @return array
   */
  public function blockUser($target){
    $this->wrapper->checkScope("user_blocks_edit", true);

    $user = $this->wrapper->getAuthorizedUser();

    return $this->wrapper->request("PUT", "users/$user/blocks/$target", [], true);
  }

  /**
   * AUTHENTICATED REQUEST
   *
   * Removes $target from authenticated user's block list.
   *
   * Required scope: user_blocks_edit
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md#delete-usersuserblockstarget
   *
   * @param  string $target Target username
   * @return array
   */
  public function unblockUser($target){
    $this->wrapper->checkScope("user_blocks_edit", true);

    $user = $this->wrapper->getAuthorizedUser();

    return $this->wrapper->request("DELETE", "users/$user/blocks/$target", [], true);
  }


}
