<?php
namespace Raideer\TwitchApi;

use Symfony\Component\OptionsResolver\OptionsResolver;

class OAuth{

  protected $baseAuthUrl = "https://api.twitch.tv/kraken/oauth2/authorize";

  protected $clientId;
  protected $redirectUri;
  protected $scopes;
  protected $state;

  /**
   * Expects an array of settings that must contain
   * client_id, redirect_uri, state and scope
   * @param array $settings
   */
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

  /**
   * Sets the client_id
   * @param string $clientId
   */
  public function setClientId($clientId){
    $this->clientId = $clientId;

    return $this;
  }

  /**
   * Returns the client_id
   * @return string
   */
  public function getClientId(){
    return $this->clientId;
  }

  /**
   * Sets the redirect_uri
   * @param string $redirectUri
   */
  public function setRedirectUri($redirectUri){
    $this->redirectUri = $redirectUri;

    return $this;
  }

  /**
   * Returns the redirect_uri
   * @return string
   */
  public function getRedirectUri(){
    return $this->redirectUri;
  }

  /**
   * Sets the scope
   * @param string or array $scope Space seperated string or array
   */
  public function setScope($scope){
    if(!is_array($scope)){
      $this->scopes = explode(" ", $scope);
    }else{
      $this->scopes = $scope;
    }

    return $this;
  }

  /**
   * Returns the list of scopes
   * @return array
   */
  public function getScope(){
    return $this->scopes;
  }

  /**
   * Adds a scope
   * @param string $scope https://github.com/justintv/Twitch-API/blob/master/authentication.md#scopes
   */
  public function addScope($scope){
    if(!is_array($scope)){
      $scope = explode(" ", $scope);
    }

    $this->scopes = array_unique(array_merge($this->scopes, $scope));

    return $this;
  }

  /**
   * Sets the state (unique token attached to the auth request)
   * @param string $state Unique Token
   */
  public function setState($state){
    $this->state = $state;

    return $this;
  }

  /**
   * Returns the state/token
   * @return string
   */
  public function getState(){
    return $this->state;
  }

  /**
   * Builds the OAuth URL
   * @return string   URL
   */
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
