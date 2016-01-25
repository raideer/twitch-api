> UNDER DEVELOPMENT - TEST DOCUMENTATION

# Twitch API wrapper in PHP

## Installation

`composer require raideer/twitch-api`

## Usage
### Basic, unauthenticated requests.
First we need to create the main Wrapper instance. The constructor takes a Guzzle Client as its only parameter.

```php
$client = new GuzzleHttp\Client;

$wrapper = new Raideer\TwitchApi\Wrapper($client);
```

Now we can access various Twitch API resources using the wrapper.    
You can see all the resources and their methods here:
https://github.com/justintv/Twitch-API#index

```php
/*
 * Wrapper->resource->function()
 */

$response = $wrapper->Channels->getChannel('lirik');
//OR
$response = $wrapper->resource('channels')->getChannel('lirik');
```
Note: letter capitalization desn't matter, so `$wrapper->CHANNELS->getChannel()` will still work.

Some methods can take an optional array of parameters.   
See the [official twitch api](https://github.com/justintv/Twitch-API) documentation for the list of parameters.

```php
$wrapper->Channels->getFollows('lirik', ['limit' => 40, 'direction' => 'asc'])
```

### Authenticated requests

First we need to create an OAuth object, that will contain the necessary information for authenticating our requests.

Read more about [authentication here](https://github.com/justintv/Twitch-API/blob/master/authentication.md).

```php
$settings = [
  'client_id'     => 'Your Client ID',
  'client_secret' => 'Your Client Secret',
  'redirect_uri'  => 'Your registered redirect URI',
  'state'         => 'Your provided unique token',
  'scope'         => 'Array or space seperated string of scopes'
];

$oauth = new Raideer\TwitchApi\Oauth($settings);

//Builds the authentication URL
$url = $oauth->getUrl();
```

Once the user authorizes your application, they will be redirected to your specified URI with a code, that's necessary for obtaining the access token.   

##### Obtaining the Access Token

You can obtain the access token by using the getResponse method. If the request is successful, *OAuthResponse* object will
be returned. It contains the access token, refresh token and registered scopes.

```php
$response = $oauth->getResponse($code);

$response->getAccessToken();
$response->getRefreshToken();
$response->getScope();
$response->hasScope($scope);
```

Now you can authorize the Wrapper using the *authorize* method.

```php
//You can pass the OAuthResponse object directly
$wrapper->authorize($response);

//Or just pass the access token
$wrapper->authorize($accessToken);

//Or pass both access token and registered scopes array
$wrapper->authorize($accessToken, $registeredScopes);
```

If you authorize the wrapper only by passing the access token, the Wrapper will not be able to check wether the scope
you're trying to access actually exists. 

Now you can make authorized requests.

```php
$wrapper->Channels->getChannel(); //Returns the authenticated user's channel
```

If the request is out of scope, `Raideer\TwitchApi\Exceptions\OutOfScopeException` will be thrown.

##### Throttling

If you need, you can enable request throttling.

```php
$wrapper->enableThrottle(true);
```

Time (milliseconds) between requests can be set like so:

```php
// 1 second throttle
$wrapper->setThrottleInterval(1000);
```

#### Examples

```php

$client = new GuzzleHttp\Client;
$wrapper = new Raideer\TwitchApi\Wrapper($client);

$settings = [
  'client_id'     => 'myClientId',
  'client_secret' => 'myClientSecret',
  'redirect_uri'  => 'http://localhost',
  'state'         => 'myUniqueToken123123',
  'scope'         => ['channel_editor']
];

$oauth = new Raideer\TwitchApi\OAuth($settings);

// You can also add a scope using the addScope method
$oauth->addScope('channel_read');

$url = $oauth->getUrl();
```

```php
  
$code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
$response = $oauth->getResponse($code);
$wrapper->authorize($response);

$response = $wrapper->Channels->getChannel();

echo "I'm currently playing " . $response->game;

```

## Resources
| Resource | Official documentation |
| -------- | ---------------------- |
| [Blocks](#blocks) | https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md |
| [Channels](#channels) | https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md |
### Blocks

* ###### getBlockedUsers($user, $params)    
`GET /users/:user/blocks`   
$user -> Name of the target user
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Required?</th>
            <th width="50">Type</th>
            <th width=100%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>limit</code></td>
            <td>optional</td>
            <td>integer</td>
            <td>Maximum number of objects in array. Default is 25. Maximum is 100.</td>
        </tr>
        <tr>
            <td><code>offset</code></td>
            <td>optional</td>
            <td>integer</td>
            <td>Object offset for pagination. Default is 0.</td>
        </tr>
    </tbody>
</table>

* ###### blockUser($user, $target)   
`PUT /users/:user/blocks/:target`   
$user -> Authenticated user
$target -> User to block

* 
