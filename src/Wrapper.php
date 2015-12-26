<?php
namespace Raideer\TwitchApi;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as Guzzle;

/**
 * ONLY FOR UNAUTHORIZED REQUESTS
 */
class Wrapper{

  protected $apiURL = "https://api.twitch.tv/kraken/";

  protected $client;
  protected $resources = [];
  protected $hasAuthToken = false;
  protected $authToken;
  protected $auth;

  /**
   * API Resources
   */
  protected $channels;
  protected $chat;
  protected $follows;
  protected $games;
  protected $ingests;
  protected $search;
  protected $streams;
  protected $teams;
  protected $users;
  protected $videos;

  public function __construct(){

    /**
     * Creating a Guzzle Client and setting CaCert file location for SSL verification
     * @var GuzzleHttp\Client
     */
    $this->client = new Guzzle(
      [
        'base_uri' => $this->apiURL,
        'verify' => realpath( __DIR__ . "/cacert.pem")
      ]
    );

    $this->channels  = new Resources\Channels($this);
    $this->chat      = new Resources\Chat($this);
    $this->follows   = new Resources\Follows($this);
    $this->games     = new Resources\Games($this);
    $this->ingests   = new Resources\Ingests($this);
    $this->search    = new Resources\Search($this);
    $this->streams   = new Resources\Streams($this);
    $this->teams     = new Resources\Teams($this);
    $this->users     = new Resources\Users($this);
    $this->videos     = new Resources\Videos($this);
  }

  public function registerResource(Resources\Resource $resource){
    $this->resources[$resource->getName()] = $resource;
  }

  public function setAuthToken($token){
    $this->authToken = $token;
    $this->hasAuthToken = true;
  }

  public function setAuth(Auth $auth){
    $this->auth = $auth;
  }

  public function getResources(){

    return array_keys($this->resources);
  }

  public function resource($name){

    if(!isset($this->resources[$name])){
      throw new Exceptions\ResourceException("Resource $name does not exist!");
      return;
    }

    return $this->resources[$name];
  }

  public function __get($resource){

    return $this->resource(strtolower($resource));
  }

  public function __isset($resource){

    return array_key_exists(strtolower($resource));
  }

  public function checkScope($scope, $throwError = false){
    if($this->auth->hasScope($scope)){
      return true;
    }

    if($throwError){
      throw new Exceptions\ScopeException("Request out of scope ($scope)!");
      exit(1);
    }

    return false;
  }

  public function request($type, $target, $options = [], $authorized = false){

    $headers = [
      "Accept" => "application/vnd.twitchtv.v3+json"
    ];

    if($authorized){
      if($this->auth->getAccessToken()){
        $headers['Authorization'] = "OAuth " . $this->auth->getAccessToken();
      }else{
        throw new Exceptions\UnauthorizedException("Access Token not provided");
        exit(1);
      }
    }

    $options = array_merge_recursive(["headers" => $headers], $options);

    print_r($options);

    try{
      $response = $this->client->request($type, $target, $options);

    }catch(RequestException $e){

      if($e->hasResponse()) {
        $response = $e->getResponse();
      }else{
        return null;
      }
    }

    $body = json_decode($response->getBody()->getContents());

    return (json_last_error() == JSON_ERROR_NONE)?$body:$response->getBody()->getContents();
  }

}
