<?php
namespace Raideer\Tweech\TwitchApi\Resources;

class Games extends Resource{

  public function getName(){
    return "games";
  }

  public function getTopGames($options = []){

    $defaults = [
      "limit" => 10,
      "offset" => 0
    ];

    return $this->wrapper->get("games/top", ['query' => $this->resolveOptions($options, $defaults)]);
  }


}
