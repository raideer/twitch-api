<?php
namespace Raideer\TwitchApi\Resources;

class Videos extends Resource{

  public function getName(){
    return 'videos';
  }

  public function getVideo($id){

    return $this->wrapper->request("GET","videos/$id");
  }

  public function getTopVideos($options = []){

    $defaults = [
      "limit" => 10,
      "offset" => 0,
      "game" => null,
      "period" => "week"
    ];

    $values = [
      "period" => ["week", "month", "all"]
    ];

    return $this->wrapper->request("GET","videos/top", ['query' => $this->resolveOptions($options, $defaults, [], $values)]);
  }

  public function getChannelVideos($channel, $options = []){

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

    return $this->wrapper->request("GET","channels/$channel/videos", ['query' => $this->resolveOptions($options, $defaults, [], $values)]);
  }

}
