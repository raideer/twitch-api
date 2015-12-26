<?php
namespace Raideer\TwitchApi\Resources;

class Chat extends Resource{

  public function getName(){
    return "chat";
  }

  public function getChat($channel){

    return $this->wrapper->request("GET","chat/$channel");
  }

  public function getEmoticons(){
    return $this->wrapper->request("GET","chat/emoticons");
  }

  public function getEmoticonImages($options = []){

    $defaults = [
      "emotesets" => null
    ];

    return $this->wrapper->request("GET","chat/emoticon_images", ['query' => $this->resolveOptions($options, $defaults)]);
  }

  public function getBadges($channel){
    return $this->wrapper->request("GET","chat/$channel/badges");
  }

}
