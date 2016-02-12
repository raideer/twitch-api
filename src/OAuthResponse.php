<?php

namespace Raideer\TwitchApi;

class OAuthResponse
{
    protected $contents;

    public function __construct($data)
    {
        $this->contents = $data;
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function getAccessToken()
    {
        return $this->contents['access_token'];
    }

    public function getRefreshToken()
    {
        return $this->contents['refresh_token'];
    }

    public function getScope()
    {
        return $this->contents['scope'];
    }

    public function hasScope($scope)
    {
        return in_array($scope, $this->getScope());
    }
}
