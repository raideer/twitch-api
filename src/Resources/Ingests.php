<?php
namespace Raideer\TwitchApi\Resources;

class Ingests extends Resource{

  public function getName(){
    return "ingests";
  }

  public function getIngests(){

    return $this->wrapper->get("ingests");
  }


}
