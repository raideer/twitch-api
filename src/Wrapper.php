<?php
namespace Raideer\TwitchApi;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as Guzzle;

class Wrapper{

  protected $apiURL = "https://api.twitch.tv/kraken/";
  protected $authURL = "https://api.twitch.tv/kraken/oauth2/token";

  protected $client;
  protected $resources = [];

  protected $oauthResponse;
  protected $authorized = false;
  protected $authorizedUser;

  /**
   * API Resources
   */
  protected $blocks;
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

    /**
     * Instantiating API resources
     * @var Resource
     */
    $this->blocks    = new Resources\Blocks($this);
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

  /**
   * Registers a resource
   * @param  ResourcesResource $resource
   * @return void
   */
  public function registerResource(Resources\Resource $resource){
    $this->resources[$resource->getName()] = $resource;
  }

  /**
   * Attaches OAuthResponse object to the wrapper, so we can use
   * authenticated requests
   * @param  OAuthResponse $response
   * @return void
   */
  private function bindOAuthResponse(OAuthResponse $response){
    $this->oauthResponse = $response;
    $this->authorized = true;
  }

  /**
   * Authenticates the app, so we can use authenticated requests
   * @param  string $code         Code received from the redirect URI
   * @param  string $clientSecret Client secret
   * @param  OAuth  $oauth        OAuth object, that contains client information
   * @return void
   */
  public function authenitcate($code, $clientSecret, OAuth $oauth){
    $response = $this->client->request("POST", $this->authURL, ['form_params' => [
        "client_id" => $oauth->getClientId(),
        "client_secret" => $clientSecret,
        "grant_type" => "authorization_code",
        "redirect_uri" => $oauth->getRedirectUri(),
        "code" => $code,
        "state" => $oauth->getState()
    ]]);

    $this->bindOAuthResponse(new OAuthResponse($response));

    $this->authorizedUser = $this->Users->getUser()->name;
  }

  /**
   * Returns authenticated user name
   * @return string
   */
  public function getAuthorizedUser(){
    if(!$this->isAuthorized()){
      throw new Exceptions\UnauthorizedException("Api not authorized");
      exit(1);
    }
    return $this->authorizedUser;
  }

  /**
   * @return boolean
   */
  public function isAuthenticated(){
    return $this->authorized;
  }

  /**
   * Returns a list of registered resources
   * @return array
   */
  public function getResources(){

    return array_keys($this->resources);
  }

  /**
   * Returns an API resource
   * @param  string $name Name of the resource
   * @return Raideer\TwitchApi\Resources\Resource
   */
  public function resource($name){

    if(!isset($this->resources[$name])){
      throw new Exceptions\ResourceException("Resource $name does not exist!");
      exit(1);
    }

    return $this->resources[$name];
  }

  /**
   * 'Magical' way of retrieving a resource
   * @param  string $resource Name of the resource
   * @return Raideer\TwitchApi\Resources\Resource
   */
  public function __get($resource){

    return $this->resource(strtolower($resource));
  }

  /**
   * Allows us to use isset() to check if the resource exists
   * @param  string  $resource Name of the resource
   * @return boolean
   */
  public function __isset($resource){

    return array_key_exists(strtolower($resource));
  }

  /**
   * Checks if the scope is registered
   * @param  string  $scope      Name of the scope
   * @param  boolean $throwError Throw a ScopeException if scope is not registered
   * @return boolean
   */
  public function checkScope($scope, $throwError = false){
    /**
     * Checking if client is authenticated
     */
    if(!$this->isAuthenticated()){
      throw new Exceptions\UnauthorizedException("Client not authenticated");
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

  /**
   * Makes a GuzzleHttp request
   * @param  requestType  $type       GET, POST, PUT, DELETE
   * @param  string       $target     Target URL
   * @param  array        $options    Request options
   * @param  boolean      $authorized Attach Authorization headers
   * @return array        JsonDecoded body contents
   */
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
