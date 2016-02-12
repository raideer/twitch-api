<?php
namespace Raideer\TwitchApi;

use Symfony\Component\OptionsResolver\OptionsResolver;

class OAuth{

  protected $baseAuthUrl = "https://api.twitch.tv/kraken/oauth2/authorize";
  protected $authURL = "https://api.twitch.tv/kraken/oauth2/token";

  protected $OAuthResponse;
  protected $clientSecret;
  protected $redirectUri;
  protected $clientId;
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
    $resolver->setRequired(['client_id', 'redirect_uri', 'state', 'client_secret']);

    $resolved = $resolver->resolve($settings);

    if($resolved){
      $this->setClientId($resolved["client_id"]);
      $this->setRedirectUri($resolved["redirect_uri"]);
      $this->setScope($resolved["scope"]);
      $this->setState($resolved["state"]);
      $this->clientSecret = $resolved['client_secret'];
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
   * Returns the OAuthResponse object that contains the access_token, registered scopes
   * and the refresh_token
   *
   * @param  string $code     Code returned by OAuth
   * @param  boolean $forceNew Force new token
   * @return Raideer\TwitchApi\OAuthResponse
   */
  public function getResponse($code, $forceNew = false){
    if(!$this->oauthResponse || $forceNew){
      $form_params = [
        "client_id"       => $this->getClientId(),
        "client_secret"   => $this->clientSecret,
        "grant_type"      => "authorization_code",
        "redirect_uri"    => $this->getRedirectUri(),
        "code"            => $code,
        "state"           => $this->getState()
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->authURL);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $form_params);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, 5);
      $result = curl_exec($ch);
      curl_close($ch);

      $data = json_decode($result, true);
      if(json_last_error() != JSON_ERROR_NONE){
        throw new \UnexpectedValueException("Received data is not json");
        return null;
      }

      $status = $data['status'];

      if(strrpos($status, 20, -strlen($status)) === false){
        throw new Exceptions\BadResponseException("Received bad response (".$data['status']."): ". $data['message']);
        return null;
      }

      $this->OAuthResponse = new OAuthResponse($data);
    }

    return $this->OAuthResponse;
  }

  /**
   * Checks if the scope is registered
   * @param  string $scope Scope name
   * @return boolean
   */
  public function checkScope($scope){
    if($this->OAuthResponse){
      return $this->OAuthResponse->hasScope($scope);
    }

    return in_array($scope, $this->getScope());
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

    return urlencode($url);
  }

}
