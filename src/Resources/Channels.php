<?php
namespace Raideer\TwitchApi\Resources;

class Channels extends Resource{

  public function getName(){
    return "channels";
  }

  public function getChannel($name = null){
    if(!$name){
      $this->wrapper->checkScope("channel_read", true);

      return $this->wrapper->request("GET","channel", [], true);
    }

    return $this->wrapper->request("GET","channels/$name");
  }

  public function getEditors($channel){
    $this->wrapper->checkScope("channel_read", true);

    return $this->wrapper->request("GET","channels/$channel/editors", [], true);
  }

  public function updateChannel($channel, $params){
    $this->wrapper->checkScope("channel_editor", true);

    return $this->wrapper->request("PUT", "channels/$channel/", ['form_params' => ['channel' => $params]], true);
  }

  public function resetStreamKey($channel){
    $this->wrapper->checkScope("channel_stream", true);

    return $this->wrapper->request("DELETE", "channels/$channel/stream_key", [], true);
  }

  public function startCommercial($channel, $length = 30){
    $this->wrapper->checkScope("channel_commercial", true);

    $values = [
      "length" => [30,60,90,120,150,180]
    ];

    $resolved = $this->resolveOptions(['length' => $length], [], ['length'], $values);

    return $this->wrapper->request("POST", "channels/$channel/commercial", ['form_params' => $resolved], true);
  }

  public function getVideos($name){
    return $this->wrapper->request("GET","channels/$name/videos");
  }

  public function getFollows($name){
    return $this->wrapper->request("GET","channels/$name/follows");
  }

}
