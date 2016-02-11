<?php

namespace Raideer\TwitchApi;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\RequestException;

class Wrapper
{
    protected $apiURL = 'https://api.twitch.tv/kraken/';

    protected $client;
    protected $resources = [];

    protected $authorized = false;
    protected $registeredScopes = [];
    protected $accessToken;

  /**
   * API Resources.
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

    protected $throttling = false;
    protected $throttle;

    public function __construct(Guzzle $client)
    {

    /*
     * @var GuzzleHttp\Client
     */
    $this->client = $client;

    /*
     * Instantiating API resources
     * @var Resource
     */
    $this->blocks = new Resources\Blocks($this);
        $this->channels = new Resources\Channels($this);
        $this->chat = new Resources\Chat($this);
        $this->follows = new Resources\Follows($this);
        $this->games = new Resources\Games($this);
        $this->ingests = new Resources\Ingests($this);
        $this->search = new Resources\Search($this);
        $this->streams = new Resources\Streams($this);
        $this->teams = new Resources\Teams($this);
        $this->users = new Resources\Users($this);
        $this->videos = new Resources\Videos($this);

        $this->throttle = new Throttle(1000);
    }

  /**
   * Registers a resource.
   *
   * @param  ResourcesResource $resource
   *
   * @return void
   */
  public function registerResource(Resources\Resource $resource)
  {
      $this->resources[strtolower($resource->getName())] = $resource;
  }

  /**
   * Enables/disables throttling.
   *
   * @param  bool $bol Enable throttle
   *
   * @return void
   */
  public function enableThrottle($bol = true)
  {
      if (!is_bool($bol)) {
          throw new \InvalidArgumentException('Parameter must be a Boolean');
      }

      $this->throttling = $bol;
  }

  /**
   * Set how much time must pass before the next request.
   *
   * @param int $ms Milliseconds
   */
  public function setThrottleInterval($ms)
  {
      if (!is_int($ms)) {
          throw new \InvalidArgumentException('Parameter must be an Integer');
      }

      $this->throttle->setInterval($ms);
  }

  /**
   * Enables the authorized requests.
   *
   * @param  string $args Access token
   * OR
   * @param  OAuthResponse $args Object returned by OAuth->getResponse()
   * OR
   * @param string $arg1 Access Token
   * @param array $arg2 Array of registered scopes
   *
   * @return void
   */
  public function authorize($args)
  {
      $numArgs = func_num_args();

      if ($numArgs === 0) {
          throw new \InvalidArgumentException('Wrapper->authorize expects atleast 1 argument!');

          return;
      }

      if ($numArgs === 1) {
          $arg1 = func_get_arg(0);
          if ($arg1 instanceof OAuthResponse) {
              $this->accessToken = $arg1->getAccessToken();
              $this->registeredScopes = $arg1->getScope();
          } elseif (is_string($arg1)) {
              $this->accessToken = $arg1;
          } else {
              throw new \InvalidArgumentException("Passed argument must be an access token OR an instance of Raideer\TwitchApi\OAuthResponse");

              return;
          }
      } elseif ($numArgs === 2) {
          list($arg1, $arg2) = func_get_args();

          if (is_string($arg1) && is_array($arg2)) {
              $this->accessToken = $arg1;
              $this->registeredScopes = $arg2;
          } else {
              throw new \InvalidArgumentException('First argument must be an accessToken and the second must be an array of registered scopes');

              return;
          }
      } else {
          throw new \InvalidArgumentException('Wrapper->authorize expects 1 or 2 arguments');

          return;
      }

      $this->authorized = true;
  }

  /**
   * Checks if scope is registered.
   *
   * @param  string  $name   Scope name
   * @param  bool  $strict If false and registeredScopes array is empty, function will return true.
   *                          Used by Resources. If an array of registered scopes is passed in
   *                          Wrapper->authorize() function, authorized requests will check if scope is
   *                          registered without making a request to the twitch api.
   *
   * @return bool
   */
  public function hasScope($name, $strict = true)
  {
      if (!$strict) {
          if (empty($this->registeredScopes)) {
              return true;
          }
      }

      return in_array($name, $this->registeredScopes);
  }

  /**
   * Checks if scope is registered
   * Throws an exception if scope doesn't exist.
   *
   * @param  string $name   Scope name
   * @param  bool $strict
   *
   * @return void
   */
  public function checkScope($name, $strict = false)
  {
      if (!$this->hasScope($name, $strict)) {
          throw new Exceptions\OutOfScopeException("Scope $name is not registered!");
      }
  }

  /**
   * @return bool
   */
  public function isAuthorized()
  {
      return $this->authorized;
  }

  /**
   * Returns a list of registered resources.
   *
   * @return array
   */
  public function getResources()
  {
      return array_keys($this->resources);
  }

  /**
   * Returns an API resource.
   *
   * @param  string $name Name of the resource
   *
   * @return Raideer\TwitchApi\Resources\Resource
   */
  public function resource($name)
  {
      if (!isset($this->resources[$name])) {
          throw new Exceptions\ResourceException("Resource $name does not exist!");

          return;
      }

      return $this->resources[$name];
  }

  /**
   * 'Magical' way of retrieving a resource.
   *
   * @param  string $resource Name of the resource
   *
   * @return Raideer\TwitchApi\Resources\Resource
   */
  public function __get($resource)
  {
      return $this->resource(strtolower($resource));
  }

  /**
   * Allows us to use isset() to check if the resource exists.
   *
   * @param  string  $resource Name of the resource
   *
   * @return bool
   */
  public function __isset($resource)
  {
      return array_key_exists(strtolower($resource));
  }

  /**
   * Makes a GuzzleHttp request.
   *
   * @param  requestType  $type       GET, POST, PUT, DELETE
   * @param  string       $target     Target URL
   * @param  array        $options    Request options
   * @param  bool      $authorized Attach Authorization headers
   *
   * @return array        JsonDecoded body contents
   */
  public function request($type, $target, $options = [], $authorized = false)
  {
      $headers = [
      'Accept' => 'application/vnd.twitchtv.v3+json',
    ];

      if ($authorized) {
          $headers['Authorization'] = 'OAuth '.$this->accessToken;
      }

      $options = array_merge_recursive(['headers' => $headers], $options);

      try {
          if ($this->throttling) {
              $this->throttle->throttle();
          }

          $response = $this->client->request($type, $this->apiURL.$target, $options);
      } catch (RequestException $e) {
          if ($e->hasResponse()) {
              $response = $e->getResponse();
          } else {
              return;
          }
      }

      $body = json_decode($response->getBody()->getContents());

      return (json_last_error() == JSON_ERROR_NONE) ? $body : $response->getBody()->getContents();
  }
}
