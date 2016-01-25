<?php
namespace Raideer\TwitchApi\Resources;

/**
 * Games are categories (e.g. League of Legends, Diablo 3) used by streams and channels.
 * Games can be searched for by query.
 */
class Games extends Resource{

  /**
   * Returns the resource name
   * @return string
   */
  public function getName(){
    return "games";
  }

  /**
   * Returns a list of games objects sorted by number of current viewers on Twitch, most popular first
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/games.md#get-gamestop
   *
   * @param  array $params Optional parameters
   * @return array
   */
  public function getTopGames($params = []){

    $defaults = [
      "limit" => 10,
      "offset" => 0
    ];

    return $this->wrapper->request("GET","games/top", ['query' => $this->resolveOptions($params, $defaults)]);
  }


}
