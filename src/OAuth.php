<?php
namespace Raideer\TwitchApi;

use Symfony\Component\OptionsResolver\OptionsResolver;
use GuzzleHttp\Client;

class OAuth{

  protected $baseAuthUrl = "https://api.twitch.tv/kraken/oauth2/authorize";

  protected $clientId;
  protected $redirectUri;
  protected $scopes;
  protected $state;

  public function __construct($settings){

    $resolver = new OptionsResolver();
    $resolver->setDefaults(['scope' => []]);
    $resolver->setRequired(['client_id', 'redirect_uri', 'state']);

    $resolved = $resolver->resolve($settings);

    if($resolved){
      $this->setClientId($resolved["client_id"]);
      $this->setRedirectUri($resolved["redirect_uri"]);
      $this->setScope($resolved["scope"]);
      $this->setState($resolved["state"]);
    }
  }

  public function setClientId($clientId){
    $this->clientId = $clientId;

    return $this;
  }

  public function getClientId(){
    return $this->clientId;
  }

  public function setRedirectUri($redirectUri){
    $this->redirectUri = $redirectUri;

    return $this;
  }

  public function getRedirectUri(){
    return $this->redirectUri;
  }

  public function setScope($scope){
    if(!is_array($scope)){
      $this->scopes = implode(" ", $scope);
    }else{
      $this->scopes = $scope;
    }

    return $this;
  }

  public function getScope(){
    return $this->scopes;
  }

  public function addScope($scope){
    if(!is_array($scope)){
      $scope = explode(" ", $scope);
    }

    $this->scopes = array_unique(array_merge($this->scopes, $scope));

    return $this;
  }

  public function setState($state){
    $this->state = $state;

    return $this;
  }

  public function getState(){
    return $this->state;
  }

  public function getUrl(){

    $url = $this->baseAuthUrl;
    $url .= "?response_type=code";
    $url .= "&client_id=" . $this->clientId;
    $url .= "&redirect_uri=" . $this->redirectUri;
    $url .= "&scope=" . implode(" ", $this->scopes);
    $url .= "&state=" . $this->state;

    return $url;
  }

}
