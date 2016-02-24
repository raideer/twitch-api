<?php

namespace Raideer\TwitchApi;

use Mockery as m;

class TestCase extends \PHPUnit_Framework_TestCase
{

    protected $resourceName;
    protected $resource;
    protected $wrapper;

    protected function setResource($resource)
    {
        $this->resourceName = $resource;
    }

    protected function setUp()
    {
        $this->wrapper = m::mock("Raideer\TwitchApi\Wrapper");
        $this->wrapper->shouldReceive('registerResource')->with('Raideer\TwitchApi\Resources\Resource');
        $resourceReflection = new \ReflectionClass($this->resourceName);
        $this->resource = $resourceReflection->newInstance($this->wrapper);
    }

    public function checkForScope($scope)
    {
        $this->wrapper->shouldReceive('checkScope')->with($scope);
    }

    public function mockRequest($mock, $type, $url, $params = [], $authenticated = false)
    {
        $args = [];
        $args[] = $type;
        $args[] = $url;

        if (!empty($params)) {
            if ($type == "GET") {
                $args[] = ["query" => $params];
            } else {
                $args[] = ["form_params" => $params];
            }
        } elseif ($authenticated) {
            $args[] = [];
        }

        if ($authenticated) {
            $args[] = $authenticated;
        }

        return $mock->shouldReceive("request")->withArgs($args);
    }
}
