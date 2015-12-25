<?php
namespace Raideer\Tweech\TwitchApi\Resources;

class Chat extends Resource{

  public function getName(){
    return "chat";
  }

  public function getChat($channel){

    return $this->wrapper->get("chat/$channel");
  }

  public function getEmoticons(){
    return $this->wrapper->get("chat/emoticons");
  }

  public function getEmoticonImages($options = []){

    $defaults = [
      "emotesets" => null
    ];

    return $this->wrapper->get("chat/emoticon_images", ['query' => $this->resolveOptions($options, $defaults)]);
  }

  public function getBadges($channel){
    return $this->wrapper->get("chat/$channel/badges");
  }

}
