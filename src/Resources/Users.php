<?php
namespace Raideer\Tweech\TwitchApi\Resources;

class Users extends Resource{

  public function getName(){
    return 'users';
  }

  public function getUser($name){

    return $this->wrapper->get("users/$name");
  }

}
