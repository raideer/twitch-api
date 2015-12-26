<?php
namespace Raideer\TwitchApi\Resources;

class Search extends Resource{

  public function getName(){
    return "search";
  }

  public function searchChannels($query, $options = []){

    $defaults = [
      "query" => $query,
      "limit" => 25,
      "offset" => 0
    ];

    return $this->wrapper->request("GET","search/channels", ['query' => $this->resolveOptions($options, $defaults)]);
  }

  public function searchStreams($query, $options = []){

    $defaults = [
      "query" => $query,
      "limit" => 25,
      "offset" => 0,
      "hls" => null
    ];

    return $this->wrapper->request("GET","search/streams", ['query' => $this->resolveOptions($options, $defaults)]);
  }

  public function searchGames($query, $options = []){

    $defaults = [
      "query" => $query,
      "limit" => 25,
      "type" => "suggest",
      "live" => false
    ];

    return $this->wrapper-request("GET","search/games", ['query' => $this->resolveOptions($options, $defaults)]);
  }

}
