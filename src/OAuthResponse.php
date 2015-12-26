<?php
namespace Raideer\TwitchApi;

class OAuthResponse{

  protected $response;

  protected $contents;

  public function __construct(\Psr\Http\Message\ResponseInterface $response){
    $this->response = $response;
    $this->contents = json_decode($this->response->getBody()->getContents());
  }

  public function getResponse(){
    return $this->response;
  }

  public function getContents(){
    return $this->contents;
  }

  public function getAccessToken(){
    return $this->contents->access_token;
  }

  public function getRefreshToken(){
    return $this->contents->refresh_token;
  }

  public function getScope(){
    return $this->contents->scope;
  }

  public function hasScope($scope){
    return in_array($scope, $this->getScope());
  }

}
