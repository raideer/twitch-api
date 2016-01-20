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
Note: resource name capitalization desn't matter, so `$wrapper->CHANNELS->getChannel()` will still work.

Some methods can take an optional array of parameters.

```php
$wrapper->Channels->getFollows('lirik', ['limit' => 40, 'direction' => 'asc'])
```

### Authenticated requests

First we need to create an OAuth object, that will contain the necessary information for authenticating our requests.

Read more about [authentication here](https://github.com/justintv/Twitch-API/blob/master/authentication.md).

```php
$settings = [
  'client_id'     => 'Your Client ID',
  'redirect_uri'  => 'Your registered redirect URI',
  'state'         => 'Your provided unique token',
  'scope'         => 'Array or space seperated string of scopes'
];

$oauth = new Raideer\TwitchApi\Oauth($settings);

//Builds the authentication URL
$url = $oauth->getUrl();
```

Once the user authorizes your application, they will be redirected to your specified URI with a code, that's necessary for obtaining the access token.

Now we can pass all the information to the Wrapper.
Wrapper's authorize method requires 3 parameters:
1. The code that was attached to the URI
2. Your client secret (Obtained when you register your application)
3. The oauth object that we just created

```php
$wrapper->authorize($code, $clientSecret, $oauth);
```

Now the wrapper will receive the access token and we'll be able to make authenticated requests.

```php
$wrapper->Channels->getChannel(); //Returns the authenticated user's channel
```

If the request is out of scope, `Raideer\TwitchApi\Exceptions\UnauthorizedException` will be thrown.
