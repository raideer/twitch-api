<?php
namespace Raideer\TwitchApi;

use GuzzleHttp\Client;

class Auth{

  protected $baseAuthUrl = "https://api.twitch.tv/kraken/oauth2/authorize";
  protected $baseTokenUrl = "https://api.twitch.tv/kraken/oauth2/token";

  protected $clientId;
  protected $redirectUri;
  protected $scopes;
  protected $token;
  protected $clientSecret;

  protected $accessToken;
  protected $refreshToken;

  public function __construct($clientId = null, $redirectUri = null, $scopes = [], $token = null){

    $this->setClientId($clientId);
    $this->setRedirectUri($redirectUri);
    $this->setScope($scopes);
    $this->setToken($token);

  }

  public function setClientId($clientId){
    if(!$clientId) return;
    $this->clientId = $clientId;

    return $this;
  }

  public function setClientSecret($clientSecret){
    if(!$clientSecret) return;
    $this->clientSecret = $clientSecret;

    return $this;
  }

  public function setRedirectUri($redirectUri){
    if(!$redirectUri) return;
    $this->redirectUri = $redirectUri;

    return $this;
  }

  public function setScope($scopes){
    if(!is_array($scopes)) return;
    $this->scopes = $scopes;

    return $this;
  }

  public function addScope($scope){
    $this->scopes[] = $scope;

    return $this;
  }

  public function hasScope($scope){
    return in_array($scope, $this->scopes);
  }

  public function setToken($token = null){
    if(!$token) $token = uniqid();
    $this->token = $token;

    return $this;
  }

  public function setState($token = null){
    $this->setToken($token);

    return $this;
  }

  private function hasSettings(){
    return $this->clientId && $this->redirectUri && $this->scopes && $this->token;
  }

  public function getAccessToken(){
    return $this->accessToken;
  }

  public function requestAccessToken($code, $clientSecret = null){

    $this->setClientSecret($clientSecret);

    if(!$this->hasSettings() && !$this->clientSecret){
      return null;
    }

    $client = new Client(['verify' => realpath( __DIR__ . "/cacert.pem")]);

    $response = $client->post($this->baseTokenUrl, ['form_params' => [
        "client_id" => $this->clientId,
        "client_secret" => $this->clientSecret,
        "grant_type" => "authorization_code",
        "redirect_uri" => $this->redirectUri,
        "code" => $code,
        "state" => $this->token
    ]]);

    $body = json_decode($response->getBody()->getContents());
    $this->accessToken = $body->access_token;
    $this->refreshToken = $body->refresh_token;

    return $this;
  }

  public function getUrl(){
    $url = null;

    if($this->hasSettings()){
      $url = $this->baseAuthUrl;
      $url .= "?response_type=code";
      $url .= "&client_id=" . $this->clientId;
      $url .= "&redirect_uri=" . $this->redirectUri;
      $url .= "&scope=" . implode(" ", $this->scopes);
      $url .= "&state=" . $this->token;
    }

    return $url;
  }

}
