<?php
namespace Raideer\TwitchApi\Resources;

class Users extends Resource{

  public function getName(){
    return 'users';
  }

  public function getUser($name){

    return $this->wrapper->request("GET","users/$name");
  }

}
