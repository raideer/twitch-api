<?php
namespace Raideer\TwitchApi;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as Guzzle;

/**
 * ONLY FOR UNAUTHORIZED REQUESTS
 */
class Wrapper{

  protected $apiURL = "https://api.twitch.tv/kraken/";
  protected $authURL = "https://api.twitch.tv/kraken/oauth2/token";

  protected $client;
  protected $resources = [];
  protected $oauthResponse;
  protected $authorized = false;

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
    $this->videos    = new Resources\Videos($this);
  }

  public function registerResource(Resources\Resource $resource){
    $this->resources[$resource->getName()] = $resource;
  }

  private function bindOAuthResponse(OAuthResponse $response){
    $this->oauthResponse = $response;
    $this->authorized = true;
  }

  public function authorize($code, $clientSecret, OAuth $oauth){
    $response = $this->client->request("POST", $this->authURL, ['form_params' => [
        "client_id" => $oauth->getClientId(),
        "client_secret" => $clientSecret,
        "grant_type" => "authorization_code",
        "redirect_uri" => $oauth->getRedirectUri(),
        "code" => $code,
        "state" => $oauth->getState()
    ]]);

    $this->bindOAuthResponse(new OAuthResponse($response));
  }

  public function isAuthorized(){
    return $this->authorized;
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
    if(!$this->isAuthorized()){
      throw new Exceptions\UnauthorizedException("Api not authorized");
      exit(1);
    }
    if($this->oauthResponse->hasScope($scope)){
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
      $headers['Authorization'] = "OAuth " . $this->oauthResponse->getAccessToken();
    }

    $options = array_merge_recursive(["headers" => $headers], $options);

    try{
      $response = $this->client->request($type, $this->apiURL . $target, $options);

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
