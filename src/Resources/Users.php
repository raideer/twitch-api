<?php
namespace Raideer\TwitchApi\Resources;

class Users extends Resource{

  public function getName(){
    return 'users';
  }

  public function getUser($name = null){
    if(!$name){
      $this->wrapper->checkScope("user_read", true);

      return $this->wrapper->request("GET","user", [], true);
    }
    return $this->wrapper->request("GET","users/$name");
  }

}
