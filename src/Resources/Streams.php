<?php
namespace Raideer\TwitchApi\Resources;

class Streams extends Resource{

  public function getName(){
    return "streams";
  }

  public function getStream($channel){

    return $this->wrapper->request("GET","streams/$channel");
  }

  public function getStreams($options = []){

    $defaults = [
      "game" => null,
      "channel" => null,
      "limit" => 25,
      "offset" => 0,
      "client_id" => null,
      "stream_type" => "all"
    ];

    $types = [
      "stream_type" => ["all","playlist","live"]
    ];

    return $this->wrapper->request("GET","streams", ['query' => $this->resolveOptions($options, $defaults, [], $types)]);
  }

  public function getFeatured($options = []){

    $defaults = [
      "limit" => 25,
      "offset" => 0
    ];

    return $this->wrapper->request("GET","streams/featured", ['query' => $this->resolveOptions($options, $defaults)]);
  }

  public function getSummary($options = []){

    $defaults = [
      "game" => null
    ];

    return $this->wrapper->request("GET","streams/summary", ['query' => $this->resolveOptions($options, $defaults)]);
  }
}
