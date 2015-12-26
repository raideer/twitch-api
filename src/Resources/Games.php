<?php
namespace Raideer\TwitchApi\Resources;

class Games extends Resource{

  public function getName(){
    return "games";
  }

  public function getTopGames($options = []){

    $defaults = [
      "limit" => 10,
      "offset" => 0
    ];

    return $this->wrapper->request("GET","games/top", ['query' => $this->resolveOptions($options, $defaults)]);
  }


}
